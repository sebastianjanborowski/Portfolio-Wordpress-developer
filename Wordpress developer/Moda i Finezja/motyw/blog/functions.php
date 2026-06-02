<?php
require_once get_template_directory().'/AutoNewsletter.php';

add_action('wp_enqueue_scripts', function () {

  if (is_admin()) return;

  $theme_uri = get_template_directory_uri();

  // bootstrap icons (lokalnie)
  wp_enqueue_style(
    'bootstrap_icons_local',
    get_template_directory_uri() . '/assets/css/bootstrap-icons-local.css',
    [],
    '1.0.0',
    'all'
  );

  // =========================
  // BOOTSTRAP MINIMAL (CSS)
  // =========================
  wp_enqueue_style(
    'bootstrap_min',
    $theme_uri . '/assets/css/bootstrap-minimal.min.css',
    [],
    '5.3.3-min-0.0.2',
    'all'
  );

  // =========================
  // THEME CSS (po bootstrap_min)
  // =========================
  wp_enqueue_style(
    'advancedBlog-style',
    $theme_uri . '/assets/css/style.css',
    ['bootstrap_min'],
    '1.0.0',
    'all'
  );

  // =========================
  // BOOTSTRAP MINIMAL (JS)
  // =========================
  wp_enqueue_script(
    'bootstrap_min_js',
    $theme_uri . '/assets/js/bootstrap-minimal.bundle.js',
    [],
    '5.3.3-min-0.0.2',
    true
  );
  wp_script_add_data('bootstrap_min_js', 'defer', true);

  // =========================
  // THEME JS (po bootstrap_min_js)
  // =========================
  wp_enqueue_script(
    'advancedBlog-script',
    $theme_uri . '/assets/js/script.js',
    ['bootstrap_min_js'],
    '0.0.1',
    true
  );
  wp_script_add_data('advancedBlog-script', 'defer', true);

  wp_script_add_data('advancedBlog-kwz_slider', 'defer', true);

  // =========================
  // WCAG JS (po bootstrap_min_js)
  // =========================
  wp_enqueue_script(
    'wcag_js',
    $theme_uri . '/assets/js/wcag.js',
    ['bootstrap_min_js'],
    '0.0.1',
    true
  );
  wp_script_add_data('wcag_js', 'defer', true);

  // =========================
  // WCAG - dane do JS
  // =========================
  wp_localize_script('wcag_js', 'advancedBlog', [
    'wcag_css_url' => $theme_uri . '/assets/css/style_wcag.css',
    'wcag_css_ver' => '0.0.1',
  ]);

}, 20);

add_action('after_setup_theme', function () {

  register_nav_menus([
    'main_menu'     => 'Menu główne',
    'dropdown_menu' => 'Rozwijane menu'
  ]);

  add_theme_support('post-thumbnails');

});

add_filter('style_loader_tag', function ($html, $handle, $href, $media) {

  // asynchronicznie tylko to, co NIE wpływa na layout above-the-fold
  $async_handles = [
    'bootstrap_icons_local',
    'wp-block-library',
    'wp-block-library-theme'
  ];

  // krytyczne: bootstrap + Twój styl
  $critical_handles = [
    'bootstrap_min',
    'advancedBlog-style'
  ];

  if (in_array($handle, $critical_handles, true)) {
    return $html;
  }

  if (!in_array($handle, $async_handles, true)) {
    return $html;
  }

  $href = esc_url($href);

  return '<link rel="preload" as="style" href="' . $href . '">' . "\n"
       . '<link rel="stylesheet" href="' . $href . '" media="print" onload="this.media=\'all\'">' . "\n"
       . '<noscript><link rel="stylesheet" href="' . $href . '"></noscript>' . "\n";

}, 10, 4);

// depth 3
class advancedBlog_Bootstrap_Navwalker extends Walker_Nav_Menu {

  public function start_lvl( &$output, $depth = 0, $args = null ) {
    $indent = str_repeat("\t", $depth);
    // Bootstrap dropdown-menu
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }

  public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
    $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
    $has_children = in_array('menu-item-has-children', (array) $item->classes, true);

    // LI klasy
    if ($depth === 0) {
      $li_classes = ['nav-item'];
      if ($has_children) $li_classes[] = 'dropdown';
    } else {
      $li_classes = [];
      if ($has_children) $li_classes[] = 'dropdown-submenu';
    }

    $output .= $indent . '<li class="' . esc_attr(implode(' ', $li_classes)) . '">';

    // A klasy
    $a_classes = ($depth === 0) ? ['nav-link'] : ['dropdown-item'];

    $atts = [];
    $atts['href'] = ! empty($item->url) ? $item->url : '#';

    // POZIOM 0 – Bootstrap dropdown (klik)
    if ($has_children && $depth === 0) {
      $a_classes[] = 'dropdown-toggle';
      $atts['href'] = '#';
      $atts['data-bs-toggle'] = 'dropdown';
      $atts['data-bs-auto-close'] = 'outside'; // stabilnie
      $atts['aria-expanded'] = 'false';
      $atts['role'] = 'button';
      $atts['data-bs-display'] = 'static';
    }

    // POZIOM 1+ – submenu (klik) – własny mechanizm w JS
    if ($has_children && $depth >= 1) {
      $a_classes[] = 'dropdown-toggle';
      $a_classes[] = 'advancedBlog-submenu-toggle';
      $atts['href'] = '#';
      $atts['data-advancedBlog-submenu'] = '1';
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

  public function end_el( &$output, $item, $depth = 0, $args = null ) {
    $output .= "</li>\n";
  }
}
