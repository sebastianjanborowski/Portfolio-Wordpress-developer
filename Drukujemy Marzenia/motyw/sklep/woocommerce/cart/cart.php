<?php
defined('ABSPATH') || exit;

/* Obsługa plus/minus */
if (
    isset($_POST['pureshop_qty_action'], $_POST['woocommerce-cart-nonce']) &&
    wp_verify_nonce(
        sanitize_text_field(wp_unslash($_POST['woocommerce-cart-nonce'])),
        'woocommerce-cart'
    )
) {
    $action = sanitize_text_field(wp_unslash($_POST['pureshop_qty_action']));
    $parts  = explode('|', $action);

    if (count($parts) === 2) {
        $cart_item_key = $parts[0];
        $type = $parts[1];

        $cart = WC()->cart->get_cart();

        if (isset($cart[$cart_item_key])) {
            $current_qty = (int) $cart[$cart_item_key]['quantity'];

            if ($type === 'plus') {
                $new_qty = $current_qty + 1;
            } elseif ($type === 'minus') {
                $new_qty = max(0, $current_qty - 1);
            } else {
                $new_qty = $current_qty;
            }

            WC()->cart->set_quantity($cart_item_key, $new_qty, true);
            WC()->cart->calculate_totals();
        }
    }
}
?>

<div class="container pureshop-cart-container py-5">
    <div class="row">
        <div class="col-12 col-lg-8">

            <div class="pureshop-cart-main-place p-4 rounded-4">

                <div class="pureshop-cart-headers d-none d-md-flex align-items-center border-bottom pb-3 mb-2">
                    <div class="pureshop-cart-col-product flex-grow-1">
                        <p class="mb-0 text-uppercase small">Produkt</p>
                    </div>

                    <div class="pureshop-cart-cols d-flex align-items-center text-center">
                        <p class="pureshop-cart-col mb-0">Cena</p>
                        <p class="pureshop-cart-col mb-0">Ilość</p>
                        <p class="pureshop-cart-col-total mb-0">Suma</p>
                        <p class="pureshop-cart-col-remove mb-0"></p>
                    </div>
                </div>

                <?php if (WC()->cart->is_empty()) : ?>

                    <p class="py-4 mb-0">Koszyk jest pusty.</p>

                <?php else : ?>

                    <form class="woocommerce-cart-form"
                          action="<?php echo esc_url(wc_get_cart_url()); ?>"
                          method="post">

                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>

                            <?php
                            $_product = $cart_item['data'];
                            $quantity = $cart_item['quantity'];

                            if (!$_product || !$_product->exists() || $quantity <= 0) {
                                continue;
                            }

                            $product_name     = $_product->get_name();
                            $product_image    = $_product->get_image('woocommerce_thumbnail');
                            $product_price    = WC()->cart->get_product_price($_product);
                            $product_subtotal = WC()->cart->get_product_subtotal($_product, $quantity);
                            $product_sku      = $_product->get_sku();
                            $availability     = $_product->get_availability();
                            ?>

                            <div class="pureshop-cart-product-row d-flex flex-column flex-md-row align-items-md-center border-bottom py-3 gap-3">

                                <div class="pureshop-cart-col-product flex-grow-1 d-flex align-items-center gap-3">

                                    <div class="pureshop-product-single-img flex-shrink-0">
                                        <?php echo wp_kses_post($product_image); ?>
                                    </div>

                                    <div class="pureshop-product-single-data">
                                        <p class="mb-1 fw-bold">
                                            <?php echo esc_html($product_name); ?>
                                        </p>

                                        <p class="mb-0 small">
                                            <?php echo esc_html($availability['availability'] ?: 'Dostępny'); ?>
                                        </p>
                                    </div>

                                </div>

                                <div class="pureshop-cart-cols d-flex align-items-center text-center">

                                    <div class="pureshop-cart-col">
                                        <span class="pureshop-cart-single-data-mobile">Cena 1szt:</span>
                                        <?php echo wp_kses_post($product_price); ?>
                                    </div>

                                    <div class="pureshop-cart-col">
                                        <span class="pureshop-cart-single-data-mobile">Ilość:</span>
                                        <div class="pureshop-cart-qty d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2 rounded-pill">

                                            <button type="submit"
                                                    name="pureshop_qty_action"
                                                    value="<?php echo esc_attr($cart_item_key . '|minus'); ?>"
                                                    class="pureshop-qty-minus btn p-0 border-0">
                                                −
                                            </button>

                                            <strong><?php echo esc_html($quantity); ?></strong>

                                            <button type="submit"
                                                    name="pureshop_qty_action"
                                                    value="<?php echo esc_attr($cart_item_key . '|plus'); ?>"
                                                    class="pureshop-qty-plus btn p-0 border-0">
                                                +
                                            </button>

                                        </div>
                                    </div>

                                    <div class="pureshop-cart-col-total fw-bold">
                                        <span class="pureshop-cart-single-data-mobile">łącznie:</span>
                                        <?php echo wp_kses_post($product_subtotal); ?>
                                    </div>

                                    <div class="pureshop-cart-col-remove">
                                        <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                                           class="cart-remove"
                                           aria-label="Usuń produkt">
                                            &times;
                                        </a>
                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

                    </form>

                <?php endif; ?>

            </div>

        </div>
        <div class="col-12 col-lg-4 mt-4 mt-lg-0">

            <div class="pureshop-cart-summary p-4 rounded-4 pureshop-cart-main-place">

                <h5 class="text-uppercase fw-bold mb-4">
                    Podsumowanie koszyka
                </h5>

                <div class="pureshop-summary-line d-flex justify-content-between py-3 border-bottom">
                    <span>Wartość produktów</span>
                    <strong><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?></strong>
                </div>

                <div class="pureshop-summary-line d-flex justify-content-between py-3 border-bottom">
                    <span>Wysyłka</span>

                    <strong>
                        <?php if (WC()->cart->needs_shipping()) : ?>
                            <?php echo wp_kses_post(WC()->cart->get_cart_shipping_total()); ?>
                        <?php else : ?>
                            0,00 zł
                        <?php endif; ?>
                    </strong>
                </div>

                <?php if (wc_tax_enabled()) : ?>
                    <div class="pureshop-summary-line d-flex justify-content-between py-3 border-bottom">
                        <span>Podatek VAT</span>
                        <strong><?php echo wp_kses_post(WC()->cart->get_taxes_total() ? wc_price(WC()->cart->get_taxes_total()) : '0,00 zł'); ?></strong>
                    </div>
                <?php endif; ?>

                <div class="pureshop-summary-total d-flex justify-content-between align-items-center py-4">
                    <span class="fw-bold">Łącznie</span>
                    <strong class="pureshop-summary-price">
                        <?php echo wp_kses_post(WC()->cart->get_total()); ?>
                    </strong>
                </div>

                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                class="pureshop-checkout-btn d-flex align-items-center justify-content-center w-100 text-decoration-none mb-3 py-2">
                    Przejdź do kasy
                </a>

                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
                class="pureshop-continue-btn d-flex align-items-center justify-content-center w-100 text-decoration-none py-2">
                    Kontynuuj zakupy
                </a>

            </div>

        </div>
    </div>
</div>