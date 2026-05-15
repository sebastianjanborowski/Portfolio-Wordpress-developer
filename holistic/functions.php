<?php
defined('ABSPATH') || exit;

require_once get_stylesheet_directory() . '/holistic-newsletter.php';

if (is_admin()) {
    return;
}


/**
 * Assets (JEDEN Bootstrap: CDN)
 */
add_action('wp_enqueue_scripts', function () {
  if (is_admin()) return;

  $theme_uri = get_template_directory_uri();

  // === Bootstrap 5.3.3 (CDN) ===
  wp_enqueue_style(
    'bootstrap',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    [],
    '5.3.3'
  );

  wp_enqueue_script(
    'bootstrap-bundle',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
    [],
    '5.3.3',
    true
  );
  // NIE dawaj defer na bootstrap-bundle (unikasz wyścigów inicjalizacji)

  // === Bootstrap Icons (lokalnie) ===
  wp_enqueue_style(
    'bootstrap_icons_local',
    $theme_uri . '/assets/css/bootstrap-icons-local.css',
    [],
    '1.0.0'
  );

  // === Theme CSS ===
  wp_enqueue_style(
    'bydlo-style',
    $theme_uri . '/assets/css/style.css',
    ['bootstrap'],
    '0.0.1'
  );

  // === Theme JS (po Bootstrap) ===
  wp_enqueue_script(
    'bydlo-script',
    $theme_uri . '/assets/js/script.js',
    ['bootstrap-bundle'],
    '0.0.1',
    true
  );
  wp_script_add_data('bydlo-script', 'defer', true);

}, 20);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
  register_nav_menus([
    'main_menu'   => 'Menu główne',
    'footer_menu' => 'Menu footer',
  ]);

  add_theme_support('post-thumbnails');

  add_theme_support('woocommerce');

});

/**
 * WooCommerce: Layout "Moje konto" (wrappery + hero)
 */
add_action('wp', function () {
  if (function_exists('is_account_page') && is_account_page()) {

    // HERO przed treścią "My Account"
    add_action('woocommerce_before_main_content', function () {
      ?>
      <header class="beauty-page-hero beauty-account-hero">
        <div class="container">
          <div class="beauty-page-hero__inner">
            <h1 class="beauty-page-title">My Account</h1>
            <div class="beauty-page-ornament" aria-hidden="true"></div>
          </div>
        </div>
      </header>
      <?php
    }, 5);

    // Wrappery układu 2 kolumny
    add_action('woocommerce_before_account_navigation', function () {
      echo '<section class="beauty-account py-5"><div class="container"><div class="beauty-paper shadow-sm"><div class="row g-4">';
      echo '<div class="col-12 col-lg-3">';
      echo '<aside class="beauty-account-nav">';
    }, 5);

    add_action('woocommerce_after_account_navigation', function () {
      echo '</aside></div><div class="col-12 col-lg-9">';
      echo '<div class="beauty-account-content">';
    }, 5);

    add_action('woocommerce_after_account_content', function () {
      echo '</div></div></div></div></div></section>';
    }, 50);
  }
});

/**
 * WooCommerce: siatka produktów (Bootstrap grid) – dla archiwum sklepu i taksonomii
 */
add_filter('woocommerce_post_class', function ($classes, $product) {
  if (is_shop() || is_product_taxonomy()) {
    // Desktop 3, tablet 2, mobile 1
    $classes[] = 'col-12';
    $classes[] = 'col-sm-6';
    $classes[] = 'col-lg-4';
    $classes[] = 'mb-4';
  }
  return $classes;
}, 10, 2);

/**
 * WooCommerce: ul.products jako Bootstrap row g-4
 */
add_filter('woocommerce_product_loop_start', function ($html) {
  return str_replace('class="products', 'class="products row g-4', $html);
});


add_filter('template_include', function ($template) {

  if (function_exists('is_shop') && is_shop() && function_exists('wc_locate_template')) {
    $t = wc_locate_template('archive-product.php'); // motyw/woocommerce/archive-product.php -> motyw/archive-product.php -> plugin
    if (!empty($t)) return $t;
  }

  return $template;
}, 9999);

// paginacja archive-product.php

add_filter('template_include', function ($template) {

    if (is_singular('product')) {
        return $template;
    }

    if (is_product()) {
        return $template;
    }

    if (is_shop() || is_post_type_archive('product')) {
        $archive_product = locate_template('woocommerce/archive-product.php');

        if ($archive_product) {
            return $archive_product;
        }
    }

    return $template;

}, 99);


/**
 * Navwalker (depth 3)
 */
class Bydlo_Bootstrap_Navwalker extends Walker_Nav_Menu {

  public function start_lvl(&$output, $depth = 0, $args = null) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }

  public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
    $indent = ($depth) ? str_repeat("\t", $depth) : '';
    $has_children = in_array('menu-item-has-children', (array) $item->classes, true);

    // LI classes
    if ($depth === 0) {
      $li_classes = ['nav-item'];
      if ($has_children) $li_classes[] = 'dropdown';
    } else {
      $li_classes = [];
      if ($has_children) $li_classes[] = 'dropdown-submenu';
    }

    $output .= $indent . '<li class="' . esc_attr(implode(' ', $li_classes)) . '">';

    // A classes
    $a_classes = ($depth === 0) ? ['nav-link'] : ['dropdown-item'];

    $atts = [];
    $atts['href'] = !empty($item->url) ? $item->url : '#';

    // Level 0 dropdown (Bootstrap)
    if ($has_children && $depth === 0) {
      $a_classes[] = 'dropdown-toggle';
      $atts['href'] = '#';
      $atts['data-bs-toggle'] = 'dropdown';
      $atts['data-bs-auto-close'] = 'outside';
      $atts['aria-expanded'] = 'false';
      $atts['role'] = 'button';
      $atts['data-bs-display'] = 'static';
    }

    // Level 1+ submenu (custom JS)
    if ($has_children && $depth >= 1) {
      $a_classes[] = 'dropdown-toggle';
      $a_classes[] = 'bydlo-submenu-toggle';
      $atts['href'] = '#';
      $atts['data-bydlo-submenu'] = '1';
      $atts['aria-expanded'] = 'false';
      $atts['role'] = 'button';
    }

    $attributes = '';
    foreach ($atts as $attr => $value) {
      $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
    }

    $title = apply_filters('the_title', $item->title, $item->ID);

    $output .= '<a class="' . esc_attr(implode(' ', $a_classes)) . '"' . $attributes . '>';
    $output .= esc_html($title);
    $output .= '</a>';
  }

  public function end_el(&$output, $item, $depth = 0, $args = null) {
    $output .= "</li>\n";
  }
}


// dodanie powtórz hasło do formularza rejestracji usera
?>

<?php function holistic_custom_field_registration(){ ?>
  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="reg_password2">
      Powtórz hasło <span class="required">*</span>
    </label>
    <input type="password"
               class="woocommerce-Input woocommerce-Input--text input-text"
               name="password2"
               id="reg_password2"
               autocomplete="new-password" />
  </p>
<?php }

add_action('woocommerce_register_form','holistic_custom_field_registration');

// walidacja hasła
function holistic_custom_firld_valisate($errors,$username,$email){
  if(isset($_POST['password']) && isset($_POST['password2'])){
    if($_POST['password'] !== $_POST['password2']){
      $errors->add('password_error','Hasła nie są takie same.');
    }
  }

  if(empty($_POST['password2'])){
    $errors->add('password2_error','Pole "Powtórz hasło" jest wymagane.');
  }

  return $errors;
}

add_filter('woocommerce_registration_errors','holistic_custom_firld_valisate',10,3);