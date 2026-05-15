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

let index = 0;

function holistic_karusel_nowosci() {

    const carousel = document.querySelector(".holistic-products-carousel");
    const track = document.getElementById("productsTrack");
    const prev = document.getElementById("productsPrev");
    const next = document.getElementById("productsNext");

    if (!carousel || !track || !prev || !next) return;

    const step = 25.5;
    const maxIndex = 8;

    let autoSlide;

    function updateSlider() {
        track.style.left = `-${index * step}%`;
    }

    function nextSlide() {
        index++;

        if (index > maxIndex) {
            index = 0;
        }

        updateSlider();
    }

    function prevSlide() {
        index--;

        if (index < 0) {
            index = maxIndex;
        }

        updateSlider();
    }

    function startAutoSlide() {
        stopAutoSlide();

        autoSlide = setInterval(() => {
            nextSlide();
        }, 3000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlide);
    }

    next.addEventListener('click', function () {
        nextSlide();
    });

    prev.addEventListener('click', function () {
        prevSlide();
    });

    carousel.addEventListener('mouseenter', function () {
        stopAutoSlide();
    });

    carousel.addEventListener('mouseleave', function () {
        startAutoSlide();
    });

    startAutoSlide();
}