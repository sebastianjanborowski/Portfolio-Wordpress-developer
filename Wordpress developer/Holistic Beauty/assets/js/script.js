document.addEventListener('DOMContentLoaded', () => {
  holistic_scroll_top();
  licznik();
  galeria();
  holistic_karusel_nowosci();
});

// przewijanie button
function holistic_scroll_top(){
    var activator = document.getElementById("holistic-button-to-top");

    if(!activator) return;

    window.addEventListener('scroll',() => {
        if(window.scrollY > 100){
            activator.style.display = 'block';
        }else{
            activator.style.display = 'none';
        }
    });

    activator.addEventListener('click',() => {
        window.scrollTo({
            top:0,
            behavior:'smooth'
        });
    });
}


// licznik
function licznik(){
    const statCards = document.querySelectorAll('.holistic-stat-card');

  if (!statCards.length) return;

  const animateCounter = (card) => {
    if (card.dataset.animated === 'true') return;

    const numberEl = card.querySelector('.holistic-stat-number');
    const target = parseFloat(card.dataset.target || '0');
    const decimals = parseInt(card.dataset.decimals || '0', 10);
    const suffix = card.dataset.suffix || '';
    const duration = 1800;

    let startTimestamp = null;

    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;

      const progress = Math.min((timestamp - startTimestamp) / duration, 1);

      // lekko płynniejsze wejście
      const eased = 1 - Math.pow(1 - progress, 3);

      const currentValue = target * eased;

      numberEl.textContent = currentValue.toFixed(decimals) + suffix;

      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        numberEl.textContent = target.toFixed(decimals) + suffix;
        card.dataset.animated = 'true';
      }
    };

    window.requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver((entries, observerRef) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observerRef.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.35
  });

  statCards.forEach((card) => observer.observe(card));
}

// obsługuje galerie i slider
function galeria(){
  const container_figuier = document.querySelector(".wp-block-gallery");

  const body = document.getElementById("galleryModal");
  const prev = document.getElementById("galleryPrev");
  const next = document.getElementById("galleryNext");
  const close = document.getElementById("galleryClose");
  const img = document.getElementById("galleryModalImg");

  var indexHelp = 0;

  if(!container_figuier) return;

  const images = container_figuier.querySelectorAll('figure img');

  const galeryImages = [];

  images.forEach((img,index) => {
    img.dataset.index = index;
    img.dataset.src = img.src;

    galeryImages.push(img.src);

    img.addEventListener('click',function () {
      const clickedIndex = Number(this.dataset.index);
      const clickedSrc = this.dataset.src;

      akcja(clickedIndex,clickedSrc,galeryImages);
    });
  });

  function akcja(index,src,tab){
    img.src = src;
    indexHelp = index;
    body.style.display = "block";
  }

  close.addEventListener('click', () => {
    body.style.display = "none";
  });
  
  next.addEventListener('click',() => {
    indexHelp++;
    if(indexHelp >= galeryImages.length) indexHelp = 0;

    img.src = galeryImages[indexHelp];
  });

  prev.addEventListener('click',() => {
    indexHelp--;
    if(indexHelp <= 0) indexHelp = galeryImages.length -1;

    img.src = galeryImages[indexHelp];
  });

}

document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".holistic-products-carousel");
    const track = document.getElementById("productsTrack");
    const prev = document.getElementById("productsPrev");
    const next = document.getElementById("productsNext");

    if (!carousel || !track || !prev || !next) return;

    let index = 0;
    let autoSlide = null;
    let startX = 0;

    function getVisibleItems() {
        if (window.innerWidth > 991) return 4;
        if (window.innerWidth > 600) return 2;
        return 1;
    }

    function getMaxIndex() {
        const visible = getVisibleItems();
        const total = track.children.length;
        return Math.max(total - visible, 0);
    }

    function updateSlider() {
        const visible = getVisibleItems();
        const maxIndex = getMaxIndex();

        if (index > maxIndex) index = maxIndex;
        if (index < 0) index = 0;

        const move = index * (100 / visible);

        track.style.transform = "translate3d(-" + move + "%, 0, 0)";
    }

    function nextSlide() {
        const maxIndex = getMaxIndex();

        index++;

        if (index > maxIndex) {
            index = 0;
        }

        updateSlider();
    }

    function prevSlide() {
        const maxIndex = getMaxIndex();

        index--;

        if (index < 0) {
            index = maxIndex;
        }

        updateSlider();
    }

    function stopAuto() {
        if (autoSlide) {
            clearInterval(autoSlide);
            autoSlide = null;
        }
    }

    function startAuto() {
        stopAuto();

        autoSlide = setInterval(function () {
            nextSlide();
        }, 3000);
    }

    next.addEventListener("click", function () {
        stopAuto();
        nextSlide();
        startAuto();
    });

    prev.addEventListener("click", function () {
        stopAuto();
        prevSlide();
        startAuto();
    });

    carousel.addEventListener("mouseenter", stopAuto);
    carousel.addEventListener("mouseleave", startAuto);

    carousel.addEventListener("touchstart", function (e) {
        startX = e.touches[0].clientX;
        stopAuto();
    }, { passive: true });

    carousel.addEventListener("touchend", function (e) {
        const endX = e.changedTouches[0].clientX;
        const distance = startX - endX;

        if (distance > 50) nextSlide();
        if (distance < -50) prevSlide();

        startAuto();
    }, { passive: true });

    window.addEventListener("resize", function () {
        updateSlider();
    });

    updateSlider();
    startAuto();
});

function holistic_karusel_nowosci() {
    const carousels = {
        products: {
            carousel: document.querySelector(".holistic-products-carousel"),
            track: document.getElementById("productsTrack"),
            prev: document.getElementById("productsPrev"),
            next: document.getElementById("productsNext"),
            index: 0,
            autoSlide: null,
            startX: 0,
            endX: 0,

            desktop: { step: 25, maxIndex: 8, marginStep: 0, moveItems: 1 },
            tablet: { step: 50, maxIndex: 10, marginStep: 0, moveItems: 1 },
            mobile: { step: 100, maxIndex: 11, marginStep: 0, moveItems: 1 }
        },

        googleReviews: {
            carousel: document.querySelector(".holistic-google-reviews-carousel"),
            track: document.getElementById("holisticGoogleReviewsTrack"),
            prev: document.getElementById("holistic-prev-google-reviews"),
            next: document.getElementById("holistic-next-google-reviews"),
            index: 0,
            autoSlide: null,
            startX: 0,
            endX: 0,

            desktop: { step: 33.333, maxIndex: 15, marginStep: 8, moveItems: 1 },
            tablet: { step: 50, maxIndex: 15, marginStep: 12, moveItems: 1 },
            mobile: { step: 100, maxIndex: 15, marginStep: 24, moveItems: 1 }
        }
    };

    function getCurrentConfig(item) {
        if (window.innerWidth > 991) return item.desktop;
        if (window.innerWidth > 600) return item.tablet;
        return item.mobile;
    }

    function updateSlider(item) {
        if (!item.track) return;

        const config = getCurrentConfig(item);

        if (item.index > config.maxIndex) item.index = config.maxIndex;
        if (item.index < 0) item.index = 0;

        const movePercent = item.index * config.step;
        const movePixels = item.index * config.marginStep;

        item.track.style.transform = `translate3d(calc(-${movePercent}% - ${movePixels}px), 0, 0)`;
    }

    function nextSlide(item) {
        const config = getCurrentConfig(item);

        item.index += config.moveItems;

        if (item.index > config.maxIndex) {
            item.index = 0;
        }

        updateSlider(item);
    }

    function prevSlide(item) {
        const config = getCurrentConfig(item);

        item.index -= config.moveItems;

        if (item.index < 0) {
            item.index = config.maxIndex;
        }

        updateSlider(item);
    }

    function stopAutoSlide(item) {
        if (item.autoSlide) {
            clearInterval(item.autoSlide);
            item.autoSlide = null;
        }
    }

    function startAutoSlide(item) {
        stopAutoSlide(item);

        item.autoSlide = setInterval(function () {
            nextSlide(item);
        }, 3000);
    }

    function initCarousel(item) {
        if (!item.carousel || !item.track || !item.prev || !item.next) return;

        item.track.style.left = "auto";
        item.track.style.transform = "translate3d(0, 0, 0)";
        item.track.style.willChange = "transform";

        item.next.addEventListener("click", function () {
            stopAutoSlide(item);
            nextSlide(item);
            startAutoSlide(item);
        });

        item.prev.addEventListener("click", function () {
            stopAutoSlide(item);
            prevSlide(item);
            startAutoSlide(item);
        });

        item.carousel.addEventListener("mouseenter", function () {
            stopAutoSlide(item);
        });

        item.carousel.addEventListener("mouseleave", function () {
            startAutoSlide(item);
        });

        item.carousel.addEventListener("touchstart", function (e) {
            item.startX = e.touches[0].clientX;
            stopAutoSlide(item);
        }, { passive: true });

        item.carousel.addEventListener("touchend", function (e) {
            item.endX = e.changedTouches[0].clientX;

            const distance = item.startX - item.endX;

            if (distance > 50) nextSlide(item);
            if (distance < -50) prevSlide(item);

            startAutoSlide(item);
        }, { passive: true });

        updateSlider(item);
        startAutoSlide(item);
    }

    let resizeTimer = null;

    window.addEventListener("resize", function () {
        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(function () {
            updateSlider(carousels.products);
            updateSlider(carousels.googleReviews);
        }, 150);
    });

    initCarousel(carousels.products);
    initCarousel(carousels.googleReviews);
}

document.addEventListener("DOMContentLoaded", holistic_karusel_nowosci);