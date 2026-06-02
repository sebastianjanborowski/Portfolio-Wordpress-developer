<?php
defined('ABSPATH') || exit;

get_header();

$paged = max(1, get_query_var('paged'), absint($_GET['paged'] ?? 1));

$search = isset($_GET['s'])
    ? sanitize_text_field(wp_unslash($_GET['s']))
    : '';

$min_price = isset($_GET['min_price'])
    ? sanitize_text_field(wp_unslash($_GET['min_price']))
    : '';

$max_price = isset($_GET['max_price'])
    ? sanitize_text_field(wp_unslash($_GET['max_price']))
    : '';

$filter_cat = isset($_GET['filter_cat'])
    ? array_map('sanitize_text_field', (array) wp_unslash($_GET['filter_cat']))
    : [];

$stock_status = isset($_GET['stock_status'])
    ? sanitize_text_field(wp_unslash($_GET['stock_status']))
    : '';

$is_search_mode = $search !== '';

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'paged'          => $paged,
];

$orderby = isset($_GET['orderby'])
    ? wc_clean(wp_unslash($_GET['orderby']))
    : 'menu_order';

switch ($orderby) {
    case 'popularity':
        $args['meta_key'] = 'total_sales';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC';
        break;

    case 'rating':
        $args['meta_key'] = '_wc_average_rating';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC';
        break;

    case 'date':
        $args['orderby'] = 'date';
        $args['order']   = 'DESC';
        break;

    case 'price':
        $args['meta_key'] = '_price';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'ASC';
        break;

    case 'price-desc':
        $args['meta_key'] = '_price';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC';
        break;

    default:
        $args['orderby'] = 'menu_order title';
        $args['order']   = 'ASC';
        break;
}

if ($is_search_mode) {
    $args['s'] = $search;
}

$meta_query = [];
$tax_query  = [];

if (is_tax('product_cat')) {
    $current_cat = get_queried_object();

    if ($current_cat && !is_wp_error($current_cat)) {
        $tax_query[] = [
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $current_cat->term_id,
        ];
    }
}

if ($min_price !== '' || $max_price !== '') {
    $meta_query[] = [
        'key'     => '_price',
        'value'   => [
            $min_price !== '' ? floatval($min_price) : 0,
            $max_price !== '' ? floatval($max_price) : 999999999,
        ],
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC',
    ];
}

if ($stock_status === 'instock') {
    $meta_query[] = [
        'key'     => '_stock_status',
        'value'   => 'instock',
        'compare' => '=',
    ];
}

if (!empty($filter_cat)) {
    $tax_query[] = [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => $filter_cat,
        'operator' => 'IN',
    ];
}

if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
}

if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}




$products = new WP_Query($args);
?>

<main class="pureshop-shop-page py-5 pureshop-margin-top">
    <div class="container-fluid pureshop-max-width_products">

        <div class="row mb-4">
            <div class="col-12">
                <h1 class="fw-bold mb-3 pureshop-color">
                    <?php if ($is_search_mode) : ?>
                        Wyniki wyszukiwania: <?php echo esc_html($search); ?>
                    <?php else : ?>
                        Sklep
                    <?php endif; ?>
                </h1>
            </div>
        </div>

        <div class="row g-4 align-items-start">

            <aside class="col-12 col-lg-3">
                <div class="pureshop-shop-filter p-4 rounded-4">

                    <h3 class="h5 fw-bold mb-4 pureshop-color">Filtry</h3>

                    <form method="get" action="<?php echo esc_url(remove_query_arg('paged')); ?>">

                        <?php if ($is_search_mode) : ?>
                            <input type="hidden" name="s" value="<?php echo esc_attr($search); ?>">
                            <input type="hidden" name="post_type" value="product">
                        <?php endif; ?>

                        <div class="pureshop-filter-widget mb-4">
                            <h4 class="pureshop-filter-title mb-3">Cena</h4>

                            <label class="pureshop-color small">Od</label>
                            <input
                                type="number"
                                name="min_price"
                                class="form-control mb-2"
                                value="<?php echo esc_attr($min_price); ?>"
                                placeholder="Cena od"
                            >

                            <label class="pureshop-color small">Do</label>
                            <input
                                type="number"
                                name="max_price"
                                class="form-control mb-3"
                                value="<?php echo esc_attr($max_price); ?>"
                                placeholder="Cena do"
                            >
                        </div>

                        <div class="pureshop-filter-widget mb-4">
                            <h4 class="pureshop-filter-title mb-3">Kategoria</h4>

                            <?php
                            $categories = get_terms([
                                'taxonomy'   => 'product_cat',
                                'hide_empty' => true,
                            ]);

                            if (!is_wp_error($categories) && !empty($categories)) :
                                foreach ($categories as $cat) :
                            ?>
                                <label class="d-block pureshop-color small mb-2">
                                    <input class="cursor-pointer"
                                        type="checkbox"
                                        name="filter_cat[]"
                                        value="<?php echo esc_attr($cat->slug); ?>"
                                        <?php checked(in_array($cat->slug, $filter_cat, true)); ?>
                                    >
                                    <?php echo esc_html($cat->name); ?>
                                </label>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>

                        <div class="pureshop-filter-widget mb-4">
                            <h4 class="pureshop-filter-title mb-3">Status</h4>

                            <label class="d-block pureshop-color small mb-2">
                                <input
                                    type="checkbox"
                                    name="stock_status"
                                    value="instock"
                                    <?php checked($stock_status, 'instock'); ?>
                                >
                                Na stanie
                            </label>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold pureshop-product-filtr-button">
                            Filtruj
                        </button>

                        <a href="<?php echo esc_url(remove_query_arg([
                            'min_price',
                            'max_price',
                            'filter_cat',
                            'stock_status',
                            'paged',
                        ])); ?>" class="btn pureshop-product-filtr-button w-100 mt-2">
                            Wyczyść filtry
                        </a>

                        <?php if (isset($_GET['orderby'])) : ?>
                            <input type="hidden" name="orderby" value="<?php echo esc_attr(wc_clean(wp_unslash($_GET['orderby']))); ?>">
                        <?php endif; ?>

                    </form>

                </div>
            </aside>

            <div class="col-12 col-lg-9">

                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <div class="pureshop-color small">
                        Wyświetlanie wyników: <?php echo esc_html($products->found_posts); ?>
                    </div>

                    <div class="pureshop-ordering">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>

                <?php if ($products->have_posts()) : ?>

                    <ul class="products row list-unstyled p-0 m-0">

                        <?php while ($products->have_posts()) : $products->the_post(); ?>

                            <?php wc_get_template_part('content', 'product'); ?>

                        <?php endwhile; ?>

                    </ul>

                    <?php
                    $pagination = paginate_links([
                        'base'      => add_query_arg('paged', '%#%'),
                        'format'    => '',
                        'total'     => $products->max_num_pages,
                        'current'   => $paged,
                        'prev_text' => '‹',
                        'next_text' => '›',
                        'type'      => 'list',
                    ]);
                    ?>

                    <?php if ($pagination) : ?>
                        <div class="pureshop-pagination mt-5">
                            <?php echo wp_kses_post($pagination); ?>
                        </div>
                    <?php endif; ?>

                <?php else : ?>

                    <p class="pureshop-color">Brak produktów.</p>

                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>