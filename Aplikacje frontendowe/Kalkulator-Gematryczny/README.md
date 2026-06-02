# Kalkulator Gematryczny

Profesjonalny kalkulator gematryczny wykonany jako czysta aplikacja frontendowa w technologiach **HTML + CSS + JavaScript**. Projekt jest gotowy do uruchomienia bez backendu, frameworków, bundlera i instalowania zależności.

Aplikacja została poprawiona tak, aby zasada obliczeń była jednoznaczna, czytelna i zgodna z wymaganiem: **jeżeli podczas redukcji pojawi się liczba specjalna, np. 11, obliczenie zatrzymuje się na tej liczbie i nie jest dalej redukowane**.

---

## 1. Cel projektu

Projekt służy do analizy tekstu w czterech systemach liczbowych:

- **Gematric**,
- **Nous**,
- **Psyche**,
- **Soma**.

Aplikacja może być użyta jako projekt do CV/portfolio, ponieważ pokazuje:

- semantyczny HTML,
- profesjonalny CSS,
- responsywny layout,
- czysty JavaScript,
- obsługę formularza,
- walidację danych,
- pracę ze stanem aplikacji,
- zapis historii w `localStorage`,
- eksport wyniku do JSON,
- kopiowanie wyniku do schowka,
- tryb jasny i ciemny,
- dostępność interfejsu.

---

## 2. Jak uruchomić projekt

### Najprostszy sposób

1. Rozpakuj ZIP.
2. Otwórz folder projektu.
3. Uruchom plik:

```text
index.html
```

w dowolnej nowoczesnej przeglądarce.

### Zalecany sposób w Visual Studio Code

1. Otwórz folder projektu w Visual Studio Code.
2. Zainstaluj rozszerzenie **Live Server**.
3. Kliknij prawym przyciskiem myszy na `index.html`.
4. Wybierz **Open with Live Server**.

Projekt nie wymaga:

- XAMPP,
- Node.js,
- npm,
- bazy danych,
- serwera PHP.

---

## 3. Struktura plików

```text
Kalkulator-Gematryczny/
├── index.html
├── README.md
├── css/
│   ├── reset.css
│   └── style.css
└── js/
    └── app.js
```

---

## 4. Najważniejsze funkcje aplikacji

Aplikacja zawiera:

- profesjonalny landing page,
- responsywny widok desktop / tablet / mobile,
- formularz analizy tekstu,
- normalizację polskich znaków,
- obliczenia w czterech systemach,
- redukcję z zatrzymaniem na liczbach specjalnych,
- wyróżnianie liczb specjalnych na zielono,
- tabelę liter,
- sumę surową pod tabelą,
- wynik końcowy pod tabelą,
- analizę cyklu Soma,
- historię analiz w przeglądarce,
- wczytywanie wcześniejszych analiz,
- czyszczenie historii,
- kopiowanie wyniku,
- pobieranie wyniku jako JSON,
- drukowanie wyniku,
- tryb jasny / ciemny,
- komunikaty bez `alert()`,
- dostępność: `aria-live`, skip link, focus states.

---

## 5. Zasada liczenia

Aplikacja działa według następującej kolejności:

1. Pobiera tekst z formularza.
2. Normalizuje tekst:
   - zamienia litery na małe,
   - usuwa znaki diakrytyczne,
   - zamienia `ł` na `l`,
   - usuwa spacje, cyfry i znaki specjalne z obliczeń.
3. Każdej literze przypisuje wartości w czterech systemach.
4. Sumuje wartości liter w każdym systemie osobno.
5. Pokazuje sumę surową pod tabelą liter.
6. Redukuje sumę przez sumowanie cyfr.
7. Jeżeli na etapie redukcji pojawi się liczba specjalna, np. `11`, redukcja zostaje zatrzymana.
8. Pokazuje wynik końcowy w kartach i w tabeli.

---

## 6. Liczby specjalne

W projekcie liczby specjalne to między innymi:

```text
6, 11, 22, 28, 33, 44, 55, 66, 77, 88, 99,
111, 222, 333, 444, 496, 555, 666, 777, 888, 999,
1111, 2222, 8128
```

Jeżeli wynik redukcji osiągnie jedną z tych wartości, aplikacja nie redukuje jej dalej.

Przykład:

```text
74 → 11
```

Wynik końcowy to `11`, a nie `2`.

---

## 7. Systemy obliczeń

### Gematric

Wartość litery według pozycji w alfabecie:

```text
A = 1, B = 2, C = 3, ..., Z = 26
```

### Nous

Wartości od 100 wzwyż:

```text
A = 100, B = 101, C = 102, ..., Z = 125
```

### Psyche

Wartość litery według pozycji w alfabecie:

```text
A = 1, B = 2, C = 3, ..., Z = 26
```

### Soma

System cykliczny od 1 do 9:

```text
A = 1, B = 2, C = 3, ..., I = 9, J = 1, K = 2 ...
```

---

## 8. Cykl Soma

Cykl Soma jest liczony na podstawie:

- wartości Soma pierwszej litery,
- wartości Soma ostatniej litery.

Możliwe wyniki cyklu:

- **cykl wzrostowy** – pierwsza wartość jest mniejsza od ostatniej,
- **cykl spadkowy** – pierwsza wartość jest większa od ostatniej,
- **cykl stagnacyjny** – pierwsza i ostatnia wartość są takie same.

Przykład dla tekstu:

```text
Sebastian Jan Borowski
```

Pierwsza litera po normalizacji to `s`, a jej wartość Soma to `1`.
Ostatnia litera to `i`, a jej wartość Soma to `9`.

Wynik:

```text
Cykl wzrostowy od 1 do 9
```

---

## 9. Przykład kontrolny

Dla tekstu:

```text
Sebastian Jan Borowski
```

po normalizacji:

```text
sebastianjanborowski
```

aplikacja zwraca wynik końcowy:

```text
Gematric: 11
Nous: 11
Psyche: 11
Soma: 11
```

oraz:

```text
Cykl wzrostowy
Start Soma: 1
Koniec Soma: 9
```

---

## 10. Historia analiz

Historia zapisuje się w `localStorage`.

Zapisywane są:

- tekst wejściowy,
- suma surowa,
- wynik końcowy,
- cykl Soma,
- data wykonania analizy.

Aplikacja nie wysyła danych na serwer.

---

## 11. Technologie

Projekt używa:

- HTML5,
- CSS3,
- JavaScript ES6+,
- localStorage,
- Clipboard API,
- Blob API,
- CSS Grid,
- Flexbox,
- CSS variables.

---

## 12. Opis projektu do CV

```text
Kalkulator Gematryczny – HTML, CSS, JavaScript

Profesjonalna aplikacja frontendowa do analizy tekstu w czterech systemach gematrycznych: Gematric, Nous, Psyche i Soma. Projekt zawiera walidację formularza, normalizację tekstu, redukcję cyfr z zatrzymaniem na liczbach specjalnych, analizę cyklu Soma, historię wyników w localStorage, eksport JSON, kopiowanie wyników, drukowanie oraz tryb jasny i ciemny. Aplikacja została wykonana w czystym HTML, CSS i JavaScript bez frameworków.
```

---

## 13. Co powiedzieć podczas prezentacji projektu

Najważniejsze punkty:

1. Projekt działa bez backendu i bez instalacji zależności.
2. Kod jest podzielony na HTML, CSS i JavaScript.
3. Logika obliczeń jest w jednym pliku `js/app.js`.
4. Aplikacja obsługuje liczby specjalne i zatrzymuje redukcję w poprawnym momencie.
5. Wynik jest pokazany w kartach, tabeli redukcji i tabeli liter.
6. Pod tabelą liter widoczna jest suma surowa i wynik końcowy.
7. Dane historii są przechowywane w `localStorage`.
8. Projekt jest responsywny i gotowy do pokazania na desktopie oraz telefonie.

---

## 14. Autor

Projekt przygotowany jako aplikacja portfolio do prezentacji umiejętności frontendowych.
