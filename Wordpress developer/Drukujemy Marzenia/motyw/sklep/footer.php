<?php
/**
 * Footer
 */
?>
</main>

<footer class="mr-footer-light">

    <div class="container-fluid pureshop-max-width">

        <div class="mr-footer-benefits">
            <div class="row">

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="mr-footer-benefit-item">
                        <div class="mr-footer-benefit-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <h5>Wysoka jakość</h5>
                            <p>Drukujemy w technologii 3D z dbałością o każdy detal.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="mr-footer-benefit-item">
                        <div class="mr-footer-benefit-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h5>Bezpieczne płatności</h5>
                            <p>Twoje płatności są chronione i realizowane bezpiecznie.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="mr-footer-benefit-item">
                        <div class="mr-footer-benefit-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h5>Szybka realizacja</h5>
                            <p>Krótki czas produkcji oraz sprawna wysyłka zamówień.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="mr-footer-benefit-item">
                        <div class="mr-footer-benefit-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div>
                            <h5>Wsparcie 24/7</h5>
                            <p>Pomagamy na każdym etapie realizacji projektu.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mr-footer-main">
            <div class="row">

                <div class="col-12 col-lg-3">
                    <div class="mr-footer-brand p-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="mr-footer-logo">
                            DRUKUJEMY<br>
                            <strong>Przyszłość</strong>
                        </a>

                        <p>
                            Profesjonalny druk 3D na zamówienie. Tworzymy modele dopasowane do Twoich potrzeb.
                        </p>

                        <div class="mr-footer-socials">
                            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-2">
                    <h4 class="mr-footer-title">Obsługa klienta</h4>

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_obsluga_klienta',
                        'container'      => false,
                        'menu_class'     => 'mr-footer-menu',
                    ));
                    ?>
                </div>

                <div class="col-12 col-sm-6 col-lg-2">
                    <h4 class="mr-footer-title">Pracownia 3D</h4>

                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_pracownia_3d',
                        'container'      => false,
                        'menu_class'     => 'mr-footer-menu',
                    ));
                    ?>
                </div>

                <div class="col-12 col-sm-6 col-lg-2">
                    <h4 class="mr-footer-title">Kontakt</h4>

                    <div class="mr-footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <strong>DRUKUJEMY Przyszłość</strong><br>
                            ul. Programista 11<br>
                            00-010 Warszawa
                        </div>
                    </div>

                    <div class="mr-footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <a href="mailto:sklep@drukujemyprzyszlosc.pl">sklep@drukujemyprzyszlosc.pl</a>
                        </div>
                    </div>

                    <div class="mr-footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <div>
                            <a href="tel:+48510444442">570 498 678</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <h4 class="mr-footer-title">Zapisz się do Newslettera</h4>

                    <p class="mr-footer-newsletter-text">
                        Dołącz do newslettera i otrzymuj informacje o nowościach, promocjach oraz inspiracjach ze świata druku 3D.
                    </p>

                    <div class="mr-footer-newsletter-form">
                        <?php echo apply_shortcodes('[newsletter_form]'); ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="mr-footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <strong>DRUKUJEMY MARZENIA</strong>. Wszelkie prawa zastrzeżone.</p>

            <div>
                <a href="/polityka-prywatnosci">Polityka prywatności</a>
                <a href="/regulamin">Regulamin</a>
            </div>
        </div>

    </div>
</footer>

<button type="button" class="pureshop-scroll-top" id="pureshopScrollTop" aria-label="Przewiń na górę">
    <i class="bi bi-arrow-up"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>