<?php get_header(); ?>

<main class="beauty-page">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <!-- HERO TITLE -->
    <header class="beauty-page-hero">
      <div class="container">
        <div class="beauty-page-hero__inner">
          <h1 class="beauty-page-title"><?php the_title(); ?>
            <br/>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/produkcja/podkreslnik_title_cut.png" alt="Podkreślnik tytułu podstrony">
          </h1>
        </div>
      </div>
    </header>

    <!-- CONTENT -->
    <section class="beauty-page-content">
      <div class="container">
        <div class="beauty-page-box shadow-sm">
          <div class="page-content">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </section>

  <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
