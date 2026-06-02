# Out Of Office — backendowy system do zarządzania pracownikami

## 1. Opis projektu

**Out Of Office** to backendowa aplikacja napisana w PHP, służąca do zarządzania:

- pracownikami,
- projektami,
- wnioskami urlopowymi,
- wnioskami o zatwierdzenie,
- rolami użytkowników,
- logowaniem i dostępem do panelu administracyjnego.


Aplikacja działa lokalnie na środowisku typu **XAMPP / Apache / MySQL / MariaDB**.

---

## 2. Technologie użyte w projekcie

W projekcie wykorzystano:

- PHP,
- MySQL / MariaDB,
- PDO,
- prepared statements,
- JavaScript,
- Fetch API,
- Bootstrap 5,
- Bootstrap Icons,
- HTML5,
- CSS3,
- sesje PHP,
- role użytkowników,
- hashowanie haseł przez `password_hash()`,
- weryfikację haseł przez `password_verify()`.

---

## 3.0 Logowanie
Login: admin Hasło: admin
Login: HR_Manager Hasło: HR_Manager
Login: Project_Manager Hasło: Project_Manager
Login: Employee Hasło: Employee

## 3.1 Najważniejsze funkcje aplikacji

Aplikacja posiada:

- system logowania,
- obsługę sesji użytkownika,
- role użytkowników:
  - `admin`,
  - `HR_Manager`,
  - `Project_Manager`,
  - `Employee`,
- menu zależne od roli użytkownika,
- CRUD dla pracowników,
- CRUD dla projektów,
- CRUD dla wniosków urlopowych,
- CRUD dla wniosków o zatwierdzenie,
- responsywny panel administracyjny,
- widok tabel na komputerze,
- widok accordion na telefonie,
- formularze z walidacją,
- komunikaty pod formularzami zamiast `alert()`,
- osobne pliki JavaScript dla poszczególnych formularzy,
- zabezpieczenie plików akcji w katalogu `calculations`,
- połączenie z bazą danych przez PDO.

---

## 4. Struktura projektu

Przykładowa struktura katalogów:

```text
OutOfOffice/
│
├── calculations/
│   ├── add.php
│   ├── update.php
│   ├── delete.php
│   ├── addProject.php
│   ├── updateProject.php
│   ├── deleteProject.php
│   ├── addLeaveRequest.php
│   ├── updateLeaveRequest.php
│   ├── deleteLeaveRequest.php
│   ├── addApprover_Request.php
│   ├── updateApprover_Request.php
│   └── deleteApprover_Request.php
│
├── config/
│   └── db.php
│
├── css/
│   └── style.css
│
├── includes/
│   ├── app-security.php
│   └── app-response.php
│
├── js/
│   ├── app-form-utils.js
│   ├── app-navigation.js
│   ├── auth-login.js
│   ├── employee-create.js
│   ├── employee-update.js
│   ├── employee-delete.js
│   ├── project-create.js
│   ├── project-update.js
│   ├── project-delete.js
│   ├── leave-request-create.js
│   ├── leave-request-update.js
│   ├── leave-request-delete.js
│   ├── approval-request-create.js
│   ├── approval-request-update.js
│   └── approval-request-delete.js
│
├── public/
│   ├── index.php
│   ├── menu.php
│   ├── header.php
│   ├── footer.php
│   └── logout.php
│
├── templates/
│   ├── show.php
│   ├── add.php
│   ├── update.php
│   ├── delete.php
│   ├── showProject.php
│   ├── project.php
│   ├── updateProject.php
│   ├── deleteProject.php
│   ├── showLeaveRequest.php
│   ├── addLeaveRequest.php
│   ├── updateLeaveRequest.php
│   ├── deleteLeaveRequest.php
│   ├── showApprover_Request.php
│   ├── addApprover_Request.php
│   ├── updateApprover_Request.php
│   └── deleteApprover_Request.php
│
├── Wizualizacja/
│   └── Screenshots.zip
│
├── outofoffice.sql
└── README.md
```

---

## 5. Baza danych

Plik:

```text
outofoffice.sql
```

jest pełną kopią bazy danych projektu.

Zawiera:

- strukturę tabel,
- dane testowe,
- konta użytkowników,
- zahashowane hasła,
- role użytkowników,
- przykładowych pracowników,
- przykładowe projekty,
- przykładowe wnioski urlopowe,
- przykładowe zatwierdzenia.

---

## 6. Wymagania przed uruchomieniem

Do uruchomienia projektu lokalnie potrzebujesz:

- XAMPP,
- Apache,
- MySQL / MariaDB,
- phpMyAdmin,
- PHP 8.x lub nowszy,
- przeglądarkę internetową.

Projekt był przygotowywany pod lokalne środowisko typu:

```text
Apache + MariaDB + PHP
```

---

## 7. Instrukcja instalacji krok po kroku

### Krok 1 — uruchom XAMPP

W panelu XAMPP uruchom:

```text
Apache
MySQL
```

Obie usługi muszą mieć status aktywny.

---

### Krok 2 — skopiuj projekt do katalogu serwera

Skopiuj cały folder projektu do katalogu:

```text
C:\xampp\htdocs\
```

Zalecana nazwa folderu:

```text
OutOfOffice
```

Finalna ścieżka powinna wyglądać tak:

```text
C:\xampp\htdocs\OutOfOffice
```

Jeżeli folder ma długą nazwę lub polskie znaki, najlepiej zmień ją na prostą nazwę:

```text
OutOfOffice
```

To zmniejsza ryzyko problemów ze ścieżkami w przeglądarce.

---

### Krok 3 — utwórz bazę danych

Wejdź do phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Utwórz nową bazę danych o nazwie:

```text
outofoffice
```

Zalecane kodowanie:

```text
utf8mb4_polish_ci
```

---

### Krok 4 — zaimportuj plik SQL

W phpMyAdmin:

1. Kliknij bazę danych `outofoffice`.
2. Wejdź w zakładkę **Import**.
3. Wybierz plik:

```text
outofoffice.sql
```

4. Kliknij **Wykonaj**.

Po poprawnym imporcie w bazie powinny pojawić się tabele, między innymi:

```text
admin
employees
project
leave_request
approval_request
```

---

### Krok 5 — sprawdź konfigurację połączenia z bazą danych

Otwórz plik:

```text
config/db.php
```

Poprawna konfiguracja dla XAMPP zwykle wygląda tak:

```php
<?php
$host = 'localhost';
$db = 'outofoffice';
$user = 'root';
$password = '';
$charset = 'utf8mb4';
```

Ważne: nazwa bazy danych w pliku `db.php` musi być taka sama jak nazwa bazy w phpMyAdmin.

Jeżeli baza nazywa się:

```text
outofoffice
```

to w `db.php` powinno być:

```php
$db = 'outofoffice';
```

---

### Krok 6 — uruchom aplikację w przeglądarce

Otwórz adres:

```text
http://localhost/OutOfOffice/public/index.php
```

Jeżeli nazwa folderu jest inna, dostosuj adres.

Przykład:

```text
http://localhost/nazwa-folderu/public/index.php
```

---

## 8. Dane logowania testowego

Po imporcie bazy możesz użyć poniższych kont:

```text
Login: admin
Hasło: admin
Rola: admin
```

```text
Login: HR_Manager
Hasło: HR_Manager
Rola: HR_Manager
```

```text
Login: Project_Manager
Hasło: Project_Manager
Rola: Project_Manager
```

```text
Login: Employee
Hasło: Employee
Rola: Employee
```

Hasła w bazie są zapisane jako hash, a logowanie wykorzystuje:

```php
password_verify()
```

---

## 9. Uprawnienia ról

### Admin

Administrator ma dostęp do wszystkich modułów:

- lista pracowników,
- dodawanie pracowników,
- aktualizacja pracowników,
- usuwanie pracowników,
- lista projektów,
- dodawanie projektów,
- aktualizacja projektów,
- usuwanie projektów,
- dodawanie wniosków urlopowych,
- lista wniosków urlopowych,
- aktualizacja wniosków urlopowych,
- usuwanie wniosków urlopowych,
- dodawanie zatwierdzeń,
- lista zatwierdzeń,
- aktualizacja zatwierdzeń,
- usuwanie zatwierdzeń.

### HR Manager

HR Manager ma dostęp głównie do:

- pracowników,
- listy projektów,
- części zatwierdzeń.

### Project Manager

Project Manager ma dostęp głównie do:

- listy pracowników,
- projektów,
- części zatwierdzeń.

### Employee

Employee ma dostęp głównie do:

- dodania wniosku urlopowego.

---

## 10. Wizualizacja projektu

W katalogu:

```text
Wizualizacja/
```

znajduje się plik:

```text
Screenshots.zip
```

Plik zawiera obrazy pokazujące wygląd aplikacji.

Wizualizacja pokazuje między innymi:

- ekran logowania,
- panel administracyjny,
- kafelki menu,
- widoki list,
- formularze,
- wygląd aplikacji na większym ekranie,
- mobilne widoki accordion.

---

## 11. Jak działa aplikacja

### Logowanie

Użytkownik wpisuje login i hasło.

Aplikacja:

1. sprawdza użytkownika w tabeli `admin`,
2. weryfikuje hasło przez `password_verify()`,
3. zapisuje w sesji:
   - ID użytkownika,
   - login,
   - rolę,
   - status zalogowania,
4. przekierowuje użytkownika do panelu.

---

### Panel menu

Po zalogowaniu użytkownik widzi kafelki zależne od swojej roli.

Menu nie jest budowane na podstawie hasła, tylko na podstawie:

```php
$_SESSION['role']
```

To jest lepsze i bezpieczniejsze rozwiązanie niż sprawdzanie loginu i hasła w menu.

---

### Formularze

Formularze korzystają z osobnych plików JavaScript.

Przykład:

```text
employee-create.js
employee-update.js
employee-delete.js
project-create.js
project-update.js
project-delete.js
```

Dzięki temu jeden formularz nie łapie przypadkowo akcji z innego formularza.

---

### Komunikaty

Aplikacja nie używa zwykłych komunikatów `alert()`.

Komunikaty są wyświetlane estetycznie pod formularzem.

Przykładowe sytuacje:

- brak wymaganych danych,
- błędny login lub hasło,
- poprawne dodanie rekordu,
- błąd podczas zapisu,
- brak dostępu,
- błąd połączenia.

---

### Widoki list

Na komputerze listy są pokazane jako klasyczne tabele.

Na telefonie dane są pokazane jako rozwijane karty accordion.

Dzięki temu aplikacja jest bardziej czytelna na małych ekranach.

---

## 12. Najważniejsze pliki

### `config/db.php`

Odpowiada za połączenie z bazą danych przez PDO.

### `includes/app-security.php`

Zawiera funkcje związane z bezpieczeństwem, sesją, logowaniem i rolami.

### `includes/app-response.php`

Zawiera funkcje do zwracania odpowiedzi JSON.

### `public/index.php`

Formularz logowania.

### `public/menu.php`

Panel administracyjny z menu zależnym od roli.

### `public/logout.php`

Wylogowanie użytkownika.

### `templates/`

Widoki formularzy i list.

### `calculations/`

Pliki wykonujące akcje na bazie danych.

### `js/`

Pliki JavaScript do obsługi formularzy i nawigacji.

### `css/style.css`

Główne style aplikacji.

---

## 13. Typowe problemy i rozwiązania

### Problem: błąd połączenia z bazą danych

Sprawdź plik:

```text
config/db.php
```

Upewnij się, że:

- MySQL jest uruchomiony,
- nazwa bazy danych jest poprawna,
- użytkownik to `root`,
- hasło jest puste, jeżeli używasz standardowego XAMPP.

---

### Problem: strona nie działa pod adresem localhost

Sprawdź, czy projekt znajduje się w:

```text
C:\xampp\htdocs\OutOfOffice
```

i otwierasz:

```text
http://localhost/OutOfOffice/public/index.php
```

---

### Problem: nie działa logowanie

Sprawdź, czy:

- baza `outofoffice` została zaimportowana,
- tabela `admin` istnieje,
- w tabeli `admin` są użytkownicy testowi,
- hasła w bazie są zapisane jako hash,
- plik `db.php` wskazuje właściwą bazę.

---

### Problem: formularz nie zapisuje danych

Sprawdź w konsoli przeglądarki, czy nie ma błędów JavaScript.

Sprawdź również, czy działa odpowiedni plik z katalogu:

```text
calculations/
```

---

### Problem: Bootstrap accordion nie rozwija się na telefonie

Sprawdź, czy w `footer.php` jest załadowany Bootstrap Bundle:

```html
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

Wersja `bundle` jest ważna, ponieważ zawiera obsługę komponentów Bootstrap.

---

## 14. Co pokazuje ten projekt w CV

Ten projekt pokazuje praktyczne umiejętności z zakresu:

- tworzenia aplikacji backendowej w PHP,
- obsługi bazy danych MySQL,
- pracy z PDO,
- tworzenia CRUD,
- obsługi sesji,
- podstawowego systemu ról,
- organizacji plików projektu,
- pracy z formularzami,
- komunikacji JavaScript z PHP,
- obsługi odpowiedzi JSON,
- responsywnego interfejsu,
- podstaw bezpieczeństwa aplikacji.

---

## 15. Propozycja opisu do CV

```text
Out Of Office — PHP Backend Application

Backendowa aplikacja webowa do zarządzania pracownikami, projektami, wnioskami urlopowymi i procesem zatwierdzania. Projekt zawiera logowanie, obsługę sesji, role użytkowników, CRUD, komunikację z bazą MySQL przez PDO, walidację formularzy, odpowiedzi JSON, osobne moduły JavaScript oraz responsywny interfejs Bootstrap z widokiem tabel na desktopie i accordion na urządzeniach mobilnych.
```

---

## 16. Propozycja opisu po angielsku do GitHub / CV

```text
Out Of Office — PHP Backend Application

A backend web application built with PHP and MySQL for managing employees, projects, leave requests and approval workflows. The project includes login, session handling, role-based menu access, CRUD operations, PDO database communication, JSON responses, modular JavaScript files, form validation and a responsive Bootstrap interface with desktop tables and mobile accordion views.
```

---

## 17. Status projektu

Projekt nadaje się do portfolio jako aplikacja typu:

```text
Junior PHP backend project
```

Nie należy przedstawiać go jako gotowego systemu produkcyjnego.

To projekt edukacyjno-portfolio, który pokazuje znajomość podstaw PHP, MySQL, PDO, sesji, CRUD, JS i responsywnego interfejsu.

---

## 18. Dobre kierunki dalszego rozwoju

W przyszłości można dodać:

- routing,
- autoloading Composer,
- strukturę MVC,
- CSRF tokeny,
- panel do zarządzania użytkownikami,
- paginację,
- wyszukiwarkę,
- sortowanie tabel,
- filtrowanie danych,
- logi operacji użytkownika,
- testy jednostkowe,
- Docker,
- plik `.env`,
- migracje bazy danych,
- REST API,
- lepszą obsługę błędów,
- deploy na serwer testowy.

---

## 19. Krótka instrukcja dla rekrutera

1. Uruchom XAMPP.
2. Skopiuj folder projektu do `htdocs`.
3. Utwórz bazę `outofoffice`.
4. Zaimportuj `outofoffice.sql`.
5. Sprawdź dane w `config/db.php`.
6. Wejdź na:

```text
http://localhost/OutOfOffice/public/index.php
```

7. Zaloguj się:

```text
admin / admin
```

---

## 20. Autor

Projekt przygotowany jako portfolio PHP Developer / Junior PHP Developer Sebastian Jan Borowski
Email: borowskisebastjan@gmail.com
Numer: 570 498 678
