<?php
defined('ABSPATH') || exit;

global $product;

if (!$product) {
    return;
}

$sku        = $product->get_sku();
$short_desc = $product->get_short_description();
$desc       = $product->get_description();
?>

<main class="pureshop-single-product py-5 pureshop-margin-top">
    <div class="container">

        <div class="row g-3 align-items-stretch">

        <?php wc_print_notices(); ?>

    <div class="col-12 col-lg-6">
        <div class="card border border-warning border-opacity-25 rounded-4 overflow-hidden shadow-lg pureshop-max-height">
            <div class="pureshop-single-image-wrap h-100">
                <?php echo $product->get_image('large', [
                    'class' => 'pureshop-single-product-img w-100 h-100'
                ]); ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card h-100 text-white border border-warning border-opacity-25 rounded-4 shadow-lg">
            <div class="card-body p-4 d-flex flex-column pureshop_single_product_color">

                <span class="badge border border-warning bg-transparent mb-3 px-3 py-2 align-self-start pureshop_single_product_color">
                    Produkt
                </span>

                <h1 class="display-5 fw-bold mb-3">
                    <?php echo esc_html($product->get_name()); ?>
                </h1>

                <div class="mb-3 small">
                    <span class="<?php echo $product->is_in_stock() ? 'text-success' : 'text-danger'; ?>">●</span>
                    <?php echo esc_html($product->is_in_stock() ? 'Dostępne '.wp_count_posts('product')->publish.' sztuk' : 'Brak w magazynie'); ?>

                    <?php if ($sku) : ?>
                        <span class="mx-2 text-white-50">|</span>
                        Kod: <?php echo esc_html($sku); ?>
                    <?php endif; ?>
                </div>

                <div class="fs-2 fw-bold single_product_color mb-4 p-2">
                    <?php echo wp_kses_post($product->get_price_html()); ?>
                </div>

                <div class="mb-3 small text-white-50 pureshop-single-product-category">
                        <span class="pureshop_single_product_color p-2">Kategorie:</span>
                        <?php echo wp_kses_post(wc_get_product_category_list($product->get_id(),', ')); ?>
                </div>

                <div class="text-white pureshop-single-product-form">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                    
                    <button type="button" class="pureshop-fav-btn text-white pureshop-padding-single-product" data-product-id="<?php echo esc_attr(get_the_ID()); ?>" > </button>
            
                </div>
                
                

            </div>
        </div>
    </div>

</div>

        <?php if ($desc) : ?>
            <section class="card pureshop_single_product_color border border-warning border-opacity-25 rounded-4 shadow-lg mt-3">
                <div class="card-body p-4">
                    <h2 class="h3 fw-bold mb-4">Opis produktu</h2>

                    <div class="lh-lg">
                        <?php echo wp_kses_post($desc); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </div>
</main>