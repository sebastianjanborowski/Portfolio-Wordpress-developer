  <!-- =========================================================
       FOOTER
       ========================================================= -->
  <footer class="blog-footer-bgc text-light pt-5 pb-4 mt-5">
  <div class="container">

    <div class="row g-4 align-items-start">

      <div class="col-12 col-lg-3 blog-mobile-center">
        <h5 class="fw-bold mb-3">Moda & Finezja</h5>
        <p class="small text-white-50 mb-3">
          Blog o modzie, stylu, beauty i kobiecym lifestyle’u. Inspiracje, trendy i praktyczne porady w eleganckiej formie.
        </p>
      </div>

      <div class="col-12 col-lg-3 blog-footer-menu-color">
        <h5 class="fw-bold mb-3">kategorie Modowe</h5>
          <?php
          wp_nav_menu([
            'theme_location' => 'dropdown_menu',
            'container'      => false,
            'menu_class'     => 'navbar-nav gap-lg-2 advancedBlog_menu',
            'fallback_cb'    => false,
            'depth'          => 3, // <- kluczowe dla zagnieżdżenia
            'walker'         => new advancedBlog_Bootstrap_Navwalker(),
          ]);
        ?>
      </div>

      <div class="col-12 col-lg-3">
        <div class="blog-footer-socialmedia">
          <h5 class="fw-bold mb-3">Dołącz do nas na</h5>
            <div class="d-flex gap-2">
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;">
                <i class="bi bi-youtube"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;">
                  <i class="bi bi-tiktok"></i>
              </a>
              <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px;">
                  <i class="bi bi-twitter-x"></i>
              </a>
           </div>
        </div>
      </div>
      

      <div class="col-12 col-lg-3 blog-mobile-center">
          <?php echo apply_shortcodes('[newsletter_form]'); ?>
      </div>

    </div>

    <hr class="border-secondary my-4">

    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 small text-white-50 text-center">
      <div><p> © <?php echo date('Y'); ?> Moda & Finezja. Wszystkie prawa zastrzeżone. </p></div>
      <div class="d-flex gap-3">
        <a href="#" class="text-white-50 text-decoration-none">Polityka prywatności</a>
        <a href="#" class="text-white-50 text-decoration-none">Regulamin</a>
      </div>
    </div>

  </div>
</footer>

<button id="scrollTopBtn" class="scroll-top-btn" type="button" aria-label="Przejdź do góry">
  <i class="bi bi-arrow-up-short"></i>
</button>

<?php wp_footer(); ?>