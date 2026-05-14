<!-- =========================================================
         Life style kobiecy
=========================================================-->
<section id="lifestylekobiecy" class="py-5 advancedBlog_marker_section">
    <div class="container">
        
    <a class="advancedBlog_permalink_to_archive" href="/category/lifestyle-kobiecy/">
      <h2 class="text-center fw-bold mb-4 advancedBlog_naglowek_h2 advancedBlog_marker_naglowki">Lifestyle kobiecy</h2>
    </a>

      <?php
$lifestylebobiecy = new WP_Query([
  'post_type'           => 'post',
  'posts_per_page'      => 4,              // zmień ile chcesz
  'category_name'       => 'lifestyle-kobiecy',  // slug kategorii
  'post_status'         => 'publish',
  'ignore_sticky_posts' => true,
]);

if ( $lifestylebobiecy->have_posts() ) :
  $i = 0;
?>
    <div class="row">
<?php
  while ( $lifestylebobiecy->have_posts() ) : $lifestylebobiecy->the_post();
    $i++;

    $title_zajawka = get_the_title();

    $ex = get_the_excerpt();
    if ( empty($ex) ) {
      $ex = wp_strip_all_tags( get_the_content() );
    }

    $p1 = wp_html_excerpt( wp_strip_all_tags($ex), 50,'...');

    $title_zajawka = wp_html_excerpt( wp_strip_all_tags($title_zajawka), 29,'...'); 
?>
  <div class="col-lg-6 advancedBlog-margines-top">
    <div class="card border-0 news-card">

      <div class="ratio ratio-4x3 news-img advancedBlog_atualnosci_single_item">
        <?php if ( has_post_thumbnail() ) : ?>
          <a href="<?php the_permalink(); ?>" class="d-block w-100 h-100">
            <?php the_post_thumbnail('large', [
              'class' => 'w-100 h-100 object-fit-cover',
              'alt'   => esc_attr( get_the_title() ),
            ]); ?>
          </a>
        <?php endif; ?>

      </div>

      <div class="advancedBlog_atualnosci_single_item">
        <div class="px-1 px-lg-2">
          <div class="fw-bold mb-2 advancedBlog_naglowek_h2 advancedBlog_marker_wcag_title_and_content advancedBlog_marker_naglowki"><?php echo $title_zajawka; ?></div>

          <p class="mb-2 advancedBlog_marker_wcag_title_and_content">
            <?php echo esc_html($p1); ?>
          </p>

          <div class="border-top my-3"></div>
          
        </div>
        <div class="d-flex mt-4 advancedBlog_post_show_more">
            <a href="<?php the_permalink(); ?>" class="btn btn-brand px-5 text-white">Zobacz więcej</a>
          </div>
      </div>

    </div>
  </div>
  

  <?php if ( $i === 1 ) : ?>
    <span class="advancedBlog-odstep-section advancedBlog-aktualnosci-mobile"></span>
  <?php endif; ?>

<?php
  endwhile;
  wp_reset_postdata();
endif;
?>
    </div>
</section>