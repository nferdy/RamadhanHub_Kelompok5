-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2026 at 09:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ramadhan_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(80) NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `icon_label` varchar(12) NOT NULL DEFAULT 'BD',
  `xp_reward` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `code`, `title`, `description`, `icon_label`, `xp_reward`, `created_at`) VALUES
(1, 'first_fast', 'Niat Pertama', 'Selesaikan minimal 1 hari puasa.', 'NF', 50, '2026-06-19 19:48:23'),
(2, 'seven_fast', '7 Hari Konsisten', 'Selesaikan 7 hari puasa.', '7H', 120, '2026-06-19 19:48:23'),
(3, 'half_ramadhan', 'Nisfu Ramadhan', 'Selesaikan 15 hari puasa.', '15', 180, '2026-06-19 19:48:23'),
(4, 'full_ramadhan', 'Full Ramadhan', 'Selesaikan 30 hari puasa.', '30', 420, '2026-06-19 19:48:23'),
(5, 'prayer_guard', 'Penjaga Waktu', 'Centang 5 sholat wajib dalam satu hari.', 'JW', 90, '2026-06-19 19:48:23'),
(6, 'sunnah_seeker', 'Pencari Sunnah', 'Selesaikan 2 target sholat sunnah hari ini.', 'SS', 80, '2026-06-19 19:48:23'),
(7, 'first_juz', 'Juz Starter', 'Selesaikan 1 juz Al-Quran.', 'J1', 60, '2026-06-19 19:48:23'),
(8, 'ten_juz', '10 Juz Runner', 'Selesaikan 10 juz Al-Quran.', '10', 180, '2026-06-19 19:48:23'),
(9, 'khatam', 'Khatam Target', 'Selesaikan 30 juz Al-Quran.', 'KT', 520, '2026-06-19 19:48:23'),
(10, 'xp_500', '500 XP', 'Kumpulkan minimal 500 XP Ramadhan.', 'XP', 100, '2026-06-19 19:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `daily_contents`
--

CREATE TABLE `daily_contents` (
  `id` int(10) UNSIGNED NOT NULL,
  `content_date` date NOT NULL,
  `type` enum('ayah','hadith','quote') NOT NULL,
  `arabic_text` text DEFAULT NULL,
  `translation` text NOT NULL,
  `source` varchar(160) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_contents`
--

INSERT INTO `daily_contents` (`id`, `content_date`, `type`, `arabic_text`, `translation`, `source`, `created_at`) VALUES
(1, '2026-06-19', 'ayah', 'يَا أَيُّهَا الَّذِينَ آمَنُوا كُتِبَ عَلَيْكُمُ الصِّيَامُ', 'Wahai orang-orang yang beriman, diwajibkan atas kamu berpuasa sebagaimana diwajibkan atas orang sebelum kamu agar kamu bertakwa.', 'QS. Al-Baqarah: 183', '2026-06-19 19:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `fasting_logs`
--

CREATE TABLE `fasting_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ramadhan_day` tinyint(3) UNSIGNED NOT NULL,
  `status` enum('empty','done','excused','missed') NOT NULL DEFAULT 'empty',
  `note` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prayer_logs`
--

CREATE TABLE `prayer_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `prayer_name` enum('subuh','dzuhur','ashar','maghrib','isya') NOT NULL,
  `prayer_date` date NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quran_progress`
--

CREATE TABLE `quran_progress` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `juz` tinyint(3) UNSIGNED NOT NULL,
  `surah` varchar(120) DEFAULT NULL,
  `ayah` int(10) UNSIGNED DEFAULT NULL,
  `page_number` int(10) UNSIGNED DEFAULT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sunnah_logs`
--

CREATE TABLE `sunnah_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `sunnah_name` enum('tahajud','dhuha','rawatib','tarawih') NOT NULL,
  `sunnah_date` date NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(160) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `timezone` varchar(64) NOT NULL DEFAULT 'Asia/Jakarta',
  `city` varchar(80) NOT NULL DEFAULT 'jakarta',
  `ramadhan_start` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password_hash`, `timezone`, `city`, `ramadhan_start`, `created_at`, `updated_at`, `password`, `role`) VALUES
(1, 'admin', 'Demo User', 'demo@ramadhan.local', NULL, 'Asia/Jakarta', 'jakarta', NULL, '2026-06-19 19:48:23', '2026-06-20 11:57:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
(2, 'user_biasa anjay', '', NULL, NULL, 'Asia/Jakarta', 'jakarta', NULL, '2026-06-20 11:57:02', '2026-06-20 13:11:49', '$2y$10$3.1dQh3rK91a3Y8URZ6ceObk0Pwe499.Bs6MSLLStj2XmKnl5MyLC', 'user'),
(3, 'ferdy', '', NULL, NULL, 'Asia/Jakarta', 'jakarta', NULL, '2026-06-20 12:30:52', NULL, '$2y$10$uUV/g6DUGXlR6DD2bbqg5..UX4QZWPP/PxUwFy9kH0b9erWtHy7gq', 'user'),
(4, 'maha agung ferdy', '', NULL, NULL, 'Asia/Jakarta', 'jakarta', NULL, '2026-06-20 13:12:49', NULL, '$2y$10$nXKv9kSmv6YyFVS7RO1ccuJqGZ.1e3L.uVvmVZ0bcwI2Zq2/6aEwi', 'admin'),
(5, 'my bahlil', '', NULL, NULL, 'Asia/Jakarta', 'jakarta', NULL, '2026-06-20 13:14:24', NULL, '$2y$10$BWGR8AhYom7vbl9hjSAkruzDlkr8bfr38YXOI7va388LBDlTcH.Xy', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_achievements`
--

CREATE TABLE `user_achievements` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `achievement_id` int(10) UNSIGNED NOT NULL,
  `unlocked_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `daily_contents`
--
ALTER TABLE `daily_contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_content_date_type` (`content_date`,`type`);

--
-- Indexes for table `fasting_logs`
--
ALTER TABLE `fasting_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_ramadhan_day` (`user_id`,`ramadhan_day`);

--
-- Indexes for table `prayer_logs`
--
ALTER TABLE `prayer_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_prayer_date` (`user_id`,`prayer_name`,`prayer_date`);

--
-- Indexes for table `quran_progress`
--
ALTER TABLE `quran_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_juz` (`user_id`,`juz`);

--
-- Indexes for table `sunnah_logs`
--
ALTER TABLE `sunnah_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_sunnah_date` (`user_id`,`sunnah_name`,`sunnah_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_achievement` (`user_id`,`achievement_id`),
  ADD KEY `fk_user_achievement_achievement` (`achievement_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `daily_contents`
--
ALTER TABLE `daily_contents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fasting_logs`
--
ALTER TABLE `fasting_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prayer_logs`
--
ALTER TABLE `prayer_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quran_progress`
--
ALTER TABLE `quran_progress`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sunnah_logs`
--
ALTER TABLE `sunnah_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_achievements`
--
ALTER TABLE `user_achievements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fasting_logs`
--
ALTER TABLE `fasting_logs`
  ADD CONSTRAINT `fk_fasting_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prayer_logs`
--
ALTER TABLE `prayer_logs`
  ADD CONSTRAINT `fk_prayer_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quran_progress`
--
ALTER TABLE `quran_progress`
  ADD CONSTRAINT `fk_quran_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sunnah_logs`
--
ALTER TABLE `sunnah_logs`
  ADD CONSTRAINT `fk_sunnah_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD CONSTRAINT `fk_user_achievement_achievement` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_achievement_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
