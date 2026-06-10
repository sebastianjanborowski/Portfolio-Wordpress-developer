<?php
/**
 * Clean optimized functions.php - Warszawskie Dachy
 */

defined( 'ABSPATH' ) || exit;

/**
 * Podstawowa konfiguracja motywu.
 */
function roofer_setup_theme() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	register_nav_menus(
		array(
			'main_menu' => 'Main Menu',
		)
	);
}
add_action( 'after_setup_theme', 'roofer_setup_theme' );

/**
 * Pomocnicza funkcja do wersjonowania plików.
 */
function roofer_asset_version( $relative_path ) {
	$file_path = get_template_directory() . $relative_path;

	return file_exists( $file_path ) ? filemtime( $file_path ) : '1.0.0';
}

/**
 * Sprawdzenie, czy aktualna strona zawiera formularz Contact Form 7.
 */
function roofer_has_contact_form() {
	if ( is_admin() ) {
		return true;
	}

	if ( is_page( 'kontakt' ) ) {
		return true;
	}

	global $post;

	if ( $post instanceof WP_Post && has_shortcode( $post->post_content, 'contact-form-7' ) ) {
		return true;
	}

	return false;
}

/**
 * Ładowanie CSS i JS.
 */
function roofer_enqueue_assets() {

	$theme_uri = get_template_directory_uri();

	$style_version  = roofer_asset_version( '/assets/css/style.css' );
	$script_version = roofer_asset_version( '/assets/js/script.js' );

	/**
	 * Bootstrap CSS.
	 * Będzie ładowany przez preload w filtrze style_loader_tag.
	 */
	wp_enqueue_style(
		'bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
		array(),
		'5.3.3'
	);

	/**
	 * Bootstrap Icons.
	 * Ikony nie są krytyczne dla pierwszego renderowania, więc ładujemy je asynchronicznie.
	 */
	wp_enqueue_style(
		'bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
		array(),
		'1.11.3'
	);

	/**
	 * Główny CSS motywu.
	 * Zostaje normalnie render-blocking, bo jest kluczowy dla wyglądu strony.
	 */
	wp_enqueue_style(
		'roofer-style',
		$theme_uri . '/assets/css/style.css',
		array( 'bootstrap' ),
		$style_version
	);

	/**
	 * Bootstrap JS.
	 */
	wp_enqueue_script(
		'bootstrap-js',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
		array(),
		'5.3.3',
		true
	);

	/**
	 * Główny JS motywu.
	 */
	wp_enqueue_script(
		'roofer-script',
		$theme_uri . '/assets/js/script.js',
		array( 'bootstrap-js' ),
		$script_version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'roofer_enqueue_assets' );

/**
 * Preload / async dla wybranych plików CSS.
 */
function roofer_optimize_style_loading( $html, $handle, $href, $media ) {

	if ( 'bootstrap' === $handle ) {
		return "<link rel='preload' href='" . esc_url( $href ) . "' as='style' onload=\"this.onload=null;this.rel='stylesheet'\" media='all'>" .
			"<noscript><link rel='stylesheet' href='" . esc_url( $href ) . "' media='all'></noscript>";
	}

	if ( 'bootstrap-icons' === $handle ) {
		return "<link rel='preload' href='" . esc_url( $href ) . "' as='style' onload=\"this.onload=null;this.rel='stylesheet'\" media='all'>" .
			"<noscript><link rel='stylesheet' href='" . esc_url( $href ) . "' media='all'></noscript>";
	}

	return $html;
}
add_filter( 'style_loader_tag', 'roofer_optimize_style_loading', 10, 4 );

/**
 * Usunięcie zbędnych stylów WordPressa.
 */
function roofer_remove_unused_wp_styles() {

	if ( is_admin() ) {
		return;
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'roofer_remove_unused_wp_styles', 100 );

/**
 * Contact Form 7 tylko tam, gdzie jest potrzebny.
 */
function roofer_optimize_contact_form_7_assets() {

	if ( is_admin() ) {
		return;
	}

	if ( roofer_has_contact_form() ) {
		return;
	}

	wp_dequeue_style( 'contact-form-7' );
	wp_dequeue_script( 'contact-form-7' );
	wp_dequeue_script( 'swv' );
}
add_action( 'wp_enqueue_scripts', 'roofer_optimize_contact_form_7_assets', 100 );

/**
 * Usunięcie emoji WordPressa.
 */
function roofer_disable_wp_emojis() {

	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'roofer_disable_wp_emojis' );

/**
 * Usunięcie dns-prefetch do emoji.
 */
function roofer_remove_emoji_dns_prefetch( $urls, $relation_type ) {

	if ( 'dns-prefetch' === $relation_type ) {
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/' );

		$urls = array_filter(
			$urls,
			function ( $url ) use ( $emoji_svg_url ) {
				return $url !== $emoji_svg_url;
			}
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'roofer_remove_emoji_dns_prefetch', 10, 2 );

/**
 * Preconnect do zewnętrznych zasobów.
 */
function roofer_resource_hints( $urls, $relation_type ) {

	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://cdn.jsdelivr.net',
			'crossorigin' => 'anonymous',
		);

		$urls[] = array(
			'href'        => 'https://www.googletagmanager.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'roofer_resource_hints', 10, 2 );

/**
 * Preload głównego zdjęcia hero.
 * Zmień nazwę pliku, jeżeli używasz innego hero.
 */
function roofer_preload_hero_image() {

	if ( is_admin() ) {
		return;
	}

	if ( is_front_page() || is_home() ) {
		$hero_path = get_template_directory() . '/assets/img/main-photo.jpg';
		$hero_url  = get_template_directory_uri() . '/assets/img/main-photo.jpg';

		if ( file_exists( $hero_path ) ) {
			echo '<link rel="preload" as="image" href="' . esc_url( $hero_url ) . '" fetchpriority="high">' . "\n";
		}
	}
}
add_action( 'wp_head', 'roofer_preload_hero_image', 2 );

/**
 * Defer dla niekrytycznych skryptów.
 */
function roofer_defer_scripts( $tag, $handle, $src ) {

	$defer_handles = array(
		'roofer-script',
		'contact-form-7',
		'swv',
	);

	if ( in_array( $handle, $defer_handles, true ) ) {
		return '<script src="' . esc_url( $src ) . '" id="' . esc_attr( $handle ) . '-js" defer></script>';
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'roofer_defer_scripts', 10, 3 );

/**
 * Dodanie wymiarów do logo, jeżeli przeglądarka ich nie widzi.
 */
function roofer_custom_logo_attributes( $html ) {

	$html = str_replace( 'class="custom-logo"', 'class="custom-logo" width="180" height="60"', $html );

	return $html;
}
add_filter( 'get_custom_logo', 'roofer_custom_logo_attributes' );






/**
 * Google Consent Mode v2 - ustawienie domyślnych zgód.
 * Domyślnie: brak zgody na analitykę i marketing do czasu decyzji użytkownika.
 */
function roofer_google_consent_mode_default() {
	if ( is_admin() ) {
		return;
	}
	?>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}

		gtag('consent', 'default', {
			'ad_storage': 'denied',
			'ad_user_data': 'denied',
			'ad_personalization': 'denied',
			'analytics_storage': 'denied',
			'functionality_storage': 'granted',
			'security_storage': 'granted',
			'personalization_storage': 'denied',
			'wait_for_update': 500
		});
	</script>
	<?php
}
add_action( 'wp_head', 'roofer_google_consent_mode_default', 1 );

/**
 * Baner cookies + obsługa Google Consent Mode v2.
 */
function roofer_cookie_consent_banner() {
	if ( is_admin() ) {
		return;
	}
	?>

	<div id="roofer-cookie-banner" class="roofer-cookie-banner" role="dialog" aria-live="polite" aria-label="Ustawienia prywatności">
		<div class="roofer-cookie-box">

			<div class="roofer-cookie-content">
				<h2>Ustawienia prywatności</h2>

				<p>
					Używamy plików cookies do prawidłowego działania strony, analityki oraz pomiaru skuteczności reklam Google.
					Możesz zaakceptować wszystkie zgody, odrzucić zgody opcjonalne albo wybrać własne ustawienia.
				</p>

				<div id="roofer-cookie-settings" class="roofer-cookie-settings" hidden>
					<label class="roofer-cookie-option">
						<input type="checkbox" checked disabled>
						<span>
							<strong>Niezbędne cookies</strong>
							<small>Wymagane do działania strony. Te zgody są zawsze aktywne.</small>
						</span>
					</label>

					<label class="roofer-cookie-option">
						<input type="checkbox" id="roofer-consent-analytics">
						<span>
							<strong>Analityka</strong>
							<small>Pomaga mierzyć ruch na stronie przez Google Analytics.</small>
						</span>
					</label>

					<label class="roofer-cookie-option">
						<input type="checkbox" id="roofer-consent-marketing">
						<span>
							<strong>Marketing i reklamy</strong>
							<small>Pomaga mierzyć skuteczność Google Ads i konwersje.</small>
						</span>
					</label>
				</div>
			</div>

			<div class="roofer-cookie-actions">
				<button type="button" class="roofer-cookie-btn roofer-cookie-btn-light" id="roofer-cookie-settings-btn">
					Ustawienia
				</button>

				<button type="button" class="roofer-cookie-btn roofer-cookie-btn-outline" id="roofer-cookie-reject">
					Odrzuć
				</button>

				<button type="button" class="roofer-cookie-btn roofer-cookie-btn-success" id="roofer-cookie-save" hidden>
					Zapisz wybór
				</button>

				<button type="button" class="roofer-cookie-btn roofer-cookie-btn-success" id="roofer-cookie-accept">
					Akceptuję wszystkie
				</button>
			</div>

		</div>
	</div>

	<button type="button" id="roofer-cookie-open" class="roofer-cookie-open" aria-label="Otwórz ustawienia cookies">
		<i class="bi bi-shield-check"></i>
	</button>

	<style>
		.roofer-cookie-banner {
			position: fixed;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 999999;
			padding: 18px;
			background: linear-gradient(180deg, rgba(18, 29, 33, 0), rgba(18, 29, 33, .92));
			display: none;
		}

		.roofer-cookie-banner.is-visible {
			display: block;
		}

		.roofer-cookie-box {
			width: min(1120px, 100%);
			margin: 0 auto;
			padding: 24px;
			border-radius: 18px;
			background: rgba(18, 29, 33, .98);
			color: #fff;
			box-shadow: 0 24px 80px rgba(0, 0, 0, .35);
			border: 1px solid rgba(255, 255, 255, .08);
			display: grid;
			grid-template-columns: 1fr auto;
			gap: 24px;
			align-items: end;
		}

		.roofer-cookie-content h2 {
			margin: 0 0 10px;
			font-size: 22px;
			font-weight: 800;
		}

		.roofer-cookie-content p {
			margin: 0;
			max-width: 760px;
			color: rgba(255, 255, 255, .78);
			font-size: 15px;
			line-height: 1.6;
		}

		.roofer-cookie-settings {
			margin-top: 18px;
			display: grid;
			gap: 12px;
		}

		.roofer-cookie-option {
			display: flex;
			gap: 12px;
			padding: 14px;
			border-radius: 12px;
			background: rgba(255, 255, 255, .05);
			border: 1px solid rgba(255, 255, 255, .08);
			cursor: pointer;
		}

		.roofer-cookie-option input {
			margin-top: 4px;
			width: 18px;
			height: 18px;
			accent-color: #198754;
		}

		.roofer-cookie-option strong {
			display: block;
			font-size: 15px;
			margin-bottom: 4px;
		}

		.roofer-cookie-option small {
			display: block;
			color: rgba(255, 255, 255, .62);
			line-height: 1.45;
		}

		.roofer-cookie-actions {
			display: flex;
			flex-wrap: wrap;
			justify-content: flex-end;
			gap: 10px;
			min-width: 370px;
		}

		.roofer-cookie-btn {
			min-height: 46px;
			padding: 0 18px;
			border-radius: 10px;
			font-size: 14px;
			font-weight: 800;
			border: 0;
			cursor: pointer;
			transition: .2s ease;
		}

		.roofer-cookie-btn-success {
			background: #198754;
			color: #fff;
		}

		.roofer-cookie-btn-success:hover {
			background: #157347;
		}

		.roofer-cookie-btn-outline {
			background: transparent;
			color: #fff;
			border: 1px solid rgba(255, 255, 255, .22);
		}

		.roofer-cookie-btn-outline:hover {
			border-color: rgba(255, 255, 255, .5);
		}

		.roofer-cookie-btn-light {
			background: rgba(255, 255, 255, .08);
			color: #fff;
		}

		.roofer-cookie-btn-light:hover {
			background: rgba(255, 255, 255, .14);
		}

		.roofer-cookie-open {
			position: fixed;
			left: 18px;
			bottom: 18px;
			z-index: 999998;
			width: 46px;
			height: 46px;
			border: 0;
			border-radius: 50%;
			background: #198754;
			color: #fff;
			display: none;
			align-items: center;
			justify-content: center;
			font-size: 20px;
			box-shadow: 0 12px 35px rgba(25, 135, 84, .35);
			cursor: pointer;
		}

		.roofer-cookie-open.is-visible {
			display: flex;
		}

		@media (max-width: 991.98px) {
			.roofer-cookie-box {
				grid-template-columns: 1fr;
			}

			.roofer-cookie-actions {
				min-width: 0;
				justify-content: flex-start;
			}
		}

		@media (max-width: 575.98px) {
			.roofer-cookie-banner {
				padding: 10px;
			}

			.roofer-cookie-box {
				padding: 18px;
				border-radius: 14px;
			}

			.roofer-cookie-actions {
				display: grid;
				grid-template-columns: 1fr;
			}

			.roofer-cookie-btn {
				width: 100%;
			}
		}
	</style>

	<script>
		(function () {
			'use strict';

			const STORAGE_KEY = 'roofer_cookie_consent_v1';
			const COOKIE_NAME = 'roofer_cookie_consent';

			const banner = document.getElementById('roofer-cookie-banner');
			const openBtn = document.getElementById('roofer-cookie-open');

			const acceptBtn = document.getElementById('roofer-cookie-accept');
			const rejectBtn = document.getElementById('roofer-cookie-reject');
			const settingsBtn = document.getElementById('roofer-cookie-settings-btn');
			const saveBtn = document.getElementById('roofer-cookie-save');

			const settingsBox = document.getElementById('roofer-cookie-settings');
			const analyticsInput = document.getElementById('roofer-consent-analytics');
			const marketingInput = document.getElementById('roofer-consent-marketing');

			if (!banner || !openBtn) {
				return;
			}

			function setCookie(name, value, days) {
				const date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + date.toUTCString() + '; path=/; SameSite=Lax';
			}

			function getStoredConsent() {
				try {
					return JSON.parse(localStorage.getItem(STORAGE_KEY));
				} catch (error) {
					return null;
				}
			}

			function saveStoredConsent(consent) {
				const value = JSON.stringify(consent);
				localStorage.setItem(STORAGE_KEY, value);
				setCookie(COOKIE_NAME, value, 180);
			}

			function updateGoogleConsent(consent) {
				window.dataLayer = window.dataLayer || [];
				window.gtag = window.gtag || function(){ window.dataLayer.push(arguments); };

				gtag('consent', 'update', {
					'analytics_storage': consent.analytics ? 'granted' : 'denied',
					'ad_storage': consent.marketing ? 'granted' : 'denied',
					'ad_user_data': consent.marketing ? 'granted' : 'denied',
					'ad_personalization': consent.marketing ? 'granted' : 'denied',
					'personalization_storage': consent.marketing ? 'granted' : 'denied',
					'functionality_storage': 'granted',
					'security_storage': 'granted'
				});

				window.dispatchEvent(new CustomEvent('rooferConsentUpdated', {
					detail: consent
				}));
			}

			function hideBanner() {
				banner.classList.remove('is-visible');
				openBtn.classList.add('is-visible');
			}

			function showBanner() {
				banner.classList.add('is-visible');
				openBtn.classList.remove('is-visible');
			}

			function acceptAll() {
				const consent = {
					necessary: true,
					analytics: true,
					marketing: true,
					date: new Date().toISOString()
				};

				saveStoredConsent(consent);
				updateGoogleConsent(consent);
				hideBanner();
			}

			function rejectAll() {
				const consent = {
					necessary: true,
					analytics: false,
					marketing: false,
					date: new Date().toISOString()
				};

				saveStoredConsent(consent);
				updateGoogleConsent(consent);
				hideBanner();
			}

			function saveCustom() {
				const consent = {
					necessary: true,
					analytics: !!analyticsInput.checked,
					marketing: !!marketingInput.checked,
					date: new Date().toISOString()
				};

				saveStoredConsent(consent);
				updateGoogleConsent(consent);
				hideBanner();
			}

			function openSettings() {
				const isHidden = settingsBox.hasAttribute('hidden');

				if (isHidden) {
					settingsBox.removeAttribute('hidden');
					saveBtn.hidden = false;
					acceptBtn.hidden = true;
					settingsBtn.textContent = 'Ukryj ustawienia';
				} else {
					settingsBox.setAttribute('hidden', '');
					saveBtn.hidden = true;
					acceptBtn.hidden = false;
					settingsBtn.textContent = 'Ustawienia';
				}
			}

			acceptBtn.addEventListener('click', acceptAll);
			rejectBtn.addEventListener('click', rejectAll);
			saveBtn.addEventListener('click', saveCustom);
			settingsBtn.addEventListener('click', openSettings);

			openBtn.addEventListener('click', function () {
				const saved = getStoredConsent();

				if (saved) {
					analyticsInput.checked = !!saved.analytics;
					marketingInput.checked = !!saved.marketing;
				}

				showBanner();
			});

			const savedConsent = getStoredConsent();

			if (savedConsent) {
				updateGoogleConsent(savedConsent);
				openBtn.classList.add('is-visible');
			} else {
				showBanner();
			}
		})();
	</script>

	<?php
}
add_action( 'wp_footer', 'roofer_cookie_consent_banner', 100 );