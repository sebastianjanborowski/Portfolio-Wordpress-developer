<?php
/**
 * Header template - Warszawskie Dachy
 */

defined( 'ABSPATH' ) || exit;

$theme_uri = get_template_directory_uri();

$favicon    = $theme_uri . '/assets/img/favicon.png';
$logo       = $theme_uri . '/assets/img/logo.png';
$logo_white = $theme_uri . '/assets/img/logo-white.png';
$hero       = $theme_uri . '/assets/images/hero.webp';

$site_name = get_bloginfo( 'name' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php wp_title( '|', true, 'right' ); ?><?php echo esc_html( $site_name ); ?></title>

	<meta name="description" content="Warszawskie Dachy - profesjonalne usługi dekarskie w Warszawie i okolicach. Dachy, naprawy dachów, obróbki blacharskie, montaż i renowacja pokryć dachowych.">
	<meta name="robots" content="index, follow">

	<meta property="og:title" content="Warszawskie Dachy - usługi dekarskie Warszawa">
	<meta property="og:description" content="Profesjonalne usługi dekarskie w Warszawie i okolicach.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $hero ); ?>">

	<link rel="canonical" href="<?php echo esc_url( home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) ) ); ?>">
	<link rel="icon" href="<?php echo esc_url( $favicon ); ?>" type="image/x-icon">

	<?php wp_head(); ?>
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-17517973592">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-17517973592');
</script>
	
<!-- Event snippet for Kontakt conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-17517973592/Kp4wCOSpl6gbENignKFB',
      'event_callback': callback
  });
  return false;
}
</script>


</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<main class="boxed_wrapper">

<header class="wd-header position-absolute top-0 start-0 w-100 z-3">
	<nav id="dek-nav-marker" class="navbar navbar-expand-lg navbar-dark">
		<div class="container-fluid px-4 px-lg-5">

			<a 
				class="navbar-brand d-flex align-items-center gap-2" 
				href="<?php echo esc_url( home_url( '/' ) ); ?>" 
				aria-label="Warszawskie Dachy - strona główna"
			>

				<picture>
					<img 
						id="dek-logo"
						src="<?php echo get_template_directory_uri() ?>/assets/img/logo-white.png" 
						alt="Warszawskie Dachy" 
						class="img-fluid wd-logo"
						width="180"
						height="60"
					>
				</picture>

			</a>

			<button 
				class="navbar-toggler border-0 shadow-none" 
				type="button" 
				data-bs-toggle="collapse" 
				data-bs-target="#mainNavbar" 
				aria-controls="mainNavbar" 
				aria-expanded="false" 
				aria-label="Otwórz menu"
			>
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse justify-content-end mt-4 mt-lg-0" id="mainNavbar">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main_menu',
						'container'      => false,
						'menu_class'     => 'navbar-nav align-items-lg-center gap-lg-5 ms-auto wd-menu dek-menu-drak-li',
						'fallback_cb'    => false,
						'depth'          => 2,
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					)
				);
				?>
			</div>

		</div>
	</nav>
</header>