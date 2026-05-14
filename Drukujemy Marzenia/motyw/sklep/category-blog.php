<?php get_header(); ?>



<?php get_header(); ?>

<section class="container mt-5 pureshop-margin-top2">

    <div class="mb-4">
        <h1 class="fw-bold mt-2 pureshop-colorH1">Blog</h1>
    </div>

    <div class="row g-4">

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>

                <?php
                $contentExcerpt = wp_strip_all_tags(get_the_content());
                $shortContent   = mb_substr($contentExcerpt, 0, 67);

                $title      = get_the_title();
                $shortTitle = mb_substr($title, 0, 37);

                if (mb_strlen($title) > 37) {
                    $shortTitle .= '...';
                }

                if (mb_strlen($contentExcerpt) > 67) {
                    $shortContent .= '...';
                }
                ?>

                <div class="col-12 col-sm-6 col-lg-4">
                    <article class="card h-100 single_product_color">

                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large', [
                                'class' => 'card-img-top object-fit-cover',
                                'style' => 'height:220px;',
                                'alt'   => esc_attr($title)
                            ]); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/akReklama.jpg'); ?>"
                                 class="card-img-top object-fit-cover"
                                 style="height:220px;"
                                 alt="<?php echo esc_attr($title); ?>">
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title fw-bold">
                                <?php echo esc_html($shortTitle); ?>
                            </h5>

                            <p class="card-text text-secondary small mb-3">
                                <?php echo esc_html($shortContent); ?>
                            </p>

                            <a href="<?php echo esc_url(get_permalink()); ?>"
                               class="btn fw-bold mt-auto pureshop-button-post">
                                Zobacz
                            </a>

                        </div>

                    </article>
                </div>

            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-white">Brak wpisów w tej kategorii.</p>
        <?php endif; ?>

    </div>

    <div class="mt-5 d-flex justify-content-center pureshop-pagination">
        <?php
        echo paginate_links(array(
            'prev_text' => '« Poprzednia',
            'next_text' => 'Następna »',
            'type'      => 'list'
        ));
        ?>
    </div>

</section>

<?php get_footer(); ?>