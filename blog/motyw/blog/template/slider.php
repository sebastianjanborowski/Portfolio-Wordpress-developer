<?php
$theme_uri = get_template_directory_uri();
?>

<section class="fashion-hero-wrap">
  <div class="container">

    <div id="heroCarousel"
         class="carousel slide carousel-fade fashion-hero-slider"
         data-bs-ride="carousel"
         data-bs-interval="4000"
         data-bs-touch="true"
         data-bs-pause="hover">

      <div class="carousel-inner">

        <div class="carousel-item active">
          <div class="fashion-slide">
            <div class="fashion-slide-content">
              <span class="fashion-kicker">MODA & INSPIRACJE</span>
              <h1>Nowy sezon</h1>
              <h2>Nowy styl, nowa Ty</h2>
              <p>Odkryj trendy, elegancję i inspiracje, które podkreślą Twój wyjątkowy styl.</p>
              <a href="category/lifestyle-kobiecy" class="fashion-btn">Czytaj na blogu</a>
            </div>

            <div class="fashion-slide-image">
              <img src="<?php echo esc_url($theme_uri); ?>/assets/img/slide1.png" alt="Moda i styl">
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <div class="fashion-slide">
            <div class="fashion-slide-content">
              <span class="fashion-kicker">TRENDY 2026</span>
              <h1>Styl premium</h1>
              <h2>Elegancja w detalu</h2>
              <p>Minimalizm, klasyka i dodatki, które budują mocny modowy charakter.</p>
              <a href="category/trendy-i-stylizacje" class="fashion-btn">Zobacz trendy</a>
            </div>

            <div class="fashion-slide-image">
              <img src="<?php echo esc_url($theme_uri); ?>/assets/img/slide2.png" alt="Trendy modowe">
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <div class="fashion-slide">
            <div class="fashion-slide-content">
              <span class="fashion-kicker">BEAUTY & LIFESTYLE</span>
              <h1>Moda codzienna</h1>
              <h2>Styl bez przesady</h2>
              <p>Inspiracje do pracy, miasta i wieczornych wyjść — prosto, kobieco, z klasą.</p>
              <a href="category/newsletter-modowy" class="fashion-btn">Sprawdź wpisy</a>
            </div>

            <div class="fashion-slide-image">
              <img src="<?php echo esc_url($theme_uri); ?>/assets/img/slide3.png" alt="Lifestyle modowy">
            </div>
          </div>
        </div>

      </div>

      <button class="carousel-control-prev fashion-arrow" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>

      <button class="carousel-control-next fashion-arrow" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>

    </div>

  </div>
</section>

<div class="advancedBlog-main-placeText shadow">