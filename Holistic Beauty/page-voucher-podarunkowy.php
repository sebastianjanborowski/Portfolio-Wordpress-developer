<?php
/*
Template Name: Voucher Podarunkowy
*/

get_header();
?>
<style>
.holistic-voucher-side-image {
    border-radius: var(--hb-radius-xl) var(--hb-radius-xl) 0 0;
    min-height: 260px;
    background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/produkcja/grafika_voucher_podarunkowy.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
<div class="beauty-page-hero">
    <div class="container">
        <div class="beauty-page-hero__inner">
            <img class="holistic-header-ornament"
                 src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/produkcja/podkreslnik_title_cut.png"
                 alt="Podkreślnik tytułu podstrony">

            <h1 class="beauty-page-title">
                <?php the_title(); ?>
                
            </h1>
             <span class="holistic-span-green">Jeden prezent, setki możliwości. Voucher na luksusowe zabiegi lub profesjonalną pielęgnację domową.</span>
        </div>
    </div>
</div>



<main class="holistic-voucher-page">

    <section class="holistic-voucher-icons">
        
        <div class="container">
            <div class="row">
                <div class="col-12 page-content beauty-page-box">
                    <?php the_content(); ?>
                </div>
            </div>
            
            <div class="row g-0">

                <div class="col-12 col-md">
                    <div class="holistic-voucher-feature">
                        <i class="bi bi-gift"></i>
                        <h3>Idealny prezent</h3>
                        <p>Dla bliskiej osoby na każdą okazję.</p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="holistic-voucher-feature">
                        <i class="bi bi-flower1"></i>
                        <h3>Zabiegi w gabinecie</h3>
                        <p>Dowolnie wybrane profesjonalne zabiegi.</p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="holistic-voucher-feature">
                        <i class="bi bi-bag-heart"></i>
                        <h3>Kosmetyki w sklepie</h3>
                        <p>Możliwość zakupu kosmetyków i akcesoriów.</p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="holistic-voucher-feature">
                        <i class="bi bi-calendar-check"></i>
                        <h3>Ważny 12 miesięcy</h3>
                        <p>Dużo czasu na realizację vouchera.</p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="holistic-voucher-feature">
                        <i class="bi bi-truck"></i>
                        <h3>Wysyłka InPost</h3>
                        <p>Wysyłka na wskazany adres w Polsce.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="holistic-voucher-main">
        <div class="container">
            <div class="row g-4 align-items-stretch">

                <div class="col-12 col-lg-7">
                    <div class="holistic-voucher-card">

                        <h2 class="holistic-voucher-card-title">
                            Zamów voucher
                        </h2>

                        <p class="holistic-voucher-card-subtitle">
                            Wypełnij formularz, a skontaktujemy się z Tobą w celu realizacji zamówienia.
                        </p>

                        <form class="holistic-voucher-form" method="post">

                            <div class="mb-4">
                                <label>Dla kogo jest voucher?</label>

                                <div class="holistic-voucher-switch">
                                    <input type="radio" id="voucher_for_me" name="voucher_type" value="Dla mnie" checked>
                                    <label for="voucher_for_me">
                                        <i class="bi bi-person-fill me-2"></i>
                                        Dla mnie
                                    </label>

                                    <input type="radio" id="voucher_for_other" name="voucher_type" value="Dla innej osoby">
                                    <label for="voucher_for_other">
                                        <i class="bi bi-person-heart me-2"></i>
                                        Dla innej osoby
                                    </label>
                                </div>
                            </div>

                            <div id="recipient_fields" class="holistic-voucher-hidden">
                                <div class="row g-3 mb-2">
                                    <div class="col-12 col-md-6">
                                        <label for="recipient_name">Imię osoby obdarowanej</label>
                                        <input id="recipient_name" class="form-control" type="text" name="recipient_name" placeholder="Wprowadź imię">
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="recipient_email">E-mail osoby obdarowanej</label>
                                        <input id="recipient_email" class="form-control" type="email" name="recipient_email" placeholder="Wprowadź e-mail">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">

                                <div class="col-12 col-md-6">
                                    <label for="client_name">Imię *</label>
                                    <input id="client_name" class="form-control" type="text" name="client_name" placeholder="Wprowadź imię" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="client_surname">Nazwisko *</label>
                                    <input id="client_surname" class="form-control" type="text" name="client_surname" placeholder="Wprowadź nazwisko" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="client_email">E-mail *</label>
                                    <input id="client_email" class="form-control" type="email" name="client_email" placeholder="Wprowadź adres e-mail" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="client_phone">Numer telefonu *</label>
                                    <input id="client_phone" class="form-control" type="tel" name="client_phone" placeholder="Wprowadź numer telefonu" required>
                                </div>

                                <div class="col-12">
                                    <label>Kwota vouchera *</label>

                                    <div class="holistic-voucher-amounts">
                                        <input type="radio" id="amount_100" name="voucher_amount" value="100 zł">
                                        <label for="amount_100">100 zł</label>

                                        <input type="radio" id="amount_150" name="voucher_amount" value="150 zł">
                                        <label for="amount_150">150 zł</label>

                                        <input type="radio" id="amount_200" name="voucher_amount" value="200 zł">
                                        <label for="amount_200">200 zł</label>

                                        <input type="radio" id="amount_300" name="voucher_amount" value="300 zł">
                                        <label for="amount_300">300 zł</label>

                                        <input type="radio" id="amount_500" name="voucher_amount" value="500 zł">
                                        <label for="amount_500">500 zł</label>

                                        <input type="radio" id="amount_other" name="voucher_amount" value="Inna kwota">
                                        <label for="amount_other">Inna kwota</label>
                                    </div>
                                </div>

                                <div class="col-12 holistic-voucher-hidden" id="custom_amount_field">
                                    <label for="custom_amount">Wpisz własną kwotę</label>
                                    <input id="custom_amount" class="form-control" type="number" name="custom_amount" placeholder="Np. 250">
                                </div>

                                <div class="col-12">
                                    <label for="voucher_message">Wiadomość opcjonalna</label>
                                    <textarea id="voucher_message" class="form-control" name="voucher_message" placeholder="Np. dedykacja, okazja, dodatkowe informacje..."></textarea>
                                </div>

                                <div class="col-12">
                                    <label>Sposób dostawy *</label>

                                    <div class="holistic-voucher-delivery">
                                        <input type="radio" id="delivery_inpost" name="delivery_type" value="Wysyłka InPost" checked>
                                        <label for="delivery_inpost">
                                            <i class="bi bi-truck me-2"></i>
                                            Wysyłka InPost na wskazany adres
                                        </label>

                                        <input type="radio" id="delivery_personal" name="delivery_type" value="Odbiór osobisty">
                                        <label for="delivery_personal">
                                            <i class="bi bi-geo-alt me-2"></i>
                                            Odbiór osobisty w gabinecie
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12" id="delivery_address_field">
                                    <label for="delivery_address">Adres dostawy InPost *</label>
                                    <input id="delivery_address" class="form-control" type="text" name="delivery_address" placeholder="Ulica, numer domu, kod pocztowy, miasto">
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input id="voucher_rules" class="form-check-input" type="checkbox" name="voucher_rules" required>
                                        <label class="form-check-label" for="voucher_rules">
                                            Akceptuję regulamin korzystania z voucherów podarunkowych. *
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="holistic-voucher-btn" type="submit">
                                        <i class="bi bi-send-fill me-2"></i>
                                        Zamawiam voucher
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="holistic-voucher-side-image"></div>

                    <div class="holistic-voucher-info">

                        <h3>Ważne informacje</h3>

                        <div class="holistic-voucher-info-item">
                            <i class="bi bi-info-circle"></i>
                            <div>
                                <h4>Booksy nie obsługuje voucherów</h4>
                                <p>
                                    Voucher nie łączy się z systemem płatności w aplikacji Booksy.
                                    Rezerwację wizyty należy wykonać standardowo, a kod lub voucher
                                    okazać personelowi podczas wizyty.
                                </p>
                            </div>
                        </div>

                        <div class="holistic-voucher-info-item">
                            <i class="bi bi-envelope"></i>
                            <div>
                                <h4>Kod vouchera</h4>
                                <p>
                                    Każdy voucher posiada unikalny
                                    Kod, zostanie przypisany po obsłudze zamówienia.
                                </p>
                            </div>
                        </div>

                        <div class="holistic-voucher-info-item">
                            <i class="bi bi-truck"></i>
                            <div>
                                <h4>Wysyłka InPost</h4>
                                <p>
                                    Voucher fizyczny wysyłamy na wskazany adres wyłącznie na terenie Polski.
                                </p>
                            </div>
                        </div>

                        <div class="holistic-voucher-info-item">
                            <i class="bi bi-clock"></i>
                            <div>
                                <h4>Ważność 12 miesięcy</h4>
                                <p>
                                    Voucher jest ważny przez 12 miesięcy od daty zakupu.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="holistic-voucher-info rounded-4 mt-3 p-4">
                        <div class="d-flex align-items-start gap-3">

                            <div class="holistic-voucher-info-icon">
                                <i class="bi bi-file-earmark-arrow-down"></i>
                            </div>

                            <div>
                                <h4 class="mb-2">
                                    Regulamin Voucherów
                                </h4>

                                <p class="mb-3">
                                    Aby pobrać regulamin korzystania z Voucherów Podarunkowych,
                                    kliknij przycisk poniżej.
                                </p>

                                
                            </div>
                            

                        </div>
                        <a class="holistic-voucher-download-btn" href="<?php echo get_template_directory_uri(); ?>/assets/regulamin/regulamin vouchera.rtf" download>
                            <i class="bi bi-download me-2"></i>
                            Pobierz regulamin PDF
                        </a>
                    </div>
                </div>

            </div>

            
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const forMe = document.getElementById('voucher_for_me');
    const forOther = document.getElementById('voucher_for_other');
    const recipientFields = document.getElementById('recipient_fields');

    const amountOther = document.getElementById('amount_other');
    const customAmountField = document.getElementById('custom_amount_field');
    const amountInputs = document.querySelectorAll('input[name="voucher_amount"]');

    const deliveryInpost = document.getElementById('delivery_inpost');
    const deliveryPersonal = document.getElementById('delivery_personal');
    const deliveryAddressField = document.getElementById('delivery_address_field');

    function toggleRecipientFields() {
        recipientFields.style.display = forOther.checked ? 'block' : 'none';
    }

    function toggleCustomAmount() {
        customAmountField.style.display = amountOther.checked ? 'block' : 'none';
    }

    function toggleDeliveryAddress() {
        deliveryAddressField.style.display = deliveryInpost.checked ? 'block' : 'none';
    }

    forMe.addEventListener('change', toggleRecipientFields);
    forOther.addEventListener('change', toggleRecipientFields);

    amountInputs.forEach(function (input) {
        input.addEventListener('change', toggleCustomAmount);
    });

    deliveryInpost.addEventListener('change', toggleDeliveryAddress);
    deliveryPersonal.addEventListener('change', toggleDeliveryAddress);

    toggleRecipientFields();
    toggleCustomAmount();
    toggleDeliveryAddress();
});
</script>

<?php get_footer(); ?>