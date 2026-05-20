<?php $theme_uri = get_template_directory_uri(); ?>
<footer class="beauty-footer position-relative text-light">
  <div class="container py-5">

    <!-- OZDOBNIK GÓRNY -->
    <div class="holistic-ozdobnik-wrap holistic-ozdobnik-wrap--top">
      <img 
        class="holistic-ozdobnik-img holistic-ozdobnik-img--bottom"
        src="<?php echo esc_url($theme_uri . '/assets/img/produkcja/podkreslnik_title_cut.png'); ?>" 
        alt="Ozdobnik footer"
      >
    </div>

    <div class="row g-4 align-items-start">

      <!-- Newsletter -->
      <div class="col-12 col-lg-3 beauty-footer-col">
        <div class="beauty-footer-title">Newsletter</div>

        <div class="footer-brand-wrap">
          <div class="row justify-content-center">
            <?php echo apply_shortcodes('[newsletter_form]'); ?>
          </div>
        </div>
      </div>

      <!-- Kontakt -->
      <div class="col-12 col-lg-3 beauty-footer-col">
        <div class="beauty-footer-title">Kontakt</div>

        <ul class="list-unstyled m-0 beauty-footer-list">
          <li class="d-flex gap-3 align-items-start">
            <span>
              <i class="bi bi-telephone-fill beauty-footer-ico"></i>
              <a class="beauty-footer-link" href="tel:+48661751391">661 751 391</a>
            </span>
          </li>

          <li class="d-flex gap-3 align-items-start">
            <span>
              <i class="bi bi-envelope-fill beauty-footer-ico"></i>
              <a class="beauty-footer-link" href="mailto:lidia.holistic.beauty@gmail.com">lidia.holistic.beauty@gmail.com</a>
            </span>
          </li>

          <li class="d-flex gap-3 align-items-start">
            <span class="beauty-footer-text">
              <i class="bi bi-geo-alt-fill beauty-footer-ico"></i>
              ul. Rubinowa 55a/5,<br>
              05-509 Piaseczno
            </span>
          </li>
        </ul>
      </div>

      <!-- Menu -->
      <div class="col-12 col-lg-3 beauty-footer-col beauty-footer-col-bordered">
        <div class="beauty-footer-title">Menu</div>

        <?php
          wp_nav_menu([
            'theme_location' => 'footer_menu',
            'container'      => false,
            'menu_class'     => 'list-unstyled m-0 beauty-footer-menu',
            'fallback_cb'    => false,
            'depth'          => 1,
            'link_before'    => '<span class="beauty-footer-bullet">›</span>',
            'link_after'     => '',
          ]);
        ?>
      </div>

      <!-- Social Media -->
      <div class="col-12 col-lg-3 beauty-footer-col beauty-footer-col-bordered">
        <div class="beauty-footer-title">Social Media</div>

        <div class="beauty-footer-social mt-2">
          <div class="holistic-footer-icons">
            <a title="Facebook" class="beauty-footer-socialbtn" href="https://www.facebook.com/Lidia.Holistic.Beauty/" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
              <i class="bi bi-facebook"></i>
            </a>

            <a title="Booksy" class="beauty-footer-socialbtn" href="https://holisticbeautylidiasyska.booksy.com/a/" aria-label="Booksy" target="_blank" rel="noopener noreferrer">
             <img src="<?php echo get_template_directory_uri() ?>/assets/img/produkcja/booksyicon_footer.png">
            </a>

            <a title="Instagram" class="beauty-footer-socialbtn" href="#" aria-label="Instagram">
              <i class="bi bi-instagram"></i>
            </a>

            <a title="YouTube" class="beauty-footer-socialbtn" href="https://www.youtube.com/@lidias823" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
              <i class="bi bi-youtube"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- OZDOBNIK DOLNY -->
    <div class="holistic-ozdobnik-wrap holistic-ozdobnik-wrap--bottom">
      <img 
        class="holistic-ozdobnik-img"
        src="<?php echo esc_url($theme_uri . '/assets/img/produkcja/podkreslnik_title_cut.png'); ?>" 
        alt="Ozdobnik footer"
      >
    </div>

    <!-- Bottom -->
    <div class="row mt-5 pt-4 beauty-footer-bottom align-items-center">
      <div class="col-12 col-md-8 text-center text-md-start">
        © <?php echo date('Y'); ?> Gabinet Kosmetyczny Holistic Beauty — wszelkie prawa zastrzeżone.
      </div>
      <div class="col-12 col-md-4 text-center text-md-end mt-3 mt-md-0">
        <a class="beauty-footer-link" href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Polityka prywatności</a>
      </div>
    </div>

  </div>
</footer>

<div id="holistic-button-to-top">
  <i class="bi bi-chevron-right"></i>
</div>

<div id="holistic-messanger">
  <a id="holistic-button-messenger" 
   href="https://m.me/Lidia.Holistic.Beauty" 
   target="_blank" 
   rel="noopener noreferrer"
   aria-label="Napisz na Messengerze">
  <i class="bi bi-messenger"></i>
</a>
</div>

<?php wp_footer(); ?>
</body>
</html>