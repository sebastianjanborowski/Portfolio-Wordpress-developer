# SBJ v1.0 — prosty generator hasha w C++

## Opis projektu

**SBJ v1.0** to konsolowy program napisany w języku **C++**, którego zadaniem jest wygenerowanie własnego, niestandardowego ciągu znaków na podstawie tekstu wpisanego przez użytkownika.

Użytkownik uruchamia program, wpisuje dowolny tekst, na przykład imię, hasło testowe albo zwykły ciąg znaków, a program zwraca wynik w postaci przekształconego hasha. Zgodnie z instrukcją działania programu użytkownik podaje ciąg znaków, np. `abc` lub dowolne hasło, a w rezultacie końcowym pojawia się hash utworzony z podanego tekstu. fileciteturn0file0

Projekt ma charakter edukacyjny i pokazuje podstawy pracy z:

- wejściem danych z konsoli,
- funkcjami w C++, 
- pętlami `for`,
- tablicami znaków,
- typem `string`,
- instrukcjami warunkowymi,
- prostym przetwarzaniem znaków,
- generowaniem wyniku na podstawie algorytmu.

---

## Ważna informacja bezpieczeństwa

Ten program **nie jest profesjonalnym algorytmem kryptograficznym** i nie powinien być używany do realnego przechowywania haseł użytkowników.

Do prawdziwych zastosowań związanych z bezpieczeństwem używa się gotowych, sprawdzonych rozwiązań, takich jak:

- `bcrypt`,
- `Argon2`,
- `PBKDF2`,
- `SHA-256` tylko w odpowiednim kontekście,
- biblioteki kryptograficzne.

Ten projekt można pokazać w CV jako **edukacyjny projekt C++ pokazujący własny algorytm przekształcania tekstu**, ale nie jako bezpieczny system haszowania haseł.

---

## Funkcjonalności programu

Program umożliwia:

- wpisanie dowolnego tekstu z klawiatury,
- pobranie całej linii tekstu przez `getline()`,
- przejście przez każdy znak wpisanego tekstu,
- porównanie znaków z tablicą liter alfabetu,
- wykonanie prostych przekształceń znaków,
- wykonanie dodatkowych obliczeń liczbowych,
- wygenerowanie końcowego ciągu wynikowego,
- wyświetlenie wyniku bezpośrednio w konsoli.

---

## Struktura działania programu

Program składa się z kilku głównych etapów.

### 1. Przygotowanie tablicy znaków

Funkcja:

```cpp
void znak()
```

uzupełnia tablicę literami alfabetu od `a` do `z`.

### 2. Pobranie tekstu od użytkownika

Funkcja:

```cpp
void textt()
```

wyświetla komunikat:

```text
Podaj tekst do haszowania:
```

i pobiera tekst wpisany przez użytkownika.

### 3. Wygenerowanie wyniku

Funkcja:

```cpp
void hashing(string text)
```

odpowiada za przetworzenie wpisanego tekstu. Program analizuje każdy znak, sprawdza jego pozycję w tablicy znaków i na tej podstawie generuje wynik.

W algorytmie używane są między innymi:

- modulo `%`,
- potęgowanie przez `pow()`,
- długość tekstu,
- pozycja aktualnie analizowanego znaku,
- warunki zależne od parzystości indeksu.

---

## Wymagania techniczne

Do uruchomienia projektu potrzebujesz:

- kompilatora C++, np. `g++`,
- systemu Windows, Linux albo macOS,
- terminala / konsoli,
- opcjonalnie Visual Studio Code.

---

## Jak skompilować program

### Linux / macOS

W terminalu przejdź do folderu z plikiem `sbj-v1.0.cpp`, a następnie wpisz:

```bash
g++ sbj-v1.0.cpp -o sbj
```

Uruchomienie:

```bash
./sbj
```

### Windows — MinGW

W terminalu lub PowerShellu przejdź do folderu z plikiem `sbj-v1.0.cpp`, a następnie wpisz:

```bash
g++ sbj-v1.0.cpp -o sbj.exe
```

Uruchomienie:

```bash
sbj.exe
```

---

## Przykładowe użycie

Po uruchomieniu programu zobaczysz komunikat:

```text
Podaj tekst do haszowania:
```

Przykład wpisanego tekstu:

```text
abc
```

Program zwróci wygenerowany ciąg wynikowy.

Przykład innego tekstu:

```text
sebastian
```

Program przeanalizuje każdą literę i wypisze wynik zgodnie z własnym algorytmem.

---

## Pliki projektu

Przykładowa struktura projektu:

```text
SBJ/
├── sbj-v1.0.cpp
├── instrukcja.txt
└── README.md
```

Opis plików:

| Plik | Opis |
|---|---|
| `sbj-v1.0.cpp` | Główny kod źródłowy programu C++. |
| `instrukcja.txt` | Krótka instrukcja działania programu. |
| `README.md` | Dokumentacja projektu. |

---

## Opis najważniejszych elementów kodu

### Biblioteki

```cpp
#include <iostream>
#include <string>
#include <cmath>
```

Program korzysta z:

- `iostream` — obsługa wejścia i wyjścia,
- `string` — obsługa tekstu,
- `cmath` — funkcja `pow()` do potęgowania.

### Zmienne globalne

```cpp
string text = "";
char table_char[25];
```

`text` przechowuje tekst podany przez użytkownika.

`table_char` przechowuje litery alfabetu.

Uwaga techniczna: alfabet od `a` do `z` ma 26 liter, dlatego profesjonalnie tablica powinna mieć rozmiar `26`, nie `25`.

Poprawniejsza wersja:

```cpp
char table_char[26];
```

### Funkcja `main()`

```cpp
int main()
{
    znak();
    textt();
    hashing(text);
    return 0;
}
```

Program wykonuje kolejno:

1. przygotowanie alfabetu,
2. pobranie tekstu,
3. wygenerowanie wyniku.

---

## Co warto poprawić w kolejnej wersji

Aby projekt wyglądał jeszcze lepiej w portfolio, można dodać:

- zapis wyniku do pliku `.txt`,
- możliwość wielokrotnego haszowania bez ponownego uruchamiania programu,
- obsługę wielkich liter,
- obsługę polskich znaków,
- czytelny separator wyniku,
- testy jednostkowe,
- wersję obiektową opartą o klasę `Hasher`,
- prawdziwy algorytm kryptograficzny jako tryb dodatkowy,
- menu użytkownika w konsoli,
- walidację pustego wejścia.

---

## Przykład lepszego opisu projektu do CV

**Wersja polska:**

```text
SBJ v1.0 — konsolowy program w C++ do generowania własnego hasha tekstowego. Projekt wykorzystuje funkcje, tablice znaków, pętle, instrukcje warunkowe, typ string oraz podstawowe operacje matematyczne. Program pobiera tekst od użytkownika i generuje wynik na podstawie autorskiego algorytmu przekształcania znaków.
```

**Wersja angielska:**

```text
SBJ v1.0 — a console-based C++ application for generating a custom text hash. The project uses functions, character arrays, loops, conditional statements, strings and basic mathematical operations. The program takes user input and generates an output using a custom character transformation algorithm.
```

---

## Technologie

- C++
- Standard Library
- Console Input / Output
- Basic Algorithms
- Character Processing

---

## Status projektu

Projekt działa jako prosty program konsolowy i nadaje się do pokazania jako mały projekt edukacyjny z C++.

Najlepiej prezentować go jako:

```text
edukacyjny generator hasha / algorytm przekształcania tekstu w C++
```

a nie jako profesjonalny system zabezpieczania haseł.

---

## Autor

Projekt przygotowany jako ćwiczenie z programowania w C++ oraz jako element portfolio programistycznego.
