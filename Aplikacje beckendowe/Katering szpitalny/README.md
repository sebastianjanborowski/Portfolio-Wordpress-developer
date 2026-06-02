# System backendowy do zarządzania cateringiem szpitalnym

## 1. Opis projektu

**System backendowy do zarządzania cateringiem szpitalnym** to aplikacja administracyjna napisana w PHP, służąca do obsługi użytkowników, diet, zamówień cateringowych oraz raportów operacji wykonywanych w systemie.

Projekt został przygotowany jako aplikacja portfolio/CV dla stanowiska **PHP Developer / Junior PHP Developer**. Pokazuje praktyczne użycie PHP, MySQL, PDO, sesji, logowania z 2FA, PHPMailer, JavaScript Fetch API, Bootstrap oraz generowania raportów.

Aplikacja działa lokalnie na środowisku typu **XAMPP**.

---

## 2. Najważniejsze możliwości aplikacji

Aplikacja posiada następujące moduły:

### Logowanie i bezpieczeństwo

- logowanie użytkownika przez login i hasło,
- hasła użytkowników zapisane w bazie jako hash,
- weryfikacja hasła przez `password_verify()`,
- dodatkowa weryfikacja 2FA przez kod e-mail,
- kod 2FA ważny przez określony czas,
- obsługa sesji PHP,
- blokowanie dostępu do panelu bez zalogowania,
- role użytkowników zapisane w bazie danych.

### Panel główny

Po zalogowaniu użytkownik trafia do panelu administracyjnego. Panel pozwala przejść do głównych sekcji:

- Zamówienia,
- Posiłki / diety,
- Użytkownicy,
- Raporty,
- Wylogowanie.

### Użytkownicy

Moduł użytkowników pozwala na:

- wyświetlanie listy użytkowników,
- dodawanie użytkownika,
- edycję danych użytkownika,
- akceptację / aktywację konta,
- usuwanie użytkownika,
- przypisanie roli,
- zapis operacji do raportu użytkowników.

### Diety / posiłki

Moduł diet pozwala na:

- wyświetlanie listy diet,
- dodawanie nowej diety,
- edycję diety,
- akceptację diety,
- usuwanie diety,
- oznaczenie diety jako specjalnej,
- zapis ograniczeń i alergenów,
- zapis opisu oraz notatek,
- raportowanie operacji na dietach.

### Zamówienia

Moduł zamówień pozwala na:

- wyświetlanie listy zamówień,
- dodawanie nowego zamówienia,
- edycję zamówienia,
- akceptację zamówienia,
- usuwanie zamówienia,
- przypisanie zamówienia do oddziału,
- określenie liczby porcji,
- oznaczenie zamówienia jako specjalnego,
- zapis ograniczeń, alergenów, opisu i uwag,
- raportowanie operacji na zamówieniach.

### Raporty

Aplikacja zapisuje historię wybranych operacji wykonywanych w systemie.

Dostępne raporty:

- raport logowania użytkowników,
- raport użytkowników,
- raport diet,
- raport zamówień.

Raporty umożliwiają sprawdzenie:

- kto wykonał operację,
- kiedy wykonano operację,
- jakiego typu była operacja,
- jakiego obiektu dotyczyła operacja,
- jaki był status danych.

Aplikacja posiada również widoki raportów oraz możliwość generowania raportów do plików.

### Wizualizacja aplikacji

W projekcie znajduje się folder:

```text
Wizualizacja/
```

W folderze jest plik:

```text
Screenshots.zip
```

Zawiera on zrzuty ekranu pokazujące wygląd aplikacji. Podczas prezentacji projektu można użyć tych obrazów jako szybkiej wizualizacji działania systemu.

---

## 3. Technologie użyte w projekcie

Projekt wykorzystuje:

- PHP,
- MySQL / MariaDB,
- PDO,
- JavaScript,
- Fetch API,
- JSON,
- HTML5,
- CSS3,
- Bootstrap,
- Bootstrap Icons,
- PHPMailer,
- jsPDF,
- jsPDF AutoTable,
- sesje PHP.

---

## 4. Struktura projektu

Najważniejsze katalogi i pliki:

```text
index.php
catering.sql
instrukcja.txt

assets/
  css/
    style.css
  js/
    logowanie/
    rejestracjaDiety/
    rejestracjaZamowienia/
    rejestracjaUzytkownika/
    edycjaDiety/
    edycjaZamowienia/
    edycjaUzytkownika/
    akceptacjaDiety/
    akceptacjaZamowienia/
    akceptacjaKonta/
    kasowanieDiet/
    kasowanieZamowienia/
    kasowanieUzytkownika/
    generacjaRaportu_js/

core/
  config/
    config.php
    db.php
    mail.php
  logowanie/
    login.php
    verify-code.php
  mail/
    sendEmail.php
  dodawanieDiet/
  dodawanieZamowien/
  rejestracjaUzytkownika/
  edycjaDiety/
  edycjaZamowien/
  edycjaUzytkownika/
  akceptacjaDiet/
  akceptacjaZamowien/
  akceptacjaKonta/
  kasowanieDiet/
  kasowanieZamowien/
  kasowanieUzytkownikow/
  generowanieRaportow/
  generowanieRaportuCSV/
  wylogowywanie/

window/
  login.php
  2fa.php
  dashboard.php
  dashboard_orders.php
  dashboard_diet.php
  dashboard_users.php
  dashboard_raport.php
  add_orders.php
  add_diet.php
  add_user.php
  edit_order.php
  edit_diet.php
  edit_user.php
  delete_order.php
  delete_diet.php
  delete_user.php
  view_orders.php
  view_diet.php
  view_users.php
  show_raport_orders.php
  show_raport_diets.php
  show_raport_logged.php
  show_raport_users.php

template/
  header.php
  footer.php

lib/
  PHPMailer-master/

Wizualizacja/
  Screenshots.zip
```

---

## 5. Wymagania do uruchomienia

Do uruchomienia projektu lokalnie potrzebne są:

- XAMPP,
- Apache,
- MySQL / MariaDB,
- PHP 8.x,
- przeglądarka internetowa,
- phpMyAdmin,
- dostęp do konta e-mail SMTP, jeżeli ma działać pełna weryfikacja 2FA.

---

## 6. Instrukcja instalacji lokalnej

### Krok 1. Uruchom XAMPP

W panelu XAMPP uruchom:

```text
Apache
MySQL
```

---

### Krok 2. Skopiuj pliki projektu

Projekt jest przygotowany do działania bezpośrednio z katalogu głównego serwera XAMPP.

Pliki projektu należy wkleić bezpośrednio do:

```text
C:\xampp\htdocs
```

Poprawnie:

```text
C:\xampp\htdocs\index.php
C:\xampp\htdocs\window\login.php
C:\xampp\htdocs\window\dashboard.php
C:\xampp\htdocs\core\config\db.php
C:\xampp\htdocs\assets\css\style.css
```

Niepoprawnie:

```text
C:\xampp\htdocs\katering\index.php
```

Aplikacja używa ścieżek zaczynających się od `/assets/...` i `/core/...`, dlatego najprostsza konfiguracja lokalna zakłada uruchomienie projektu bez dodatkowego folderu.

---

### Krok 3. Utwórz bazę danych

Wejdź w przeglądarce na:

```text
http://localhost/phpmyadmin
```

Utwórz bazę danych o nazwie:

```text
catering
```

Kodowanie bazy najlepiej ustawić jako:

```text
utf8mb4_unicode_ci
```

---

### Krok 4. Zaimportuj pełną kopię bazy danych

W projekcie znajduje się plik:

```text
catering.sql
```

To pełna kopia bazy danych aplikacji.

W phpMyAdmin:

1. Wybierz bazę `catering`.
2. Przejdź do zakładki **Import**.
3. Wybierz plik `catering.sql`.
4. Kliknij **Wykonaj** / **Importuj**.

Po imporcie powinny pojawić się między innymi tabele:

```text
users
departments
diets
order_diets
login_codes
raport_logowanie
raport_users
raport_diet
raport_orders
```

---

### Krok 5. Sprawdź konfigurację bazy danych

Otwórz plik:

```text
core/config/config.php
```

Domyślna konfiguracja dla XAMPP:

```php
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'catering',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ]
];
```

Jeżeli używasz standardowego XAMPP, zwykle nie trzeba nic zmieniać.

---

### Krok 6. Sprawdź konfigurację wysyłki e-mail

Aplikacja wysyła kod 2FA przez PHPMailer.

Konfiguracja SMTP znajduje się w pliku:

```text
core/config/mail.php
```

W tym pliku należy ustawić:

- host SMTP,
- port SMTP,
- login do skrzynki,
- hasło aplikacji SMTP,
- adres nadawcy,
- nazwę nadawcy.

Dla Gmaila zwykle potrzebne jest **hasło aplikacji**, a nie zwykłe hasło do konta Google.

Ważne: jeżeli projekt będzie wrzucany na GitHub, nie publikuj prawdziwych danych SMTP. Przed publikacją usuń hasło z `mail.php` albo zastąp je przykładową wartością.

Przykład bezpiecznej wersji do repozytorium:

```php
return [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'twoj-email@gmail.com',
    'password' => 'TUTAJ_HASLO_APLIKACJI',
    'encryption' => 'tls',
    'from_email' => 'twoj-email@gmail.com',
    'from_name' => 'Katering Szpitalny',
];
```

---

### Krok 7. Uruchom aplikację

Po uruchomieniu Apache i MySQL wejdź na:

```text
http://localhost/
```

System automatycznie przekieruje Cię do logowania albo do panelu, jeżeli sesja jest już aktywna.

---

## 7. Dane logowania do aplikacji

Dane testowego użytkownika w aplikacji:

```text
Login: rekrutacja
Hasło: KateringTest123
```

Po wpisaniu loginu i hasła aplikacja wyśle kod 2FA na adres e-mail przypisany do użytkownika w tabeli `users`.

W bazie testowej użytkownik `rekrutacja` ma przypisany adres:

```text
kateringtest5@gmail.com
```

Podczas prezentacji aplikacji trzeba mieć dostęp do tej skrzynki albo zmienić adres e-mail użytkownika w bazie danych na własny adres testowy.

Nie zalecam publikowania hasła do skrzynki e-mail w publicznym README na GitHubie. Jeżeli projekt pokazujesz rekruterowi, przekaż dane do skrzynki osobno albo zademonstruj logowanie podczas rozmowy.

---

## 8. Jak zalogować się krok po kroku

1. Wejdź na:

```text
http://localhost/
```

2. Aplikacja przekieruje Cię na stronę logowania.

3. Wpisz dane:

```text
Login: rekrutacja
Hasło: KateringTest123
```

4. Kliknij przycisk logowania.

5. Aplikacja wyśle sześciocyfrowy kod 2FA na adres e-mail przypisany do konta.

6. Otwórz skrzynkę e-mail i skopiuj kod.

7. Wpisz kod w formularzu 2FA.

8. Po poprawnej weryfikacji zostaniesz przeniesiony do panelu głównego aplikacji.

---

## 9. Role i dostęp do modułów

Aplikacja wykorzystuje kolumnę `role` w tabeli `users`.

W aktualnej wersji role są zapisane liczbowo.

Przykładowa logika dostępu w panelu:

```text
Rola 1: pełny dostęp administracyjny
Rola 2: dostęp do zamówień, diet, użytkowników i raportów
Rola 3: dostęp do użytkowników i raportów
```

Zakres widocznych kafelków w panelu zależy od wartości zapisanej w sesji po logowaniu.

---

## 10. Jak najlepiej zaprezentować projekt rekruterowi

Proponowana kolejność prezentacji:

1. Pokaż ekran logowania.
2. Wyjaśnij, że aplikacja używa hashowania haseł i `password_verify()`.
3. Zaloguj się na konto testowe.
4. Pokaż działanie 2FA przez e-mail.
5. Pokaż panel główny i podział na moduły.
6. Pokaż moduł zamówień:
   - lista,
   - dodawanie,
   - edycja,
   - akceptacja,
   - usuwanie.
7. Pokaż moduł diet:
   - lista,
   - dodawanie,
   - edycja,
   - akceptacja,
   - usuwanie.
8. Pokaż moduł użytkowników:
   - lista,
   - dodawanie,
   - edycja,
   - aktywacja,
   - usuwanie.
9. Pokaż raporty:
   - raport logowania,
   - raport użytkowników,
   - raport diet,
   - raport zamówień.
10. Pokaż eksport raportu.
11. Pokaż responsywny wygląd aplikacji na mniejszym ekranie.
12. Na końcu wyjaśnij strukturę projektu: `window`, `core`, `assets`, `template`, `lib`.

---

## 11. Co warto powiedzieć o projekcie w CV

Propozycja opisu do CV:

```text
System backendowy do zarządzania cateringiem szpitalnym

Aplikacja administracyjna napisana w PHP i MySQL do zarządzania użytkownikami, dietami, zamówieniami oraz raportami. Projekt zawiera logowanie z weryfikacją 2FA przez e-mail, obsługę sesji, hashowanie haseł, komunikację z bazą przez PDO, operacje CRUD, JavaScript Fetch API, odpowiedzi JSON, Bootstrap UI oraz generowanie raportów.
```

Krótsza wersja:

```text
PHP/MySQL backend application for hospital catering management. Implemented CRUD modules for users, diets and orders, session-based login, e-mail 2FA, PDO database access, Fetch API communication, reporting and responsive Bootstrap UI.
```

---

## 12. Co warto powiedzieć technicznie podczas rozmowy

Najważniejsze punkty techniczne:

- formularze nie wysyłają danych klasycznie, tylko przez JavaScript Fetch API,
- backend zwraca odpowiedzi JSON,
- połączenie z bazą działa przez PDO,
- hasła są weryfikowane przez `password_verify()`,
- kody 2FA są zapisywane jako hash,
- sesja przechowuje informację o zalogowanym użytkowniku,
- panel pokazuje moduły zależnie od roli,
- operacje są zapisywane do tabel raportowych,
- raporty można oglądać w aplikacji i generować do plików,
- PHPMailer obsługuje wysyłkę kodów e-mail.

---

## 13. Najczęstsze problemy podczas uruchamiania

### Problem: aplikacja pokazuje 404 albo nie ładują się style / JS

Najczęstsza przyczyna: projekt został włożony do dodatkowego folderu, np.:

```text
C:\xampp\htdocs\katering\
```

Najprostsze rozwiązanie: przenieś pliki bezpośrednio do:

```text
C:\xampp\htdocs\
```

---

### Problem: nie działa połączenie z bazą danych

Sprawdź:

- czy MySQL działa w XAMPP,
- czy baza nazywa się `catering`,
- czy zaimportowano `catering.sql`,
- czy dane w `core/config/config.php` są poprawne.

---

### Problem: kod 2FA nie przychodzi na e-mail

Sprawdź:

- czy w `core/config/mail.php` są poprawne dane SMTP,
- czy konto e-mail pozwala na wysyłkę przez SMTP,
- czy dla Gmaila użyto hasła aplikacji,
- czy użytkownik w tabeli `users` ma poprawny adres e-mail,
- czy połączenie internetowe działa.

---

### Problem: logowanie nie działa mimo poprawnego hasła

Sprawdź:

- czy zaimportowano właściwy plik `catering.sql`,
- czy użytkownik `rekrutacja` istnieje w tabeli `users`,
- czy konto ma `is_active = 1`,
- czy hasło w bazie jest hashem zgodnym z `password_verify()`.

---

## 14. Ważna informacja przed publikacją na GitHub

Przed wrzuceniem projektu do publicznego repozytorium należy koniecznie usunąć lub zamienić prywatne dane dostępowe.

Szczególnie sprawdź plik:

```text
core/config/mail.php
```

Nie publikuj:

- hasła do skrzynki e-mail,
- hasła aplikacji Gmail,
- prywatnego adresu SMTP,
- danych produkcyjnej bazy danych.

Profesjonalnie najlepiej dodać plik przykładowy:

```text
core/config/mail.example.php
```

A prawdziwy plik `mail.php` dodać do `.gitignore`.

---

## 15. Status projektu

Projekt jest dobrym materiałem do portfolio na stanowisko Junior PHP Developer, ponieważ pokazuje realne elementy aplikacji backendowej:

- logowanie,
- 2FA,
- sesje,
- role,
- CRUD,
- raportowanie,
- PDO,
- JSON,
- Fetch API,
- Bootstrap,
- strukturę katalogów,
- pracę z bazą danych.

Projekt należy prezentować jako aplikację demonstracyjną / portfolio, a nie jako gotowy system produkcyjny dla szpitala.

---

## 16. Autor

Projekt przygotowany jako aplikacja portfolio/CV pokazująca umiejętności z zakresu PHP, MySQL, JavaScript i tworzenia paneli administracyjnych.
