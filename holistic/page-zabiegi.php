<?php
/**
 * Template Name: Kontakt
 */
defined('ABSPATH') || exit;

get_header();

$args = [
    'post_type'      => 'post',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'category_name'  => 'zabiegi',
];

$zabiegi_query = new WP_Query($args);
?>

<main class="beauty-contact">
    <section class="beauty-treatments py-5">
        <div class="container py-lg-4">

            <header class="row justify-content-center text-center mb-5">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                        <span class="beauty-line d-inline-block"></span>
                        <span class="text-uppercase fw-bold small beauty-gold">Oferta gabinetu</span>
                        <span class="beauty-line d-inline-block"></span>
                    </div>

                    <h1 class="display-5 fw-bold mb-3 beauty-green">
                        Zabiegi dopasowane do Twoich potrzeb
                    </h1>

                    <p class="lead text-muted mb-0">
                        Wybierz zabieg i zarezerwuj termin. Ostateczny plan terapii dobieramy indywidualnie po analizie skóry i potrzeb.
                    </p>
                </div>
            </header>

            <div class="row g-4 justify-content-center">

                <?php if ($zabiegi_query->have_posts()) : ?>
                    <?php while ($zabiegi_query->have_posts()) : $zabiegi_query->the_post(); ?>

                        <div class="col-12 col-md-6">
                            <article class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden treatment-card">

                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="ratio ratio-16x9 bg-secondary bg-opacity-10">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', [
                                                'class' => 'w-100 h-100 object-fit-cover',
                                                'loading' => 'lazy',
                                                'decoding' => 'async',
                                            ]); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column p-4">

                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                        <span class="badge rounded-pill bg-light text-secondary border px-3 py-2">
                                            Zabieg
                                        </span>

                                        <span class="small text-muted fw-bold">
                                            <?php echo esc_html(str_pad((string) ($zabiegi_query->current_post + 1), 2, '0', STR_PAD_LEFT)); ?>
                                        </span>
                                    </div>

                                    <h2 class="h4 fw-bold lh-sm mb-3">
                                        <a href="<?php the_permalink(); ?>" class="text-decoration-none beauty-green">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>

                                   <p class="text-muted small lh-lg mb-4">
                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 22, '...')); ?>
                                    </p>

                                    <div class="mt-auto">
                                        <a href="<?php the_permalink(); ?>" class="btn rounded-pill fw-semibold holistic-zabiegi-button w-100">
                                            Zobacz szczegóły
                                        </a>
                                    </div>

                                </div>
                            </article>
                        </div>

                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>

                    <div class="col-12 text-center">
                        <p class="text-muted mb-0">
                            Brak wpisów w kategorii „Zabiegi”.
                        </p>
                    </div>

                <?php endif; ?>

            </div>

        </div>
    </section>
</main>

<?php get_footer(); ?>