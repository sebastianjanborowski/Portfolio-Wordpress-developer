<?php
/*
Template Name: Kontakt
*/
get_header();
?>

<style>
	.kontakt-page::before {
		content: "";
		position: absolute;
		inset: 0;
		background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/img/dlaczego-warto-tlo.png' ); ?>');
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		opacity: .08;
		pointer-events: none;
	}
</style>

<main id="primary" class="site-main">

	<section class="kontakt-page">

		<div class="container">

			<div class="row align-items-center g-5">

				<div class="col-12 col-lg-5">

					<h1 class="kontakt-title">
						Skontaktuj się z nami
					</h1>

					<p class="kontakt-desc">
						Masz pytania lub chcesz otrzymać wycenę? Jesteśmy do Twojej dyspozycji. Skontaktuj się z nami telefonicznie, mailowo lub przez formularz.
					</p>

					<div class="kontakt-info-item">
						<div class="kontakt-info-icon">
							<i class="bi bi-telephone"></i>
						</div>
						<div>
							<div class="kontakt-info-label">Zadzwoń do nas</div>
							<a href="tel:+48739446851" class="kontakt-info-value">
								+48 739 446 851
							</a>
						</div>
					</div>

					<div class="kontakt-info-item">
						<div class="kontakt-info-icon">
							<i class="bi bi-envelope"></i>
						</div>
						<div>
							<div class="kontakt-info-label">Napisz do nas</div>
							<a href="mailto:alpinistadachy2@gmail.com" class="kontakt-info-value">
								alpinistadachy2@gmail.com
							</a>
						</div>
					</div>

					<div class="mt-4">
						<div class="kontakt-info-label mb-3">Skontaktuj się przez WhatsApp</div>
						<a href="https://wa.me/48739446851" target="_blank" rel="noopener" class="kontakt-whatsapp">
							<span>Skontaktuj się przez WhatsApp</span>
							<i class="bi bi-whatsapp"></i>
						</a>
					</div>

				</div>

				<div class="col-12 col-lg-7">

					<div class="kontakt-form-box">

						<?php echo do_shortcode('[contact-form-7 id="85dc4eb" title="Kontakt"]'); ?>

					</div>

				</div>

			</div>

			

		</div>

	</section>

	

</main>

<?php get_footer(); ?>