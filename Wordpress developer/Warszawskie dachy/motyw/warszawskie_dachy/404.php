<?php
/**
 * 404 template - Warszawskie Dachy
 */

defined( 'ABSPATH' ) || exit;

get_header();

$home_url  = home_url( '/' );
$theme_url = get_template_directory_uri();
?>

<section class="wd-404 min-vh-100 d-flex align-items-center text-white position-relative overflow-hidden">

	<div class="container position-relative py-5">
		<div class="row min-vh-100 align-items-center">

			<div class="col-12 col-lg-7 col-xl-6">

				<div class="mb-5">
					<span class="d-inline-block text-uppercase fw-bold text-success small wd-letter mb-4">
						Błąd 404
					</span>

					<h1 class="display-1 fw-black text-uppercase lh-1 wd-title mb-4">
						Nie znaleziono<br>
						strony
					</h1>

					<p class="fs-5 lh-lg text-white-75 mb-0 wd-desc">
						Strona, której szukasz, nie istnieje, została przeniesiona
						albo wpisany adres jest nieprawidłowy.
					</p>
				</div>

				<div class="d-flex flex-column gap-4 mb-5">

					<a href="<?php echo esc_url( $home_url ); ?>" class="d-flex align-items-center gap-3 text-decoration-none wd-contact-link">
						<span class="wd-icon d-flex align-items-center justify-content-center rounded-4 text-success fs-3">
							<i class="bi bi-house-door"></i>
						</span>

						<span>
							<span class="d-block text-uppercase small fw-bold text-white-50 mb-1 wd-contact-label">
								Wróć do serwisu
							</span>

							<span class="d-block text-white fw-bold fs-5">
								Strona główna
							</span>
						</span>
					</a>

					<a href="tel:+48739446851" class="d-flex align-items-center gap-3 text-decoration-none wd-contact-link">
						<span class="wd-icon d-flex align-items-center justify-content-center rounded-4 text-success fs-3">
							<i class="bi bi-telephone"></i>
						</span>

						<span>
							<span class="d-block text-uppercase small fw-bold text-white-50 mb-1 wd-contact-label">
								Zadzwoń do nas
							</span>

							<span class="d-block text-white fw-bold fs-5">
								+48 739 446 851
							</span>
						</span>
					</a>

					<a href="mailto:alpinistadachy2@gmail.com" class="d-flex align-items-center gap-3 text-decoration-none wd-contact-link">
						<span class="wd-icon d-flex align-items-center justify-content-center rounded-4 text-success fs-3">
							<i class="bi bi-envelope"></i>
						</span>

						<span>
							<span class="d-block text-uppercase small fw-bold text-white-50 mb-1 wd-contact-label">
								Napisz do nas
							</span>

							<span class="d-block text-white fw-bold fs-5 wd-email">
								alpinistadachy2@gmail.com
							</span>
						</span>
					</a>

				</div>

				<div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 wd-404-actions">

					<a href="<?php echo esc_url( $home_url ); ?>" class="btn btn-success fw-bold px-4 py-3 wd-main-btn">
						Strona główna
					</a>

					<a href="<?php echo esc_url( $home_url . 'kontakt/' ); ?>" class="wd-action-link text-white fw-bold text-decoration-none">
						Kontakt
					</a>

					<a href="https://wa.me/48739446851" target="_blank" rel="noopener" class="wd-action-link text-success fw-bold text-decoration-none">
						WhatsApp
					</a>

				</div>

			</div>

		</div>
	</div>

</section>

<style>

	.wd-404 {
		background:
			linear-gradient(90deg, rgba(18, 29, 33, .97) 0%, rgba(18, 29, 33, .88) 48%, rgba(18, 29, 33, .7) 100%),
			url('<?php echo esc_url( $theme_url . '/assets/img/dlaczego-warto-tlo.png' ); ?>') center/cover no-repeat;
	}
	@media (max-width: 991.98px) {
		.wd-404 {
			background:
				linear-gradient(rgba(18, 29, 33, .93), rgba(18, 29, 33, .95)),
				url('<?php echo esc_url( $theme_url . '/assets/img/dlaczego-warto-tlo.png' ); ?>') center/cover no-repeat;
		}
	}

</style>

<?php
get_footer();