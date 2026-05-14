document.addEventListener('DOMContentLoaded', function () {
    pureshopScrollUp();
    pureshopShowSearch();
    pureshopMoveHeaderElements();
    pureshopMobileMenu();
    pureshopPopup();
    pureshopThemeSwitch();
    pureshopUserMenu();
    pureshopFavorites();
    pureshopInitCarousels();
});

/* ================================
   SCROLL TO TOP
================================ */

function pureshopScrollUp() {
    const btn = document.getElementById('pureshopScrollTop');

    if (!btn) return;

    function toggleButton() {
        const isScrolled = window.scrollY > 300;
        const isBottom =
            window.innerHeight + window.scrollY >=
            document.documentElement.scrollHeight - 80;

        btn.style.display = isScrolled && !isBottom ? 'flex' : 'none';
    }

    btn.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });

    toggleButton();
    window.addEventListener('scroll', toggleButton);
    window.addEventListener('resize', toggleButton);
}

/* ================================
   HEADER SEARCH
================================ */

function pureshopShowSearch() {
    const searchBox = document.getElementById('pureshop-header-container-search-ID');
    const searchBtn = document.getElementById('pureshop_header_activator_search');

    if (!searchBox || !searchBtn) return;

    searchBtn.addEventListener('click', function () {
        searchBox.classList.toggle('pureshop-header-container-search');
    });
}

/* ================================
   MOVE HEADER ELEMENTS MOBILE/DESKTOP
================================ */

function pureshopMoveHeaderElements() {
    const searchBox = document.getElementById('pureshop-header-container-search-ID');
    const mobileContainer = document.getElementById('mainMenu');
    const desktopContainer = document.getElementById('pure_shop_container_desktop');
    const clientMenu = document.getElementById('pureshop_header_mobile_client_menu');

    if (!searchBox || !mobileContainer || !desktopContainer || !clientMenu) return;

    function moveElements() {
        const target = window.innerWidth <= 991 ? mobileContainer : desktopContainer;

        target.appendChild(searchBox);
        target.appendChild(clientMenu);
    }

    moveElements();
    window.addEventListener('resize', moveElements);
}

/* ================================
   MOBILE MENU
================================ */

function pureshopMobileMenu() {
    if (window.innerWidth > 991) return;

    const items = document.querySelectorAll('#menu-menu-glowne li.menu-item-has-children');

    items.forEach(function (item) {
        const link = item.querySelector(':scope > a');

        if (!link || item.dataset.mobileMenuReady === '1') return;

        item.dataset.mobileMenuReady = '1';
        item.classList.add('noopen');

        link.addEventListener('click', function (e) {
            e.preventDefault();
            item.classList.toggle('noopen');
        });
    });
}

/* ================================
   THEME SWITCH
================================ */
function pureshopThemeSwitch() {
    const toggle = document.getElementById('themeToggle');
    const cssHref = '/wp-content/themes/sklep/assets/css/dark_style.css';
    const cssId = 'dark-css';
    const storageKey = 'pureshop_theme';

    function addDarkCss() {
        if (document.getElementById(cssId)) return;

        const darkCssLink = document.createElement('link');
        darkCssLink.id = cssId;
        darkCssLink.rel = 'stylesheet';
        darkCssLink.href = cssHref;

        document.head.appendChild(darkCssLink);
        document.body.classList.add('dark-mode');
    }

    function removeDarkCss() {
        const existingLink = document.getElementById(cssId);

        if (existingLink) {
            existingLink.remove();
        }

        document.body.classList.remove('dark-mode');
    }

    if (localStorage.getItem(storageKey) === 'dark') {
        addDarkCss();
    }

    if (!toggle) return;

    toggle.addEventListener('click', function () {
        const isDark = document.getElementById(cssId);

        if (isDark) {
            removeDarkCss();
            localStorage.setItem(storageKey, 'light');
        } else {
            addDarkCss();
            localStorage.setItem(storageKey, 'dark');
        }
    });
}
/* ================================
   USER MENU
================================ */

function pureshopUserMenu() {
    const userToggle = document.getElementById('userMenuToggle');

    if (!userToggle || !userToggle.parentElement) return;

    const userControl = userToggle.parentElement;

    userToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        userControl.classList.toggle('active');
    });

    document.addEventListener('click', function (e) {
        if (!userControl.contains(e.target)) {
            userControl.classList.remove('active');
        }
    });
}

/* ================================
   PRODUCT CAROUSELS
================================ */

function pureshopGetCarouselSettings() {
    const width = window.innerWidth;

    if (width <= 350) {
        return { step: 107.8, maxMoves: 11, isMobile: true };
    }

    if (width <= 400) {
        return { step: 106.8, maxMoves: 11, isMobile: true };
    }

    if (width <= 600) {
        return { step: 106, maxMoves: 11, isMobile: true };
    }

    if (width <= 770) {
        return { step: 53.8, maxMoves: 10, isMobile: true };
    }

    if (width <= 1100) {
        return { step: 35.2, maxMoves: 9, isMobile: true };
    }

    if (width <= 1301) {
        return { step: 26.2, maxMoves: 8, isMobile: true };
    }

    if (width <= 1780) {
        return { step: 25.7, maxMoves: 8, isMobile: false };
    }

    return { step: 17, maxMoves: 5, isMobile: false };
}

function pureshopInitCarousels() {
    const settings = pureshopGetCarouselSettings();

    const carousels = [
        {
            trackId: 'customCatTrackNowosci',
            prevId: 'customCatPrevNowosci',
            nextId: 'customCatNextNowosci',
        },
        {
            trackId: 'customCatTrackDekoracje',
            prevId: 'customCatPrevDekoracje',
            nextId: 'customCatNextDekoracje',
        },
        {
            trackId: 'customCatTrackdruk-3d-na-zamowienie',
            prevId: 'customCatPrevdruk-3d-na-zamowienie',
            nextId: 'customCatNextdruk-3d-na-zamowienie',
        },
    ];

    carousels.forEach(function (carousel) {
        pureshopInitCarousel({
            ...carousel,
            step: settings.step,
            maxMoves: settings.maxMoves,
            intervalTime: 3000,
            isMobile: settings.isMobile,
        });
    });
}

function pureshopInitCarousel(config) {
    const track = document.getElementById(config.trackId);
    const prev = document.getElementById(config.prevId);
    const next = document.getElementById(config.nextId);

    if (!track) return;

    let index = 0;
    let interval = null;
    let startX = 0;
    let deltaX = 0;
    let isDragging = false;

    function render(withTransition = true) {
        track.style.transition = withTransition ? 'transform 0.4s ease' : 'none';
        track.style.transform = `translateX(${-index * config.step}%)`;
    }

    function nextSlide() {
        index = index >= config.maxMoves ? 0 : index + 1;
        render(true);
    }

    function prevSlide() {
        index = index <= 0 ? config.maxMoves : index - 1;
        render(true);
    }

    function startAutoplay() {
        if (interval) return;

        interval = setInterval(nextSlide, config.intervalTime);
    }

    function stopAutoplay() {
        clearInterval(interval);
        interval = null;
    }

    if (prev) {
        prev.addEventListener('click', function () {
            stopAutoplay();
            prevSlide();
            startAutoplay();
        });
    }

    if (next) {
        next.addEventListener('click', function () {
            stopAutoplay();
            nextSlide();
            startAutoplay();
        });
    }

    if (!config.isMobile) {
        track.addEventListener('mouseenter', stopAutoplay);
        track.addEventListener('mouseleave', startAutoplay);
    }

    if (config.isMobile) {
        track.addEventListener(
            'touchstart',
            function (e) {
                isDragging = true;
                startX = e.touches[0].clientX;
                deltaX = 0;

                stopAutoplay();
                track.style.transition = 'none';
            },
            { passive: true }
        );

        track.addEventListener(
            'touchmove',
            function (e) {
                if (!isDragging) return;
                deltaX = e.touches[0].clientX - startX;
            },
            { passive: true }
        );

        track.addEventListener('touchend', function () {
            if (!isDragging) return;

            isDragging = false;

            if (deltaX < -40) {
                nextSlide();
            } else if (deltaX > 40) {
                prevSlide();
            } else {
                render(true);
            }

            startAutoplay();
        });

        track.addEventListener('touchcancel', function () {
            isDragging = false;
            render(true);
            startAutoplay();
        });
    }

    render(true);
    startAutoplay();
}

/* ================================
   NEWSLETTER POPUP
================================ */

function pureshopPopup() {
    const activator = document.getElementById('pureshop-newsletter-activator');
    const close = document.getElementById('pureshop_popup_close');
    const container = document.getElementById('pureshop_popup');

    if (!activator || !close || !container) return;

    activator.addEventListener('click', function () {
        setTimeout(function () {
            container.classList.remove('pureshop_non_visibility');
        }, 50);
    });

    close.addEventListener('click', function () {
        setTimeout(function () {
            container.classList.add('pureshop_non_visibility');
        }, 50);
    });
}

/* ================================
   FAVORITES
================================ */

function pureshopFavorites() {
    const key = 'pureshop_favorites';

    function getFavs() {
        try {
            return JSON.parse(localStorage.getItem(key) || '[]').map(String);
        } catch (e) {
            return [];
        }
    }

    function setFavs(favs) {
        localStorage.setItem(key, JSON.stringify([...new Set(favs.map(String))]));
    }

    function renderBtn(btn, isActive) {
        btn.classList.toggle('active', isActive);
        btn.textContent = isActive ? '♥' : '♡';
        btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
    }

    document.querySelectorAll('.pureshop-fav-btn').forEach(function (btn) {
        const id = String(btn.dataset.productId || '');

        if (!id) return;

        renderBtn(btn, getFavs().includes(id));

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            let favs = getFavs();
            const isActive = favs.includes(id);

            if (isActive) {
                favs = favs.filter(function (item) {
                    return item !== id;
                });
            } else {
                favs.push(id);
            }

            setFavs(favs);
            renderBtn(btn, !isActive);
        });
    });
}