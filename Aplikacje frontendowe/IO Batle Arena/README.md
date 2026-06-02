# IO AI Arena — gra przeglądarkowa JavaScript

## Opis projektu

IO AI Arena to prosta, responsywna gra przeglądarkowa przygotowana jako projekt do portfolio/CV. Użytkownik uruchamia rundę, obserwuje poruszające się boty na arenie i zdobywa punkty przez kliknięcie lub dotknięcie elementów. Projekt pokazuje praktyczne użycie HTML, CSS, JavaScript, Bootstrap, obsługi zdarzeń, animacji, stanu aplikacji oraz localStorage.

Projekt nie wymaga backendu ani bazy danych. Działa lokalnie w przeglądarce.

## Najważniejsze funkcje

- Profesjonalny landing page.
- Responsywny wygląd na komputerze, tablecie i telefonie.
- Interaktywna arena gry.
- Generowanie botów na podstawie ustawień użytkownika.
- Różne typy botów z prostą symulacją zachowania AI.
- Start, pauza, reset gry.
- Poziomy trudności: łatwy, normalny, trudny.
- Regulacja liczby botów na starcie.
- Punktacja i system combo.
- Timer rundy.
- Rekord zapisywany w localStorage.
- Tryb jasny/ciemny.
- Skróty klawiaturowe:
  - Spacja — pauza/wznowienie,
  - R — reset,
  - A — dodanie botów.

## Technologie

- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- Bootstrap Icons
- DOM API
- requestAnimationFrame
- localStorage
- Responsive Web Design

## Struktura plików

```text
io/
├── index.html
├── style.css
├── script.js
└── README.md
```

## Jak uruchomić projekt lokalnie

### Opcja 1 — zwykłe otwarcie pliku

1. Pobierz projekt.
2. Otwórz folder `io`.
3. Kliknij dwukrotnie plik `index.html`.
4. Projekt otworzy się w przeglądarce.

### Opcja 2 — uruchomienie przez lokalny serwer

W folderze projektu uruchom:

```bash
python -m http.server 8000
```

Następnie wejdź w przeglądarce na:

```text
http://localhost:8000
```

## Jak grać

1. Wybierz poziom trudności.
2. Ustaw liczbę botów na starcie.
3. Kliknij przycisk `Start`.
4. Klikaj boty na arenie, aby zdobywać punkty.
5. Im lepsza seria, tym większe combo.
6. Po zakończeniu czasu aplikacja zapisuje najlepszy wynik w przeglądarce.

## Opis logiki gry

Aplikacja przechowuje stan gry w obiekcie `gameState`. Znajdują się tam informacje o wyniku, czasie, aktywnych botach, pauzie, rekordzie i poziomie trudności.

Animacja botów działa przez `requestAnimationFrame`, dzięki czemu ruch jest płynniejszy niż przy użyciu zwykłego `setInterval`. Każdy bot ma własne współrzędne, prędkość, kierunek, rozmiar i typ zachowania.

Po kliknięciu bota:

- bot zostaje usunięty z areny,
- użytkownik otrzymuje punkty,
- zwiększa się combo,
- pojawia się krótka animacja punktów.

## Co można powiedzieć o projekcie na rozmowie rekrutacyjnej

Projekt pokazuje, że potrafię zbudować kompletną interaktywną aplikację frontendową w czystym JavaScript. Zaimplementowałem stan gry, animację przez requestAnimationFrame, obsługę zdarzeń, zapis rekordu w localStorage, responsywny interfejs Bootstrap oraz prostą symulację zachowań botów.

## Propozycja opisu do CV

**IO AI Arena — gra przeglądarkowa JavaScript**

Responsywna gra typu arena wykonana w HTML, CSS, JavaScript i Bootstrap. Projekt zawiera logikę startu, pauzy i resetu gry, generowanie botów, system punktów, combo, poziomy trudności, animację przez requestAnimationFrame oraz zapis najlepszego wyniku w localStorage.

## Możliwe kierunki rozbudowy

- Ranking wyników po stronie backendu.
- Logowanie użytkowników.
- Tryb wieloosobowy.
- Lepsze algorytmy AI botów.
- Efekty dźwiękowe.
- System poziomów i osiągnięć.
- Eksport wyniku do JSON.
