<?php
/**
 * Template Name: Archiwum (Województwa) – filtry kategorii + paginacja
 */

defined('ABSPATH') || exit;

get_header();

$message = '';

/* ================= FORMULARZ DODAWANIA WPISU ================= */

if (is_user_logged_in() && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post_nonce'])) {

  if (!wp_verify_nonce($_POST['add_post_nonce'], 'add_post_action')) {

    $message = '<div class="alert alert-danger mb-4">Błąd bezpieczeństwa formularza.</div>';

  } else {

    $title   = sanitize_text_field($_POST['post_title'] ?? '');
    $content = wp_kses_post($_POST['post_content'] ?? '');
    $cat_id  = intval($_POST['post_category'] ?? 0);

    $selected_tags = isset($_POST['post_tags'])
      ? array_map('intval', (array) $_POST['post_tags'])
      : [];

    $new_tags_raw = sanitize_text_field($_POST['new_tags'] ?? '');

    if ($title && $content && $cat_id) {

      $post_id = wp_insert_post([
        'post_title'    => $title,
        'post_content'  => $content,
        'post_status'   => 'pending',
        'post_author'   => get_current_user_id(),
        'post_category' => [$cat_id],
        'post_type'     => 'post',
      ]);

      if (!is_wp_error($post_id)) {

        if (!empty($selected_tags)) {
          wp_set_post_terms($post_id, $selected_tags, 'post_tag', false);
        }

        if (!empty($new_tags_raw)) {

          $new_tags = array_map('trim', explode(',', $new_tags_raw));
          $new_tags = array_filter($new_tags);

          foreach ($new_tags as $tag_name) {
            if (!term_exists($tag_name, 'post_tag')) {
              wp_insert_term($tag_name, 'post_tag');
            }
          }

          wp_set_post_terms($post_id, $new_tags, 'post_tag', true);
        }

        if (!empty($_FILES['post_image']['name'])) {

          require_once ABSPATH . 'wp-admin/includes/image.php';
          require_once ABSPATH . 'wp-admin/includes/file.php';
          require_once ABSPATH . 'wp-admin/includes/media.php';

          $attachment_id = media_handle_upload('post_image', $post_id);

          if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
          }
        }

        $message = '<div class="alert alert-success mb-4">Wpis został dodany i czeka na akceptację.</div>';

      } else {

        $message = '<div class="alert alert-danger mb-4">Nie udało się dodać wpisu.</div>';
      }

    } else {

      $message = '<div class="alert alert-danger mb-4">Uzupełnij tytuł, kategorię i treść wpisu.</div>';
    }
  }
}


/* ================= FILTRY ARCHIWUM ================= */

$raw_tag = '';
$raw_category = '';

if (isset($_GET['category_name'])) {
  $raw_category = wp_unslash($_GET['category_name']);
  if (is_array($raw_category)) $raw_category = reset($raw_category);
  $raw_category = trim((string) $raw_category);
}

$current_category = $raw_category ? sanitize_title($raw_category) : '';
$category_obj = $current_category ? get_term_by('slug', $current_category, 'category') : null;
$invalid_category = ($current_category !== '' && (!$category_obj || is_wp_error($category_obj)));

if (isset($_GET['tag'])) {
  $raw_tag = wp_unslash($_GET['tag']);
  if (is_array($raw_tag)) $raw_tag = reset($raw_tag);
  $raw_tag = trim((string) $raw_tag);
}

$current_tag = $raw_tag ? sanitize_title($raw_tag) : '';
$tag_obj = $current_tag ? get_term_by('slug', $current_tag, 'post_tag') : null;
$invalid_tag = ($current_tag !== '' && (!$tag_obj || is_wp_error($tag_obj)));

$posts_per_page = 9;

$paged = (int) get_query_var('paged');
if ($paged < 1) $paged = (int) get_query_var('page');
if ($paged < 1) $paged = 1;

$current_cat = isset($_GET['cat']) ? (int) $_GET['cat'] : 0;

$voivodeships = [
  'dodatki-i-akcesoria' => 'Dodatki i Akcesoria',
  'lifestyle-kobiecy'   => 'Lifestyle Kobiecy',
  'moda-premium'        => 'Moda Premium',
  'newsletter'          => 'Newsletter',
  'lodzkie'             => 'Łódzkie',
  'trendy-i-stylizacje' => 'Trendy i Stylizacje',
  'uroda-i-beauty'      => 'Uroda i Beauty',
];

$cats = [];

foreach ($voivodeships as $slug => $label) {
  $term = get_category_by_slug($slug);

  if ($term && !is_wp_error($term)) {
    $cats[] = [
      'id'   => (int) $term->term_id,
      'slug' => $slug,
      'name' => $label,
    ];
  }
}

$voivodeship_cat_ids = array_values(array_unique(array_map(function ($c) {
  return (int) $c['id'];
}, $cats)));

$base_url = get_permalink();

if ($current_cat > 0 && !in_array($current_cat, $voivodeship_cat_ids, true)) {
  $current_cat = 0;
}

$args = [
  'post_type'           => 'post',
  'post_status'         => 'publish',
  'posts_per_page'      => $posts_per_page,
  'paged'               => $paged,
  'ignore_sticky_posts' => true,
];

if ($invalid_category) {
  $args['post__in'] = [0];
} elseif ($current_category !== '') {
  $args['category_name'] = $current_category;
} elseif ($current_cat > 0) {
  $args['cat'] = $current_cat;
} else {
  $args['category__in'] = $voivodeship_cat_ids ?: [-1];
}

if ($invalid_tag) {
  $args['post__in'] = [0];
} elseif ($current_tag !== '') {
  $args['tax_query'] = [
    [
      'taxonomy' => 'post_tag',
      'field'    => 'slug',
      'terms'    => $current_tag,
    ]
  ];
}

$tags = get_terms([
  'taxonomy'   => 'post_tag',
  'hide_empty' => true,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

$form_categories = get_categories([
  'hide_empty' => false,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

$form_tags = get_terms([
  'taxonomy'   => 'post_tag',
  'hide_empty' => false,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

$q = new WP_Query($args);

?>

<main class="container py-4">

  <div class="advancedBlog_hide_form" id="advancedBlog-ogloszenia-popup">

    <div id="advancedBlog-ogloszenia-close" role="button" tabindex="0" aria-label="Zamknij">
      X
    </div>

    <div class="container">

      <div class="row justify-content-center">
        <div class="col-12">

          <div class="card border-0 shadow-lg overflow-hidden bg-white">

            <div class="card-header bg-dark text-white p-4">
              <h3 class="mb-1">Dodaj wpis</h3>
              <p class="mb-0 text-white-50">
                Wybierz kategorię, tagi, dodaj treść oraz grafikę wpisu.
              </p>
            </div>

            <div class="card-body p-3">

              <?php if (!is_user_logged_in()) : ?>

                <div class="alert alert-warning mb-0">
                  Musisz być zalogowany, aby dodać wpis.
                </div>

              <?php else : ?>

                <form method="post" enctype="multipart/form-data" class="row g-4">

                  <?php wp_nonce_field('add_post_action', 'add_post_nonce'); ?>

                  <div class="col-12">
                    <label class="form-label fw-semibold">
                      Tytuł wpisu
                    </label>
                    <input
                      type="text"
                      name="post_title"
                      class="form-control form-control-lg"
                      placeholder="Wpisz tytuł wpisu"
                      required
                    >
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-semibold">
                      Kategoria
                    </label>

                    <select name="post_category" class="form-select form-select-lg" required>
                      <option value="">Wybierz kategorię</option>

                      <?php foreach ($form_categories as $category) : ?>
                        <option value="<?php echo esc_attr($category->term_id); ?>">
                          <?php echo esc_html($category->name); ?>
                        </option>
                      <?php endforeach; ?>

                    </select>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-semibold">
                      Istniejące tagi
                    </label>

                    <select name="post_tags[]" class="form-select" multiple size="6">
                      <?php foreach ($form_tags as $tag) : ?>
                        <option value="<?php echo esc_attr($tag->term_id); ?>">
                          <?php echo esc_html($tag->name); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>

                    <div class="form-text">
                      Przytrzymaj CTRL, aby zaznaczyć kilka tagów.
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-semibold">
                      Nowe tagi
                    </label>

                    <input
                      type="text"
                      name="new_tags"
                      class="form-control"
                      placeholder="np. moda, uroda, lifestyle"
                    >

                    <div class="form-text">
                      Nowe tagi oddziel przecinkami. Jeśli tag nie istnieje, WordPress go utworzy.
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-semibold">
                      Treść wpisu
                    </label>

                    <textarea
                      name="post_content"
                      class="form-control"
                      rows="8"
                      placeholder="Wpisz treść wpisu"
                      required
                    ></textarea>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-semibold">
                      Grafika wpisu
                    </label>

                    <input
                      type="file"
                      name="post_image"
                      class="form-control"
                      accept="image/*"
                    >

                    <div class="form-text">
                      Grafika zostanie ustawiona jako obrazek wyróżniający wpisu.
                    </div>
                  </div>

                  <div class="col-12 d-grid">
                    <button type="submit" class="btn btn-dark btn-lg">
                      Dodaj wpis
                    </button>
                  </div>

                </form>

              <?php endif; ?>

            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
  
  <div class="advancedBlog-ogloszenia-popup">
      <?php echo $message; ?>
  </div>                      
  

  <h1 class="mb-4 advancedBlog_wcag_light_color">
    <?php the_title(); ?>
  </h1>

  <div class="row g-4 mb-4">

    <div class="col-lg-4">
      <div id="advancedBlog-dodaj-ogloszenie" class="advancedBlog-ogloszenia-add">
        Dodaj blog
      </div>
    </div>

    <div class="col-lg-4">
      <div class="advancedBlog-shortContainer-ogloszenia-wojewodztwa">
        <?php $all_active = ($current_cat === 0) ? 'active' : ''; ?>

        <h3>Szukaj według kategorii</h3>

        <ul>
          <li>
            <a class="btn <?php echo esc_attr($all_active); ?>" href="<?php echo esc_url($base_url); ?>">
              Wszystkie
            </a>
          </li>

          <?php foreach ($cats as $cat) :
            $is_active = ($current_cat === (int) $cat['id']) ? 'active' : '';
            $url = add_query_arg(['cat' => (int) $cat['id']], $base_url);
          ?>
            <li>
              <a class="btn <?php echo esc_attr($is_active); ?>" href="<?php echo esc_url($url); ?>">
                <?php echo esc_html($cat['name']); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>

      </div>
    </div>

    <div class="col-lg-4">
      <div class="advancedBlog-shortContainer-ogloszenia-wojewodztwa">
        <?php $tag_all_active = ($current_tag === '') ? 'active' : ''; ?>

        <h3>Szukaj według tagu</h3>

        <ul>
          <li>
            <a
              class="btn <?php echo esc_attr($tag_all_active); ?>"
              href="<?php echo esc_url($current_cat ? add_query_arg(['cat' => $current_cat], $base_url) : $base_url); ?>"
            >
              Wszystkie
            </a>
          </li>

          <?php foreach ($tags as $t) :
            $is_active = ($current_tag === $t->slug) ? 'active' : '';

            $url = add_query_arg(
              array_filter([
                'cat' => $current_cat ?: null,
                'tag' => $t->slug,
              ]),
              $base_url
            );
          ?>
            <li>
              <a class="btn <?php echo esc_attr($is_active); ?>" href="<?php echo esc_url($url); ?>">
                <?php echo esc_html($t->name); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>

      </div>
    </div>

  </div>

  <?php if ($q->have_posts()) : ?>

    <div class="row g-4">

      <?php while ($q->have_posts()) : $q->the_post(); ?>

        <div class="col-12 col-md-6 col-lg-4">

          <article class="card h-100 shadow-sm advancedBlog_dark_bgc_light_content">

            <?php if (has_post_thumbnail()) : ?>

              <a href="<?php the_permalink(); ?>" class="d-block advancedBlog-archive-ogloszenia">
                <?php the_post_thumbnail('large', [
                  'class' => 'card-img-top img-fluid advancedBlog-archive-thubbnail',
                  'alt'   => get_the_title(),
                ]); ?>
              </a>

            <?php else : ?>

              <a href="<?php the_permalink(); ?>" class="d-block advancedBlog-archive-ogloszenia">
                <img
                  class="card-img-top img-fluid advancedBlog-archive-thubbnail wp-post-image"
                  src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/placeholder_advancedBlog.png'); ?>"
                  alt="<?php echo esc_attr(get_the_title()); ?>"
                >
              </a>

            <?php endif; ?>

            <div class="card-body d-flex flex-column">

              <h5 class="card-title advancedBlog-category-title advancedBlog_wcag_light_color">
                <a class="text-decoration-none" href="<?php the_permalink(); ?>">
                  <?php the_title(); ?>
                </a>
              </h5>

              <p class="card-text mb-4 advancedBlog-category-title">
                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 5, '...')); ?>
              </p>

              <a class="btn btn-outline-dark mt-auto advancedBlog-ogloszenia-button" href="<?php the_permalink(); ?>">
                Czytaj
              </a>

            </div>

          </article>

        </div>

      <?php endwhile; ?>

    </div>

    <div class="mt-4 advancedBlog-pagination-wrap">
      <?php
        echo paginate_links([
          'total'     => (int) $q->max_num_pages,
          'current'   => $paged,
          'mid_size'  => 2,
          'prev_text' => '← Poprzednie',
          'next_text' => 'Następne →',
          'type'      => 'list',
          'add_args'  => array_filter([
            'cat' => $current_cat ?: null,
            'tag' => $current_tag ?: null,
          ]),
        ]);
      ?>
    </div>

  <?php else : ?>

    <div class="alert alert-info">
      Brak wpisów.
    </div>

  <?php endif; ?>

</main>

<?php
wp_reset_postdata();
get_footer();