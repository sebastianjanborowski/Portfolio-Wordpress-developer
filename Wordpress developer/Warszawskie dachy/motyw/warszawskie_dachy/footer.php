<?php
/**
 * Footer template - Warszawskie Dachy
 */

defined( 'ABSPATH' ) || exit;

$theme_uri = get_template_directory_uri();

$logo      = $theme_uri . '/assets/img/logo-white.png';


$phone_raw  = '+48739446851';
$phone_show = '+48 739 446 851';

$whatsapp_url = 'https://wa.me/48739446851';

$email_address = 'alpinistadachy2@gmail.com';
$email_url     = 'mailto:' . $email_address;
?>

<footer 
	class="wd-footer-bs"
>
	<div class="wd-footer-bs__inner">

		<div class="container-fluid px-3 px-md-4 px-xl-5 wd-footer-bs__main">

			<div class="row g-3 g-xl-0 align-items-center justify-content-center">

				<div class="col-12 col-xl-auto">
					<a 
						href="<?php echo esc_url( home_url( '/' ) ); ?>" 
						class="wd-footer-bs__logo-wrap text-decoration-none"
						aria-label="Warszawskie Dachy - strona główna"
					>
						<img
							src="<?php echo esc_url( $logo ); ?>"
							alt="Warszawskie Dachy"
							class="wd-footer-bs__logo"
							width="260"
							height="90"
							loading="lazy"
						>
					</a>
				</div>

				<div class="col-12 col-sm-6 col-lg-4 col-xl-auto">
					<a 
						href="tel:<?php echo esc_attr( $phone_raw ); ?>"
						class="wd-footer-bs__item"
						aria-label="Zadzwoń do Warszawskie Dachy"
					>
						<span class="wd-footer-bs__icon">
							<i class="bi bi-telephone"></i>
						</span>

						<span>
							<span class="wd-footer-bs__label">Zadzwoń</span>
							<span class="wd-footer-bs__value"><?php echo esc_html( $phone_show ); ?></span>
						</span>
					</a>
				</div>

				<div class="col-12 col-sm-6 col-lg-4 col-xl-auto">
					<div class="wd-footer-bs__item">
						<span class="wd-footer-bs__icon">
							<i class="bi bi-geo-alt"></i>
						</span>

						<span>
							<span class="wd-footer-bs__label">Lokalizacja</span>
							<span class="wd-footer-bs__value">Warszawa i okolice</span>
						</span>
					</div>
				</div>

				<div class="col-12 col-sm-6 col-lg-4 col-xl-auto">
					<a 
						href="mailto:alpinistadachy2@gmail.com"
						class="wd-footer-bs__item wd-footer-bs__whatsapp"
						aria-label="Napisz do nas na adres email"
					>
						<span class="wd-footer-bs__icon">
							<i class="bi bi-envelope"></i>
						</span>

						<span>
							<span class="wd-footer-bs__label">Email</span>
							<span class="wd-footer-bs__value">
								alpinistadachy2@gmail.com 
							</span>
						</span>
					</a>
				</div>
			</div>

		</div>

		<div class="wd-footer-bs__bottom">
			<div class="container-fluid px-3 px-md-4 px-xl-5">
				<p>
					© 2026 <span>Warszawskie Dachy.</span> Wszelkie prawa zastrzeżone.
				</p>
			</div>
		</div>

	</div>
</footer>

<a 
	href="<?php echo esc_url( $whatsapp_url ); ?>"
	class="wd-whatsapp position-fixed d-flex align-items-center justify-content-center rounded-circle text-white text-decoration-none"
	target="_blank"
	rel="noopener noreferrer"
	aria-label="Napisz do nas na WhatsApp"
>
	<i class="bi bi-whatsapp"></i>
</a>

</main>

<?php wp_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {

  function sendGoogleAdsConversion(url) {
    if (typeof gtag !== 'function') {
      if (url) {
        window.location.href = url;
      }
      return;
    }

    gtag('event', 'conversion', {
      'send_to': 'AW-17517973592/Kp4wCOSpl6gbENignKFB',
      'event_callback': function () {
        if (url) {
          window.location.href = url;
        }
      }
    });

    setTimeout(function () {
      if (url) {
        window.location.href = url;
      }
    }, 800);
  }

  document.querySelectorAll('a[href^="tel:"], a[href*="wa.me"]').forEach(function(link) {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      sendGoogleAdsConversion(this.href);
    });
  });

});
</script>

</body>
</html>