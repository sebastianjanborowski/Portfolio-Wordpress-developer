-- =========================================================
-- HRD - Host Ready Domains
-- Pełny dump bazy danych dla aplikacji PHP + MySQL
-- Baza: hrd
--
-- Konta testowe:
-- admin / admin
-- demo  / demo123
-- =========================================================

CREATE DATABASE IF NOT EXISTS `hrd`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `hrd`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `domain_searches`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(80) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(40) NOT NULL DEFAULT 'user',
  `full_name` VARCHAR(160) NOT NULL,
  `email` VARCHAR(160) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `domain_searches` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NULL,
  `domain` VARCHAR(253) NOT NULL,
  `status` VARCHAR(120) NOT NULL,
  `message` TEXT NOT NULL,
  `recommendation` TEXT NULL,
  `dns_a` TINYINT(1) NOT NULL DEFAULT 0,
  `dns_aaaa` TINYINT(1) NOT NULL DEFAULT 0,
  `dns_mx` TINYINT(1) NOT NULL DEFAULT 0,
  `dns_ns` TINYINT(1) NOT NULL DEFAULT 0,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_domain_searches_user_id` (`user_id`),
  KEY `idx_domain_searches_domain` (`domain`),
  KEY `idx_domain_searches_created_at` (`created_at`),
  CONSTRAINT `fk_domain_searches_user`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Hasła są zapisane jako password_hash().
-- admin  => admin
-- demo   => demo123
INSERT INTO `users` (`id`, `username`, `password_hash`, `role`, `full_name`, `email`, `is_active`, `created_at`) VALUES
(1, 'admin', '$2y$12$ybg9diF6ErUZvIlKP0qIfuIu4gQV6xifqR.0gej08oW9dpnfUAlMK', 'admin', 'Administrator systemu', 'admin@example.local', 1, NOW()),
(2, 'demo', '$2y$12$Vq56FuKLzetatYZdMPtUzO8ZcTZCiokCto.h5kRMHQFiju76rHypa', 'user', 'Użytkownik demonstracyjny', 'demo@example.local', 1, NOW());

INSERT INTO `domain_searches`
(`user_id`, `domain`, `status`, `message`, `recommendation`, `dns_a`, `dns_aaaa`, `dns_mx`, `dns_ns`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 'google.pl', 'Aktywna / prawdopodobnie zajęta', 'Domena posiada aktywne rekordy DNS: A, AAAA, MX, NS. Oznacza to, że prawdopodobnie jest już używana lub skonfigurowana.', 'Jeżeli chcesz kupić tę domenę, sprawdź ją dodatkowo u rejestratora albo przez WHOIS.', 1, 1, 1, 1, '127.0.0.1', 'Demo browser', NOW()),
(1, 'portfolio-php-demo.pl', 'Brak aktywnych DNS / możliwa dostępność', 'Nie znaleziono podstawowych rekordów DNS dla tej domeny. Domena może być wolna, ale nie jest to pełna gwarancja dostępności.', 'Potwierdź dostępność domeny u rejestratora, ponieważ brak DNS nie zawsze oznacza, że domena jest wolna.', 0, 0, 0, 0, '127.0.0.1', 'Demo browser', NOW()),
(2, 'mojafirma-testowa.pl', 'Brak aktywnych DNS / możliwa dostępność', 'Nie znaleziono podstawowych rekordów DNS dla tej domeny. Domena może być wolna, ale nie jest to pełna gwarancja dostępności.', 'Potwierdź dostępność domeny u rejestratora, ponieważ brak DNS nie zawsze oznacza, że domena jest wolna.', 0, 0, 0, 0, '127.0.0.1', 'Demo browser', NOW());
