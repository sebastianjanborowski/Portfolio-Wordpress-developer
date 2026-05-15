<?php
/**
 * Template Name: Kontakt
 */
get_header();
?>



<main class="beauty-contact">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <!-- Nagłówek jak w Twoim stylu (opcjonalnie) -->
    <header class="beauty-page-hero">
      <div class="container">
        <div class="beauty-page-hero__inner">
          <h1 class="beauty-page-title"><?php the_title(); ?>
            <br/>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/produkcja/podkreslnik_title_cut.png" alt="Podkreślnik tytułu podstrony">
          </h1>
        </div>
      </div>
    </header>

    <section class="beauty-contact-section py-5">
      <div class="container">

        <div class="beauty-paper shadow-sm">

          <div class="row g-4">

            <!-- LEWA: Formularz -->
            <div class="col-12 col-lg-7">
              <h2 class="beauty-box-title mb-3">Wyślij do nas wiadomość</h2>

              <div class="beauty-cf7">
                <!-- WSTAW SHORTCODE CF7 -->
                <?php echo do_shortcode('[contact-form-7 id="4022b3b" title="Kontakt"]'); ?>
              </div>
            </div>

            <!-- PRAWA: Dane kontaktowe -->
            <div class="col-12 col-lg-5">
              <div class="holistic-kontakt-main-img">
                    <img src="<?php echo get_template_directory_uri()?>/assets/img/produkcja/lidia_syska_kontakt.jpg">
                    <div class="p-3 rounded-4 bg-white bg-opacity-75 shadow-sm">
                        <h2 class="fw-semibold" style="color:#c9a45c; font-family: 'Playfair Display', serif;">
                            Świadoma pielęgnacja,
                        </h2>
                        <p class="mb-0 text-dark" style="line-height:1.7;">
                            holistyczne podejście i troska o Twoje piękno 
                            zaczynają się właśnie tutaj — skontaktuj się ze mną. Lidia Syska
                        </p>
                    </div>
              </div>

              <div class="holistic-kontakt-informacje-kafelek p-3">
                  <h2 class="beauty-box-title mb-3">Informacje kontaktowe</h2>

                  <ul class="beauty-contact-list list-unstyled m-0">
                  <li class="d-flex align-items-start">
                    <i class="bi bi-telephone-fill beauty-ico"></i>
                    <div>
                      <div class="beauty-label">Kontakt</div>
                      <a class="beauty-link" href="tel:+48123456789">+48 661 751 391</a>
                    </div>
                  </li>

                  <li class="d-flex gap-3 align-items-start">
                    <i class="bi bi-envelope-fill beauty-ico"></i>
                    <div>
                      <div class="beauty-label">Email</div>
                      <a class="beauty-link" href="mailto:info@beautyclinic.pl">lidia.holistic.beauty@gmail.com</a>
                    </div>
                  </li>

                  <li class="d-flex gap-3 align-items-start">
                    <i class="bi bi-geo-alt-fill beauty-ico"></i>
                    <div>
                      <div class="beauty-label">Lokalizacja</div>
                      <div class="beauty-text">
                        ul. Rubinowa 55a/5 05-509 Piaseczno
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
             
            </div>

          </div>

          <!-- MAPA -->
          <div class="beauty-map-wrap mt-4">
            <!-- Wklej iframe z Google Maps -->
            <iframe
              class="beauty-map"
  src="https://www.google.com/maps?q=ul.+Rubinowa+55a/5,+05-509+Piaseczno&output=embed"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Mapa dojazdu"
            ></iframe>
          </div>

        </div>

        <!-- Treść strony (jeśli chcesz coś dopisać w edytorze WP) -->
        <?php if (trim(get_the_content())) : ?>
          <div class="mt-4">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>

      </div>
    </section>

  <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
