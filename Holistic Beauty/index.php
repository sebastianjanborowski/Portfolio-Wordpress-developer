<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <div class="container bydlo-main-placeText">
    <div class="col-lg-12">
      <h2 class="text-center my-5"><?php the_title(); ?></h2>

      <div class="page-content bydlo-page-p">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
