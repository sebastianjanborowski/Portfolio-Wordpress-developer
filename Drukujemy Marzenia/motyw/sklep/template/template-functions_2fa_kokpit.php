<?php
//logowanie 2FA dla kokpitu wordpress 

// zabezpieczenie na nieautoryzowane wejscie do pliku
if(!defined('ABSPATH')){
    exit;
}

// definiowanie stałej dla logowania czy przeszedł logowanie
define('CF2FA_PENDING_COOKIE','cf2fa_pending_token');

// ile jest ważny token
define('CF2FA_CODE_LIFETIME',3 * MINUTE_IN_SECONDS);

// definicja liczby prób logowania
define('CF2FA_MAX_ATTEMPTS',5);

// okrślenie jacy użytkownicy mają posiadać mechnaizm 2fa włączony true to z listy tylko będzie działąć jak na false to dla każdego usera działa 2fa
define('CF2FA_LIMIT_TO_SELECTED_ROLES',true);

// defiicja email skonfigurowany na smtp
define('CF2FA_MAIL_FROM','borowskisebastjan@gmail.com');

// definiowanie nadawcy wiadomości email
define('CF2FA_MAIL_FROM_NAME','Wordpress 2FA');

// ustawianie adresu FROM dla wiadomosci z kodem
add_filter('wp_mail_from',function($email){
    return CF2FA_MAIL_FROM;
});

// ustawianie nazwy nadawcy wiadomości
add_filter('wp_mail_from_name',function($name){
    return CF2FA_MAIL_FROM_NAME;
});

// funkcja pomocnicza sterowanie kto może przystąpić do procedury 2FA
//  * @param WP_User $user
//  * @return bool

function cf2fa_user_requires_2fa($user){
    // sprawdza czy zmienna  przekazywana user jest obiektem classy jak niei to kończy
    if(!($user instanceof WP_User)){
        return false;
    }

    // sprawdza czy ma dodawać 2FA dla każdej roli w systemie, false każda rola przechodzi procedure, true tylko zdefiniowane w tablicy
    if(!CF2FA_LIMIT_TO_SELECTED_ROLES){
        return true;
    }

    // definiowanie listy rol do weryfikacji 2FA
    $protected_roles = array(
        'administrator',
        'editor',
        'contributor',
        'shop_manager'
    );

    // sprawdzenbie czy użytkownik ma role przypisane w systemie
    if(empty($user->roles) || !is_array($user->roles)){
        return false;
    }

    // sprawdza czy rola jest w tablicy protected_roles
    foreach($user->roles as $role){
        // sprawdza czy w tablicy jest określona wartość roli użytkownika
        if(in_array($role,$protected_roles,true)){
            return true;
        }
    }

    return false;

}

// funkcja pomocnicza do generowania 6 cyfrowego kodu dostępu 2fa
function cf2fa_generate_code(){
    return (string) wp_rand(100000,999999);
}

// dostaje token i dokleja do niego stały napis
function cf2fa_get_pending_transient_key($token){
    return 'cf2fa_pending_'.$token;
}

// ustawia tymczasowe cookie z tokenem oczekującym na 2fa
function cf2fa_set_pending_cookie($token){
    // sprawdza czy strona ma ssl
    $secure = is_ssl();
    // określa rodzaj ochrony
    $httponly = true;

    // ustawia cookie
    setcookie(
        CF2FA_PENDING_COOKIE,
        $token,
        array(
            'expires' => time() + CF2FA_CODE_LIFETIME,
            'path' => COOKIEPATH ? COOKIEPATH : '/',
            'domain' => COOKIE_DOMAIN,
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => 'Lax',
        )
    );

    // ustawia na serwerze cookie by móc się do tego odwołąć
    $_COOKIE[CF2FA_PENDING_COOKIE] = $token;
}

// czyści cookie oczekującego logowania usera
function cf2fa_clear_pending_cookie() {
    setcookie(
        CF2FA_PENDING_COOKIE,
        '',
        array(
            'expires' => time() - HOUR_IN_SECONDS,
            'path' => COOKIEPATH ? COOKIEPATH : '/',
            'domain' => COOKIE_DOMAIN,
            'secure' => is_ssl(),
            'httponly' => true,
            'samesite' => 'Lax',
        )
    );

    unset($_COOKIE[CF2FA_PENDING_COOKIE]);

}

// zwraca token z cookie jeżeli istnieje
function cf2fa_get_pending_cookie_token(){
    if(empty($_COOKIE[CF2FA_PENDING_COOKIE])){
        return '';
    }

    return sanitize_text_field(wp_unslash($_COOKIE[CF2FA_PENDING_COOKIE]));

}

// wysyłka emial z kodem na email użytkownika
function cf2fa_send_code_email( $user, $code ){
    $to = $user->user_email;
    $subject = 'Kod logowania 2FA do panelu administracyjnego';

    $message = "Witaj,\n\n";
    $message.= "Twój jednorazowy kod logowania do kokpitu wordpress to \n\n";
    $message .= $code."\n\n";
    $message .= "Kod jest ważny przez 3 minut.\n";
	$message .= "Jeśli to nie Ty próbujesz się zalogować, natychmiast zmień hasło.\n";

    return wp_mail($to,$subject,$message);
}

// tworzy oczekującą sesje 2FA
function cf2fa_create_pending_session( $user, $remember = false ) {
    $code = cf2fa_generate_code();
    $token = wp_generate_password( 40, false, false );

    $data = array(
		'user_id'      => (int) $user->ID,
		'code_hash'    => wp_hash_password( $code ), // Nie zapisujemy kodu jawnie.
		'remember'     => ! empty( $remember ),
		'attempts'     => 0,
		'created_at'   => time(),
		'expires_at'   => time() + CF2FA_CODE_LIFETIME,
		'ip'           => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
		'user_agent'   => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ), 0, 255 ) : '',
	);

    set_transient( cf2fa_get_pending_transient_key( $token ), $data, CF2FA_CODE_LIFETIME );
	cf2fa_set_pending_cookie( $token );

	return cf2fa_send_code_email( $user, $code );

}

//  Pobiera dane oczekującej sesji 2FA z transientu.
function cf2fa_get_pending_session() {
    $token = cf2fa_get_pending_cookie_token();

    if(!$token){
        return false;
    }

    $data = get_transient( cf2fa_get_pending_transient_key( $token ) );

    if ( empty( $data ) || ! is_array( $data ) ) {
		return false;
	}

	return $data;
}

// aktualizacja oczekiwania sesji 2FA
function cf2fa_update_pending_session( $data ) {
	$token = cf2fa_get_pending_cookie_token();

	if ( ! $token ) {
		return;
	}

	$expires_in = max( 1, (int) $data['expires_at'] - time() );

	set_transient( cf2fa_get_pending_transient_key( $token ), $data, $expires_in );
}

// kasuje sesje 2fa
function cf2fa_destroy_pending_session() {
	$token = cf2fa_get_pending_cookie_token();

	if ( $token ) {
		delete_transient( cf2fa_get_pending_transient_key( $token ) );
	}

	cf2fa_clear_pending_cookie();
}

/**
 * Zwraca URL do ekranu wpisania kodu 2FA.
 *
 * @return string
 */
function cf2fa_get_verify_url() {
	return wp_login_url() . '?action=custom_2fa';
}

function cf2fa_intercept_wp_login($user,$username,$password){

    if(is_wp_error($user)){
        return $user;
    }

    // Jeśli nie ma poprawnie uwierzytelnionego użytkownika, nic nie robimy.
	if ( ! ( $user instanceof WP_User ) ) {
		return $user;
	}

    // Jeśli jesteśmy już na ekranie 2FA, nie zapętlaj logowania.
	$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '';
	if ( 'custom_2fa' === $action ) {
		return $user;
	}

    // Jeśli użytkownik nie podlega 2FA, przepuszczamy logowanie normalnie.
	if ( ! cf2fa_user_requires_2fa( $user ) ) {
		return $user;
	}

    // Czy użytkownik zaznaczył "Zapamiętaj mnie".
	$remember = false;
	if ( isset( $_POST['rememberme'] ) ) {
		$remember = ! empty( $_POST['rememberme'] );
	}

	// Tworzymy sesję oczekującą i wysyłamy kod.
	$sent = cf2fa_create_pending_session( $user, $remember );

	if ( ! $sent ) {
		return new WP_Error(
			'cf2fa_mail_failed',
			__( '<strong>Błąd 2FA:</strong> Nie udało się wysłać kodu e-mail. Skontaktuj się z administratorem.', 'textdomain' )
		);
	}

	// Przekierowanie na ekran wpisania kodu.
	wp_safe_redirect( cf2fa_get_verify_url() );
	exit;
}

add_filter( 'authenticate', 'cf2fa_intercept_wp_login', 99, 3 );

// renderuje furmularz
function cf2fa_render_and_handle_verify_screen() {
	$error_message = '';

	// Najpierw sprawdzamy, czy istnieje sesja oczekująca.
	$pending = cf2fa_get_pending_session();

	if ( ! $pending ) {
		login_header( __( 'Weryfikacja 2FA', 'textdomain' ) );

		echo '<div id="login_error"><p>Sesja 2FA wygasła lub nie istnieje. Zaloguj się ponownie.</p></div>';
		echo '<p class="message"><a href="' . esc_url( wp_login_url() ) . '">Wróć do logowania</a></p>';

		login_footer();
		exit;
	}

	// Obsługa wysłania formularza z kodem.
	if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {

		/**
		 * Sprawdzenie nonce.
		 *
		 * WordPress zaleca używanie nonce do formularzy,
		 * żeby potwierdzić intencję żądania.
		 */
		check_admin_referer( 'cf2fa_verify_code_action', 'cf2fa_nonce' );

		$code = isset( $_POST['cf2fa_code'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['cf2fa_code'] ) ) ) : '';

		// Podstawowa walidacja formatu.
		if ( ! preg_match( '/^\d{6}$/', $code ) ) {
			$error_message = 'Kod musi zawierać dokładnie 6 cyfr.';
		} else {

			// Sprawdzenie wygaśnięcia.
			if ( time() > (int) $pending['expires_at'] ) {
				cf2fa_destroy_pending_session();

				login_header( __( 'Weryfikacja 2FA', 'textdomain' ) );
				echo '<div id="login_error"><p>Kod wygasł. Zaloguj się ponownie.</p></div>';
				echo '<p class="message"><a href="' . esc_url( wp_login_url() ) . '">Wróć do logowania</a></p>';
				login_footer();
				exit;
			}

			// Limit prób.
			if ( (int) $pending['attempts'] >= CF2FA_MAX_ATTEMPTS ) {
				cf2fa_destroy_pending_session();

				login_header( __( 'Weryfikacja 2FA', 'textdomain' ) );
				echo '<div id="login_error"><p>Przekroczono limit prób. Zaloguj się ponownie.</p></div>';
				echo '<p class="message"><a href="' . esc_url( wp_login_url() ) . '">Wróć do logowania</a></p>';
				login_footer();
				exit;
			}

			// Porównanie kodu z hashem zapisanym w transient.
			if ( wp_check_password( $code, $pending['code_hash'] ) ) {

				$user = get_user_by( 'id', (int) $pending['user_id'] );

				if ( ! $user || ! ( $user instanceof WP_User ) ) {
					cf2fa_destroy_pending_session();

					login_header( __( 'Weryfikacja 2FA', 'textdomain' ) );
					echo '<div id="login_error"><p>Nie znaleziono użytkownika. Zaloguj się ponownie.</p></div>';
					echo '<p class="message"><a href="' . esc_url( wp_login_url() ) . '">Wróć do logowania</a></p>';
					login_footer();
					exit;
				}

				/**
				 * To jest moment pełnego zalogowania użytkownika.
				 *
				 * - wp_set_current_user() ustawia aktualnego użytkownika w bieżącym requestcie
				 * - wp_set_auth_cookie() ustawia cookies logowania WordPress
				 * - do_action('wp_login', ...) odpala standardowe akcje po logowaniu
				 */
				wp_set_current_user( $user->ID );
				wp_set_auth_cookie( $user->ID, ! empty( $pending['remember'] ), is_ssl() );
				do_action( 'wp_login', $user->user_login, $user );

				// Czyścimy stan tymczasowy 2FA.
				cf2fa_destroy_pending_session();

				// Przekierowanie do kokpitu.
				wp_safe_redirect( admin_url() );
				exit;
			} else {
				// Zły kod -> zwiększamy licznik prób.
				$pending['attempts'] = (int) $pending['attempts'] + 1;
				cf2fa_update_pending_session( $pending );

				$remaining = max( 0, CF2FA_MAX_ATTEMPTS - (int) $pending['attempts'] );
				$error_message = 'Nieprawidłowy kod. Pozostało prób: ' . $remaining . '.';
			}
		}
	}

	/**
	 * Render własnego ekranu 2FA.
	 *
	 * To jest normalna strona logowania WordPress,
	 * ale z własnym formularzem.
	 */
	login_header( __( 'Weryfikacja 2FA', 'textdomain' ) );

	if ( ! empty( $error_message ) ) {
		echo '<div id="login_error"><p>' . esc_html( $error_message ) . '</p></div>';
	}

	echo '<p class="message">Na adres e-mail Twojego konta został wysłany 6-cyfrowy kod logowania.</p>';

	echo '<form name="cf2faform" id="loginform" action="' . esc_url( cf2fa_get_verify_url() ) . '" method="post">';
		wp_nonce_field( 'cf2fa_verify_code_action', 'cf2fa_nonce' );

		echo '<p>';
			echo '<label for="cf2fa_code">Kod 2FA</label>';
			echo '<input type="text" name="cf2fa_code" id="cf2fa_code" class="input" value="" size="20" inputmode="numeric" autocomplete="one-time-code" maxlength="6" />';
		echo '</p>';

		echo '<p class="submit">';
			echo '<input type="submit" class="button button-primary button-large" value="Zweryfikuj i zaloguj" />';
		echo '</p>';
	echo '</form>';

	echo '<p id="nav">';
		echo '<a href="' . esc_url( wp_login_url() ) . '">Wróć do logowania</a>';
	echo '</p>';

	login_footer();
	exit;
}
add_action( 'login_form_custom_2fa', 'cf2fa_render_and_handle_verify_screen' );

/**
 * Dla porządku czyścimy ewentualny stan oczekujący przy wylogowaniu.
 */
function cf2fa_cleanup_on_logout() {
	cf2fa_destroy_pending_session();
}
add_action( 'wp_logout', 'cf2fa_cleanup_on_logout' );