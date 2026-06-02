# Lmaker — kalkulator proporcji liquidów do e-papierosów

## Opis projektu

**Lmaker** to konsolowy program napisany w języku **C++**, który pomaga obliczyć proporcje składników potrzebnych do przygotowania własnej mieszanki liquidu do e-papierosów.

Program prowadzi użytkownika krok po kroku przez proces podawania danych, a następnie wylicza ilość poszczególnych składników w mililitrach.

Projekt może być prezentowany jako prosty program C++ pokazujący:

- obsługę wejścia i wyjścia w konsoli,
- pracę na zmiennych liczbowych,
- użycie funkcji,
- użycie struktur (`struct`),
- użycie wektora (`std::vector`),
- prostą walidację danych,
- obliczenia matematyczne,
- podział programu na logiczne etapy.

---

## Co robi aplikacja?

Program oblicza ilość składników potrzebnych do przygotowania liquidu, takich jak:

- baza,
- aromaty,
- słodzik,
- chłodzik,
- shot nikotynowy,
- docelowa moc liquidu.

Użytkownik podaje dane w konsoli, a program zwraca gotowy skład mieszanki w mililitrach.

---

## Główne funkcjonalności

Aplikacja umożliwia:

1. Podanie docelowej ilości liquidu w mililitrach.
2. Podanie liczby aromatów.
3. Nadanie nazw aromatom.
4. Podanie stężenia aromatu w procentach.
5. Podanie proporcji aromatu.
6. Dodanie słodzika lub pominięcie go.
7. Dodanie chłodzika lub pominięcie go.
8. Przygotowanie liquidu bez nikotyny.
9. Przygotowanie liquidu z określoną mocą nikotyny.
10. Obliczenie ilości shota nikotynowego.
11. Obliczenie ilości bazy.
12. Wyświetlenie końcowego składu liquidu.

---

## Jak działa logika obliczeń?

Program zbiera dane od użytkownika i oblicza składniki według ogólnego schematu:

```text
ilość bazy = całkowita ilość liquidu - aromaty - słodzik - chłodzik - shot
```

Dla liquidu bez nikotyny program nie odejmuje shota.

Dla liquidu z nikotyną program dodatkowo oblicza ilość shota według wzoru:

```text
ilość shota = (docelowa moc liquidu / moc shota) * całkowita ilość liquidu
```

Przykład:

```text
Docelowa ilość liquidu: 100 ml
Moc shota: 18 mg/ml
Docelowa moc liquidu: 3 mg/ml

Ilość shota = (3 / 18) * 100 = 16.67 ml
```

---

## Struktura projektu

Projekt zawiera dwa podstawowe pliki:

```text
Lmaker.cpp       główny kod programu C++
instrukcja.txt   krótka instrukcja działania programu
```

Rekomendowana struktura po rozpakowaniu:

```text
Lmaker/
├── Lmaker.cpp
├── instrukcja.txt
└── README.md
```

---

## Wymagania

Do uruchomienia programu potrzebny jest kompilator C++.

Przykładowe rozwiązania:

- Windows: MinGW / g++
- Linux: g++
- macOS: clang++ lub g++
- Visual Studio Code z rozszerzeniem C/C++
- Code::Blocks
- CLion
- Visual Studio

---

## Jak uruchomić projekt?

### 1. Rozpakuj projekt

Rozpakuj archiwum ZIP do wybranego folderu, np.:

```text
C:\projekty\Lmaker
```

albo na Linux/macOS:

```text
/home/user/projekty/Lmaker
```

---

### 2. Otwórz terminal w folderze projektu

Przejdź do folderu, w którym znajduje się plik `Lmaker.cpp`.

Windows:

```bash
cd C:\projekty\Lmaker
```

Linux/macOS:

```bash
cd /home/user/projekty/Lmaker
```

---

### 3. Skompiluj program

#### Windows / Linux / macOS z g++

```bash
g++ Lmaker.cpp -o Lmaker
```

Na Windows może powstać plik:

```text
Lmaker.exe
```

Na Linux/macOS:

```text
Lmaker
```

---

### 4. Uruchom program

Windows:

```bash
Lmaker.exe
```

Linux/macOS:

```bash
./Lmaker
```

---

## Przykładowe użycie programu

Przykład danych wejściowych:

```text
Podaj ilość liquidu w ml: 100
Ile aromatów chcesz dodać: 2
Podaj nazwę aromatu 1: Truskawka
Podaj stężenie aromatu 1 w %: 10
Podaj proporcję aromatu 1: 10
Podaj nazwę aromatu 2: Wanilia
Podaj stężenie aromatu 2 w %: 5
Podaj proporcję aromatu 2: 5
Czy dodajesz słodzik? 1
Podaj proporcję słodzika na 100 ml: 1
Czy dodajesz chłodzik? 0
Czy chcesz zrobić liquid z mocą? 1
Podaj moc shota mg/ml: 18
Podaj docelową moc mg/ml: 3
```

Przykładowy wynik:

```text
Skład liquidu:
Truskawka: ... ml
Wanilia: ... ml
Ilość słodzika do wlania: ... ml
Ilość chłodzika do wlania: ... ml
Ilość shota do wlania: ... ml
Ilość bazy do wlania: ... ml
Łącznie: 100 ml
```

---

## Znaczenie danych wejściowych

### Ilość liquidu

Całkowita ilość gotowej mieszanki w mililitrach.

Przykład:

```text
100
```

Oznacza przygotowanie 100 ml liquidu.

---

### Liczba aromatów

Liczba aromatów, które użytkownik chce dodać do mieszanki.

Przykład:

```text
2
```

Oznacza, że użytkownik doda dwa aromaty.

---

### Nazwa aromatu

Dowolna nazwa aromatu, np.:

```text
Truskawka
Wanilia
Mango
Mięta
```

---

### Stężenie aromatu

Procentowe stężenie aromatu.

Przykład:

```text
10
```

Oznacza 10%.

---

### Proporcja aromatu

W aktualnej wersji programu proporcja działa według zasady opisanej w pierwotnej instrukcji:

```text
1 = jedna dziesiąta
10 = dziesięć dziesiątych, czyli proporcja 1:1
```

Oznacza to, że większa wartość daje większy udział aromatu w obliczeniach.

---

### Słodzik

Program pyta, czy użytkownik chce dodać słodzik:

```text
1 = Tak
0 = Nie
```

Jeżeli użytkownik wybierze `1`, program poprosi o proporcję słodzika na 100 ml.

---

### Chłodzik

Program pyta, czy użytkownik chce dodać chłodzik:

```text
1 = Tak
0 = Nie
```

Jeżeli użytkownik wybierze `1`, program poprosi o proporcję chłodzika na 100 ml.

---

### Liquid z mocą

Program pyta, czy liquid ma zawierać moc nikotynową:

```text
1 = Tak
2 = Nie
```

Jeżeli użytkownik wybierze `1`, program zapyta o:

- moc shota,
- docelową moc gotowego liquidu.

---

## Funkcje w kodzie

W projekcie zastosowano podział logiki na funkcje:

```cpp
ilosc_lix()
```

Pobiera od użytkownika docelową ilość liquidu.

```cpp
ile_aromatow()
```

Pobiera liczbę aromatów.

```cpp
vektor()
```

Tworzy listę aromatów i pobiera ich dane.

```cpp
slodzone()
```

Obsługuje dodanie słodzika.

```cpp
chlodzone()
```

Obsługuje dodanie chłodzika.

```cpp
z_moca()
```

Pyta użytkownika, czy liquid ma mieć moc nikotynową.

```cpp
podaj_moc()
```

Pobiera moc shota.

```cpp
docelowa_moc_lix()
```

Pobiera docelową moc liquidu.

```cpp
obliczenia()
```

Wykonuje główne obliczenia.

```cpp
wyswietlenie()
```

Wyświetla końcowy skład mieszanki.

```cpp
zero_mocy()
```

Obsługuje przypadek liquidu bez nikotyny.

---

## Technologie

Projekt wykorzystuje:

- C++,
- standardowe wejście i wyjście (`iostream`),
- wektory (`vector`),
- struktury (`struct`),
- podstawowe operacje matematyczne,
- funkcje,
- prostą obsługę konsoli.

---

## Co projekt pokazuje w CV?

Ten projekt pokazuje podstawowe umiejętności programowania w C++:

- budowanie programu konsolowego,
- rozbijanie programu na funkcje,
- przechowywanie danych w strukturach,
- używanie `std::vector`,
- pobieranie danych od użytkownika,
- walidację wejścia,
- wykonywanie obliczeń,
- prezentację wyników w konsoli.

Przykładowy opis do CV:

```text
Lmaker — C++ console calculator for e-liquid ingredient proportions

Created a console application in C++ for calculating ingredient proportions for custom e-liquid preparation. The program collects user input, validates basic values, stores flavour data in structures and vectors, calculates base, flavour, sweetener, cooling additive and nicotine shot quantities, and displays the final recipe in millilitres.
```

Opis po polsku:

```text
Lmaker — konsolowy kalkulator proporcji liquidów w C++

Stworzyłem program konsolowy w C++ do obliczania proporcji składników podczas przygotowywania liquidu. Aplikacja pobiera dane od użytkownika, waliduje podstawowe wartości, zapisuje aromaty w strukturach i wektorze, oblicza ilość bazy, aromatów, słodzika, chłodzika oraz shota, a następnie prezentuje końcowy skład mieszanki w mililitrach.
```

---

## Ważna informacja bezpieczeństwa

Program ma charakter edukacyjny i obliczeniowy. Wyniki należy traktować jako pomocnicze. Przy pracy z substancjami chemicznymi lub nikotyną należy zachować ostrożność, stosować odpowiednie środki ochrony i przestrzegać lokalnych przepisów prawa.

---

## Możliwe kierunki rozbudowy

Projekt można rozwinąć o:

- lepszą walidację danych wejściowych,
- obsługę błędnych znaków wpisanych zamiast liczb,
- zapis receptur do pliku tekstowego,
- eksport wyników do CSV,
- menu główne z możliwością wykonania wielu obliczeń bez ponownego uruchamiania programu,
- obsługę profili użytkownika,
- wersję graficzną desktopową,
- wersję webową w HTML/CSS/JavaScript lub PHP,
- dokładniejsze formatowanie wyników do dwóch miejsc po przecinku,
- testy jednostkowe dla funkcji obliczeniowych.

---

## Uwagi techniczne

Aktualny kod korzysta z `system("cls")`, które działa głównie w systemie Windows.

Na Linux/macOS można zastąpić tę instrukcję przez:

```cpp
system("clear");
```

albo całkowicie zrezygnować z czyszczenia konsoli, aby program był bardziej przenośny.

---

## Status projektu

Projekt jest działającym programem konsolowym C++ i może być użyty jako przykład prostego kalkulatora obliczeniowego do portfolio.

Rekomendowana forma prezentacji w CV:

```text
Projekt edukacyjny / portfolio — C++ console application
```

