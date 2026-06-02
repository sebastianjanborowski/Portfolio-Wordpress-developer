<?php get_header(); ?>

<section class="container py-5">
    <div class="row g-5">
        <div class="col-lg-12">

            <?php while (have_posts()) : the_post(); ?>

                <article <?php post_class('single-post-wrapper'); ?>>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="position-relative overflow-hidden mb-4" style="max-height:480px;">
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                                 class="w-100 object-fit-cover"
                                 style="max-height:480px;"
                                 alt="<?php echo esc_attr(get_the_title()); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="p-4">

                        <?php $categories = get_the_category(); ?>
                        <?php if (!empty($categories)) : ?>
                            <div class="mb-3">
                                <?php foreach ($categories as $category) : ?>
                                    <span
                                       class="badge bg-opacity-10 text-decoration-none px-3 py-2 fw-normal me-1 pureshop-kategorie-single">
                                        <?php echo esc_html($category->name); ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="fw-bold mb-3 color-dark">
                            <?php the_title(); ?>
                        </h1>

                        <div class="d-flex flex-wrap gap-3 text-muted small mb-4 pb-3 border-bottom pureshop-single-meta">
                            <span class="d-flex align-items-center gap-1">
                                <span class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:28px;height:28px;">
                                    <i class="bi bi-person text-primary" style="font-size:.8rem;"></i>
                                </span>
                                <?php echo esc_html(get_the_author()); ?>
                            </span>

                            <span class="d-flex align-items-center gap-1">
                                <span class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:28px;height:28px;">
                                    <i class="bi bi-calendar3 text-secondary" style="font-size:.8rem;"></i>
                                </span>
                                <?php echo esc_html(get_the_date('d M Y')); ?>
                            </span>

                        </div>

                        <div class="post-content color-white fs-5 lh-lg mb-4">
                            <?php the_content(); ?>
                        </div>

                        <?php $tags = get_the_tags(); ?>
                        <?php if ($tags) : ?>
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="text-muted small fw-semibold align-self-center">
                                    <i class="bi bi-tags me-1"></i>Tagi:
                                </span>

                                <?php foreach ($tags as $tag) : ?>
                    
                                  <span class="badge text-dark border fw-normal px-3 py-2 text-decoration-none rounded-pill">  #<?php echo esc_html($tag->name); ?> </span>
                                  
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between p-3 rounded-3 mb-4 pureshop-single-button">
                            <div>
                                <?php previous_post_link('%link', '<i class="bi bi-arrow-left me-1"></i>Poprzedni'); ?>
                            </div>

                            <div>
                                <?php next_post_link('%link', 'Następny<i class="bi bi-arrow-right ms-1"></i>'); ?>
                            </div>
                        </div>

                    </div>

                </article>

            <?php endwhile; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>