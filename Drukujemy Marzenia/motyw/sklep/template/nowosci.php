<?php

$kategoria_slug   = 'nowosci';
$ilosc_produktow  = 12;

$args = array(
    'post_type'      => 'product',
    'posts_per_page' => $ilosc_produktow,
    'post_status'    => 'publish',
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $kategoria_slug,
        ),
    ),
);

$produkty_query = new WP_Query($args);
$term = get_term_by('slug', $kategoria_slug, 'product_cat');

$shop_link = function_exists('wc_get_page_permalink')
    ? wc_get_page_permalink('shop')
    : home_url('/sklep/');

$nowosci_link = add_query_arg(
    array(
        'filter_cat' => array($kategoria_slug),
    ),
    $shop_link
);

?>

<section class="custom-cat-section">
    <div class="container-fluid pureshop-max-width">

        <div class="custom-cat-carousel-header">
            <div>
                <span class="custom-cat-carousel-eyebrow fs-3">
                    <?php echo $term ? esc_html($term->name) : 'Nowości'; ?>
                </span>
            </div>

            <div class="custom-cat-carousel-nav pureshop-mobile-new-line">

                <a class="custom-cat-see-all" href="<?php echo esc_url($nowosci_link); ?>">
                    Zobacz wszystkie
                    <i class="bi bi-arrow-right"></i>
                </a>

                <div class="d-flex flex-direction-row gap-2 pureshop-mobile-new-line-arrow">
                    <button type="button"
                            class="custom-cat-carousel-btn"
                            id="customCatPrevNowosci"
                            aria-label="Przewiń w lewo">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <button type="button"
                            class="custom-cat-carousel-btn custom-cat-carousel-btn-active"
                            id="customCatNextNowosci"
                            aria-label="Przewiń w prawo">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <?php if ($produkty_query->have_posts()) : ?>
            <div class="custom-cat-carousel-viewport">
                <div class="custom-cat-carousel-track" id="customCatTrackNowosci">

                    <?php while ($produkty_query->have_posts()) : $produkty_query->the_post(); ?>
                        <?php
                        global $product;

                        if (!$product || !is_a($product, 'WC_Product')) {
                            continue;
                        }

                        $product_id   = $product->get_id();
                        $product_link = get_permalink($product_id);
                        $product_name = $product->get_name();
                        $price_html   = $product->get_price_html();

                        $image_html = $product->get_image('medium_large', array(
                            'class'   => 'custom-cat-card-image',
                            'loading' => 'lazy',
                        ));

                        $is_in_stock = $product->is_in_stock();
                        $stock_label = $is_in_stock ? 'Dostępny' : 'Niedostępny';
                        ?>

                        <article class="custom-cat-card">
                            <div class="custom-cat-card-image-wrap">
                                <a href="<?php echo esc_url($product_link); ?>" aria-label="<?php echo esc_attr($product_name); ?>">
                                    <?php echo $image_html; ?>
                                </a>
                            </div>

                            <div class="custom-cat-card-body">
                                <h3 class="custom-cat-card-title">
                                    <a href="<?php echo esc_url($product_link); ?>">
                                        <?php echo esc_html($product_name); ?>
                                    </a>
                                </h3>

                                <div class="custom-cat-card-stock">
                                    <span class="custom-cat-card-stock-dot <?php echo $is_in_stock ? 'is-available' : 'is-unavailable'; ?>"></span>
                                    <?php echo esc_html($stock_label); ?>
                                </div>

                                <div class="custom-cat-card-price">
                                    <?php echo wp_kses_post($price_html); ?>
                                </div>

                                <a class="custom-cat-card-btn" href="<?php echo esc_url($product_link); ?>">
                                    <i class="bi bi-bag"></i>
                                    Zobacz produkt
                                </a>
                            </div>

                        </article>

                    <?php endwhile; ?>

                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-light border mb-0">
                Brak produktów w tej kategorii.
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>
</section>