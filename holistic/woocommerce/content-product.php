<?php
defined('ABSPATH') || exit;

global $product;

if ( empty($product) || ! $product->is_visible() ) return;

// Best Seller: tag produktu "best-seller"
$is_best_seller = has_term('best-seller', 'product_tag', $product->get_id());
?>

<li <?php wc_product_class('beauty-product-card-item', $product); ?>>

  <div class="beauty-product-card">

    <?php if ($is_best_seller): ?>
      <div class="beauty-product-badge">
        Best Seller
      </div>
    <?php endif; ?>

    <button
      class="beauty-heart"
      type="button"
      aria-label="Wishlist"
    >♡</button>

    <a
      class="beauty-product-media"
      href="<?php the_permalink(); ?>"
    >
      <?php do_action('woocommerce_before_shop_loop_item_title'); ?>
    </a>

    <div class="beauty-product-body">
      <h2 class="beauty-product-title">
        <a href="<?php the_permalink(); ?>">
          <?php echo wp_trim_words(get_the_title(), 4, '...'); ?>
        </a>
      </h2>

      <div class="beauty-product-price">
        <?php do_action('woocommerce_after_shop_loop_item_title'); ?>
      </div>

      <div class="beauty-product-actions">
        <?php do_action('woocommerce_after_shop_loop_item'); ?>
      </div>
    </div>

  </div>

</li>