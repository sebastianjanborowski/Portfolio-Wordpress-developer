<?php
$theme_uri = get_template_directory_uri();
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="robots" content="noindex,nofollow" />
  <title><?php bloginfo('name'); ?></title>

  <?php wp_head(); ?>
  

</head>

<body <?php body_class('bg-blobs'); ?>>
<?php wp_body_open(); ?>

<div class="page-layer">

<header class="topbar sticky-top bydlo-index">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg py-2">

      <a class="brand-wrap navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <span class="brand-logo">
          <img
            src="<?php echo esc_url($theme_uri); ?>/assets/img/produkcja/zlote_logo.png"
            alt="Logo"
            loading="eager"
            decoding="async"
          >
        </span>
        <span class="brand-title"></span>
      </a>

      <button
  id="holistic_main_menu_mobile_button"
  class="navbar-toggler holistic-white-toggler"
  type="button"
  aria-controls="mainNav"
  aria-expanded="false"
  aria-label="Menu"
>
  <span class="navbar-toggler-icon"></span>
</button>

      <div id="mainNav">

        <?php
        wp_nav_menu([
          'theme_location' => 'main_menu',
          'container'      => false,
          'menu_class'     => 'navbar-nav mx-auto gap-lg-2 bydlo_menu',
          'fallback_cb'    => false,
          'depth'          => 3,
          'walker'         => new Bydlo_Bootstrap_Navwalker(),
        ]);
        ?>
        <div class="holistic-socialmedia-header-mobile">

        <div class="holistic-header-menu-container">
          <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="holistic-menu-mobile-koszyk" aria-label="Koszyk">
            <i class="bi bi-bag"></i>
            <span class="holistic-header-cart-count">
              <?php echo function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
            </span>
          </a>

          <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="holistic-menu-mobile-konto">
              <i class="bi bi-person-circle"></i>
          </a>
        </div>

        <div class="d-flex gap-2 justify-content-center py-2 py-lg-0 mt-2">
            <a class="holistic-menu-mobile-booksy" href="https://holisticbeautylidiasyska.booksy.com/a/">
                <img src="<?php echo get_template_directory_uri() ?>/assets/img/produkcja/booksy_white_border.png">
            </a>
          </div>
      
        </div>
        <div class="d-flex gap-2 justify-content-center py-2 py-lg-0 bydlo-menu-socialmedia mt-2">
           <a class="holistic-header-link-booksy" href="https://holisticbeautylidiasyska.booksy.com/a/">
              <img src="<?php echo get_template_directory_uri() ?>/assets/img/produkcja/booksy_white_border.png">
           </a>
        </div>

        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="holistic-header-cart" aria-label="Koszyk">
          <i class="bi bi-bag"></i>
          <span class="holistic-header-cart-count">
            <?php echo function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
          </span>
        </a>
        
          <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="holistic-header-user-greeting">
            <i class="bi bi-person-circle"></i>
          </a>
          
      </div>

    </nav>
  </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const button = document.getElementById("holistic_main_menu_mobile_button");
  const menu = document.getElementById("mainNav");

  if (!button || !menu) return;

  button.addEventListener("click", function () {
    const isOpen = menu.classList.toggle("is-open");
    button.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });
});
</script>