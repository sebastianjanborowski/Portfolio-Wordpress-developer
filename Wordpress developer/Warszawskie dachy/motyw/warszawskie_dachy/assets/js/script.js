document.addEventListener('DOMContentLoaded',() => {
    dek_menu_add_bg();
    dek_replace_logo();
    dek_find_special_li_menu();
    dek_gallery_lightbox_slider();
});

function dek_gallery_lightbox_slider(){
	const galleryImages = document.querySelectorAll('.gallery-content img') || "";
	const lightbox = document.getElementById('galleryLightbox') || "";
	const lightboxImage = document.getElementById('galleryLightboxImage') || "";
	const lightboxClose = document.getElementById('galleryLightboxClose') || "";
	const lightboxPrev = document.getElementById('galleryLightboxPrev') || "";
	const lightboxNext = document.getElementById('galleryLightboxNext') || "";
	const galleryCounter = document.getElementById('galleryCounter') || "";

	let imagesArray = [];
	let currentIndex = 0;

	if(galleryImages.length > 0 && lightbox !== "" && lightboxImage !== ""){

		galleryImages.forEach((img,index) => {
			const parentLink = img.closest('a');
			const imageSrc = parentLink ? parentLink.href : img.src;
			const imageAlt = img.alt || 'Zdjęcie z galerii';

			imagesArray.push({
				src: imageSrc,
				alt: imageAlt
			});

			img.setAttribute('data-gallery-index',index);
			img.style.cursor = 'pointer';

			img.addEventListener('click',(e) => {
				e.preventDefault();

				currentIndex = Number(img.getAttribute('data-gallery-index'));
				dek_open_gallery_image();
			});
		});

		function dek_open_gallery_image(){
			lightboxImage.src = imagesArray[currentIndex].src;
			lightboxImage.alt = imagesArray[currentIndex].alt;

			lightbox.classList.add('active');
			document.body.style.overflow = 'hidden';

			dek_update_gallery_counter();
		}

		function dek_close_gallery_image(){
			lightbox.classList.remove('active');
			lightboxImage.src = '';
			lightboxImage.alt = '';
			document.body.style.overflow = '';
		}

		function dek_next_gallery_image(){
			currentIndex++;

			if(currentIndex >= imagesArray.length){
				currentIndex = 0;
			}

			dek_open_gallery_image();
		}

		function dek_prev_gallery_image(){
			currentIndex--;

			if(currentIndex < 0){
				currentIndex = imagesArray.length - 1;
			}

			dek_open_gallery_image();
		}

		function dek_update_gallery_counter(){
			if(galleryCounter !== ""){
				galleryCounter.textContent = (currentIndex + 1) + ' / ' + imagesArray.length;
			}
		}

		if(lightboxClose !== ""){
			lightboxClose.addEventListener('click',() => {
				dek_close_gallery_image();
			});
		}

		if(lightboxNext !== ""){
			lightboxNext.addEventListener('click',() => {
				dek_next_gallery_image();
			});
		}

		if(lightboxPrev !== ""){
			lightboxPrev.addEventListener('click',() => {
				dek_prev_gallery_image();
			});
		}

		if(lightbox !== ""){
			lightbox.addEventListener('click',(e) => {
				if(e.target === lightbox){
					dek_close_gallery_image();
				}
			});
		}

		document.addEventListener('keydown',(e) => {
			if(lightbox.classList.contains('active')){

				if(e.key === 'Escape'){
					dek_close_gallery_image();
				}

				if(e.key === 'ArrowRight'){
					dek_next_gallery_image();
				}

				if(e.key === 'ArrowLeft'){
					dek_prev_gallery_image();
				}

			}
		});

	}
}

function dek_find_special_li_menu() {
    const anchorLinks = document.querySelectorAll('#mainNavbar a[href^="#"]');
    const homeUrl = "https://warszawskiedachy.pl/";

    anchorLinks.forEach((link) => {
        const href = link.getAttribute("href");

        if (href && href !== "#") {
            link.setAttribute("href", homeUrl + href);
        }
    });
}

function dek_replace_logo(){
    const logo_dek = document.getElementById("dek-logo") || "";
    const dark = "https://warszawskiedachy.pl/wp-content/themes/warszawskie_dachy/assets/img/logo.png";
    const white = "https://warszawskiedachy.pl/wp-content/themes/warszawskie_dachy/assets/img/logo-white.png";

    if(logo_dek !== ""){
        if(window.innerWidth > 990){
            window.addEventListener('scroll',() => {
                if(window.scrollY > 150){
                    logo_dek.src = dark;
                }else{
                    logo_dek.src = white;
                }
            });
        }
    }else{
        return;
    }
}

function dek_menu_add_bg(){
    const target = document.getElementById("dek-nav-marker") || "";
    const target_li = document.querySelectorAll('.dek-menu-drak-li li a') || "";
    const logo = document.getElementById("dek-logo") || "";

    if(target !== "" || target_li.length > 0 || logo !== ""){

        function dek_toggle_menu_color(){
            if(window.innerWidth > 990 && window.scrollY > 150){

                if(target !== ""){
                    target.classList.add("dek-white-color");
                }

                if(logo !== ""){
                    logo.classList.add("dek-white-logo");
                }

                target_li.forEach((e) => {
                    e.classList.add("dek-white-color-li");
                });

            }else{

                if(target !== ""){
                    target.classList.remove("dek-white-color");
                }

                if(logo !== ""){
                    logo.classList.remove("dek-white-logo");
                }

                target_li.forEach((e) => {
                    e.classList.remove("dek-white-color-li");
                });

            }
        }

        dek_toggle_menu_color();

        window.addEventListener('scroll',() => {
            dek_toggle_menu_color();
        });

        window.addEventListener('resize',() => {
            dek_toggle_menu_color();
        });

    }else{
        return;
    }
}