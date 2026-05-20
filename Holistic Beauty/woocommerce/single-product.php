<?php
defined('ABSPATH') || exit;

get_header();

global $product;

if (!is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

if (!$product) {
    return;
}

do_action('woocommerce_before_single_product');

$product_id      = $product->get_id();
$product_title   = $product->get_name();
$product_price   = $product->get_price_html();
$product_sku     = $product->get_sku();
$product_excerpt = $product->get_short_description();
$product_desc    = $product->get_description();
$product_stock   = $product->is_in_stock();
$product_cats    = wc_get_product_category_list($product_id, ', ');
$product_tags    = wc_get_product_tag_list($product_id, ', ');

$attachment_ids = $product->get_gallery_image_ids();
$main_image_id  = $product->get_image_id();
?>

<header class="beauty-page-hero">
    <div class="container">
        <div class="beauty-page-hero__inner text-center">
            <img class="holistic-header-ornament" src="<?php echo get_template_directory_uri(); ?>/assets/img/produkcja/podkreslnik_title_cut.png" alt="Podkreślnik tytułu podstrony">
            <h1 class="beauty-page-title"><?php echo esc_html($product_title); ?></h1>
        </div>
    </div>
</header>

<main class="holistic-single-product py-5">
    <div class="container">

        <nav class="mb-4 small holistic-breadcrumb">
            <?php woocommerce_breadcrumb(); ?>
        </nav>

        <div class="row g-4 g-xl-5 align-items-start">

            <div class="col-12 col-lg-6">
                <div class="card border-0 rounded-5 shadow-sm holistic-product-gallery overflow-hidden">
                    <div class="card-body p-3 p-md-4">

                        <div class="holistic-main-image rounded-5 overflow-hidden text-center">
                            <?php if ($main_image_id) : ?>
                                <?php echo wp_get_attachment_image($main_image_id, 'large', false, [
                                    'class' => 'img-fluid holistic-product-main-img',
                                    'alt'   => esc_attr($product_title),
                                ]); ?>
                            <?php else : ?>
                                <?php echo wc_placeholder_img('large', ['class' => 'img-fluid holistic-product-main-img']); ?>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($attachment_ids)) : ?>
                            <div class="row g-3 mt-3">
                                <?php foreach ($attachment_ids as $attachment_id) : ?>
                                    <div class="col-3">
                                        <a href="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, 'large')); ?>" class="holistic-thumb d-block rounded-4 overflow-hidden">
                                            <?php echo wp_get_attachment_image($attachment_id, 'woocommerce_thumbnail', false, [
                                                'class' => 'img-fluid w-100',
                                                'alt'   => esc_attr($product_title),
                                            ]); ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-0 rounded-5 shadow-sm holistic-product-summary">
                    <div class="card-body p-4 p-xl-5">

                        <span class="text-uppercase fw-bold small holistic-gold d-inline-block mb-2">
                            Holistic Beauty
                        </span>

                        <h1 class="h2 fw-bold holistic-green mb-3">
                            <?php echo esc_html($product_title); ?>
                        </h1>

                        <div class="mb-3">
                            <?php woocommerce_template_single_rating(); ?>
                        </div>

                        <div class="holistic-single-price mb-4">
                            <?php echo wp_kses_post($product_price); ?>
                        </div>

                        <?php if ($product_excerpt) : ?>
                            <div class="holistic-short-desc text-muted mb-4">
                                <?php echo wp_kses_post(wpautop($product_excerpt)); ?>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge rounded-pill holistic-soft-badge">
                                <?php echo $product_stock ? 'Dostępny' : 'Brak w magazynie'; ?>
                            </span>

                            <?php if ($product_sku) : ?>
                                <span class="badge rounded-pill holistic-outline-badge">
                                    SKU: <?php echo esc_html($product_sku); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="holistic-add-to-cart mb-4">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div>

                        <div class="holistic-product-meta small text-muted">
                            <?php if ($product_cats) : ?>
                                <div class="mb-2">
                                    <strong>Kategoria:</strong> <?php echo wp_kses_post($product_cats); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($product_tags) : ?>
                                <div>
                                    <strong>Tagi:</strong> <?php echo wp_kses_post($product_tags); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <section class="mt-5">
            <div class="card border-0 rounded-5 shadow-sm holistic-product-tabs">
                <div class="card-body p-4 p-xl-5">

                    <ul class="nav nav-pills gap-2 mb-4" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill" id="desc-tab" data-bs-toggle="pill" data-bs-target="#desc" type="button" role="tab">
                                Opis
                            </button>
                        </li>

                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill" id="info-tab" data-bs-toggle="pill" data-bs-target="#info" type="button" role="tab">
                                Informacje dodatkowe
                            </button>
                        </li> -->

                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" type="button" role="tab">
                                Opinie
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="desc" role="tabpanel">
                            <div class="holistic-product-content">
                                <?php
                                if ($product_desc) {
                                    echo wp_kses_post(wpautop($product_desc));
                                } else {
                                    echo '<p class="text-muted mb-0">Brak opisu produktu.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="info" role="tabpanel">
                            <?php woocommerce_product_additional_information_tab(); ?>
                        </div>

                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <?php comments_template(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <?php
        $related_products = wc_get_related_products($product_id, 3);

        if (!empty($related_products)) :
            $related_query = new WP_Query([
                'post_type'      => 'product',
                'post__in'       => $related_products,
                'posts_per_page' => 3,
                'orderby'        => 'post__in',
            ]);
        ?>

            <section class="mt-5">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div>
                        <span class="text-uppercase fw-bold small holistic-gold d-inline-block mb-2">
                            Zobacz również
                        </span>
                        <h2 class="h3 fw-bold holistic-green mb-0">
                            Podobne produkty
                        </h2>
                    </div>

                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn rounded-pill px-4 holistic-outline-btn">
                        Wróć do sklepu
                    </a>
                </div>

                <ul class="products row list-unstyled p-0 m-0 g-4">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                        <?php wc_get_template_part('content', 'product'); ?>
                    <?php endwhile; ?>
                </ul>
            </section>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>

    </div>
</main>


<script>

function opinie(){
  const reviews_tabID = document.getElementById("reviews-tab");
  const desc_tab_id = document.getElementById("desc-tab");

  const comments = document.getElementById("comments");
  const review_form_wrapper = document.getElementById("review_form_wrapper");

  if(!reviews_tabID || !comments || !review_form_wrapper || !desc_tab_id) return;

  reviews_tabID.addEventListener('click',() => {
    comments.classList.add('disnonImportant');
    review_form_wrapper.classList.add('disnonImportant');
  });
        
  desc_tab_id.addEventListener('click',() => {
    comments.classList.remove('disnonImportant');
    review_form_wrapper.classList.remove('disnonImportant'); 
  });
}

document.addEventListener('DOMContentLoaded', function () {
    opinie();
    const mainImage = document.querySelector('.holistic-product-main-img');

    document.querySelectorAll('.holistic-thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function (e) {
            e.preventDefault();

            if (!mainImage) {
                return;
            }

            const newSrc = thumb.getAttribute('href');

            if (newSrc) {
                mainImage.setAttribute('src', newSrc);
                mainImage.removeAttribute('srcset');
                mainImage.removeAttribute('sizes');
            }
        });
    });
});
</script>

<?php
do_action('woocommerce_after_single_product');

get_footer();