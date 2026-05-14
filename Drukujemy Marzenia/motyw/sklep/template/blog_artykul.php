<?php
$category_id = 36;

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'cat'            => $category_id,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
);

$query = new WP_Query($args);
?>

<section class="container pureshop-max-width mt-3 mb-3">

    <div class="mb-4">
        <h2 class="text-white fw-bold mt-2">Poradnik i aktualności</h2>
    </div>

    <div class="row g-4">

        <?php if($query->have_posts()):
            while($query->have_posts()): $query->the_post(); ?>

                <?php
                $contentExcerpt = wp_strip_all_tags(get_the_content());
                $shortContent   = mb_substr($contentExcerpt, 0, 67);

                $title      = get_the_title();
                $shortTitle = mb_substr($title, 0, 37);

                if(mb_strlen($title) > 37) $shortTitle .= '...';
                if(mb_strlen($contentExcerpt) > 67) $shortContent .= '...';
                ?>

                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="card h-100 bg-dark border-secondary text-white">

                        <!-- obraz -->
                        <?php if(has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium', [
                                'class' => 'card-img-top object-fit-cover',
                                'style' => 'height:200px;'
                            ]); ?>
                        <?php else: ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/akReklama.jpg'); ?>"
                                 class="card-img-top object-fit-cover"
                                 style="height:200px;"
                                 alt="<?php echo esc_attr($title); ?>">
                        <?php endif; ?>

                        <!-- body -->
                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title fw-bold">
                                <?php echo esc_html($shortTitle); ?>
                            </h5>

                            <p class="card-text text-secondary small mb-3">
                                <?php echo esc_html($shortContent); ?>
                            </p>

                            <a href="<?php echo esc_url(get_permalink()); ?>"
                               class="btn btn-warning fw-bold mt-auto text-dark pureshop-none-radius">
                                Zobacz
                            </a>

                        </div>

                    </article>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>

<?php wp_reset_postdata(); ?>