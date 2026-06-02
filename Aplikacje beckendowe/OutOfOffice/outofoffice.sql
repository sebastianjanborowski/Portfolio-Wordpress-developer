-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 02, 2026 at 11:27 AM
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
-- Database: `outofoffice`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `login`, `password`, `role`) VALUES
(5, 'admin', '$2y$12$lXoUH5xImcHr9m3amMAiJ.AuohT9nvFQ2PuFSZg2vJdLs35LJEQJS', 'admin'),
(6, 'HR_Manager', '$2y$12$9NYFmNpwjUr.VjHt1Zl8MeEH.0JSTvwpQwRBn/Puuc9SNVcGfpsfG', 'HR_Manager'),
(7, 'Project_Manager', '$2y$12$wyyeJuPFBkdNc7ZVr0.s1.Us.VEWS5Yvao6eTzDLIYum2RX1Znf.K', 'Project_Manager'),
(8, 'Employee', '$2y$12$.fy9HBL9IoZc4dqfzOrQkeHoBXoC4YMNwEQEq4LO5ji/0MXmTgGf2', 'Employee');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `approval_request`
--

CREATE TABLE `approval_request` (
  `ID` int(11) NOT NULL,
  `Approver` int(11) NOT NULL,
  `Leave_Request` int(11) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `approval_request`
--

INSERT INTO `approval_request` (`ID`, `Approver`, `Leave_Request`, `Status`, `Comment`) VALUES
(3, 1, 1, 'Zaakceptowano', 'Wniosek zaakceptowany. Pracownik może wykorzystać urlop w podanym terminie.'),
(4, 2, 2, 'Do akceptacji', 'Wniosek oczekuje na sprawdzenie przez osobę zatwierdzającą.'),
(5, 3, 3, 'Odrzucono', 'Termin koliduje z ważnym etapem projektu. Proszę wybrać inny zakres dat.'),
(6, 4, 4, 'Zaakceptowano', 'Nieobecność jednodniowa została zatwierdzona.'),
(7, 5, 5, 'Do akceptacji', 'Wymagana dodatkowa weryfikacja dostępności zespołu.'),
(8, 6, 6, 'Zaakceptowano', 'Urlop zaakceptowany po zakończeniu aktualnego zadania.'),
(9, 7, 7, 'Odrzucono', 'Brak możliwości zatwierdzenia w tym terminie ze względu na obciążenie działu.'),
(10, 8, 8, 'Do akceptacji', 'Wniosek świąteczny oczekuje na decyzję kierownika.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `Full_Name` varchar(255) NOT NULL,
  `Subdivision` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `People_Partner` int(11) DEFAULT NULL,
  `Out_of_Balance` decimal(6,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`ID`, `Full_Name`, `Subdivision`, `Position`, `Status`, `People_Partner`, `Out_of_Balance`) VALUES
(1, 'Jan Kowalski', 'Dział IT', 'Programista PHP', 'Aktywny', 101, 0.00),
(2, 'Anna Nowak', 'Dział HR', 'Specjalista ds. kadr', 'Aktywny', 102, 0.00),
(3, 'Piotr Wiśniewski', 'Dział Projektów', 'Kierownik projektu', 'Aktywny', 103, 0.00),
(4, 'Katarzyna Zielińska', 'Dział Finansowy', 'Księgowa', 'Aktywny', 102, 0.00),
(5, 'Michał Lewandowski', 'Dział Sprzedaży', 'Specjalista ds. sprzedaży', 'Nieaktywny', 101, 0.00),
(6, 'Agnieszka Wójcik', 'Dział Administracji', 'Asystentka biura', 'Aktywny', 104, 0.00),
(7, 'Tomasz Kamiński', 'Dział IT', 'Administrator systemów', 'Aktywny', 101, 0.00),
(8, 'Magdalena Dąbrowska', 'Dział Marketingu', 'Specjalista ds. marketingu', 'Aktywny', 105, 0.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `leave_request`
--

CREATE TABLE `leave_request` (
  `ID` int(11) NOT NULL,
  `Employee` int(11) NOT NULL,
  `Absense_Reason` varchar(255) NOT NULL,
  `Start_Date` date NOT NULL,
  `End_Date` date NOT NULL,
  `Comment` text DEFAULT NULL,
  `Status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `leave_request`
--

INSERT INTO `leave_request` (`ID`, `Employee`, `Absense_Reason`, `Start_Date`, `End_Date`, `Comment`, `Status`) VALUES
(2, 1, 'Wyjazd z rodziną nad morze', '2026-06-04', '2026-06-25', 'Brak', 'Do akceptacji'),
(3, 2, 'Urlop wypoczynkowy', '2026-07-01', '2026-07-14', 'Planowany urlop letni.', 'Zaakceptowany'),
(4, 3, 'Sprawy rodzinne', '2026-05-10', '2026-05-12', 'Krótka nieobecność prywatna.', 'Do akceptacji'),
(5, 4, 'Wizyta lekarska', '2026-04-18', '2026-04-18', 'Nieobecność jednodniowa.', 'Zaakceptowany'),
(6, 5, 'Urlop okolicznościowy', '2026-08-20', '2026-08-21', 'Ważna uroczystość rodzinna.', 'Do akceptacji'),
(7, 6, 'Odpoczynek po projekcie', '2026-09-02', '2026-09-09', 'Urlop po zakończeniu dużego zadania.', 'Zaakceptowany'),
(8, 7, 'Wyjazd prywatny', '2026-10-05', '2026-10-11', 'Wyjazd poza miejsce zamieszkania.', 'Odrzucony');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `project`
--

CREATE TABLE `project` (
  `ID` int(11) NOT NULL,
  `Project_Type` varchar(255) NOT NULL,
  `Start_Date` date NOT NULL,
  `End_Date` date NOT NULL,
  `Project_Manager` int(11) NOT NULL,
  `Comment` text DEFAULT NULL,
  `Status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ID`, `Project_Type`, `Start_Date`, `End_Date`, `Project_Manager`, `Comment`, `Status`) VALUES
(1, 'Holistic Beauty', '2026-02-26', '2026-06-18', 6, 'Projekt strony internetowej dla branży beauty.', 'W trakcie'),
(2, 'Katering Szpitalny', '2026-03-01', '2026-07-15', 3, 'Aplikacja backendowa do zarządzania zamówieniami diet.', 'W trakcie'),
(3, 'Out Of Office', '2026-01-10', '2026-04-30', 5, 'System zarządzania pracownikami, projektami i wnioskami urlopowymi.', 'Zakończony'),
(4, 'Panel administracyjny HR', '2026-04-05', '2026-08-20', 2, 'Moduł dla działu HR do obsługi pracowników.', 'Planowany'),
(5, 'System rekrutacyjny', '2026-05-12', '2026-09-30', 4, 'Aplikacja do obsługi kandydatów i etapów rekrutacji.', 'W trakcie'),
(6, 'Sklep internetowy WordPress', '2026-02-01', '2026-05-25', 7, 'Motyw WordPress z obsługą WooCommerce.', 'Zakończony'),
(7, 'Raporty sprzedażowe', '2026-06-01', '2026-10-10', 1, 'Panel raportowania sprzedaży i aktywności użytkowników.', 'Planowany'),
(8, 'Modernizacja aplikacji PHP', '2026-03-15', '2026-06-30', 6, 'Redesign backendu, poprawa responsywności i walidacji formularzy.', 'W trakcie');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indeksy dla tabeli `approval_request`
--
ALTER TABLE `approval_request`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `leave_request`
--
ALTER TABLE `leave_request`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `approval_request`
--
ALTER TABLE `approval_request`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `leave_request`
--
ALTER TABLE `leave_request`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
