-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 01, 2026 at 04:49 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catering`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Chirurgia', 'CHIR', 1, '2026-03-24 10:09:56', '2026-03-24 10:09:56'),
(2, 'Interna', 'INT', 1, '2026-03-24 10:09:56', '2026-03-24 10:09:56'),
(3, 'Pediatria', 'PED', 1, '2026-03-24 10:09:56', '2026-03-24 10:09:56'),
(4, 'Geriatria', 'GER', 1, '2026-03-24 10:09:56', '2026-03-24 10:09:56'),
(5, 'Neurologia', 'NEU', 1, '2026-03-24 10:09:56', '2026-03-24 10:09:56'),
(6, 'Onkologia', 'ONK', 1, '2026-03-24 10:09:56', '2026-03-24 10:09:56');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `diets`
--

CREATE TABLE `diets` (
  `id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `diet_name` varchar(150) NOT NULL,
  `diet_code` varchar(50) NOT NULL,
  `is_special_diet` tinyint(1) NOT NULL DEFAULT 0,
  `diet_restrictions` varchar(255) DEFAULT NULL,
  `diet_description` text DEFAULT NULL,
  `diet_notes` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `diets`
--

INSERT INTO `diets` (`id`, `department_id`, `diet_name`, `diet_code`, `is_special_diet`, `diet_restrictions`, `diet_description`, `diet_notes`, `is_active`, `created_at`, `updated_at`) VALUES
(58, 1, 'Dieta lekkostrawna', 'D1', 0, 'Bez potraw smażonych, bez ostrych przypraw, bez produktów wzdymających', 'Dieta przeznaczona dla pacjentów wymagających łagodnego sposobu żywienia. Posiłki powinny być gotowane, duszone lub pieczone bez dodatku tłuszczu. Należy unikać ciężkostrawnych potraw, smażenia, ostrych przypraw oraz produktów powodujących wzdęcia. Zalecane są lekkie zupy, gotowane warzywa, chude mięso, ryby, ryż, kasza manna oraz pieczywo pszenne.', 'Posiłki podawać regularnie, w mniejszych porcjach. W razie pogorszenia stanu pacjenta dietę skonsultować z dietetykiem.', 0, '2026-06-01 11:45:23', '2026-06-01 11:45:23'),
(61, 3, 'Dieta bezglutenowa', 'D12', 0, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 1, '2026-06-01 11:47:25', '2026-06-01 12:25:43'),
(62, 5, 'Dieta niskosodowa', 'D4', 1, 'Bez dosalania, ograniczona ilość soli, bez produktów wysoko przetworzonych', 'Dieta przeznaczona dla pacjentów z nadciśnieniem tętniczym, chorobami serca lub obrzękami. Należy ograniczyć sól oraz produkty zawierające duże ilości sodu, takie jak wędliny, konserwy, sery dojrzewające, gotowe sosy, zupy instant i słone przekąski. Posiłki powinny być przygotowywane z użyciem ziół i łagodnych przypraw zamiast soli.', 'Kontrolować zawartość soli w posiłkach. Nie podawać dodatkowej soli pacjentowi.', 0, '2026-06-01 11:47:46', '2026-06-01 11:47:46');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `login_codes`
--

CREATE TABLE `login_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_codes`
--

INSERT INTO `login_codes` (`id`, `user_id`, `code_hash`, `expires_at`, `used_at`, `created_at`) VALUES
(88, 10, '$2y$10$eOvUtJk0TE.rKFDQRdr1sevjXg4LfpGyUOsgFS3BI1/uARAytANw6', '2026-06-01 13:48:33', '2026-06-01 13:43:55', '2026-06-01 11:43:33'),
(89, 18, '$2y$10$eVVBinzWuN32LU3AeT6Kce.v8yci4xv6cjzYARxAIqJGzFfAOtF/y', '2026-06-01 15:26:50', '2026-06-01 15:22:20', '2026-06-01 13:21:50'),
(90, 18, '$2y$10$/7Y/1vN5nvRDJ6sv4uYzFuvJlELs3sSZZC8agNYY4s.mtgfhp1DO.', '2026-06-01 15:32:49', '2026-06-01 15:28:12', '2026-06-01 13:27:49'),
(91, 18, '$2y$10$02C9GyOJvkH1eUlyd5g92uZMsskQgumppZyU0wUHcxKmHxguThHFm', '2026-06-01 15:45:45', '2026-06-01 15:41:10', '2026-06-01 13:40:45'),
(92, 18, '$2y$10$gSTOkYkYyNTTqKDYfd2oRuH8AHNP/p67BwZK.pvQOo.syEKokGF/q', '2026-06-01 15:46:57', '2026-06-01 15:42:16', '2026-06-01 13:41:57'),
(94, 18, '$2y$10$djVkug4bpaxxYoeVHFazCOdCh1Rc/GyL5Vy9Y8Ur8jW9/0LUQnXIm', '2026-06-01 16:53:04', '2026-06-01 16:48:50', '2026-06-01 14:48:04');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_diets`
--

CREATE TABLE `order_diets` (
  `id` int(11) NOT NULL,
  `Order_name` varchar(255) NOT NULL,
  `Cod` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Special` varchar(255) NOT NULL,
  `Restrictions` varchar(255) NOT NULL,
  `Describe` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Addtional_describe` varchar(255) NOT NULL,
  `Created_at` datetime DEFAULT current_timestamp(),
  `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `order_diets`
--

INSERT INTO `order_diets` (`id`, `Order_name`, `Cod`, `Department`, `Special`, `Restrictions`, `Describe`, `Quantity`, `Addtional_describe`, `Created_at`, `is_active`) VALUES
(14, 'Dieta bezglutenowa', 'DF223', 'Oddział Geriatryczny', 'Tak', 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1801, 'Porcje należy przygotować w standardowych pojemnikach cateringowych. Dostawa na oddział powinna zostać potwierdzona przez personel dyżurny.', '2026-06-01 14:53:45', 1),
(15, 'Chirurgia', '1233', 'Geriatria', 'Tak', 'Bez', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1112, 'Porcje należy przygotować w standardowych pojemnikach cateringowych. Dostawa na oddział powinna zostać potwierdzona przez personel dyżurny.', '2026-06-01 14:56:10', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `raport_diet`
--

CREATE TABLE `raport_diet` (
  `id` int(10) UNSIGNED NOT NULL,
  `kto` varchar(255) NOT NULL,
  `rodzajOperacji` varchar(255) NOT NULL,
  `nazwaObiektu` varchar(255) DEFAULT NULL,
  `czas` datetime NOT NULL DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `diet_name` varchar(255) DEFAULT NULL,
  `diet_code` varchar(255) DEFAULT NULL,
  `is_special_diet` tinyint(1) NOT NULL DEFAULT 0,
  `diet_restrictions` text DEFAULT NULL,
  `diet_description` text DEFAULT NULL,
  `diet_notes` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raport_diet`
--

INSERT INTO `raport_diet` (`id`, `kto`, `rodzajOperacji`, `nazwaObiektu`, `czas`, `department_id`, `diet_name`, `diet_code`, `is_special_diet`, `diet_restrictions`, `diet_description`, `diet_notes`, `is_active`) VALUES
(8, 'sebastian', 'Dodanie diety', 'Dieta lekkostrawna', '2026-06-01 13:45:23', 1, 'Dieta lekkostrawna', 'D1', 0, 'Bez potraw smażonych, bez ostrych przypraw, bez produktów wzdymających', 'Dieta przeznaczona dla pacjentów wymagających łagodnego sposobu żywienia. Posiłki powinny być gotowane, duszone lub pieczone bez dodatku tłuszczu. Należy unikać ciężkostrawnych potraw, smażenia, ostrych przypraw oraz produktów powodujących wzdęcia. Zalecane są lekkie zupy, gotowane warzywa, chude mięso, ryby, ryż, kasza manna oraz pieczywo pszenne.', 'Posiłki podawać regularnie, w mniejszych porcjach. W razie pogorszenia stanu pacjenta dietę skonsultować z dietetykiem.', 0),
(9, 'sebastian', 'Dodanie diety', 'Dieta cukrzycowa', '2026-06-01 13:46:27', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 0),
(10, 'sebastian', 'Dodanie diety', 'Dieta bezglutenowa', '2026-06-01 13:47:25', 3, 'Dieta bezglutenowa', 'D3', 1, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 0),
(11, 'sebastian', 'Dodanie diety', 'Dieta niskosodowa', '2026-06-01 13:47:46', 5, 'Dieta niskosodowa', 'D4', 1, 'Bez dosalania, ograniczona ilość soli, bez produktów wysoko przetworzonych', 'Dieta przeznaczona dla pacjentów z nadciśnieniem tętniczym, chorobami serca lub obrzękami. Należy ograniczyć sól oraz produkty zawierające duże ilości sodu, takie jak wędliny, konserwy, sery dojrzewające, gotowe sosy, zupy instant i słone przekąski. Posiłki powinny być przygotowywane z użyciem ziół i łagodnych przypraw zamiast soli.', 'Kontrolować zawartość soli w posiłkach. Nie podawać dodatkowej soli pacjentowi.', 0),
(12, 'sebastian', 'Edycja diety', 'Dieta bezglutenowa', '2026-06-01 13:52:42', 3, 'Dieta bezglutenowa', 'D7', 1, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 0),
(13, 'sebastian', 'Edycja diety', 'Dieta bezglutenowa', '2026-06-01 13:53:06', 3, 'Dieta bezglutenowa_D8', 'D8', 1, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 0),
(14, 'sebastian', 'Edycja diety', 'Dieta bezglutenowa_D8', '2026-06-01 13:54:13', 3, 'Dieta bezglutenowa', 'D11', 1, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 0),
(15, 'sebastian', 'Edycja diety', 'Dieta bezglutenowa', '2026-06-01 13:55:02', 3, 'Dieta bezglutenowa', 'D11', 0, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 0),
(16, 'sebastian', 'Edycja diety', 'Dieta bezglutenowa', '2026-06-01 13:56:40', 3, 'Dieta bezglutenowa', 'D12', 0, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 0),
(17, 'sebastian', 'Akceptacja diety', 'Dieta cukrzycowa', '2026-06-01 14:00:36', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(18, 'sebastian', 'Dezaktywacja diety', 'Dieta cukrzycowa', '2026-06-01 14:01:07', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 0),
(19, 'sebastian', 'Akceptacja diety', 'Dieta cukrzycowa', '2026-06-01 14:01:36', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(20, 'sebastian', 'Dezaktywacja diety', 'Dieta cukrzycowa', '2026-06-01 14:01:46', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 0),
(21, 'sebastian', 'Akceptacja diety', 'Dieta cukrzycowa', '2026-06-01 14:21:25', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(22, 'sebastian', 'Dezaktywacja diety', 'Dieta cukrzycowa', '2026-06-01 14:21:29', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 0),
(23, 'sebastian', 'Akceptacja diety', 'Dieta cukrzycowa', '2026-06-01 14:21:32', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(24, 'sebastian', 'Akceptacja diety', 'Dieta cukrzycowa', '2026-06-01 14:23:26', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(25, 'sebastian', 'Dezaktywacja diety', 'Dieta cukrzycowa', '2026-06-01 14:23:28', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 0),
(26, 'sebastian', 'Dezaktywacja diety', 'Dieta cukrzycowa', '2026-06-01 14:23:30', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 0),
(27, 'sebastian', 'Akceptacja diety', 'Dieta cukrzycowa', '2026-06-01 14:23:32', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(28, 'sebastian', 'Akceptacja diety', 'Dieta cukrzycowa', '2026-06-01 14:23:33', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(29, 'sebastian', 'Usunięcie diety', 'Dieta cukrzycowa', '2026-06-01 14:25:18', 5, 'Dieta cukrzycowa', 'D2', 0, 'Bez cukru, ograniczona ilość węglowodanów prostych, kontrolowana ilość owoców', 'Dieta przeznaczona dla pacjentów z cukrzycą. Posiłki powinny mieć kontrolowaną zawartość węglowodanów i być podawane o stałych porach. Należy unikać cukru, słodyczy, słodzonych napojów, białego pieczywa oraz produktów o wysokim indeksie glikemicznym. Zalecane są warzywa, produkty pełnoziarniste, chude białko i zdrowe tłuszcze.', 'Wartość kaloryczna i ilość węglowodanów powinna być dostosowana do zaleceń lekarza lub dietetyka.', 1),
(30, 'sebastian', 'Akceptacja diety', 'Dieta bezglutenowa', '2026-06-01 14:25:43', 3, 'Dieta bezglutenowa', 'D12', 0, 'Bez glutenu, bez pszenicy, żyta, jęczmienia i owsa niecertyfikowanego', 'Dieta przeznaczona dla pacjentów z celiakią lub nietolerancją glutenu. Należy całkowicie wykluczyć produkty zawierające gluten, w tym pieczywo pszenne, makarony pszenne, kaszę mannę oraz produkty panierowane. Zalecane są produkty naturalnie bezglutenowe, takie jak ryż, ziemniaki, kukurydza, kasza gryczana, mięso, ryby, jaja, warzywa i owoce.', 'Należy unikać zanieczyszczenia krzyżowego glutenem podczas przygotowywania i podawania posiłków.', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `raport_logowanie`
--

CREATE TABLE `raport_logowanie` (
  `id` int(10) UNSIGNED NOT NULL,
  `kto` varchar(255) NOT NULL,
  `rodzajOperacji` varchar(255) NOT NULL,
  `czas` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `raport_logowanie`
--

INSERT INTO `raport_logowanie` (`id`, `kto`, `rodzajOperacji`, `czas`) VALUES
(12, 'sebastian', 'Wylogowanie', '2026-06-01 13:43:22'),
(13, 'sebastian', 'logowanie', '2026-06-01 13:43:55'),
(14, 'sebastian', 'Wylogowanie', '2026-06-01 15:21:28'),
(15, 'rekrutacja', 'logowanie', '2026-06-01 15:22:20'),
(16, 'rekrutacja', 'Wylogowanie', '2026-06-01 15:26:40'),
(17, 'rekrutacja', 'logowanie', '2026-06-01 15:28:12'),
(18, 'rekrutacja', 'Wylogowanie', '2026-06-01 15:39:51'),
(19, 'rekrutacja', 'logowanie', '2026-06-01 15:41:10'),
(20, 'rekrutacja', 'Wylogowanie', '2026-06-01 15:41:45'),
(21, 'rekrutacja', 'logowanie', '2026-06-01 15:42:16'),
(22, 'rekrutacja', 'Wylogowanie', '2026-06-01 16:46:57'),
(23, 'rekrutacja', 'logowanie', '2026-06-01 16:48:50');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `raport_orders`
--

CREATE TABLE `raport_orders` (
  `id` int(11) NOT NULL,
  `Who` varchar(255) NOT NULL,
  `Type_operation` varchar(255) NOT NULL,
  `Created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `Name` varchar(255) NOT NULL,
  `Department_id` varchar(255) NOT NULL,
  `Order_name` varchar(255) NOT NULL,
  `Order_code` varchar(255) NOT NULL,
  `Is_special` int(11) NOT NULL,
  `Order_restrictions` varchar(255) NOT NULL,
  `Order_description` varchar(255) NOT NULL,
  `Is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `raport_orders`
--

INSERT INTO `raport_orders` (`id`, `Who`, `Type_operation`, `Created_at`, `Name`, `Department_id`, `Order_name`, `Order_code`, `Is_special`, `Order_restrictions`, `Order_description`, `Is_active`) VALUES
(24, 'sebastian', 'Dodanie zamówienia', '2026-06-01 14:52:17', 'Dieta niskosodowa', '2', 'Dieta niskosodowa', 'ZamD1', 1, 'Bez laktozy, bez glutenu, ograniczona ilość soli', 'Zamówienie obejmuje przygotowanie posiłków dla pacjentów wymagających diety niskosodowej. Posiłki powinny być przygotowane bez dosalania, z ograniczeniem produktów wysoko przetworzonych, konserw, wędlin oraz słonych przekąsek.', 0),
(25, 'sebastian', 'Dodanie zamówienia', '2026-06-01 14:53:45', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'ZamD55', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 0),
(26, 'sebastian', 'Akceptacja zamówienia', '2026-06-01 14:54:03', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'ZamD55', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1),
(27, 'sebastian', 'Akceptacja zamówienia', '2026-06-01 14:54:05', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'ZamD55', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1),
(28, 'sebastian', 'Brak akceptacji zamówienia', '2026-06-01 14:54:06', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'ZamD55', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 0),
(29, 'sebastian', 'Brak akceptacji zamówienia', '2026-06-01 14:54:08', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'ZamD55', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 0),
(30, 'sebastian', 'Akceptacja zamówienia', '2026-06-01 14:54:09', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'ZamD55', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1),
(31, 'sebastian', 'Edycja zamówienia', '2026-06-01 14:54:19', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'ZamD5556', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1),
(32, 'sebastian', 'Edycja zamówienia', '2026-06-01 14:55:02', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'DF223', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1),
(33, 'sebastian', 'Akceptacja zamówienia', '2026-06-01 14:55:12', 'Dieta bezglutenowa', '4', 'Dieta bezglutenowa', 'DF223', 1, 'Bez ostrych przypraw, bez potraw smażonych', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 1),
(34, 'sebastian', 'Usunięcie zamówienia', '2026-06-01 14:55:23', 'ZamD1', '2', 'Dieta niskosodowa', 'ZamD1', 1, 'Bez laktozy, bez glutenu, ograniczona ilość soli', 'Zamówienie obejmuje przygotowanie posiłków dla pacjentów wymagających diety niskosodowej. Posiłki powinny być przygotowane bez dosalania, z ograniczeniem produktów wysoko przetworzonych, konserw, wędlin oraz słonych przekąsek.', 0),
(35, 'sebastian', 'Dodanie zamówienia', '2026-06-01 14:56:10', 'Chirurgia', '4', 'Chirurgia', '1233', 1, 'Bez', 'Zamówienie dotyczy przygotowania lekkostrawnych posiłków dla pacjentów po zabiegach chirurgicznych. Dania powinny być gotowane, duszone lub pieczone bez dodatku dużej ilości tłuszczu. Należy unikać produktów ciężkostrawnych i wzdymających.', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `raport_users`
--

CREATE TABLE `raport_users` (
  `id` int(11) NOT NULL,
  `kto` varchar(255) NOT NULL,
  `rodzajOperacji` varchar(255) NOT NULL,
  `nazwaObiektu` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `imie` varchar(255) NOT NULL,
  `nazwisko` varchar(255) NOT NULL,
  `rola` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `raport_users`
--

INSERT INTO `raport_users` (`id`, `kto`, `rodzajOperacji`, `nazwaObiektu`, `login`, `imie`, `nazwisko`, `rola`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'sebastian', 'Dodanie nowego użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 0, '2026-06-01 14:32:22', '2026-06-01 14:32:22'),
(6, 'sebastian', 'Akceptacja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 1, '2026-06-01 14:32:22', '2026-06-01 14:32:51'),
(7, 'sebastian', 'Akceptacja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 1, '2026-06-01 14:32:22', '2026-06-01 14:32:53'),
(8, 'sebastian', 'Dezaktywacja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 0, '2026-06-01 14:32:22', '2026-06-01 14:32:55'),
(9, 'sebastian', 'Dezaktywacja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 0, '2026-06-01 14:32:22', '2026-06-01 14:32:57'),
(10, 'sebastian', 'Dezaktywacja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 0, '2026-06-01 14:32:22', '2026-06-01 14:32:59'),
(11, 'sebastian', 'Akceptacja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 1, '2026-06-01 14:32:22', '2026-06-01 14:33:00'),
(12, 'sebastian', 'Dodanie nowego użytkownika', 'boro', 'boro', 'borowskisebastjan@gmail.com', 'Borowski', 2, 'olciabot@wp.pl', 0, '2026-06-01 14:50:24', '2026-06-01 14:50:24'),
(13, 'sebastian', 'Usunięcie użytkownika', 'boro', 'boro', 'borowskisebastjan@gmail.com', 'Borowski', 2, 'olciabot@wp.pl', 0, '2026-06-01 14:50:24', '2026-06-01 14:50:32'),
(14, 'rekrutacja', 'Edycja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 3, 'kateringtest5@gmail.com', 0, '2026-06-01 14:32:22', '2026-06-01 15:39:44'),
(15, 'rekrutacja', 'Edycja użytkownika', 'rekrutacja', 'rekrutacja', 'Admin', 'Borowski', 1, 'kateringtest5@gmail.com', 0, '2026-06-01 14:32:22', '2026-06-01 15:41:42');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `surname`, `role`, `password`, `email`, `is_active`, `created_at`, `updated_at`) VALUES
(10, 'sebastian', 'sebastian', 'borowski', '1', '$2y$10$/63vPXzR4W5v3.dOQSy0F.QWt9nQBWTpmY7DyQ6SuPcMWT6EdJSl2', 'borowskisebastjan@gmail.com', 1, '2026-03-23 13:18:54', '2026-05-29 15:36:37'),
(18, 'rekrutacja', 'Admin', 'Borowski', '1', '$2y$10$dUh726.5cMegPaXgcsMD0ulCFTCh6bTo4Wl4iVj8x9FApjyqbCKom', 'kateringtest5@gmail.com', 1, '2026-06-01 12:32:22', '2026-06-01 13:41:42');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `diets`
--
ALTER TABLE `diets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_diet_code` (`diet_code`),
  ADD KEY `fk_diets_department` (`department_id`);

--
-- Indeksy dla tabeli `login_codes`
--
ALTER TABLE `login_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_login_codes_user_id` (`user_id`),
  ADD KEY `idx_login_codes_expires_at` (`expires_at`);

--
-- Indeksy dla tabeli `order_diets`
--
ALTER TABLE `order_diets`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `raport_diet`
--
ALTER TABLE `raport_diet`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `raport_logowanie`
--
ALTER TABLE `raport_logowanie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `raport_orders`
--
ALTER TABLE `raport_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `raport_users`
--
ALTER TABLE `raport_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_users_login` (`login`),
  ADD UNIQUE KEY `uniq_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `diets`
--
ALTER TABLE `diets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `login_codes`
--
ALTER TABLE `login_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `order_diets`
--
ALTER TABLE `order_diets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `raport_diet`
--
ALTER TABLE `raport_diet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `raport_logowanie`
--
ALTER TABLE `raport_logowanie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `raport_orders`
--
ALTER TABLE `raport_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `raport_users`
--
ALTER TABLE `raport_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diets`
--
ALTER TABLE `diets`
  ADD CONSTRAINT `fk_diets_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `login_codes`
--
ALTER TABLE `login_codes`
  ADD CONSTRAINT `fk_login_codes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
