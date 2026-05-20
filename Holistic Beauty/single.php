<?php get_header(); ?>

<main class="container py-5">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div class="row justify-content-center">
      <div class="col-lg-12">

        <article id="post-<?php the_ID(); ?>" <?php post_class('bydlo-main-placeText p-3 card shadow-sm'); ?>>

          <?php if ( has_post_thumbnail() ) : ?>
            <div class="">
              <?php the_post_thumbnail('large', ['class' => 'card-img-top object-fit-cover bydlo-postthumbnail-single-container-img']); ?>
            </div>
          <?php endif; ?>

          <div class="card-body bydlo_single_all">

            <h1 class="card-title mb-3 text-center">
              <?php the_title(); ?>
            </h1>

            <div class="card-text bydlo-single__content">
              <?php the_content(); ?>
            </div>

            <?php wp_link_pages(); ?>

            <div class="mt-4 d-flex gap-2 flex-wrap">
              <a class="holistic-button-single" href="javascript:history.back()">
                ← Powrót
              </a>
              
              <a target="_blank"
                href="https://holisticbeautylidiasyska.booksy.com/a/"
                class="holistic-book-btn ms-auto">
                  
                  <span class="holistic-book-btn-text">
                      Zarezerwuj termin
                  </span>

                  <i class="bi bi-arrow-right-short"></i>
              </a>

            </div>

          </div>

        </article>

      </div>
    </div>

  <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
