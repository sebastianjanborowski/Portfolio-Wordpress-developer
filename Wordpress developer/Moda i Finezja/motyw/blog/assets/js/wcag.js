// 0 = spoczynek, 1-3 = poziomy
  var advancedBlog_wcag_licznik = 0;
  // POPRAWKA: jak brak w localStorage -> ma być 0
  advancedBlog_wcag_licznik = parseInt(localStorage.getItem('rozmiar'), 10);
  if(isNaN(advancedBlog_wcag_licznik)) advancedBlog_wcag_licznik = 0;

  
  // efekt po najechaniu na menu wcag jest widoczne po zabraniu kursora znika
  let advancedBlog_flaga_hover_menu_wcag = false;

  // aktywacja pokazania się menu wcag
  let flaga = true;

document.addEventListener('DOMContentLoaded', () => {
  advancedBlog_theme_load_on_start();
  advancedBlog_activate_menu_wcag();
  advancedBlog_sterowanie_wcag();
  advancedBlog_find_cursor_on_wcag_menu();
  advancedBlog_wcag_apply();
});

/* =========================================================
   WCAG CSS attach/detach (TYLKO dark)
   ========================================================= */

function advancedBlog_wcag_css_attach(){
  if (!window.advancedBlog || !advancedBlog.wcag_css_url) return;

  const id = 'advancedBlog-wcag-css';
  if (document.getElementById(id)) return;

  const link = document.createElement('link');
  link.id = id;
  link.rel = 'stylesheet';
  link.href = advancedBlog.wcag_css_url + (advancedBlog.wcag_css_ver ? ('?ver=' + encodeURIComponent(advancedBlog.wcag_css_ver)) : '');
  document.head.appendChild(link);
}

function advancedBlog_wcag_css_detach(){
  const link = document.getElementById('advancedBlog-wcag-css');
  if (link) link.remove();
}

/* =========================================================
   HOVER hide menu WCAG
   ========================================================= */
function advancedBlog_find_cursor_on_wcag_menu(){
  const advancedBlog_menu_wcag = document.getElementById("advancedBlog_wcag_menu");
  if(!advancedBlog_menu_wcag) return;

  advancedBlog_menu_wcag.addEventListener('mouseenter', () => {
    advancedBlog_flaga_hover_menu_wcag = true;
  });

  advancedBlog_menu_wcag.addEventListener('mouseleave', () => {
    advancedBlog_flaga_hover_menu_wcag = false;

    // chowaj i ZSYNCUJ flagę kliknięcia
    advancedBlog_menu_wcag.classList.add('advancedBlog_nonVisibility');
    flaga = true; // po schowaniu następny klik ma POKAZAĆ
  });
}

/* =========================================================
   Klik aktywatora menu WCAG (desktop + mobile)
   ========================================================= */
function advancedBlog_activate_menu_wcag(){
  const advancedBlog_wcag_activator_ID = document.getElementById("advancedBlog_wcag_activator");
  const advancedBlog_wcag_menu_ID = document.getElementById("advancedBlog_wcag_menu");
  const advancedBlog_wcag_activator_mobile_ID = document.getElementById("advancedBlog_wcag_activator_mobile");

  // BŁĄD: blokowałeś CAŁE WCAG jeśli brak mobile przycisku
  // POPRAWKA: menu musi być, a desktop/mobile podepnij osobno
  if(!advancedBlog_wcag_activator_ID || !advancedBlog_wcag_menu_ID) return;

  function advancedBlog_toggle_wcag_menu(e){
    e.preventDefault();

    // bierz prawdę z DOM, nie z flaga
    const advancedBlog_jest_schowane = advancedBlog_wcag_menu_ID.classList.contains('advancedBlog_nonVisibility');

    if(advancedBlog_jest_schowane){
      advancedBlog_wcag_menu_ID.classList.remove('advancedBlog_nonVisibility');
      flaga = false; // teraz jest pokazane
    }else{
      advancedBlog_wcag_menu_ID.classList.add('advancedBlog_nonVisibility');
      flaga = true;  // teraz jest schowane
    }
  }

  advancedBlog_wcag_activator_ID.addEventListener('click', advancedBlog_toggle_wcag_menu);

  if(advancedBlog_wcag_activator_mobile_ID){
    advancedBlog_wcag_activator_mobile_ID.addEventListener('click', advancedBlog_toggle_wcag_menu);
  }
}

/* =========================================================
   Podłącza kliknięcia +/- oraz dark/light
   ========================================================= */
function advancedBlog_sterowanie_wcag(){
  const advancedBlog_wcag_aplus_ID = document.getElementById("advancedBlog_wcag_aplus");
  const advancedBlog_wcag_minus_ID = document.getElementById("advancedBlog_wcag_minus");
  const advancedBlog_light_mode_ID = document.getElementById("advancedBlog_wcag_light");
  const advancedBlog_dark_mode_ID = document.getElementById("advancedBlog_wcag_dark");

  if(!advancedBlog_wcag_aplus_ID || !advancedBlog_wcag_minus_ID || !advancedBlog_light_mode_ID || !advancedBlog_dark_mode_ID) return;

  advancedBlog_wcag_aplus_ID.addEventListener('click',(e) => {
    e.preventDefault();
    e.stopPropagation();
    advancedBlog_wcag_plus();
  });

  advancedBlog_wcag_minus_ID.addEventListener('click',(e) => {
    e.preventDefault();
    e.stopPropagation();
    advancedBlog_wcag_minus();
  });

  advancedBlog_light_mode_ID.addEventListener('click', () => {
    advancedBlog_switch_theme_v2(1);
  });

  advancedBlog_dark_mode_ID.addEventListener('click', () => {
    advancedBlog_switch_theme_v2(0);
  });
}

/* =========================================================
   SWITCH THEME v2 (ORYGINALNE DZIAŁANIE + attach/detach CSS)
   index: 0=dark, 1=light
   ========================================================= */
function advancedBlog_switch_theme_v2(index){

  // zapis ustawienia (0=dark, 1=light)
  localStorage.setItem('advancedBlog_theme_mode', String(index));

  // WCAG CSS: tylko dark ma mieć dołączony plik
  const isDark = (index === 0);
  if (isDark) advancedBlog_wcag_css_attach();
  else advancedBlog_wcag_css_detach();

  // menu głowne składniki menu
  const advancedBlog_main_menu_query = document.querySelectorAll('#menu-menu-glowne li a');

  // kolor tła menu
  const advancedBlog_bauckground_color_menu = document.querySelector('.topbar');

  // button dropdown menu
  const advancedBlog_button_dropdown_menu = document.getElementById("advancedBlog_dropdown_menu");

  // nazwa firmy obok loga
  const advancedBlog_logo_name = document.querySelector('.brand-title');

  //kolor tła menu wcag
  const advancedBlog_menu_wcag = document.getElementById("advancedBlog_wcag_menu");

  // kolor tła menu rozwijanego oraz kolor czcionki
  const advancedBlog_menu_rozwijane = document.getElementById("advancedBlog_menu_dropdown");

  //pojedyncze elementy menu rozwijanego
  const advancedBlog_menu_rozwijane_single_item_all = document.querySelectorAll('#menu-rozwijane-menu li a');

  //menu głowne elementy rozwijane
  const advancedBlog_men_glowne_rozwijane_elementy = document.querySelectorAll('ul.advancedBlog_marekr_dropdown_menu li a');

  // sekcje na stronie głownej
  const advancedBlog_section_all_main_page = document.querySelectorAll('.advancedBlog_marker_section');

  //nagłowki sekcji na stronie głownej
  const advancedBlog_header_section = document.querySelectorAll('.advancedBlog_marker_naglowki');

  //łapie tło strony
  const advancedBlog_body = document.querySelector('.bg-blobs');

  //łapie tło pojedynczego wpisu
  const advancedBlog_single_posts = document.querySelectorAll('.news-card');

  // łąpie kontent + tytuł pojedynczego wpisu na stronie głownej
  const advancedBlog_post_title_content = document.querySelectorAll('.advancedBlog_atualnosci_single_item');

  //łapie footer
  const advancedBlog_footer_items = document.querySelector('.advancedBlog-footer__row');

  // łapie button mobile
  const advancedBlog_main_menu_mobile_button_ID = document.getElementById("advancedBlog_main_menu_mobile_button");

  // łapie menu główne zagniezdzone opcje
  const advancedBlog_main_menu_dropdown = document.querySelectorAll(".advancedBlog_menu .dropdown-menu");

  // single item menu rozwijanego
  const advancedBlog_main_menu_dropdown_li_a = document.querySelectorAll(".advancedBlog_menu .dropdown-menu li a");

  // ==============================================
  // DARK (index === 0)
  // ==============================================
  if(index === 0){

    advancedBlog_main_menu_query.forEach((e) => e.classList.add('advancedBlog_switch_theme_white_content'));

    if(advancedBlog_bauckground_color_menu) advancedBlog_bauckground_color_menu.classList.add('advancedBlog_switch_theme_dark_bgc');
    if(advancedBlog_button_dropdown_menu)   advancedBlog_button_dropdown_menu.classList.add('advancedBlog_switch_theme_white_content_hamburger');
    if(advancedBlog_logo_name)             advancedBlog_logo_name.classList.add('advancedBlog_switch_theme_white_content');
    if(advancedBlog_menu_wcag)             advancedBlog_menu_wcag.classList.add('advancedBlog_kolor_strony_dark');
    if(advancedBlog_menu_rozwijane)        advancedBlog_menu_rozwijane.classList.add('advancedBlog_switch_theme_dark_bgc');

    advancedBlog_menu_rozwijane_single_item_all.forEach((e) => e.classList.add('advancedBlog_switch_theme_white_content_hamburger'));
    advancedBlog_men_glowne_rozwijane_elementy.forEach((e) => e.classList.add('advancedBlog_switch_theme_dark_content'));

    advancedBlog_section_all_main_page.forEach((e) => e.classList.add('advancedBlog_switch_theme_dark_bgc'));
    advancedBlog_header_section.forEach((e) => e.classList.add('advancedBlog_switch_theme_white_content'));

    if(advancedBlog_body) advancedBlog_body.classList.add('advancedBlog_kolor_strony_dark');

    advancedBlog_single_posts.forEach((e) => e.classList.add('advancedBlog_kolor_strony_dark'));
    advancedBlog_post_title_content.forEach((e) => e.classList.add('advancedBlog_switch_theme_white_content'));

    if(advancedBlog_footer_items) advancedBlog_footer_items.classList.add('advancedBlog_footer_color_and_bgc');

    if(advancedBlog_main_menu_mobile_button_ID) advancedBlog_main_menu_mobile_button_ID.classList.add("advancedBlog_switch_theme_white_content_hamburger");

    if(advancedBlog_main_menu_dropdown){
      advancedBlog_main_menu_dropdown.forEach(e => {
        e.classList.add("advancedBlog_switch_theme_dark_bgc");
      });
    }

    if(advancedBlog_main_menu_dropdown_li_a){
      advancedBlog_main_menu_dropdown_li_a.forEach(e => {
        e.classList.add("advancedBlog_switch_theme_dropdown_menu");
      });
    }

  } else {

    // ==============================================
    // LIGHT (index !== 0)
    // ==============================================

    advancedBlog_main_menu_query.forEach((e) => e.classList.remove('advancedBlog_switch_theme_white_content'));

    if(advancedBlog_bauckground_color_menu) advancedBlog_bauckground_color_menu.classList.remove('advancedBlog_switch_theme_dark_bgc');
    if(advancedBlog_button_dropdown_menu)   advancedBlog_button_dropdown_menu.classList.remove('advancedBlog_switch_theme_white_content_hamburger');
    if(advancedBlog_logo_name)             advancedBlog_logo_name.classList.remove('advancedBlog_switch_theme_white_content');
    if(advancedBlog_menu_wcag)             advancedBlog_menu_wcag.classList.remove('advancedBlog_kolor_strony_dark');
    if(advancedBlog_menu_rozwijane)        advancedBlog_menu_rozwijane.classList.remove('advancedBlog_switch_theme_dark_bgc');

    advancedBlog_menu_rozwijane_single_item_all.forEach((e) => e.classList.remove('advancedBlog_switch_theme_white_content_hamburger'));
    advancedBlog_men_glowne_rozwijane_elementy.forEach((e) => e.classList.remove('advancedBlog_switch_theme_dark_content'));

    advancedBlog_section_all_main_page.forEach((e) => e.classList.remove('advancedBlog_switch_theme_dark_bgc'));
    advancedBlog_header_section.forEach((e) => e.classList.remove('advancedBlog_switch_theme_white_content'));

    if(advancedBlog_body) advancedBlog_body.classList.remove('advancedBlog_kolor_strony_dark');

    advancedBlog_single_posts.forEach((e) => e.classList.remove('advancedBlog_kolor_strony_dark'));
    advancedBlog_post_title_content.forEach((e) => e.classList.remove('advancedBlog_switch_theme_white_content'));

    if(advancedBlog_footer_items) advancedBlog_footer_items.classList.remove('advancedBlog_footer_color_and_bgc');

    if(advancedBlog_main_menu_mobile_button_ID) advancedBlog_main_menu_mobile_button_ID.classList.remove("advancedBlog_switch_theme_white_content_hamburger");

    if(advancedBlog_main_menu_dropdown){
      advancedBlog_main_menu_dropdown.forEach(e => {
        e.classList.remove("advancedBlog_switch_theme_dark_bgc");
      });
    }

    if(advancedBlog_main_menu_dropdown_li_a){
      advancedBlog_main_menu_dropdown_li_a.forEach(e => {
        e.classList.remove("advancedBlog_switch_theme_dropdown_menu");
      });
    }
  }
}

/* =========================================================
   Odpala się na starcie i ustawia motyw z localStorage
   ========================================================= */
function advancedBlog_theme_load_on_start(){
  const advancedBlog_saved = localStorage.getItem('advancedBlog_theme_mode');

  // jeśli brak zapisu, ustaw domyślnie jasny (1)
  if(advancedBlog_saved === null){
    advancedBlog_switch_theme_v2(1);
    return;
  }

  const advancedBlog_index = (advancedBlog_saved === '0') ? 0 : 1;
  advancedBlog_switch_theme_v2(advancedBlog_index);
}

/* =========================================================
   WCAG: stosowanie klas font-size
   ========================================================= */
function advancedBlog_wcag_apply(){
// strona główna
  // (zostawiam Twój styl, ale poprawka typu: tu i tak będzie NodeList)
  const links = document.querySelectorAll('#menu-menu-glowne li a') || '';
  const advancedBlog_menu_dropdown_ID = document.querySelectorAll('#menu-rozwijane-menu li a') || '';
  const advancedBlog_main_header_h2_query = document.querySelectorAll('.advancedBlog_marker_naglowki') || '';
  const advancedBlog_all = document.querySelectorAll('.advancedBlog_marker_wcag_title_and_content') || '';
  const wcagNodes = document.querySelectorAll(
  '.advancedBlog-auth-box label, .advancedBlog-auth-box small, .advancedBlog-auth-box p,' +
  '.advancedBlog-auth-box a, .advancedBlog-auth-box button,' +
  '.advancedBlog-auth-box input:not([type="hidden"]):not([type="checkbox"]):not([type="submit"]),' +
  '.advancedBlog-auth-box textarea, .advancedBlog-auth-box select, .advancedBlog-auth-box input[type="submit"]'
);
const wcagNode_title = document.querySelectorAll('.advancedBlog-auth-box h3');

const advancedBlog_ogloszenia_formularz = document.querySelectorAll('.cf7-grid label , .advancedBlog-ogloszenia-button-O button , p.advancedBlog-category-title , .advancedBlog-kafelek__btn');;

const advancedBlog_ogloszenia_podstrona_shortcontainer = document.querySelectorAll('.advancedBlog-ogloszenia-add , .advancedBlog-shortContainer-ogloszenia-wojewodztwa h3');

const advancedBlog_ogloszenia_page = document.querySelectorAll('.advancedBlog-category-title a , .advancedBlog-ogloszenia-button');

// podstrona kontakt 
  const advancedBlog_kontakt_input = document.querySelectorAll(
    '.advancedBlog-kontakt-form input:not([type="submit"]):not([type="hidden"]), .advancedBlog-kontakt-form select, .advancedBlog-kontakt-form textarea, .advancedBlog-kontakt-opis p,.advancedBlog-kontakt-form label'
  ) || '';
  
  //content podstron na page.php z selectorem do p, single.php
  const advancedBlog_page_p = document.querySelectorAll('.advancedBlog-page div.col-lg-12 .advancedBlog-page-p p, '+ '.advancedBlog-page div.col-lg-12 ol li, ' + '.advancedBlog-page div.col-lg-12 ul li, ' + '.advancedBlog_archive_resize .advancedBlog_archive h5 a, ' + '.advancedBlog_archive_resize .advancedBlog_archive p, ' + '.advancedBlog_single_all div.text-muted.small.mb-4, ' +
     '.advancedBlog_single_all p, ' + '.advancedBlog_single_all ul li, ' + '.advancedBlog_single_all ol li, ' + '.advancedBlog-kafelki article.advancedBlog-kafelek div.advancedBlog-kafelek__title, ' + 
    '.advancedBlog-page-p div.wp-block-button a, ' + '.advancedBlog_archive_secret p, ' + '.advancedBlog-single__content div.wp-block-file a');

  //tabele na page.php
  const advancedBlog_page_table = document.querySelectorAll('.advancedBlog-page div.col-lg-12 .advancedBlog-page-p figure table tbody tr, ' + '.advancedBlog-page div.col-lg-12 .advancedBlog-page-p figure table tbody tr td, ' + '.advancedBlog-page-p table thead tr th, ' + '.advancedBlog-page-p table tbody tr td, ' +
    '.advancedBlog-single__content figure table tbody tr td'
  );

  // tytuł podstron
  const advancedBlog_page_title = document.querySelectorAll('.advancedBlog-page div.col-lg-12 h2, ' + '.advancedBlog_single_all h2');

  // tytuł h5 archive
  const advancedBlog_archive_h5 = document.querySelectorAll('.advancedBlog_archive_resize .advancedBlog_archive_secret h5');

  const blog_all_footer_h5 = document.querySelectorAll('footer h5');

  const blog_all_footer_p_a = document.querySelectorAll('footer p, '+'footer a');

  const blog_slider_h1 = document.querySelectorAll('.fashion-slide-content h1');
  const blog_slider_h2 = document.querySelectorAll('.fashion-slide-content h2');
  const blog_slider_p = document.querySelectorAll('.fashion-slide-content p, '+'.blog-category-marker-zajawka p');
  const blog_slider_a = document.querySelectorAll('.fashion-slide-content a, '+ '.blog-category-marker-zajawka a');
  const fashion_contact_box_span = document.querySelectorAll('.fashion-contact-box span');
  const fashion_contact_box_h3 = document.querySelectorAll('.fashion-contact-box h3');

  const blog_category_marker_zajawka_h5 = document.querySelectorAll('.blog-category-marker-zajawka h5 a');
  
  if(blog_category_marker_zajawka_h5.length !== 0){
    blog_category_marker_zajawka_h5.forEach(el => {
      el.classList.remove('advancedBlog_h5_1','advancedBlog_h5_2','advancedBlog_h5_3');
    });
  }

  if(fashion_contact_box_h3.length !== 0){
    fashion_contact_box_h3.forEach(el => {
      el.classList.remove('advancedBlog_h3_1','advancedBlog_h3_2','advancedBlog_h3_3');
    });
  }

  if(fashion_contact_box_span.length !== 0){
    fashion_contact_box_span.forEach(el => {
      el.classList.remove('advancedBlog_single_title_1','advancedBlog_single_title_2','advancedBlog_single_title_3');
    });
  }

  if(blog_slider_a.length !== 0){
    blog_slider_a.forEach(el => {
      el.classList.remove('advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3');
    });
  }

  if(blog_slider_h2.length !== 0){
    blog_slider_h2.forEach(el => {
      el.classList.remove('advancedBlog_h2_1','advancedBlog_h2_2','advancedBlog_h2_3');
    });
  }

  if(blog_slider_p.length !== 0){
    blog_slider_p.forEach(el => {
      el.classList.remove('advancedBlog_single_title_1','advancedBlog_single_title_2','advancedBlog_single_title_3');
    });
  }

  if(blog_slider_h1.length !== 0){
    blog_slider_h1.forEach(el => {
      el.classList.remove('advancedBlog_h1_1','advancedBlog_h1_2','advancedBlog_h1_3');
    });
  }

  // kasowanie starych klas (1-3)
 if(links != '') links.forEach(el => el.classList.remove('advancedBlog_menu_1','advancedBlog_menu_2','advancedBlog_menu_3'));

 if(advancedBlog_menu_dropdown_ID != '') advancedBlog_menu_dropdown_ID.forEach(el => el.classList.remove('advancedBlog_menu_1','advancedBlog_menu_2','advancedBlog_menu_3'));

 if(advancedBlog_main_header_h2_query != '') advancedBlog_main_header_h2_query.forEach(el => el.classList.remove('advancedBlog_h2_1','advancedBlog_h2_2','advancedBlog_h2_3'));

 if(advancedBlog_all != '') advancedBlog_all.forEach(el => el.classList.remove('advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3'));

 if(advancedBlog_page_title.length != 0) advancedBlog_page_title.forEach(el => el.classList.remove('advancedBlog_h2_1','advancedBlog_h2_2','advancedBlog_h2_3'));

// kontakt
 if(advancedBlog_kontakt_input != ''){
    advancedBlog_kontakt_input.forEach(el => { el.classList.remove('advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3');});
 }

//  kasowanie starych class resize
 if(advancedBlog_page_p != '') advancedBlog_page_p.forEach(el => el.classList.remove('advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3'));

//  kasowanie starch class resize
 if(advancedBlog_page_table.length != 0){
    advancedBlog_page_table.forEach(el => el.classList.remove('advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3'));
 }

 if(advancedBlog_archive_h5.length != 0){
    advancedBlog_archive_h5.forEach(el => el.classList.remove('advancedBlog_single_title_1','advancedBlog_single_title_2','advancedBlog_single_title_3'));
 }

 if(wcagNodes.length != 0){
  wcagNodes.forEach(el => {
    el.classList.remove('advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3');
  })
 }

 if(wcagNode_title.length != 0){
  wcagNode_title.forEach(el => {
    el.classList.remove('advancedBlog_h2_1','advancedBlog_h2_2','advancedBlog_h2_3');
  })
 }

 if(advancedBlog_ogloszenia_formularz.length != 0){
  advancedBlog_ogloszenia_formularz.forEach(e => {
    e.classList.remove('advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3');
  });
 }

 if(advancedBlog_ogloszenia_podstrona_shortcontainer != 0){
  advancedBlog_ogloszenia_podstrona_shortcontainer.forEach(el => {
    el.classList.remove('advancedBlog_h4_1','advancedBlog_h4_2','advancedBlog_h4_3');
  });
 }

if(advancedBlog_ogloszenia_page.length != 0){
  advancedBlog_ogloszenia_page.forEach(el => {
    el.classList.remove('advancedBlog_h4_1','advancedBlog_h4_2','advancedBlog_h4_3');
  });
}

if(blog_all_footer_h5.length !== 0){
  blog_all_footer_h5.forEach(el => {
    el.classList.remove('advancedBlog_h5_1','advancedBlog_h5_2','advancedBlog_h5_3');
  });
}

if(blog_all_footer_p_a.length !== 0){
  blog_all_footer_p_a.forEach(el => {
    el.classList.remove('advancedBlog_single_content_0','advancedBlog_single_content_1','advancedBlog_single_content_2','advancedBlog_single_content_3');
  });
}


 // 0 = spoczynek -> nic nie dodawaj
 // BŁĄD: u Ciebie licznik bywał "" / NaN, więc warunek nie działał
 // POPRAWKA: tu normalizuję na liczbę 0-3 przed sprawdzeniem
 advancedBlog_wcag_licznik = parseInt(advancedBlog_wcag_licznik, 10);
 if(isNaN(advancedBlog_wcag_licznik)) advancedBlog_wcag_licznik = 0;
 if(advancedBlog_wcag_licznik < 0) advancedBlog_wcag_licznik = 0;
 if(advancedBlog_wcag_licznik > 3) advancedBlog_wcag_licznik = 3;

 if(advancedBlog_wcag_licznik === 0){
   localStorage.setItem('rozmiar', 0);
   return;
 }

  // dodaj aktualny poziom
  if(links != '') links.forEach(el => el.classList.add('advancedBlog_menu_' + advancedBlog_wcag_licznik));

 if(advancedBlog_menu_dropdown_ID != '') advancedBlog_menu_dropdown_ID.forEach(el => el.classList.add('advancedBlog_menu_' + advancedBlog_wcag_licznik));

 if(advancedBlog_main_header_h2_query != '') advancedBlog_main_header_h2_query.forEach(el => el.classList.add('advancedBlog_h2_' + advancedBlog_wcag_licznik));

 if(advancedBlog_all != '')  advancedBlog_all.forEach(el => el.classList.add('advancedBlog_single_content_' + advancedBlog_wcag_licznik));

// kontakt
 if(advancedBlog_kontakt_input != '') advancedBlog_kontakt_input.forEach(el => el.classList.add('advancedBlog_single_content_' + advancedBlog_wcag_licznik));

 if(advancedBlog_page_title.length != 0)advancedBlog_page_title.forEach(el => el.classList.add('advancedBlog_h2_' + advancedBlog_wcag_licznik));
// page.php p
 if(advancedBlog_page_p != '') advancedBlog_page_p.forEach(el => el.classList.add('advancedBlog_single_content_' + advancedBlog_wcag_licznik));

// page.php table
if(advancedBlog_page_table.length != 0) advancedBlog_page_table.forEach(el => el.classList.add('advancedBlog_single_content_' + advancedBlog_wcag_licznik));

if(advancedBlog_archive_h5.length != 0){
  advancedBlog_archive_h5.forEach(el => el.classList.add('advancedBlog_single_title_' + advancedBlog_wcag_licznik));
}

if(wcagNodes.length != 0){
wcagNodes.forEach(el => {
  el.classList.add('advancedBlog_single_content_' + advancedBlog_wcag_licznik);
})
}

if(wcagNode_title.length != 0){
wcagNode_title.forEach(el => {
  el.classList.add('advancedBlog_h2_' + advancedBlog_wcag_licznik);
})
}

if(advancedBlog_ogloszenia_formularz != 0){
  advancedBlog_ogloszenia_formularz.forEach(e => {
    e.classList.add('advancedBlog_single_content_' + advancedBlog_wcag_licznik);
  });
}

if(advancedBlog_ogloszenia_podstrona_shortcontainer != 0){
advancedBlog_ogloszenia_podstrona_shortcontainer.forEach(el => {
  el.classList.add('advancedBlog_h4_' + advancedBlog_wcag_licznik);
});
}

if(advancedBlog_ogloszenia_page.length !== 0){
  advancedBlog_ogloszenia_page.forEach(el => {
    el.classList.add('advancedBlog_h4_' + advancedBlog_wcag_licznik);
  });
}

if(blog_all_footer_h5.length !== 0){
  blog_all_footer_h5.forEach(el => {
    el.classList.add('advancedBlog_h5_' + advancedBlog_wcag_licznik);
  });
}

if(blog_all_footer_p_a.length !== 0){
  blog_all_footer_p_a.forEach(el => {
    el.classList.add('advancedBlog_single_content_' + advancedBlog_wcag_licznik);
  });
}


if(fashion_contact_box_h3.length !== 0){
    fashion_contact_box_h3.forEach(el => {
      el.classList.add('advancedBlog_h3_'+ advancedBlog_wcag_licznik);
    });
  }

  if(fashion_contact_box_span.length !== 0){
    fashion_contact_box_span.forEach(el => {
      el.classList.add('advancedBlog_single_title_'+ advancedBlog_wcag_licznik);
    });
  }

  if(blog_slider_a.length !== 0){
    blog_slider_a.forEach(el => {
      el.classList.add('advancedBlog_single_content_'+ advancedBlog_wcag_licznik);
    });
  }

  if(blog_slider_h2.length !== 0){
    blog_slider_h2.forEach(el => {
      el.classList.add('advancedBlog_h2_'+ advancedBlog_wcag_licznik);
    });
  }

  if(blog_slider_p.length !== 0){
    blog_slider_p.forEach(el => {
      el.classList.add('advancedBlog_single_title_'+ advancedBlog_wcag_licznik);
    });
  }

  if(blog_slider_h1.length !== 0){
    blog_slider_h1.forEach(el => {
      el.classList.add('advancedBlog_h1_'+ advancedBlog_wcag_licznik);
    });
  }

if(blog_category_marker_zajawka_h5.length !== 0){
    blog_category_marker_zajawka_h5.forEach(el => {
      el.classList.add('advancedBlog_h5_'+ advancedBlog_wcag_licznik);
    });
}



localStorage.setItem('rozmiar',advancedBlog_wcag_licznik);

}

// PLUS: 0->1->2->3 
function advancedBlog_wcag_plus(){
  if(advancedBlog_wcag_licznik === 3) return;
  advancedBlog_wcag_licznik++;
  advancedBlog_wcag_apply();
}

// MINUS: 3->2->1->0
function advancedBlog_wcag_minus(){
  if(advancedBlog_wcag_licznik === 0) return;
  advancedBlog_wcag_licznik--;
  advancedBlog_wcag_apply();
}
