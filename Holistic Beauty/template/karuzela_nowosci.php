<?php
$args = [
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'tax_query'      => [
        [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'nowosci',
        ],
    ],
];

$latest_product = new WP_Query($args);
?>

<style>
.holistic-products-carousel {
    width: 100%;
    overflow: hidden;
}

.holistic-products-track {
    display: flex;
    flex-wrap: nowrap;
    gap: 0;
    transform: translate3d(0, 0, 0);
    transition: transform 0.35s ease;
    will-change: transform;
}

.holistic-product-slide {
    flex: 0 0 calc(25% - 10px);
    max-width: calc(25% - 10px);
    margin: 0 5px;
}

@media (max-width: 991px) {
    .holistic-product-slide {
        flex: 0 0 calc(50% - 10px);
        max-width: calc(50% - 10px);
        margin: 0 5px;
    }
}

@media (max-width: 600px) {
    .holistic-product-slide {
        flex: 0 0 100%;
        max-width: 100%;
        margin: 0;
    }
}
</style>

<div class="container py-5">
    <?php if ($latest_product->have_posts()) : ?>

        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
            <h2 class="fw-bold mb-0 holistic-google-reviews-title">Nowości</h2>

            <div class="d-flex align-items-center gap-2">
                <button id="productsPrev" class="btn holistic-review-nav-btn holistic-mobile-zobacz-wszyskie" type="button">
                    <i class="bi bi-arrow-left"></i>
                </button>

                <button id="productsNext" class="btn holistic-review-nav-btn holistic-mobile-zobacz-wszyskie" type="button">
                    <i class="bi bi-arrow-right"></i>
                </button>

                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="holistic-carousel-all">
                    Zobacz wszystkie
                </a>
            </div>
        </div>

        <div class="holistic-products-carousel">
            <div class="holistic-products-track" id="productsTrack">

                <?php while ($latest_product->have_posts()) : ?>
                    <?php $latest_product->the_post(); ?>
                    <?php global $product; ?>

                    <div class="holistic-product-slide">
                        <article class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">

                            <a href="<?php the_permalink(); ?>" class="ratio ratio-1x1">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', [
                                        'class' => 'w-100 h-100 object-fit-cover',
                                    ]); ?>
                                <?php endif; ?>
                            </a>

                            <div class="card-body d-flex flex-column">
                                <h2 class="h6 fw-bold mb-2">
                                    <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <div class="mb-3">
                                    <?php echo $product ? $product->get_price_html() : ''; ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="btn mt-auto holistic-button-product-nowosci">
                                    Zobacz produkt
                                </a>
                            </div>

                        </article>
                    </div>

                <?php endwhile; ?>

            </div>
        </div>

        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</div>
