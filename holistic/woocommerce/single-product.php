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
            <h1 class="beauty-page-title">
                <?php echo esc_html($product_title); ?>
                <br>
                <img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/produkcja/podkreslnik_title_cut.png'); ?>"
                    alt=""
                    class="img-fluid mt-2"
                >
            </h1>
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

<style>
.holistic-single-product{
    background:
        radial-gradient(circle at top left, rgba(212,184,93,.12), transparent 32%),
        linear-gradient(180deg,#f8faf9 0%,#ffffff 100%);
}

.holistic-green{
    color:#1f5f52;
}

.holistic-gold{
    color:#d4b85d;
    letter-spacing:.14em;
}

.holistic-product-gallery,
.holistic-product-summary,
.holistic-product-tabs{
    border:1px solid rgba(31,95,82,.08)!important;
}

.holistic-product-gallery,
.holistic-product-summary{
    background:
        radial-gradient(circle at top right, rgba(212,184,93,.13), transparent 34%),
        #fff;
}

.holistic-main-image{
    background:#faf8f2;
    min-height:420px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.holistic-product-main-img{
    max-height:520px;
    object-fit:contain;
}

.holistic-thumb{
    background:#faf8f2;
    border:1px solid rgba(31,95,82,.08);
    transition:transform .2s ease, border-color .2s ease;
}

.holistic-thumb:hover{
    transform:translateY(-2px);
    border-color:#d4b85d;
}

.holistic-single-price{
    color:#1f5f52;
    font-size:1.75rem;
    font-weight:800;
}

.holistic-single-price del{
    color:#8c8c8c;
    font-size:1rem;
    font-weight:500;
    margin-right:.5rem;
}

.holistic-single-price ins{
    text-decoration:none;
}

.holistic-soft-badge{
    background:rgba(212,184,93,.18);
    color:#1f5f52;
    padding:.65rem .9rem;
}

.holistic-outline-badge{
    color:#1f5f52;
    border:1px solid rgba(31,95,82,.18);
    background:#fff;
    padding:.65rem .9rem;
}

.holistic-add-to-cart form.cart{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    align-items:center;
}

.holistic-add-to-cart .quantity .qty{
    width:90px;
    height:48px;
    border-radius:999px;
    border:1px solid rgba(31,95,82,.18);
    padding:0 1rem;
    text-align:center;
}

.holistic-add-to-cart .single_add_to_cart_button,
.holistic-add-to-cart button[type="submit"]{
    min-height:48px;
    border-radius:999px!important;
    background:#1f5f52!important;
    border:1px solid #1f5f52!important;
    color:#fff!important;
    padding:.75rem 1.6rem!important;
    font-weight:700!important;
    box-shadow:0 8px 20px rgba(31,95,82,.16);
    transition:background-color .2s ease,border-color .2s ease,color .2s ease,transform .2s ease;
}

.holistic-add-to-cart .single_add_to_cart_button:hover,
.holistic-add-to-cart button[type="submit"]:hover{
    background:#d4b85d!important;
    border-color:#d4b85d!important;
    color:#1f332e!important;
    transform:translateY(-1px);
}

.holistic-product-meta a{
    color:#1f5f52;
    font-weight:600;
    text-decoration:none;
}

.holistic-product-meta a:hover{
    color:#d4b85d;
}

.holistic-product-tabs .nav-pills .nav-link{
    color:#1f5f52;
    background:#fff;
    border:1px solid rgba(31,95,82,.12);
    font-weight:700;
    padding:.7rem 1.2rem;
}

.holistic-product-tabs .nav-pills .nav-link.active{
    background:#1f5f52;
    color:#fff;
    border-color:#1f5f52;
}

.holistic-product-content{
    color:#44524d;
    line-height:1.8;
}

.holistic-outline-btn{
    color:#1f5f52;
    border:1px solid rgba(31,95,82,.2);
    background:#fff;
    font-weight:700;
}

.holistic-outline-btn:hover{
    background:#1f5f52;
    color:#fff;
}

.woocommerce-product-rating{
    display:flex;
    align-items:center;
    gap:.75rem;
    margin-bottom:0!important;
}

.woocommerce-product-rating .star-rating{
    color:#d4b85d;
}

.woocommerce-review-link{
    color:#1f5f52;
    font-weight:600;
    text-decoration:none;
}

.woocommerce-review-link:hover{
    color:#d4b85d;
}

.woocommerce table.shop_attributes{
    border:0;
}

.woocommerce table.shop_attributes th,
.woocommerce table.shop_attributes td{
    border-bottom:1px solid rgba(31,95,82,.08);
    padding:14px;
}

/* OPINIE PRODUKTU */
#reviews {
  color: #1f332e;
}

#reviews #comments h2,
#reviews #reply-title {
  color: #1f5f52;
  font-weight: 800;
  margin-bottom: 16px;
}

#reviews .comment-reply-title {
  display: block;
  font-size: 24px;
}

#reviews .comment-form {
  max-width: 500px;
  margin-top: 24px;
  padding: 24px;
  border-radius: 28px;
  background: linear-gradient(135deg, #ffffff 0%, #f8faf9 100%);
  border: 1px solid rgba(31, 95, 82, .10);
  box-shadow: 0 10px 28px rgba(31, 95, 82, .08);
}

#reviews .comment-form label {
  display: block;
  color: #1f5f52;
  font-weight: 700;
  margin-bottom: 8px;
}

#reviews .comment-form textarea,
#reviews .comment-form input[type="text"],
#reviews .comment-form input[type="email"],
#reviews .comment-form input[type="url"] {
  width: 100%;
  border: 1px solid rgba(31, 95, 82, .18);
  border-radius: 18px;
  padding: 14px 16px;
  color: #1f332e;
  background: #fff;
  outline: none;
  transition: border-color .2s ease, box-shadow .2s ease;
}

#reviews .comment-form textarea {
  min-height: 160px;
  resize: vertical;
}

#reviews .comment-form textarea:focus,
#reviews .comment-form input:focus {
  border-color: #d4b85d;
  box-shadow: 0 0 0 .25rem rgba(212, 184, 93, .18);
}

#reviews .comment-form-rating {
  margin-bottom: 18px;
}

#reviews .stars {
  margin: 8px 0 0;
}

#reviews .stars a {
  color: transparent !important;
  position: relative;
  display: inline-flex;
  width: 34px;
  height: 34px;
  margin-right: 4px;
  text-decoration: none !important;
}

#reviews .stars a::before {
  content: "★";
  color: #d4b85d;
  font-size: 30px;
  line-height: 34px;
  position: absolute;
  inset: 0;
}

#reviews .form-submit {
  margin-top: 18px;
}

#reviews .form-submit input[type="submit"],
#reviews button[type="submit"] {
  background: #1f5f52 !important;
  border: 1px solid #1f5f52 !important;
  color: #fff !important;
  border-radius: 999px !important;
  padding: 8px 15px !important;
  font-weight: 700 !important;
  box-shadow: 0 8px 20px rgba(31, 95, 82, .16);
  transition: background-color .2s ease, border-color .2s ease, color .2s ease, transform .2s ease;
}

#reviews .form-submit input[type="submit"]:hover,
#reviews button[type="submit"]:hover {
  background: #d4b85d !important;
  border-color: #d4b85d !important;
  color: #1f332e !important;
  transform: translateY(-1px);
}

#reviews .woocommerce-noreviews {
  padding: 14px 18px;
  border-radius: 18px;
  background: rgba(212, 184, 93, .14);
  color: #1f5f52;
  font-weight: 600;
}

#reviews .commentlist {
  list-style: none;
  padding: 0;
  margin: 0 0 28px;
}

#reviews .commentlist li {
  padding: 18px;
  border-radius: 22px;
  background: #fff;
  border: 1px solid rgba(31, 95, 82, .10);
  margin-bottom: 14px;
}

#reviews .comment_container {
  display: flex;
  gap: 16px;
}

#reviews .avatar {
  width: 54px;
  height: 54px;
  border-radius: 50%;
}

#reviews .comment-text {
  flex: 1;
}

#reviews .meta {
  color: #1f332e;
  font-weight: 700;
}

#reviews .description {
  color: #5f6f69;
  line-height: 1.7;
}

.avatar.avatar-60.photo{
  display:none !important;
}

@media (max-width: 575.98px) {
  #reviews .comment-form {
    padding: 18px;
    border-radius: 22px;
  }

  #reviews .comment_container {
    flex-direction: column;
  }

  #reviews .stars a {
    width: 30px;
    height: 30px;
  }

  #reviews .stars a::before {
    font-size: 26px;
  }
}

@media (max-width:991.98px){
    .holistic-main-image{
        min-height:320px;
    }

    .holistic-product-main-img{
        max-height:360px;
    }

    .holistic-single-price{
        font-size:1.45rem;
    }
}

@media (max-width:575.98px){
    .holistic-add-to-cart form.cart{
        flex-direction:column;
        align-items:stretch;
    }

    .holistic-add-to-cart .quantity .qty,
    .holistic-add-to-cart .single_add_to_cart_button,
    .holistic-add-to-cart button[type="submit"]{
        width:100%;
    }

    .bydlo_header_logo,
    .custom-logo{
        max-width:180px;
        height:auto;
    }
}
</style>

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