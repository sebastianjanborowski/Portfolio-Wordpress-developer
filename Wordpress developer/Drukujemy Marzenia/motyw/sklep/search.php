<?php
defined('ABSPATH') || exit;

get_header();

$paged = max(1, absint($_GET['paged'] ?? 1));

$search = sanitize_text_field(wp_unslash($_GET['s'] ?? ''));

$min_price = sanitize_text_field(wp_unslash($_GET['min_price'] ?? ''));
$max_price = sanitize_text_field(wp_unslash($_GET['max_price'] ?? ''));

$filter_cat = isset($_GET['filter_cat'])
    ? array_map('sanitize_text_field', (array) wp_unslash($_GET['filter_cat']))
    : [];

$stock_status = sanitize_text_field(wp_unslash($_GET['stock_status'] ?? ''));

global $wp_query;
$products = $wp_query;
?>

<main class="pureshop-shop-page py-5">
    <div class="container-fluiid pureshop-max-width_products">

        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-white fw-bold mb-3">
                    Wyniki wyszukiwania: „<?php echo esc_html($search); ?>”
                </h1>
            </div>
        </div>

        <div class="row g-4 align-items-start">

            <aside class="col-12 col-lg-3">
                <div class="pureshop-shop-filter p-4 rounded-4">

                    <h3 class="h5 text-white fw-bold mb-4">Filtry</h3>

                    <form method="get" action="<?php echo esc_url(home_url('/')); ?>">

                        <input type="hidden" name="s" value="<?php echo esc_attr($search); ?>">
                        <input type="hidden" name="post_type" value="product">

                        <div class="pureshop-filter-widget mb-4">
                            <h4 class="pureshop-filter-title mb-3">Cena</h4>

                            <label class="text-white-50 small">Od</label>
                            <input
                                type="number"
                                name="min_price"
                                class="form-control mb-2"
                                value="<?php echo esc_attr($min_price); ?>"
                                placeholder="Cena od"
                            >

                            <label class="text-white-50 small">Do</label>
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
                                    <label class="d-block text-white-50 small mb-2">
                                        <input
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

                            <label class="d-block text-white-50 small mb-2">
                                <input
                                    type="checkbox"
                                    name="stock_status"
                                    value="instock"
                                    <?php checked($stock_status, 'instock'); ?>
                                >
                                Na stanie
                            </label>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold">
                            Filtruj
                        </button>

                        <a href="<?php echo esc_url(add_query_arg([
                            's' => $search,
                            'post_type' => 'product',
                        ], home_url('/'))); ?>" class="btn btn-outline-light w-100 mt-2">
                            Wyczyść filtry
                        </a>

                    </form>

                </div>
            </aside>

            <div class="col-12 col-lg-9">

                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <div class="text-white-50 small">
                        Wyświetlanie wszystkich wyników: <?php echo esc_html($products->found_posts); ?>
                    </div>

                    <div class="pureshop-ordering">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>

                <?php if ($products->have_posts()) : ?>

                    <ul class="products row list-unstyled p-0 m-0">

                        <?php while ($products->have_posts()) : ?>
                            <?php
                            $products->the_post();
                            wc_get_template_part('content', 'product');
                            ?>
                        <?php endwhile; ?>

                    </ul>

                    <?php
                    $pagination = paginate_links([
                        'base'      => add_query_arg('paged', '%#%', home_url('/')),
                        'format'    => '',
                        'total'     => $products->max_num_pages,
                        'current'   => $paged,
                        'prev_text' => '‹',
                        'next_text' => '›',
                        'type'      => 'list',
                        'add_args'  => [
                            's'            => $search,
                            'post_type'    => 'product',
                            'min_price'    => $min_price,
                            'max_price'    => $max_price,
                            'filter_cat'   => $filter_cat,
                            'stock_status' => $stock_status,
                        ],
                    ]);
                    ?>

                    <?php if ($pagination) : ?>
                        <div class="pureshop-pagination mt-5">
                            <?php echo wp_kses_post($pagination); ?>
                        </div>
                    <?php endif; ?>

                <?php else : ?>

                    <p class="text-white-50">Brak produktów.</p>

                <?php endif; ?>

                <?php wp_reset_postdata(); ?>

            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>