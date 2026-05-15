<?php 
// URL do katalogu motywu (do obrazków)
$theme_uri = get_template_directory_uri();?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="robots" content="noindex,nofollow" />
  <title><?php bloginfo('name'); ?></title>

<?php wp_head(); ?>

</head>

<body class="bg-blobs">
  
  

<div class="page-layer">

  <!-- =========================================================
       NAVBAR
       ========================================================= -->


  <header class="topbar sticky-top bydlo-index">
    <div class="container">
      <nav class="navbar navbar-expand-lg py-2">

        <a class="brand-wrap navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
          <span class="brand-logo">
            <!-- PODMIEŃ NA: /assets/img/logo.png -->
            <img src="<?php echo esc_url($theme_uri); ?>/assets/img/produkcja/zlote_logo.png" alt="Logo">
          </span>
          <span class="brand-title">
            <!-- nazwa firmy -->
          </span>
        </a>

        <button id="bydlo_main_menu_mobile_button" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Menu">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
       
          <?php
            wp_nav_menu([
              'theme_location' => 'main_menu',
              'container'      => false,
              'menu_class'     => 'navbar-nav mx-auto gap-lg-2 bydlo_menu',
              'fallback_cb'    => false,
              'depth'          => 3, // <- kluczowe dla zagnieżdżenia
              'walker'         => new Bydlo_Bootstrap_Navwalker(),
            ]);

          ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="holistic-header-cart" aria-label="Koszyk">
              <i class="bi bi-bag"></i>
              <span class="holistic-header-cart-count">
                <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
              </span>
            </a>

          <div class="d-flex gap-2 justify-content-center py-2 py-lg-0 bydlo-menu-socialmedia">
              <a target="_blank" href="https://holisticbeautylidiasyska.booksy.com/a/" class="holistic_menu_button_booksy" title="Zarezerwój wizyte na Booksy">Zarezerwuj wizyte przez </br> <span>Booksy</span></a>
          </div>

          <?php if ( is_user_logged_in() ) : ?>
            <?php $current_user = wp_get_current_user(); ?>
            <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>" class="holistic-header-user-greeting">
              <span class="holistic-header-user-name">Witaj</span>
              <span class="holistic-header-user-name"><?php echo esc_html( $current_user->display_name ); ?></span>
            </a>
          <?php else : ?>
            <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>" class="holistic-header-user-greeting">
              Zaloguj się
            </a>
          <?php endif; ?>
        </div>

      </nav>
    </div>
    <!-- rozwijane menu obsługiwane skryptem  -->
    <div id="bydlo_menu_dropdown" class="bydlo_nonVisibility">
      <?php
          wp_nav_menu([
            'theme_location' => 'dropdown_menu',
            'container'      => false,
            'menu_class'     => 'navbar-nav mx-auto gap-lg-2 bydlo_menu',
            'fallback_cb'    => false,
            'depth'          => 3, // <- kluczowe dla zagnieżdżenia
            'walker'         => new Bydlo_Bootstrap_Navwalker(),
          ]);
      ?>
    </div>

  </header>


