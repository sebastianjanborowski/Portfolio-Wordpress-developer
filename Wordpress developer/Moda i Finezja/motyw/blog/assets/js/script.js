document.addEventListener('DOMContentLoaded', () => {
  advancedBlog_close_submenus_when_main_dropdown_hides();
  advancedBlog_find_cursor_on_wcag_menu2();
  advancedBlog_dodaj_ogloszenie();
	blog_scroll_to_top();
});


function advancedBlog_dodaj_ogloszenie(){
  try{
    var advancedBlog_acivator = document.getElementById("advancedBlog-dodaj-ogloszenie");
    var advancedBlog_deactivator = document.getElementById("advancedBlog-ogloszenia-close");
    var advancedBlog_container = document.getElementById("advancedBlog-ogloszenia-popup");

    advancedBlog_acivator.addEventListener('click',() => {
      advancedBlog_container.classList.remove("advancedBlog_hide_form");
    });

    advancedBlog_deactivator.addEventListener('click',() => {
      advancedBlog_container.classList.add("advancedBlog_hide_form");
    });

  }catch(error){
    return;
  }
}

var i = 0;

function advancedBlog_find_cursor_on_wcag_menu2(){

  // Twoje osobne menu dropdown
  const budlo_menu_wcag = document.getElementById("advancedBlog_menu_dropdown");

  // dropdowny w menu głównym
  const advancedBlog_main_menu_dropdown_query = document.querySelectorAll('#menu-menu-glowne li.nav-item.dropdown');

  if(!budlo_menu_wcag && advancedBlog_main_menu_dropdown_query.length === 0) return;

  // ------------------ 1) Twoje menu dropdown (hamburger) ------------------
  if(budlo_menu_wcag){
    budlo_menu_wcag.addEventListener('mouseenter', () => {
      advancedBlog_flaga_hover_menu_wcag = true;
    });

    budlo_menu_wcag.addEventListener('mouseleave', () => {
      advancedBlog_flaga_hover_menu_wcag = false;
      budlo_menu_wcag.classList.add('advancedBlog_nonVisibility');
    });
  }

  // ------------------ 2) Dropdowny w menu głównym (stałe powiązanie) ------------------
  advancedBlog_main_menu_dropdown_query.forEach((advancedBlog_li_dropdown) => {

    const advancedBlog_ul_dropdown = advancedBlog_li_dropdown.querySelector('ul.dropdown-menu');
    const advancedBlog_toggle_a    = advancedBlog_li_dropdown.querySelector('a.dropdown-toggle');

    const lvl3Menus = document.querySelectorAll('#menu-menu-glowne ul.dropdown-menu > li.dropdown-submenu > ul.dropdown-menu');
    
    const lvl2 = document.querySelectorAll('#advancedBlog_menu_dropdown li.nav-item.dropdown > ul.dropdown-menu');


    if(!advancedBlog_ul_dropdown) return;

    advancedBlog_ul_dropdown.addEventListener('mouseleave', () => {
      advancedBlog_ul_dropdown.classList.remove('show');

      if(advancedBlog_toggle_a){
        advancedBlog_toggle_a.classList.remove('show');
        advancedBlog_toggle_a.setAttribute('aria-expanded','false');
      }
    });

    lvl3Menus.forEach(e => {
      e.addEventListener('mouseleave',() => {
        e.classList.remove('show');
      });
    });

    lvl2.forEach(e => {
      e.addEventListener('mouseleave',() => {
        e.classList.remove('show');
      });
    });

  });

  // ------------------ 3) DODATKOWO: mechanizm tylko dla UL które mają .show ------------------
  // delegacja: działa też gdy bootstrap dopiero doda .show po kliknięciu
  document.addEventListener('mouseout', (e) => {

    const advancedBlog_otwarty_ul = e.target.closest('ul.dropdown-menu.advancedBlog_marekr_dropdown_menu.show');
    if(!advancedBlog_otwarty_ul) return;

    // jeśli kursor przeszedł do środka tego samego UL, to nie chowaj
    if(advancedBlog_otwarty_ul.contains(e.relatedTarget)) return;

    // znajdź toggle powiązany z tym UL (rodzic li)
    const advancedBlog_li = advancedBlog_otwarty_ul.closest('li.nav-item.dropdown');
    const advancedBlog_toggle_a = advancedBlog_li ? advancedBlog_li.querySelector('a.dropdown-toggle') : null;

    // chowaj
    advancedBlog_otwarty_ul.classList.remove('show');

    if(advancedBlog_toggle_a){
      advancedBlog_toggle_a.classList.remove('show');
      advancedBlog_toggle_a.setAttribute('aria-expanded','false');
    }

  }, true);

}


// --- gdy Bootstrap zamknie dropdown poziomu 0, zamknij też submenus ---
function advancedBlog_close_submenus_when_main_dropdown_hides(){
  document.addEventListener('hide.bs.dropdown', function (e) {
    const root = e.target;
    root.querySelectorAll('.dropdown-submenu > .dropdown-menu.show').forEach(m => m.classList.remove('show'));
    root.querySelectorAll('.dropdown-submenu > a[aria-expanded="true"]').forEach(a => a.setAttribute('aria-expanded', 'false'));
  });
}


function blog_scroll_to_top(){
  const activator = document.getElementById("scrollTopBtn") || "";

  if(activator === ""){
    return;
  }
  
  window.addEventListener('scroll',() => {
      activator.style.display = window.scrollY > 300 ? 'block' : 'none';
  });


  activator.addEventListener('click',() => {
      window.scrollTo({
          top:0,
          behavior:'smooth'
      });
  });
}
