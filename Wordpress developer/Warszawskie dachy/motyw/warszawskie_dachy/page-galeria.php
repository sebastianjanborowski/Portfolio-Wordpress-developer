<?php
/**
 * Template Name: Galeria
 * Page template - dark professional gallery.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$theme_uri  = get_template_directory_uri();
$pattern_bg = $theme_uri . '/assets/img/dlaczego-warto-tlo.png';
?>

<style>
	
	.gallery-page::before {
		content: "";
		position: absolute;
		inset: 0;
		background-image: url('<?php echo esc_url( $pattern_bg ); ?>');
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		opacity: .08;
		pointer-events: none;
	}

</style>

<main id="primary" class="site-main">

	<section class="gallery-page">

		<div class="container">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div class="gallery-heading">

						<h1 class="gallery-title">
							<?php the_title(); ?>
						</h1>

						<p class="gallery-desc">
							Zobacz wybrane realizacje dekarskie wykonane przez nasz zespół. Każdy dach realizujemy solidnie, estetycznie i z dbałością o każdy detal.
						</p>

					</div>

					<div class="gallery-content">

						<?php if ( trim( get_the_content() ) ) : ?>

							<?php the_content(); ?>

						<?php else : ?>

							<div class="gallery-empty">
								<h2>Dodaj zdjęcia do galerii</h2>
								<p>
									Wejdź w edycję tej strony w kokpicie WordPressa, dodaj blok „Galeria” i wybierz zdjęcia z biblioteki mediów.
								</p>
							</div>

						<?php endif; ?>

					</div>

				<?php endwhile; ?>

			<?php endif; ?>

		</div>

	</section>

	<div class="gallery-lightbox" id="galleryLightbox">
		<button class="gallery-lightbox-close" type="button" id="galleryLightboxClose" aria-label="Zamknij galerię">
			×
		</button>

		<button class="gallery-lightbox-prev" type="button" id="galleryLightboxPrev" aria-label="Poprzednie zdjęcie">
			‹
		</button>

		<img src="" alt="" id="galleryLightboxImage">

		<button class="gallery-lightbox-next" type="button" id="galleryLightboxNext" aria-label="Następne zdjęcie">
			›
		</button>

		<div class="gallery-counter" id="galleryCounter"></div>
	</div>

</main>

<?php get_footer(); ?>