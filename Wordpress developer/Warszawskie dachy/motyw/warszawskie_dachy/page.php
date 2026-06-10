<?php
/**
 * Page template - clean version.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<section class="page-section py-5">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-12 col-lg-10 col-xl-9">

							<h1 class="display-5 fw-bold text-dark mb-4">
								<?php the_title(); ?>
							</h1>

							<div class="page-content text-secondary lh-lg">
								<?php the_content(); ?>
							</div>

						</div>
					</div>

				</div>
			</section>

		<?php endwhile; ?>

	<?php else : ?>

		<section class="py-5">
			<div class="container">
				<p>Nie znaleziono treści.</p>
			</div>
		</section>

	<?php endif; ?>

</main>

<?php get_footer(); ?>