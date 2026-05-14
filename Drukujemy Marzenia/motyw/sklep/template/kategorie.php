<?php
$shop_link = function_exists('wc_get_page_permalink')
    ? wc_get_page_permalink('shop')
    : home_url('/sklep/');

$pureshop_categories = array(
    array(
        'slug'  => 'wyprzedaz',
        'title' => 'Wyprzedaż',
        'desc'  => 'Produkty 3D w niższych cenach — dekoracje, akcesoria i praktyczne dodatki do domu.',
        'icon'  => 'bi-tags',
    ),
    array(
        'slug'  => 'gadzety-i-akcesoria',
        'title' => 'Gadżety i akcesoria',
        'desc'  => 'Nowoczesne dodatki drukowane w 3D do codziennego użytku, prezentów i personalizacji.',
        'icon'  => 'bi-stars',
    ),
    array(
        'slug'  => 'akcesoria-motoryzacyjne',
        'title' => 'Akcesoria motoryzacyjne',
        'desc'  => 'Praktyczne uchwyty, organizery i elementy użytkowe do auta wykonane w technologii 3D.',
        'icon'  => 'bi-car-front',
    ),
    array(
        'slug'  => 'akcesoria-biurowe',
        'title' => 'Akcesoria biurowe',
        'desc'  => 'Organizery, stojaki i funkcjonalne dodatki na biurko do pracy oraz domowego stanowiska.',
        'icon'  => 'bi-briefcase',
    ),
    array(
        'slug'  => 'personalizowane-prezenty-3d',
        'title' => 'Personalizowane prezenty 3D',
        'desc'  => 'Unikalne prezenty drukowane w 3D, tworzone pod konkretną osobę, okazję lub pomysł.',
        'icon'  => 'bi-gift',
    ),
    array(
    'slug'  => 'dekoracje-gamingowe',
    'title' => 'Dekoracje gamingowe',
    'desc'  => 'Nowoczesne dekoracje i akcesoria inspirowane światem gamingu, setupów RGB oraz futurystycznego designu.',
    'icon'  => 'bi-controller',
),
);
?>

<section class="pureshop-category-tiles-section py-5">
    <div class="container-fluid pureshop-max-width">

        <div class="row mb-4">
            <div class="col-12">
                <span class="pureshop-category-eyebrow fs-3">Kategorie produktów</span>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($pureshop_categories as $cat) : ?>
                <?php
                $cat_link = add_query_arg(
                    array(
                        'filter_cat' => array($cat['slug']),
                    ),
                    $shop_link
                );
                ?>

                <div class="col-12 col-sm-6 col-xl-4">
                    <a href="<?php echo esc_url($cat_link); ?>" class="pureshop-category-tile text-decoration-none">
                        <div class="pureshop-category-icon">
                            <i class="bi <?php echo esc_attr($cat['icon']); ?>"></i>
                        </div>

                        <h3><?php echo esc_html($cat['title']); ?></h3>

                        <p><?php echo esc_html($cat['desc']); ?></p>

                        <span class="pureshop-category-link">
                            Zobacz produkty
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>