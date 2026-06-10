<?php
$hero = get_template_directory_uri() . '/assets/img/main-photo.jpg';
?>


<section 
	class="wd-hero position-relative min-vh-100 d-flex align-items-center text-white overflow-hidden"
	style="--hero-bg: url('<?php echo esc_url( $hero ); ?>');"
>

	<div class="container-fluid px-4 px-lg-5 position-relative z-2">
		<div class="row min-vh-100 align-items-center">
			<div class="col-12 col-md-10 col-lg-7 col-xl-5">

				<p class="text-danger fw-semibold mb-4">
					Warszawa Dachy
				</p>

				<h1 class="display-3 fw-bold lh-1 mb-3">
					Doświadczenie i jakość w branży dekarskiej
				</h1>

				<a 
					href="tel:+48739446851" 
					class="d-inline-flex align-items-center gap-3 text-white text-decoration-none fs-2 fw-light mb-4"
				>
					<span class="wd-phone-icon d-inline-flex align-items-center justify-content-center">
						<i class="bi bi-telephone-fill"></i>
					</span>
					<span class="dek-slider-tel">Zadzwoń +48 739 446 851</span>
				</a>

				<div>
					<a 
						href="https://wa.me/48739446851" 
						class="btn px-4 py-2 rounded-1 fw-semibold dek-button-slider"
						target="_blank" 
						rel="noopener noreferrer"
					>
						Skontaktuj się przez Whatsapp
					</a>
				</div>

			</div>
		</div>
	</div>

</section>