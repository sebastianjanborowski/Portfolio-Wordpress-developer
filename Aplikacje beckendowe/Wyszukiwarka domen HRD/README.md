# HRD – Host Ready Domains

**HRD** to demonstracyjna aplikacja webowa napisana w PHP. Projekt służy do sprawdzania domen, wykonywania podstawowej analizy DNS, zapisywania historii wyszukiwań w MySQL oraz prezentowania wyników w panelu użytkownika.

Projekt jest przygotowany jako pozycja do CV / portfolio na stanowisko **Junior PHP Developer**.

---

## 1. Co robi aplikacja?

Aplikacja umożliwia:

- wpisanie domeny w formularzu, np. `mojafirma.pl`,
- normalizację wpisanej wartości, np. usunięcie `https://`, ścieżki URL i `www.`,
- walidację poprawności nazwy domeny,
- sprawdzenie podstawowych rekordów DNS: `A`, `AAAA`, `MX`, `NS`,
- pokazanie wyniku w czytelnej karcie,
- zapisanie wyszukiwania w bazie danych,
- logowanie użytkownika,
- przeglądanie historii wyszukiwań w panelu,
- oddzielne widoki desktop/mobile,
- prezentację projektu jako aplikacji portfolio.

---

## 2. Ważne ograniczenie techniczne

Aplikacja wykonuje **podstawową analizę DNS**, a nie pełne sprawdzanie dostępności domeny u rejestratora.

Brak rekordów DNS oznacza, że domena może być wolna, ale nie daje 100% gwarancji. Pełną dostępność domeny należy potwierdzić przez:

- WHOIS,
- API rejestratora domen,
- panel sprzedaży domen, np. OVH, Aftermarket, Namecheap, GoDaddy.

W projekcie komunikaty są celowo sformułowane uczciwie jako: **„możliwa dostępność”**, a nie jako pewna dostępność.

---

## 3. Technologie

Projekt wykorzystuje:

- PHP 8+
- MySQL / MariaDB
- PDO
- prepared statements
- sessions
- CSRF token
- `password_hash()` / `password_verify()`
- Bootstrap 5
- Bootstrap Icons
- HTML5
- CSS3
- JavaScript

---

## 4. Struktura projektu

```text
HRD/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── config/
│   └── db.php
├── core/
│   ├── auth/
│   │   └── login.php
│   └── findDomain/
│       └── searchDomain.php
├── database/
│   └── hrd.sql
├── includes/
│   ├── app-security.php
│   └── domain-utils.php
├── template/
│   ├── domain-form.php
│   ├── footer.php
│   └── header.php
├── dashboard.php
├── index.php
├── login.php
├── logout.php
└── README.md
```

---

## 5. Dane logowania

Po imporcie bazy danych dostępne są dwa konta testowe.

### Administrator

```text
Login: admin
Hasło: admin
```

Administrator widzi szerszy zakres historii wyszukiwań.

### Użytkownik demo

```text
Login: demo
Hasło: demo123
```

Użytkownik demo widzi swoje wyszukiwania.

---

## 6. Instalacja lokalna w XAMPP

### Krok 1. Skopiuj projekt

Skopiuj folder projektu do katalogu:

```text
C:\xampp\htdocs\HRD\
```

Finalna ścieżka powinna wyglądać tak:

```text
C:\xampp\htdocs\HRD\index.php
```

---

### Krok 2. Uruchom XAMPP

W panelu XAMPP uruchom:

```text
Apache
MySQL
```

---

### Krok 3. Zaimportuj bazę danych

Otwórz phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Następnie:

1. Wejdź w zakładkę **Import**.
2. Wybierz plik:

```text
database/hrd.sql
```

3. Kliknij **Wykonaj**.

Plik SQL automatycznie utworzy bazę:

```text
hrd
```

oraz tabele:

```text
users
domain_searches
```

---

### Krok 4. Sprawdź połączenie z bazą

Plik konfiguracyjny znajduje się tutaj:

```text
config/db.php
```

Domyślna konfiguracja dla XAMPP:

```php
$host = 'localhost';
$dbname = 'hrd';
$username = 'root';
$password = '';
```

Jeżeli Twoja baza ma hasło, wpisz je w zmiennej:

```php
$password = 'twoje_haslo';
```

---

### Krok 5. Uruchom aplikację

W przeglądarce wpisz:

```text
http://localhost/HRD/
```

---

## 7. Jak zaprezentować aplikację rekruterowi?

Najlepsza kolejność prezentacji:

1. Otwórz stronę główną.
2. Pokaż profesjonalny landing page.
3. Wpisz błędną domenę, np. `test` i pokaż walidację.
4. Wpisz poprawną domenę, np. `google.pl`.
5. Pokaż wynik analizy DNS.
6. Zaloguj się jako `admin / admin`.
7. Pokaż panel użytkownika i historię wyszukiwań.
8. Pokaż plik `database/hrd.sql` jako dump bazy danych.
9. Pokaż `core/auth/login.php`, gdzie używane jest `password_verify()`.
10. Pokaż `core/findDomain/searchDomain.php`, gdzie wykonywana jest analiza domeny i zapis do bazy.
11. Pokaż `includes/domain-utils.php`, gdzie jest walidacja domeny.
12. Pokaż `config/db.php`, gdzie używane jest PDO.

---

## 8. Co warto powiedzieć o projekcie w CV?

Przykładowy opis:

```text
HRD – Host Ready Domains
Aplikacja PHP do sprawdzania domen, analizy podstawowych rekordów DNS i zapisywania historii wyszukiwań użytkownika. Projekt wykorzystuje PHP, MySQL, PDO, prepared statements, sesje, token CSRF, password_hash/password_verify oraz responsywny interfejs Bootstrap 5.
```

Wersja krótsza:

```text
HRD – aplikacja PHP + MySQL do analizy domen z logowaniem użytkownika, historią wyszukiwań, walidacją formularzy i responsywnym interfejsem Bootstrap.
```

---

## 9. Co pokazuje projekt technicznie?

Projekt pokazuje praktyczne użycie:

- konfiguracji PDO,
- zapytań SQL przez prepared statements,
- obsługi formularzy metodą POST,
- sesji PHP,
- logowania użytkownika,
- hashowania haseł,
- tokenów CSRF,
- walidacji danych po stronie backendu,
- prostych komunikatów użytkownika,
- struktury katalogów w aplikacji PHP,
- responsywnego UI w Bootstrapie.

---

## 10. Najważniejsze pliki

### `index.php`

Strona główna aplikacji. Zawiera landing page, formularz sprawdzania domeny, wynik analizy oraz opis funkcji projektu.

### `login.php`

Widok formularza logowania.

### `dashboard.php`

Panel użytkownika z historią wyszukiwań domen i statystykami.

### `core/auth/login.php`

Obsługa logowania. Plik pobiera użytkownika z bazy i sprawdza hasło przez `password_verify()`.

### `core/findDomain/searchDomain.php`

Obsługa formularza sprawdzania domeny. Plik normalizuje domenę, waliduje ją, wykonuje analizę DNS i zapisuje wynik do bazy.

### `includes/app-security.php`

Funkcje bezpieczeństwa: sesja, escapowanie HTML, logowanie, role, CSRF i komunikaty flash.

### `includes/domain-utils.php`

Funkcje domenowe: normalizacja, walidacja i analiza DNS.

### `database/hrd.sql`

Pełny dump bazy danych wraz z tabelami i użytkownikami testowymi.

---

## 11. Typowe problemy

### Błąd połączenia z bazą danych

Sprawdź:

- czy działa MySQL w XAMPP,
- czy zaimportowano `database/hrd.sql`,
- czy dane w `config/db.php` są poprawne.

### Logowanie nie działa

Sprawdź:

- czy tabela `users` istnieje,
- czy import SQL został wykonany do bazy `hrd`,
- czy wpisujesz poprawne dane: `admin / admin` albo `demo / demo123`.

### Wynik domeny jest inny niż oczekiwany

To normalne. DNS zależy od realnych rekordów w internecie. Aplikacja sprawdza tylko podstawowe rekordy DNS.

---
