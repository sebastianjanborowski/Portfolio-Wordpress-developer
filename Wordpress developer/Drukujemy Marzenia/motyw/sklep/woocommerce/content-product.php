<?php
defined('ABSPATH') || exit;

global $product;

if (!$product || !$product->is_visible()) {
    return;
}
?>

<li <?php wc_product_class('col-12 col-sm-6 col-lg-4 col-xl-3 mb-4', $product); ?>>

    <div class="card h-100 border border-warning border-opacity-25 rounded-4 overflow-hidden shadow-lg pureshop-product-card">

        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="text-decoration-none pureshop-color">

            <div class="position-relative bg-black">
                <?php echo $product->get_image('woocommerce_thumbnail', [
                    'class' => 'card-img-top w-100 object-fit-cover pureshop-product-img'
                ]); ?>
            </div>

            <div class="card-body py-2">

                <h2 class="h5 fw-bold mb-2 pureshop-color">
                    <?php echo esc_html($product->get_name()); ?>
                </h2>

                <p class="small mb-2 pureshop-color">
                    <span class="<?php echo $product->is_in_stock() ? 'pureshop-color' : 'text-danger'; ?>">●</span>
                    <?php echo esc_html($product->is_in_stock() ? 'Dostępny' : 'Brak w magazynie'); ?>
                </p>

                <div class="fs-4 fw-bold pureshop-color mb-3">
                    <?php echo wp_kses_post($product->get_price_html()); ?>
                </div>

            </div>

        </a>

        <div class="card-footer border-0 bg-transparent p-3 text-white">
            

            <?php if (!is_page('ulubione') && !wp_doing_ajax()) : ?>
                <button type="button" class="pureshop-fav-btn text-white pureshop-padding-single-product" data-product-id="<?php echo esc_attr(get_the_ID()); ?>" > </button>
            <?php endif; ?>

            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
    
        

    </div>

</li>