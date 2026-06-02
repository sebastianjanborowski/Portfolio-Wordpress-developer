# Wisielec Arena — gra HTML, CSS i JavaScript

## Opis projektu

**Wisielec Arena** to kompletna, responsywna gra przeglądarkowa przygotowana jako projekt do CV/portfolio. Aplikacja została napisana w czystym **HTML5, CSS3 i JavaScript ES6+**, bez frameworków i bez backendu.

Projekt pokazuje praktyczne użycie JavaScriptu w aplikacji interaktywnej: obsługę stanu gry, zdarzenia klawiatury, manipulację DOM, timer, punktację, localStorage, tryb jasny/ciemny, komunikaty użytkownika oraz responsywny interfejs.

---

## Najważniejsze funkcje

- klasyczna gra Wisielec w nowoczesnym wydaniu,
- kategorie haseł: bohaterowie, przedmioty, umiejętności i wszystkie kategorie,
- poziomy trudności: łatwy, normalny, trudny, ekspert,
- system punktacji zależny od poziomu trudności, czasu, błędów i podpowiedzi,
- timer aktualnej rundy,
- licznik prób,
- zapis statystyk w `localStorage`,
- zapis najlepszego wyniku,
- statystyki: liczba gier, wygrane, przegrane, skuteczność,
- obsługa klawiatury fizycznej,
- obsługa klawiatury ekranowej,
- blokowanie ponownego użycia tej samej litery,
- podpowiedzi zależne od poziomu trudności,
- opcja poddania rundy,
- dźwięki poprawnej odpowiedzi, błędu, wygranej i przegranej,
- możliwość wyłączenia dźwięków,
- tryb jasny i ciemny,
- responsywny layout desktop/tablet/mobile,
- brak `alert()` i natywnych komunikatów przeglądarki,
- estetyczne komunikaty typu toast,
- semantyczna struktura HTML,
- podstawowe elementy dostępności: `aria-live`, `aria-label`, focus states, skip link.

---

## Technologie

- HTML5
- CSS3
- JavaScript ES6+
- DOM API
- localStorage
- Audio API
- CSS Grid
- Flexbox
- Responsive Web Design
- Accessibility basics

---

## Struktura plików

```text
Wisielec/
├── index.html
├── README.md
├── css/
│   ├── reset.css
│   └── style.css
├── js/
│   ├── hangman-game.js
│   ├── yes.wav
│   ├── no.wav
│   ├── win.mp3
│   └── lose.mp3
└── img/
    ├── dota.png
    ├── s0.png
    ├── s1.png
    ├── s2.png
    ├── s3.png
    ├── s4.png
    ├── s5.png
    ├── s6.png
    ├── s7.png
    ├── s8.png
    └── s9.png
```

---

## Jak uruchomić projekt

### Opcja 1 — najprościej

1. Pobierz projekt.
2. Rozpakuj plik ZIP.
3. Otwórz plik `index.html` w przeglądarce.

Projekt nie wymaga instalacji zależności.

### Opcja 2 — przez Live Server w Visual Studio Code

1. Otwórz folder projektu w Visual Studio Code.
2. Zainstaluj rozszerzenie **Live Server**.
3. Kliknij prawym przyciskiem na `index.html`.
4. Wybierz **Open with Live Server**.

---

## Jak grać

1. Wybierz kategorię haseł.
2. Wybierz poziom trudności.
3. Kliknij **Nowa gra**.
4. Odgaduj litery przy użyciu klawiatury ekranowej lub fizycznej.
5. Za błędne litery tracisz próby.
6. Wygrywasz, gdy odkryjesz całe hasło.
7. Przegrywasz, gdy liczba błędów osiągnie limit prób.

---

## Poziomy trudności

| Poziom | Liczba prób | Podpowiedzi | Mnożnik punktów |
|---|---:|---:|---:|
| Łatwy | 9 | 3 | 1.00 |
| Normalny | 7 | 2 | 1.35 |
| Trudny | 5 | 1 | 1.80 |
| Ekspert | 4 | 0 | 2.40 |

---

## System punktacji

Wynik zależy od:

- liczby poprawnie odgadniętych liter,
- poziomu trudności,
- czasu rundy,
- liczby błędnych odpowiedzi,
- liczby użytych podpowiedzi,
- bonusu za ukończenie rundy.

Dzięki temu gra nie jest tylko prostą zgadywanką, ale ma pełną logikę punktacji.

---

## localStorage

Aplikacja zapisuje statystyki lokalnie w przeglądarce użytkownika.

Zapisywane dane:

- najlepszy wynik,
- liczba rozegranych gier,
- liczba wygranych,
- liczba przegranych.

Dane można wyczyścić przyciskiem **Wyczyść statystyki**. Przycisk wymaga drugiego kliknięcia jako potwierdzenia, dlatego aplikacja nie używa natywnego `alert()` ani `confirm()`.

---

## Co zostało poprawione względem prostej wersji

- przebudowana struktura HTML,
- poprawiony layout responsywny,
- dodana pełna sekcja landing page,
- dodana sekcja technologii i zasad,
- uporządkowana logika gry w jednym pliku JS,
- usunięte przypadkowe zależności od nietypowych środowisk,
- poprawione komunikaty użytkownika,
- poprawiona obsługa mobile,
- dodane zabezpieczenie przed wielokrotnym klikaniem tych samych liter,
- dodane statystyki i zapis lokalny,
- dodany tryb ciemny,
- dodana obsługa dostępności.

---

## Gotowy opis do CV

**Wisielec Arena — JavaScript Game**  
Responsywna gra przeglądarkowa napisana w HTML, CSS i JavaScript. Projekt zawiera kategorie haseł, poziomy trudności, system punktacji, timer, podpowiedzi, obsługę klawiatury, dźwięki, tryb jasny/ciemny oraz zapis statystyk w localStorage. Aplikacja pokazuje praktyczną pracę z DOM API, eventami, stanem aplikacji i responsywnym interfejsem.

---

## Gotowy opis do GitHuba

```text
A responsive Hangman game built with pure HTML, CSS and JavaScript. The project includes categories, difficulty levels, score system, timer, hints, keyboard support, sound effects, dark mode and localStorage statistics. Built as a portfolio project to demonstrate DOM manipulation, application state management and responsive UI.
```

---

## Uwagi techniczne

- Projekt działa bez backendu.
- Projekt działa bez bazy danych.
- Projekt nie wymaga instalacji pakietów npm.
- Wszystkie dane są przechowywane lokalnie w przeglądarce.
- Kod można opublikować na GitHub Pages.

---

## Propozycje dalszej rozbudowy

- ranking wyników online,
- backend z logowaniem użytkowników,
- baza własnych haseł,
- panel administratora do dodawania haseł,
- wybór języka gry,
- animowany SVG zamiast obrazków etapów,
- testy jednostkowe logiki gry.
