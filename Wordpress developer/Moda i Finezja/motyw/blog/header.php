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
  <header class="topbar sticky-top advancedBlog-index blog-dark-bgc">
    <div class="container container-custom">
      <nav class="navbar navbar-expand-lg py-2">

        <a title="Moda i Finezja" class="brand-wrap navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
          <span class="brand-logo">
            <!-- PODMIEŃ NA: /assets/img/logo.png -->
            <img src="<?php echo esc_url($theme_uri); ?>/assets/img/logo.png" alt="Logo">
          </span>
        </a>

        
        <span id="advancedBlog_wcag_activator_mobile" class="social-btn"><img  class="advancedBlog_wcag_activator_img" src="<?php echo esc_url($theme_uri) ?>/assets/img/wcag.png"></span>

        <button id="advancedBlog_main_menu_mobile_button" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Menu">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
       
          <?php
            wp_nav_menu([
              'theme_location' => 'main_menu',
              'container'      => false,
              'menu_class'     => 'navbar-nav mx-auto gap-lg-2 advancedBlog_menu',
              'fallback_cb'    => false,
              'depth'          => 3, // <- kluczowe dla zagnieżdżenia
              'walker'         => new advancedBlog_Bootstrap_Navwalker(),
            ]);

          ?>
          

          <div class="d-flex justify-content-center py-2 py-lg-0 advancedBlog-menu-socialmedia">
            <div class="d-flex advancedBlog-socialmedia-icons-one">
              <span title="Menu WCAG" id="advancedBlog_wcag_activator" class="social-btn"><img class="advancedBlog_wcag_activator_img" src="<?php echo esc_url($theme_uri) ?>/assets/img/wcag.png"></span>
            </div>
          </div>
           
        </div>
        

        <div id="advancedBlog_wcag_menu" class="advancedBlog_nonVisibility">

           <div id="advancedBlog_wcag_light" class="advancedBlog-container-wcag" title="Tryb jasny">
                <i class="bi bi-sun"></i>
            </div>

            <div id="advancedBlog_wcag_dark" class="advancedBlog-container-wcag" title="Tryb ciemny">
                <i class="bi bi-moon-stars"></i>
            </div>

            <div id="advancedBlog_wcag_aplus" class="advancedBlog-container-wcag" title="Zwiększ tekst">
                <i class="bi bi-plus-lg"></i>
                <span>A</span>
            </div>

             <div id="advancedBlog_wcag_minus" class="advancedBlog-container-wcag" title="Zmniejsz tekst">
                <i class="bi bi-dash-lg"></i>
                <span>A</span>
            </div>

        </div>

      </nav>
    </div>

  </header>
