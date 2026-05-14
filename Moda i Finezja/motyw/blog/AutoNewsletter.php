<?php
/**
 * Newsletter: zapis emaili do DB + panel w kokpicie + shortcode formularza AJAX + usuwanie wpisów + eksport CSV/Excel
 */

defined('ABSPATH') || exit;

global $blog_newsletter_db_version;
$blog_newsletter_db_version = '1.0.0';

function blog_newsletter_install_table() {
  global $wpdb;

  $table = $wpdb->prefix . 'newsletter_signups';
  $charset = $wpdb->get_charset_collate();

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';

  $sql = "CREATE TABLE {$table} (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(190) NOT NULL,
    ip VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY email_unique (email)
  ) {$charset};";

  dbDelta($sql);

  update_option('blog_newsletter_db_version', '1.0.0');
}

add_action('init', function () {
  if (get_option('blog_newsletter_db_version') === '1.0.0') {
    return;
  }

  blog_newsletter_install_table();
});

function blog_newsletter_add_email($email) {
  global $wpdb;

  $table = $wpdb->prefix . 'newsletter_signups';
  $email = sanitize_email($email);

  if (!$email || !is_email($email)) {
    return new WP_Error('invalid_email', 'Podaj poprawny adres e-mail.');
  }

  $existing = $wpdb->get_var(
    $wpdb->prepare("SELECT id FROM {$table} WHERE email = %s LIMIT 1", $email)
  );

  if ($existing) {
    return new WP_Error('duplicate', 'Ten e-mail jest już zapisany do newslettera.');
  }

  $ip = isset($_SERVER['REMOTE_ADDR'])
    ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']))
    : null;

  $ua = isset($_SERVER['HTTP_USER_AGENT'])
    ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT']))
    : null;

  $inserted = $wpdb->insert(
    $table,
    [
      'email'      => $email,
      'ip'         => $ip,
      'user_agent' => $ua,
      'created_at' => current_time('mysql'),
    ],
    ['%s', '%s', '%s', '%s']
  );

  if ($inserted === false) {
    return new WP_Error('db_error', 'Nie udało się zapisać e-maila. Spróbuj ponownie.');
  }

  return true;
}

add_action('wp_ajax_blog_newsletter_ajax_add', 'blog_newsletter_ajax_add');
add_action('wp_ajax_nopriv_blog_newsletter_ajax_add', 'blog_newsletter_ajax_add');

function blog_newsletter_ajax_add() {
  if (
    !isset($_POST['blog_newsletter_nonce']) ||
    !wp_verify_nonce(
      sanitize_text_field(wp_unslash($_POST['blog_newsletter_nonce'])),
      'blog_newsletter'
    )
  ) {
    wp_send_json_error([
      'type'    => 'error',
      'message' => 'Błąd zabezpieczenia formularza. Odśwież stronę i spróbuj ponownie.',
    ]);
  }

  $email = isset($_POST['blog_newsletter_email'])
    ? wp_unslash($_POST['blog_newsletter_email'])
    : '';

  $result = blog_newsletter_add_email($email);

  if ($result === true) {
    wp_send_json_success([
      'type'    => 'success',
      'message' => 'Dziękujemy! Twój e-mail został zapisany do newslettera.',
    ]);
  }

  wp_send_json_error([
    'type'    => $result->get_error_code() === 'duplicate' ? 'warning' : 'error',
    'message' => $result->get_error_message(),
  ]);
}

add_shortcode('newsletter_form', function ($atts) {
  $atts = shortcode_atts([
    'placeholder' => 'Wpisz swój e-mail',
    'button'      => 'Zapisz się',
  ], $atts);

  ob_start(); ?>
  <h5 class="fw-bold mb-3 blog-footer-kategorie">Dołącz do Newsletter</h5>
  <form method="post" class="holistic-footer-newsletter blog-newsletter-ajax-form">
    <?php wp_nonce_field('blog_newsletter', 'blog_newsletter_nonce'); ?>

    <input
      type="email"
      name="blog_newsletter_email"
      required
      placeholder="<?php echo esc_attr($atts['placeholder']); ?>"
    >
    
    <br/>

    <button type="submit" name="blog_newsletter_submit" value="1">
      <?php echo esc_html($atts['button']); ?>
    </button>

    <div class="blog-newsletter-result"></div>
  </form>

  <style>
    .blog-newsletter-message{
      width:80%;
      margin-top:10px;
      padding:10px 14px;
      border-radius:12px;
      font-size:14px;
      font-weight:600;
      line-height:1.4;
    }

    .blog-newsletter-success{
      color:#155724;
      background:#d4edda;
      border:1px solid #c3e6cb;
    }

    .blog-newsletter-warning{
      color:#856404;
      background:#fff3cd;
      border:1px solid #ffeeba;
    }

    .blog-newsletter-error{
      color:#721c24;
      background:#f8d7da;
      border:1px solid #f5c6cb;
    }

    .blog-newsletter-ajax-form button:disabled{
      opacity:.65;
      cursor:not-allowed;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.blog-newsletter-ajax-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
          e.preventDefault();

          const resultBox = form.querySelector('.blog-newsletter-result');
          const button = form.querySelector('button[type="submit"]');
          const emailInput = form.querySelector('input[name="blog_newsletter_email"]');
          const formData = new FormData(form);

          formData.append('action', 'blog_newsletter_ajax_add');

          button.disabled = true;
          resultBox.innerHTML = '';

          fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
          })
          .then(function (response) {
            return response.json();
          })
          .then(function (data) {
            const type = data && data.data && data.data.type ? data.data.type : 'error';
            const message = data && data.data && data.data.message ? data.data.message : 'Wystąpił błąd. Spróbuj ponownie.';

            resultBox.innerHTML =
              '<div class="blog-newsletter-message blog-newsletter-' + type + '">' +
              message +
              '</div>';

            if (data.success && emailInput) {
              emailInput.value = '';
            }
          })
          .catch(function () {
            resultBox.innerHTML =
              '<div class="blog-newsletter-message blog-newsletter-error">Wystąpił błąd. Spróbuj ponownie.</div>';
          })
          .finally(function () {
            button.disabled = false;
          });
        });
      });
    });
  </script>

  <?php
  return ob_get_clean();
});

add_action('admin_menu', function () {
  add_menu_page(
    'Newsletter',
    'Newsletter',
    'manage_options',
    'blog-newsletter',
    'blog_newsletter_admin_page',
    'dashicons-email-alt2',
    26
  );
});

add_action('admin_init', function () {
  if (
    !is_admin() ||
    !current_user_can('manage_options') ||
    !isset($_GET['page'], $_GET['blog_newsletter_export']) ||
    $_GET['page'] !== 'blog-newsletter' ||
    $_GET['blog_newsletter_export'] !== '1'
  ) {
    return;
  }

  check_admin_referer('blog_newsletter_export');

  global $wpdb;
  $table = $wpdb->prefix . 'newsletter_signups';

  $emails = $wpdb->get_col("SELECT email FROM {$table} ORDER BY id DESC");

  while (ob_get_level()) {
    ob_end_clean();
  }

  nocache_headers();

  header('Content-Type: text/csv; charset=UTF-8');
  header('Content-Disposition: attachment; filename=newsletter-emails.csv');
  header('Pragma: no-cache');
  header('Expires: 0');

  echo "\xEF\xBB\xBF";

  foreach ($emails as $email) {
    echo sanitize_email($email) . "\r\n";
  }

  exit;
});

function blog_newsletter_admin_page() {
  if (!current_user_can('manage_options')) {
    return;
  }

  global $wpdb;

  $table = $wpdb->prefix . 'newsletter_signups';

  if (
    isset($_GET['blog_newsletter_delete'], $_GET['_wpnonce']) &&
    $_GET['blog_newsletter_delete'] !== ''
  ) {
    $delete_id = absint($_GET['blog_newsletter_delete']);

    if (
      $delete_id > 0 &&
      wp_verify_nonce(
        sanitize_text_field(wp_unslash($_GET['_wpnonce'])),
        'blog_newsletter_delete_' . $delete_id
      )
    ) {
      $wpdb->delete($table, ['id' => $delete_id], ['%d']);

      wp_safe_redirect(admin_url('admin.php?page=blog-newsletter&deleted=1'));
      exit;
    }
  }

  $per_page = 50;
  $paged = max(1, absint($_GET['paged'] ?? 1));
  $offset = ($paged - 1) * $per_page;

  $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");

  $rows = $wpdb->get_results(
    $wpdb->prepare(
      "SELECT id, email, ip, created_at FROM {$table} ORDER BY id DESC LIMIT %d OFFSET %d",
      $per_page,
      $offset
    ),
    ARRAY_A
  );

  $total_pages = max(1, (int) ceil($total / $per_page));

  echo '<div class="wrap">';
  echo '<h1>Newsletter – zapisane e-maile</h1>';

  if (isset($_GET['deleted']) && $_GET['deleted'] === '1') {
    echo '<div class="notice notice-success is-dismissible"><p>E-mail został usunięty.</p></div>';
  }

  echo '<p>';
  echo 'Łącznie: <strong>' . esc_html($total) . '</strong>';
  echo ' | ';
  echo '<a class="button button-primary" href="' . esc_url(wp_nonce_url(admin_url('admin.php?page=blog-newsletter&blog_newsletter_export=1'), 'blog_newsletter_export')) . '">Eksport Excel</a>';
  echo '</p>';

  echo '<table class="widefat striped">';
  echo '<thead>';
  echo '<tr>';
  echo '<th>ID</th>';
  echo '<th>E-mail</th>';
  echo '<th>IP</th>';
  echo '<th>Data</th>';
  echo '<th>Akcja</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  if (!$rows) {
    echo '<tr><td colspan="5">Brak zapisów.</td></tr>';
  } else {
    foreach ($rows as $r) {
      $delete_url = wp_nonce_url(
        admin_url('admin.php?page=blog-newsletter&blog_newsletter_delete=' . absint($r['id'])),
        'blog_newsletter_delete_' . absint($r['id'])
      );

      echo '<tr>';
      echo '<td>' . esc_html($r['id']) . '</td>';
      echo '<td><strong>' . esc_html($r['email']) . '</strong></td>';
      echo '<td>' . esc_html($r['ip'] ?: '-') . '</td>';
      echo '<td>' . esc_html($r['created_at']) . '</td>';
      echo '<td>';
      echo '<a class="button button-small button-link-delete" href="' . esc_url($delete_url) . '" onclick="return confirm(\'Na pewno usunąć ten e-mail?\');">Usuń</a>';
      echo '</td>';
      echo '</tr>';
    }
  }

  echo '</tbody>';
  echo '</table>';

  if ($total_pages > 1) {
    echo '<p style="margin-top:12px;">';

    for ($i = 1; $i <= $total_pages; $i++) {
      $url = admin_url('admin.php?page=blog-newsletter&paged=' . $i);

      if ($i === $paged) {
        echo '<strong style="margin-right:8px;">' . esc_html($i) . '</strong>';
      } else {
        echo '<a style="margin-right:8px;" href="' . esc_url($url) . '">' . esc_html($i) . '</a>';
      }
    }

    echo '</p>';
  }

  echo '</div>';
}