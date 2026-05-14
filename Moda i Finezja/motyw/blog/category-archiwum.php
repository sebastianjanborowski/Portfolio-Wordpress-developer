<?php get_header(); ?>

<main class="container py-4">

  <h1 class="mb-4 advancedBlog_wcag_light_color">Archiwum</h1>

  <?php if ( have_posts() ) : ?>
    <div class="row g-4">

      <?php while ( have_posts() ) : the_post(); ?>
        <div class="col-12 col-md-6 col-lg-4">

          <article class="card h-100 shadow-sm advancedBlog_dark_bgc_light_content advancedBlog_archive_resize">

            <?php if ( has_post_thumbnail() ) : ?>
              <a href="<?php the_permalink(); ?>" class="d-block">
                <?php the_post_thumbnail('large', ['class' => 'card-img-top img-fluid advancedBlog-archive-thubbnail']); ?>
              </a>
            <?php endif; ?>

            <div class="card-body d-flex flex-column advancedBlog_archive_secret blog-category-marker-zajawka">

              <h5 class="card-title advancedBlog_wcag_light_color">
                <a class="text-decoration-none text-dark" href="<?php the_permalink(); ?>">
                  <?php echo esc_html(wp_trim_words(get_the_title(),4,'...')); ?>
                </a>
              </h5>

              <p class="card-text mb-4">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), 4, '...' ) ); ?>
              </p>

              <a class="btn btn-outline-dark mt-auto" href="<?php the_permalink(); ?>">
                Pokaż więcej
              </a>

            </div>

          </article>

        </div>
      <?php endwhile; ?>

    </div>

    <div class="mt-4">
      <?php the_posts_pagination([
        'mid_size'  => 2,
        'prev_text' => '← Poprzednie',
        'next_text' => 'Następne →',
      ]); ?>
    </div>

  <?php else : ?>
    <p>Brak wpisów.</p>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
