<?php
defined('ABSPATH') || exit;

get_header();

global $wpdb;

$paged = isset($_GET['product_page']) ? max(1, absint($_GET['product_page'])) : 1;

$shop_page_id = wc_get_page_id('shop');

$shop_url = $shop_page_id && $shop_page_id > 0
    ? get_permalink($shop_page_id)
    : home_url('/sklep/');

$shop_url = trailingslashit($shop_url);

$search = isset($_GET['product_search'])
    ? trim(sanitize_text_field(wp_unslash($_GET['product_search'])))
    : '';

$min_price = isset($_GET['min_price']) ? sanitize_text_field(wp_unslash($_GET['min_price'])) : '';
$max_price = isset($_GET['max_price']) ? sanitize_text_field(wp_unslash($_GET['max_price'])) : '';

$filter_cat = isset($_GET['filter_cat'])
    ? array_filter(array_map('sanitize_text_field', (array) wp_unslash($_GET['filter_cat'])))
    : [];

$stock_status = isset($_GET['stock_status']) ? sanitize_text_field(wp_unslash($_GET['stock_status'])) : '';
$orderby = isset($_GET['orderby']) ? wc_clean(wp_unslash($_GET['orderby'])) : 'menu_order';

$is_search_mode = $search !== '';

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'paged'          => $paged,
];

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
        $args['orderby'] = [
            'menu_order' => 'ASC',
            'title'      => 'ASC',
        ];
        break;
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

if ($is_search_mode) {
    $search_like = '%' . $wpdb->esc_like($search) . '%';

    $search_join = function ($join) use ($wpdb) {
        if (strpos($join, 'holistic_pm_search') === false) {
            $join .= " LEFT JOIN {$wpdb->postmeta} AS holistic_pm_search ON ({$wpdb->posts}.ID = holistic_pm_search.post_id)";
        }

        return $join;
    };

    $search_where = function ($where) use ($wpdb, $search_like) {
        $where .= $wpdb->prepare(
            " AND (
                {$wpdb->posts}.post_title LIKE %s
                OR {$wpdb->posts}.post_excerpt LIKE %s
                OR {$wpdb->posts}.post_content LIKE %s
                OR holistic_pm_search.meta_value LIKE %s
            )",
            $search_like,
            $search_like,
            $search_like,
            $search_like
        );

        return $where;
    };

    $search_distinct = function () {
        return 'DISTINCT';
    };

    add_filter('posts_join', $search_join);
    add_filter('posts_where', $search_where);
    add_filter('posts_distinct', $search_distinct);
}

$products = new WP_Query($args);

if ($is_search_mode) {
    remove_filter('posts_join', $search_join);
    remove_filter('posts_where', $search_where);
    remove_filter('posts_distinct', $search_distinct);
}

$categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
]);

$pagination_args = [];

foreach ($_GET as $key => $value) {
    if ($key === 'product_page') {
        continue;
    }

    $pagination_args[$key] = $value;
}

$pagination = paginate_links([
    'base'      => add_query_arg('product_page', '%#%', $shop_url),
    'format'    => '',
    'total'     => max(1, $products->max_num_pages),
    'current'   => $paged,
    'prev_text' => '‹',
    'next_text' => '›',
    'type'      => 'list',
    'add_args'  => $pagination_args,
]);
?>

<header class="beauty-page-hero">
    <div class="container">
        <div class="beauty-page-hero__inner text-center">
            <img class="holistic-header-ornament" src="<?php echo get_template_directory_uri(); ?>/assets/img/produkcja/podkreslnik_title_cut.png" alt="Podkreślnik tytułu podstrony">
            <h1 class="beauty-page-title"><?php woocommerce_page_title(); ?></h1>
        </div>
    </div>
</header>

<main class="holistic-shop-page py-2">
    <div class="container">

        <section class="mb-1">
            <div class="card border-0 rounded-5 shadow-sm holistic-shop-search-card overflow-hidden">
                <div class="card-body p-4">

                    <div class="row align-items-center g-4">
                        <div class="col-12 col-lg-5">
                            <span class="text-uppercase fw-bold small holistic-gold d-inline-block mb-2">
                                Sklep Holistic Beauty
                            </span>

                            <h2 class="h3 fw-bold holistic-green mb-2">
                                Znajdź produkt dla siebie
                            </h2>

                            <p class="text-muted mb-0">
                                Wyszukaj produkt, a następnie doprecyzuj wynik filtrem ceny, kategorii lub dostępności.
                            </p>
                        </div>

                        <div class="col-12 col-lg-7">
                            <form method="get" action="<?php echo esc_url($shop_url); ?>" class="holistic-product-search-form">
                                <div class="input-group input-group-lg holistic-search-group">
                                    <input
                                        type="search"
                                        name="product_search"
                                        class="form-control rounded-start-pill px-4"
                                        value="<?php echo esc_attr($search); ?>"
                                        placeholder="Wpisz nazwę produktu, SKU, opis..."
                                    >

                                    <button type="submit" class="btn px-4 px-lg-5 holistic-main-btn">
                                        Szukaj
                                    </button>
                                </div>
                            </form>

                            <?php if ($is_search_mode) : ?>
                                <div class="mt-3 small text-muted">
                                    Aktywne wyszukiwanie:
                                    <strong><?php echo esc_html($search); ?></strong>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <div class="row g-4 align-items-start">

            <aside class="col-12 col-lg-3">
                <div class="card border-0 rounded-5 shadow-sm holistic-filter-card sticky-lg-top">
                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h2 class="h5 fw-bold holistic-green mb-0">
                                Filtry
                            </h2>

                            <span class="badge rounded-pill holistic-soft-badge">
                                <?php echo esc_html($products->found_posts); ?>
                            </span>
                        </div>

                        <form method="get" action="<?php echo esc_url($shop_url); ?>">

                            <?php if ($is_search_mode) : ?>
                                <input type="hidden" name="product_search" value="<?php echo esc_attr($search); ?>">
                            <?php endif; ?>

                            <?php if ($orderby) : ?>
                                <input type="hidden" name="orderby" value="<?php echo esc_attr($orderby); ?>">
                            <?php endif; ?>

                            <div class="mb-4 pb-4 border-bottom">
                                <h3 class="h6 fw-bold mb-3 holistic-filter-title">
                                    Cena
                                </h3>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label small text-muted mb-1">Od</label>
                                        <input type="number" name="min_price" class="form-control rounded-4" value="<?php echo esc_attr($min_price); ?>" placeholder="0" min="0">
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label small text-muted mb-1">Do</label>
                                        <input type="number" name="max_price" class="form-control rounded-4" value="<?php echo esc_attr($max_price); ?>" placeholder="999" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 pb-4 border-bottom">
                                <h3 class="h6 fw-bold mb-3 holistic-filter-title">
                                    Kategoria
                                </h3>

                                <?php if (!is_wp_error($categories) && !empty($categories)) : ?>
                                    <div class="d-flex flex-column gap-2">
                                        <?php foreach ($categories as $cat) : ?>
                                            <label class="form-check d-flex align-items-center gap-2 mb-0">
                                                <input
                                                    type="checkbox"
                                                    name="filter_cat[]"
                                                    class="form-check-input mt-0"
                                                    value="<?php echo esc_attr($cat->slug); ?>"
                                                    <?php checked(in_array($cat->slug, $filter_cat, true)); ?>
                                                >

                                                <span class="form-check-label small text-muted">
                                                    <?php echo esc_html($cat->name); ?>
                                                </span>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <p class="small text-muted mb-0">
                                        Brak kategorii.
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <h3 class="h6 fw-bold mb-3 holistic-filter-title">
                                    Dostępność
                                </h3>

                                <label class="form-check d-flex align-items-center gap-2 mb-0">
                                    <input
                                        type="checkbox"
                                        name="stock_status"
                                        class="form-check-input mt-0"
                                        value="instock"
                                        <?php checked($stock_status, 'instock'); ?>
                                    >

                                    <span class="form-check-label small text-muted">
                                        Tylko produkty na stanie
                                    </span>
                                </label>
                            </div>

                            <button type="submit" class="btn w-100 fw-semibold py-2 holistic-main-btn">
                                Zastosuj filtry
                            </button>

                            <a href="<?php echo esc_url($shop_url); ?>" class="btn btn-outline-secondary w-100 fw-semibold py-2 mt-2">
                                Wyczyść wszystko
                            </a>
                        </form>

                    </div>
                </div>
            </aside>

            <section class="col-12 col-lg-9">

                <div class="card border-0 rounded-5 shadow-sm holistic-toolbar-card">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                            <div>
                                <p class="small text-muted mb-1">
                                    Wyniki
                                </p>

                                <h2 class="h5 fw-bold holistic-green mb-0">
                                    <?php echo $is_search_mode ? '„' . esc_html($search) . '”' : 'Wszystkie produkty'; ?>
                                </h2>
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <span class="small text-muted">
                                    Znaleziono:
                                    <strong><?php echo esc_html($products->found_posts); ?></strong>
                                </span>

                                <form method="get" action="<?php echo esc_url($shop_url); ?>" class="holistic-ordering">
                                    <?php if ($is_search_mode) : ?>
                                        <input type="hidden" name="product_search" value="<?php echo esc_attr($search); ?>">
                                    <?php endif; ?>

                                    <?php if ($min_price !== '') : ?>
                                        <input type="hidden" name="min_price" value="<?php echo esc_attr($min_price); ?>">
                                    <?php endif; ?>

                                    <?php if ($max_price !== '') : ?>
                                        <input type="hidden" name="max_price" value="<?php echo esc_attr($max_price); ?>">
                                    <?php endif; ?>

                                    <?php if ($stock_status !== '') : ?>
                                        <input type="hidden" name="stock_status" value="<?php echo esc_attr($stock_status); ?>">
                                    <?php endif; ?>

                                    <?php foreach ($filter_cat as $cat_slug) : ?>
                                        <input type="hidden" name="filter_cat[]" value="<?php echo esc_attr($cat_slug); ?>">
                                    <?php endforeach; ?>

                                    <select name="orderby" class="orderby" onchange="this.form.submit()">
                                        <option value="menu_order" <?php selected($orderby, 'menu_order'); ?>>Domyślne sortowanie</option>
                                        <option value="popularity" <?php selected($orderby, 'popularity'); ?>>Sortuj wg popularności</option>
                                        <option value="rating" <?php selected($orderby, 'rating'); ?>>Sortuj wg oceny</option>
                                        <option value="date" <?php selected($orderby, 'date'); ?>>Sortuj od najnowszych</option>
                                        <option value="price" <?php selected($orderby, 'price'); ?>>Cena: od najniższej</option>
                                        <option value="price-desc" <?php selected($orderby, 'price-desc'); ?>>Cena: od najwyższej</option>
                                    </select>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <?php if ($products->have_posts()) : ?>

                    <ul class="products row list-unstyled p-0 m-0 g-4 holistic-margin">
                        <?php while ($products->have_posts()) : $products->the_post(); ?>
                            <?php wc_get_template_part('content', 'product'); ?>
                        <?php endwhile; ?>
                    </ul>

                    <?php if ($pagination) : ?>
                        <nav class="holistic-pagination mt-5">
                            <?php echo wp_kses_post($pagination); ?>
                        </nav>
                    <?php endif; ?>

                <?php else : ?>

                    <div class="card border-0 rounded-5 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <h2 class="h4 fw-bold holistic-green mb-3">
                                Brak produktów
                            </h2>

                            <p class="text-muted mb-4">
                                Nie znaleziono produktów dla wybranych kryteriów.
                            </p>

                            <a href="<?php echo esc_url($shop_url); ?>" class="btn rounded-pill px-5 py-2 holistic-main-btn">
                                Wyczyść filtry
                            </a>
                        </div>
                    </div>

                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

            </section>

        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.holistic-product-search-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const input = form.querySelector('input[name="product_search"]');

            if (input && input.value.trim() === '') {
                e.preventDefault();
                window.location.href = form.action;
            }
        });
    });
});
</script>

<?php get_footer(); ?>