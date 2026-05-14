<?php get_header(); ?>

<section class="py-5 pureshop-margin-top">
    <div class="container-fluid pureshop-max-width">
        <?php while (have_posts()) : the_post(); ?>		
            <h1 class="section-title pureshop-colorH1"><?php the_title(); ?></h1>
            <div class="mt-4 color-white"><?php the_content(); ?></div>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>