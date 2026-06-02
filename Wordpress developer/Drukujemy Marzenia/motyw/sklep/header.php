<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header sticky-top vt-header bg-white pureshop-header-sticky">

<div class="container pureshop-max-width p-2">

    <div id="pure_shop_container_desktop" class="row align-items-center vt-header-top">

        <!-- LOGO + TOGGLER -->
        <div class="col-12 col-lg-3 m-0">

            <div class="vt-brand-row d-flex align-items-center justify-content-between w-100">

                <a class="vt-brand d-flex align-items-center text-decoration-none"
                   href="<?php echo esc_url(home_url('/')); ?>">

                    <img class="pureshop_header_logo"
                         src="<?php echo get_template_directory_uri() ?>/assets/img/logo_cut.png">

                    <span class="pureshop-logo-text">
                        Drukujemy <strong>PRZYSZŁOSĆ</strong>
                    </span>

                </a>

                <button class="navbar-toggler vt-navbar-toggler d-lg-none"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#mainMenu"
                        aria-controls="mainMenu"
                        aria-expanded="false"
                        aria-label="Menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>

        </div>

        <!-- MENU -->
        <div class="col-12 col-lg-7 vt-search-col d-flex align-items-center justify-content-center">

           <nav class="navbar navbar-expand-lg puresop-mobile-width position-relative vt-menu-wrapper">

    <div class="collapse navbar-collapse vt-menu-collapse justify-content-center"
         id="mainMenu">

        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'navbar-nav vt-main-menu flex-column flex-lg-row align-items-start align-items-lg-center',
            'fallback_cb'    => false,
            'depth'          => 3,
            'walker'         => new PURESHOP()
        ));
        ?>

        <div id="pureshop_header_activator_search" class="p-2">
            <i id="pureshop_activator_search" class="bi bi-search"></i>
        </div>

    </div>

</nav>

        </div>

        <!-- ICONS -->
        <div id="pureshop_header_mobile_client_menu"
             class="col-12 col-lg-2 d-flex justify-content-end align-items-center gap-2">

            <a href="/konto" class="pureshop-icon-btn pureshop-non-desktop">
                <i class="bi bi-person-circle"></i>
            </a>

            <a href="/ulubione" class="pureshop-icon-btn pureshop-non-desktop">
                <i class="bi bi-heart"></i>
            </a>

            <a href="/koszyk" class="pureshop-icon-btn">
                <i class="bi bi-cart3"></i>
            </a>

            <button id="themeToggle" class="pureshop-icon-btn">
                <i class="bi bi-sun-fill"></i>
                <i class="bi bi-moon-fill"></i>
            </button>
            

            <div class="pureshop-control position-relative">

                <button id="userMenuToggle" class="pureshop-icon-btn">
                    <i class="bi bi-person-circle"></i>
                </button>

                <div id="userDropdown" class="pureshop-dropdown">
                    <a href="/konto"><i class="bi bi-person"></i> Konto</a>
                    <div class="pureshop-divider"></div>
                    <a href="/ulubione"><i class="bi bi-heart"></i> Ulubione</a>
                </div>

            </div>

        </div>

    </div>

    <!-- SEARCH BAR -->
    <div id="pureshop-header-container-search-ID" class="pureshop-displaynone">

        <div class="container_header_form">

            <form role="search"
                  method="get"
                  class="d-flex align-items-center px-3 vt-search-wrap"
                  action="<?php echo esc_url(home_url('/')); ?>">

                <i class="bi bi-search text-white me-2"></i>

                <input type="search"
                       class="form-control vt-search-input px-0"
                       placeholder="Szukaj produktów..."
                       value="<?php echo esc_attr(get_search_query()); ?>"
                       name="s">

                <input type="hidden" name="post_type" value="product">

                <button type="submit" class="btn vt-search-btn px-0 ms-2">
                    Szukaj
                </button>

            </form>

        </div>

    </div>

</div>

</header>

<main>