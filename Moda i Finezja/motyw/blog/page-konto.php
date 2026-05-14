<?php
/**
 * Template Name: Konto - Logowanie
 */
defined('ABSPATH') || exit;

$redirect_to = home_url('/blogowe-inspiracje/');

function advancedBlog_redirect_with_msg($ok = '', $err = '') {
  $url = wp_get_referer();

  if (!$url) {
    $url = home_url('/konto/');
  }

  $args = [];

  if ($ok !== '') {
    $args['advancedBlog_ok'] = $ok;
  }

  if ($err !== '') {
    $args['advancedBlog_err'] = $err;
  }

  wp_safe_redirect(add_query_arg($args, $url));
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode'])) {

  $mode = sanitize_text_field((string) wp_unslash($_POST['mode']));

  $nonce = isset($_POST['advancedBlog_nonce'])
    ? (string) wp_unslash($_POST['advancedBlog_nonce'])
    : '';

  if (!wp_verify_nonce($nonce, 'advancedBlog_konto')) {
    advancedBlog_redirect_with_msg('', 'Niepoprawny token formularza. Odśwież stronę i spróbuj ponownie.');
  }

  if ($mode === 'login') {

    $log = isset($_POST['log']) ? trim((string) wp_unslash($_POST['log'])) : '';
    $pwd = isset($_POST['pwd']) ? (string) wp_unslash($_POST['pwd']) : '';
    $remember = !empty($_POST['remember']);

    if ($log === '' || $pwd === '') {
      advancedBlog_redirect_with_msg('', 'Uzupełnij login/e-mail i hasło.');
    }

    $creds = [
      'user_login'    => $log,
      'user_password' => $pwd,
      'remember'      => $remember,
    ];

    $user = wp_signon($creds, is_ssl());

    if (is_wp_error($user)) {
      advancedBlog_redirect_with_msg('', 'Nieprawidłowy login/e-mail lub hasło.');
    }

    wp_safe_redirect($redirect_to);
    exit;
  }

  advancedBlog_redirect_with_msg('', 'Nieznany tryb formularza.');
}

get_header();

$err = isset($_GET['advancedBlog_err'])
  ? sanitize_text_field((string) $_GET['advancedBlog_err'])
  : '';

$ok = isset($_GET['advancedBlog_ok'])
  ? sanitize_text_field((string) $_GET['advancedBlog_ok'])
  : '';
?>

<main class="container d-flex align-items-center justify-content-center mt-4">

  <div class="row w-100 justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">

      <section class="advancedBlog-auth-box card shadow-sm p-4">

        <?php if (is_user_logged_in()) : ?>

          <?php $u = wp_get_current_user(); ?>

          <div class="text-center">

            <p class="mb-4">
              Jesteś Zalogowany jako:
              <strong><?php echo esc_html($u->user_login); ?></strong>
            </p>

            <div class="d-flex flex-column gap-2">
              <a class="btn btn-dark w-100" href="<?php echo esc_url($redirect_to); ?>">
                Przejdź do Blogowe inspiracje
              </a>

              <a class="btn btn-outline-dark w-100" href="<?php echo esc_url(wp_logout_url(home_url('/konto/'))); ?>">
                Wyloguj
              </a>
            </div>

          </div>

        <?php else : ?>

          <p class="advancedBlog-login-info text-center mb-4">
            Dostęp do konta jest nadawany indywidualnie.
            Jeżeli chcesz się zalogować, skontaktuj się z nami i umów sprawę dołączenia do naszego grona.
          </p>

          <?php if ($ok) : ?>
            <div class="alert alert-success">
              <?php echo esc_html($ok); ?>
            </div>
          <?php endif; ?>

          <?php if ($err) : ?>
            <div class="alert alert-danger">
              <?php echo esc_html($err); ?>
            </div>
          <?php endif; ?>

          <form method="post" class="advancedBlog-form-login">

            <?php wp_nonce_field('advancedBlog_konto', 'advancedBlog_nonce'); ?>

            <input type="hidden" name="mode" value="login">

            <div class="mb-3">
              <label class="form-label" for="advancedBlog-login">
                E-mail lub login
              </label>

              <input
                id="advancedBlog-login"
                required
                class="form-control"
                type="text"
                name="log"
                autocomplete="username"
              >
            </div>

            <div class="mb-3">
              <label class="form-label" for="advancedBlog-password">
                Hasło
              </label>

              <input
                id="advancedBlog-password"
                required
                class="form-control"
                type="password"
                name="pwd"
                autocomplete="current-password"
              >
            </div>

            <div class="d-flex justify-content-between align-items-center gap-3 mb-4 flex-wrap">

              <label class="form-check m-0">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="remember"
                  value="1"
                  checked
                >

                <span class="form-check-label">
                  Zapamiętaj mnie
                </span>
              </label>

              <a class="small text-dark blog-konto-dark" href="<?php echo esc_url(wp_lostpassword_url(get_permalink())); ?>">
                Nie pamiętasz hasła?
              </a>

            </div>

            <button type="submit" class="btn btn-dark w-100">
              Zaloguj
            </button>

          </form>

        <?php endif; ?>

      </section>

    </div>
  </div>

</main>

<?php get_footer(); ?>