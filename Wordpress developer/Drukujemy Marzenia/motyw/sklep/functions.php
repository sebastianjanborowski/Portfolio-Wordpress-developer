<?php
// ============================================
// KONFIGURACJA MOTYWU
// ============================================

function pureshop_register_menus() {

    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');

    register_nav_menus(array(
        'primary' => __('Menu główne', 'pureshop'),
        'footer_pracownia_3d' => __('Menu pracownia 3d', 'pureshop'),
        'footer_obsluga_klienta' => __('Menu obsługa klienta', 'pureshop'),
    ));
}
add_action('after_setup_theme', 'pureshop_register_menus');


// ============================================
// ŁADOWANIE STYLÓW I SKRYPTÓW
// ============================================

function pureshop_add_scripts() {

    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
        array(),
        '5.3.8'
    );

    wp_enqueue_style(
        'bootstrap-icon',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
        array(),
        '1.11.3'
    );

    wp_enqueue_style(
        'pure-shopd-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0.0'
    );

    wp_enqueue_script(
        'main-style-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.8',
        true
    );

    wp_add_inline_script('main-style-js', '
        document.addEventListener("DOMContentLoaded", function () {

            function getFavorites() {
                try {
                    return JSON.parse(localStorage.getItem("pureshop_favorites") || "[]").map(String);
                } catch(e) {
                    return [];
                }
            }

            function saveFavorites(favs) {
                localStorage.setItem("pureshop_favorites", JSON.stringify(favs.map(String)));
            }

            function refreshFavoriteButtons() {
                const favs = getFavorites();

                document.querySelectorAll(".pureshop-fav-btn").forEach(function(btn) {
                    const id = String(btn.dataset.productId || "");

                    if (!id) return;

                    if (favs.includes(id)) {
                        btn.classList.add("is-active");
                        btn.innerHTML = "<i class=\"bi bi-heart-fill\"></i> ";
                    } else {
                        btn.classList.remove("is-active");
                        btn.innerHTML = "<i class=\"bi bi-heart\"></i> ";
                    }
                });
            }

            document.addEventListener("click", function(e) {
                const btn = e.target.closest(".pureshop-fav-btn");
                if (!btn) return;

                e.preventDefault();

                const id = String(btn.dataset.productId || "");
                if (!id) return;

                let favs = getFavorites();

                if (favs.includes(id)) {
                    favs = favs.filter(function(item) {
                        return item !== id;
                    });
                } else {
                    favs.push(id);
                }

                saveFavorites(favs);
                refreshFavoriteButtons();

                if (document.body.classList.contains("page-id-ulubione")) {
                    window.location.reload();
                }
            });

            refreshFavoriteButtons();
        });
    ');
}
add_action('wp_enqueue_scripts', 'pureshop_add_scripts');


// ============================================
// WALKER DLA MENU BOOTSTRAP
// ============================================

class PURESHOP extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $classes = $depth === 0 ? 'dropdown-menu vt-dropdown-menu' : 'dropdown-menu vt-dropdown-menu vt-dropdown-submenu';
        $output .= "\n$indent<ul class=\"" . esc_attr($classes) . "\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = $depth ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes, true);

        $classes[] = 'nav-item';

        if ($has_children && $depth === 0) {
            $classes[] = 'dropdown';
        }

        if ($has_children && $depth > 0) {
            $classes[] = 'dropdown-submenu';
        }

        $class_names = implode(' ', array_map('sanitize_html_class', array_filter($classes)));
        $output .= $indent . '<li class="' . esc_attr($class_names) . '">';

        $atts = array(
            'title'  => !empty($item->attr_title) ? $item->attr_title : '',
            'target' => !empty($item->target) ? $item->target : '',
            'rel'    => !empty($item->xfn) ? $item->xfn : '',
            'href'   => !empty($item->url) ? $item->url : '',
            'class'  => $depth === 0 ? 'nav-link' : 'dropdown-item',
        );

        if ($has_children) {
            $atts['aria-expanded'] = 'false';
        }

        $attributes = '';

        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = $attr === 'href' ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output = '<a' . $attributes . '>';
        $item_output .= $title;

        if ($has_children && $depth === 0) {
            $item_output .= ' <i class="bi bi-chevron-down small ms-1"></i>';
        } elseif ($has_children && $depth > 0) {
            $item_output .= ' <i class="bi bi-chevron-right small float-end ms-2"></i>';
        }

        $item_output .= '</a>';

        $output .= $item_output;
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}


// ============================================
// BLOG
// ============================================

function pureshop_blog_category_posts_per_page($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_category('blog')) {
        $query->set('posts_per_page', 3);
    }
}
add_action('pre_get_posts', 'pureshop_blog_category_posts_per_page');


// ============================================
// WOOCOMMERCE TEMPLATE
// ============================================

add_filter('template_include', function($template) {

    if (is_shop() || is_product_category() || is_product_tag()) {
        $new_template = get_stylesheet_directory() . '/woocommerce/archive-product.php';

        if (file_exists($new_template)) {
            return $new_template;
        }
    }

    return $template;

}, 99);




// ============================================
// WYSZUKIWANIE PRODUKTÓW
// ============================================

function pureshop_product_search_wide($search, $wp_query) {
    global $wpdb;

    if (!$wp_query->is_main_query() || !is_search()) {
        return $search;
    }

    $search_term = trim($wp_query->get('s'));

    if ($search_term === '') {
        return $search;
    }

    $like = '%' . $wpdb->esc_like($search_term) . '%';

    return $wpdb->prepare("
        AND (
            {$wpdb->posts}.post_title LIKE %s
            OR {$wpdb->posts}.post_excerpt LIKE %s
            OR {$wpdb->posts}.post_content LIKE %s
            OR EXISTS (
                SELECT 1
                FROM {$wpdb->term_relationships} tr
                INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
                WHERE tr.object_id = {$wpdb->posts}.ID
                AND (
                    tt.taxonomy = 'product_cat'
                    OR tt.taxonomy = 'product_tag'
                    OR tt.taxonomy LIKE 'pa_%'
                )
                AND (
                    t.name LIKE %s
                    OR t.slug LIKE %s
                )
            )
        )
    ", $like, $like, $like, $like, $like);
}

function pureshop_product_search_order($orderby, $wp_query) {
    global $wpdb;

    if (!$wp_query->is_main_query() || !is_search()) {
        return $orderby;
    }

    $search_term = trim($wp_query->get('s'));

    if ($search_term === '') {
        return $orderby;
    }

    $like = '%' . $wpdb->esc_like($search_term) . '%';

    return $wpdb->prepare("
        CASE
            WHEN {$wpdb->posts}.post_title LIKE %s THEN 0
            WHEN {$wpdb->posts}.post_excerpt LIKE %s THEN 1
            WHEN {$wpdb->posts}.post_content LIKE %s THEN 2
            ELSE 3
        END ASC,
        {$wpdb->posts}.post_title ASC
    ", $like, $like, $like);
}

add_action('pre_get_posts', function($query) {

    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    $post_type = $query->get('post_type');

    $is_product_search =
        $query->is_search()
        && (
            $post_type === 'product'
            || (isset($_GET['post_type']) && $_GET['post_type'] === 'product')
        );

    $is_product_archive =
        $query->is_post_type_archive('product')
        || $query->is_tax('product_cat')
        || $query->is_tax('product_tag')
        || (
            is_string($query->get('taxonomy'))
            && function_exists('str_starts_with')
            && str_starts_with($query->get('taxonomy'), 'pa_')
        );

    if (!$is_product_search && !$is_product_archive) {
        return;
    }

    $query->set('post_type', 'product');
    $query->set('posts_per_page', 8);

    $meta_query = (array) $query->get('meta_query');

    $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== ''
        ? floatval(wp_unslash($_GET['min_price']))
        : null;

    $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== ''
        ? floatval(wp_unslash($_GET['max_price']))
        : null;

    if ($min_price !== null || $max_price !== null) {
        $meta_query[] = array(
            'key'     => '_price',
            'value'   => array(
                $min_price !== null ? $min_price : 0,
                $max_price !== null ? $max_price : 999999999,
            ),
            'compare' => 'BETWEEN',
            'type'    => 'NUMERIC',
        );

        $query->set('meta_query', $meta_query);
    }

    if ($is_product_search) {
        add_filter('posts_search', 'pureshop_product_search_wide', 10, 2);
        add_filter('posts_orderby', 'pureshop_product_search_order', 10, 2);
    }
});

add_filter('template_include', function($template) {

    if (is_search() && isset($_GET['post_type']) && $_GET['post_type'] === 'product') {
        $product_template = locate_template('woocommerce/archive-product.php');

        if ($product_template) {
            return $product_template;
        }

        $product_template = locate_template('archive-product.php');

        if ($product_template) {
            return $product_template;
        }
    }

    return $template;

}, 99);


// ============================================
// ULUBIONE PRODUKTY - SHORTCODE
// ============================================

add_shortcode('pureshop_ulubione', function() {
    ob_start();
    ?>

    <div id="pureshop-favorites-page" class="pureshop-favorites-page">
        <p>Ładowanie ulubionych produktów...</p>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const box = document.getElementById("pureshop-favorites-page");
        if (!box) return;

        let favs = [];

        try {
            favs = JSON.parse(localStorage.getItem("pureshop_favorites") || "[]").map(String);
        } catch(e) {
            favs = [];
        }

        if (!favs.length) {
            box.innerHTML = "<p>Nie masz jeszcze ulubionych produktów.</p>";
            return;
        }

        fetch("<?php echo esc_url(admin_url('admin-ajax.php')); ?>?action=pureshop_load_favorites&ids=" + encodeURIComponent(favs.join(",")))
            .then(function(res) {
                return res.text();
            })
            .then(function(html) {
                box.innerHTML = html;
            })
            .catch(function() {
                box.innerHTML = "<p>Nie udało się załadować ulubionych produktów.</p>";
            });
    });
    </script>

    <?php
    return ob_get_clean();
});


// ============================================
// ULUBIONE PRODUKTY - AJAX
// ============================================

add_action('wp_ajax_pureshop_load_favorites', 'pureshop_load_favorites');
add_action('wp_ajax_nopriv_pureshop_load_favorites', 'pureshop_load_favorites');

function pureshop_load_favorites() {

    $ids = isset($_GET['ids'])
        ? array_filter(array_map('absint', explode(',', sanitize_text_field(wp_unslash($_GET['ids'])))))
        : array();

    if (empty($ids)) {
        echo '<p>Brak ulubionych produktów.</p>';
        wp_die();
    }

    $query = new WP_Query(array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'post__in'       => $ids,
        'orderby'        => 'post__in',
        'posts_per_page' => -1,
    ));

    if ($query->have_posts()) {
        echo '<ul class="products row list-unstyled p-0 m-0">';

        while ($query->have_posts()) {
            $query->the_post();

            global $product;
            $product = wc_get_product(get_the_ID());

            wc_get_template_part('content', 'product');
        }

        echo '</ul>';
    } else {
        echo '<p>Nie znaleziono ulubionych produktów.</p>';
    }

    wp_reset_postdata();
    wp_die();
}


// ============================================
// DODATKOWE PLIKI
// ============================================

// zakomentowane podłączenie wbudowanej wtyczki do 2FA logowania do kokpitu administracyjnego, wyłączone poniewaz przenosząć serwis na nowa domene nie zawsze jest od razu skonfigurowany smtp i jak smtp nie działa nie ma jak dostarczyć wiadomości kodu dostępu 2Fa i nie ma jak sie zzalopgowac, uruchamiac dopiero wtedy kiedy na domenie , serwerze jest odpowiednio skonfigurowany smtp, moe być wtyczka wp smtp
// require_once 'template/template-functions_2fa_kokpit.php';

require_once get_template_directory() . "/pureshop-newsletter.php";