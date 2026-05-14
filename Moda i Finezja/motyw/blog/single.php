<?php get_header(); ?>

<main class="container py-5">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div class="row justify-content-center">
      <div class="col-lg-12">

        <article class="advancedBlog-main-placeText p-3 card shadow-sm text-left m-2" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

          <?php if ( has_post_thumbnail() ) : ?>
            <div class="advancedBlog-single-thumb mb-4">
              <?php the_post_thumbnail( 'large', [
                'class' => 'advancedBlog-single-thumb-img img-fluid',
                'alt'   => get_the_title(),
              ] ); ?>
            </div>
          <?php endif; ?>

          <div class="d-flex justify-content-left gap-2 flex-wrap mb-4">

              <?php
              $categories = get_the_category();
              if ( ! empty( $categories ) ) :
                foreach ( $categories as $category ) :
              ?>
                  <a class="badge rounded-pill text-decoration-none px-3 py-2 border border-light text-dark bg-light"
                     href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                    <?php echo esc_html( $category->name ); ?>
                  </a>
              <?php
                endforeach;
              endif;
              ?>

              <?php
              $tags = get_the_tags();
              if ( ! empty( $tags ) ) :
                foreach ( $tags as $tag ) :
              ?>
                  <span class="badge rounded-pill text-decoration-none px-3 py-2 bg-light text-dark">
                    #<?php echo esc_html( $tag->name ); ?>
                </span>
              <?php
                endforeach;
              endif;
              ?>

            </div>

          <div class="card-body advancedBlog_single_all m-3">

            <h2 class="card-title mb-3 text-left">
              <?php the_title(); ?>
            </h2>

            <div class="card-text advancedBlog-single__content">
              <?php the_content(); ?>
            </div>

            <?php wp_link_pages(); ?>

          </div>

        </article>

        <div class="mt-4 d-flex gap-2 flex-wrap">

          <a class="btn btn-outline-dark"
             href="#"
             onclick="window.history.back(); return false;">
            ← Powrót
          </a>

        </div>

      </div>
    </div>

  <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>