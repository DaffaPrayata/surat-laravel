-- ASIP Database Optimization
-- Project: Laravel Surat Menyurat (ASIP)
-- Optimized for: Muhammad Daffa Prayata

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------
-- Table Structure: users
-- ------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin', 'staff') NOT NULL DEFAULT 'staff',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `profile_picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_active`, `created_at`) VALUES
(1, 'Administrator', 'admin@admin.com', '$2y$10$r0vCZVkH9fmSsBH4CDJCgO03q9UAe9sDbFKGAdqf188y6heVAdvnm', 'admin', 1, NOW());

-- ------------------------------------------------------
-- Table Structure: classifications
-- ------------------------------------------------------
DROP TABLE IF EXISTS `classifications`;
CREATE TABLE `classifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `classifications_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `classifications` (`code`, `type`, `description`) VALUES 
('ADM', 'Administrasi', 'Urusan surat menyurat umum'),
('UND', 'Undangan', 'Surat undangan kegiatan'),
('TGS', 'Tugas', 'Surat perintah/tugas staff');

-- ------------------------------------------------------
-- Table Structure: letter_statuses
-- ------------------------------------------------------
DROP TABLE IF EXISTS `letter_statuses`;
CREATE TABLE `letter_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `letter_statuses` VALUES (1,'Rahasia'),(2,'Segera'),(3,'Biasa');

-- ------------------------------------------------------
-- Table Structure: letters
-- ------------------------------------------------------
DROP TABLE IF EXISTS `letters`;
CREATE TABLE `letters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(100) NOT NULL COMMENT 'Nomor Surat',
  `agenda_number` varchar(100) NOT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `letter_date` date DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `type` enum('incoming','outgoing') NOT NULL DEFAULT 'incoming',
  `classification_code` varchar(50) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `letters_reference_number_unique` (`reference_number`),
  CONSTRAINT `letters_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- Table Structure: dispositions
-- ------------------------------------------------------
DROP TABLE IF EXISTS `dispositions`;
CREATE TABLE `dispositions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `to` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `content` text NOT NULL,
  `note` text,
  `letter_status` bigint unsigned NOT NULL,
  `letter_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `dispositions_letter_fk` FOREIGN KEY (`letter_id`) REFERENCES `letters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dispositions_status_fk` FOREIGN KEY (`letter_status`) REFERENCES `letter_statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- Table Structure: configs (App System Settings)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configs_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `configs` (`code`, `value`) VALUES 
('app_name', 'ASIP - Aplikasi Surat'),
('institution_name', 'SMK IT Software & Game Dev'),
('default_password', 'admin123');

SET FOREIGN_KEY_CHECKS = 1;