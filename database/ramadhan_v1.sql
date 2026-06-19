-- Ramadhan Companion v1 CI3 - Full Database Schema
-- Import fresh:
--   mysql -u root -p < database/ramadhan_v1.sql
-- Catatan: file ini membuat ulang database ramadhan_v1 agar struktur bersih dan konsisten.

CREATE DATABASE IF NOT EXISTS ramadhan_v1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ramadhan_v1;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS user_achievements;
DROP TABLE IF EXISTS achievements;
DROP TABLE IF EXISTS daily_content_reads;
DROP TABLE IF EXISTS daily_contents;
DROP TABLE IF EXISTS quran_progress;
DROP TABLE IF EXISTS sunnah_logs;
DROP TABLE IF EXISTS prayer_logs;
DROP TABLE IF EXISTS fasting_logs;
DROP TABLE IF EXISTS user_preferences;
DROP TABLE IF EXISTS quran_ayahs;
DROP TABLE IF EXISTS quran_surahs;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NULL,
    timezone VARCHAR(64) NOT NULL DEFAULT 'Asia/Jakarta',
    city VARCHAR(80) NOT NULL DEFAULT 'jakarta',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_preferences (
    user_id INT UNSIGNED PRIMARY KEY,
    ramadhan_start DATE NOT NULL,
    city ENUM('jakarta','bandung','purbalingga','surabaya','makassar') NOT NULL DEFAULT 'jakarta',
    reminders_enabled TINYINT(1) NOT NULL DEFAULT 0,
    selected_fasting_day TINYINT UNSIGNED NOT NULL DEFAULT 1,
    last_surah VARCHAR(120) NULL,
    last_ayah VARCHAR(20) NULL,
    last_page VARCHAR(20) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_preferences_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE fasting_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    ramadhan_day TINYINT UNSIGNED NOT NULL,
    status ENUM('empty','done','excused','missed') NOT NULL DEFAULT 'empty',
    note TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_ramadhan_day (user_id, ramadhan_day),
    INDEX idx_fasting_user_status (user_id, status),
    CONSTRAINT fk_fasting_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE prayer_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    prayer_name ENUM('subuh','dzuhur','ashar','maghrib','isya') NOT NULL,
    prayer_date DATE NOT NULL,
    is_completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_prayer_date (user_id, prayer_name, prayer_date),
    INDEX idx_prayer_user_date (user_id, prayer_date),
    CONSTRAINT fk_prayer_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE sunnah_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    sunnah_name ENUM('tahajud','dhuha','rawatib','tarawih') NOT NULL,
    sunnah_date DATE NOT NULL,
    is_completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_sunnah_date (user_id, sunnah_name, sunnah_date),
    INDEX idx_sunnah_user_date (user_id, sunnah_date),
    CONSTRAINT fk_sunnah_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE quran_surahs (
    id SMALLINT UNSIGNED PRIMARY KEY,
    name_arabic VARCHAR(120) NOT NULL,
    name_latin VARCHAR(120) NOT NULL,
    total_ayah SMALLINT UNSIGNED NOT NULL,
    revelation_place ENUM('makkah','madinah') NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE quran_ayahs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    surah_id SMALLINT UNSIGNED NOT NULL,
    ayah_number SMALLINT UNSIGNED NOT NULL,
    juz TINYINT UNSIGNED NULL,
    arabic_text TEXT NOT NULL,
    translation_id TEXT NOT NULL,
    theme VARCHAR(120) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_surah_ayah (surah_id, ayah_number),
    INDEX idx_ayah_juz (juz),
    INDEX idx_ayah_theme (theme),
    CONSTRAINT fk_ayah_surah FOREIGN KEY (surah_id) REFERENCES quran_surahs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE quran_progress (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    juz TINYINT UNSIGNED NOT NULL,
    surah VARCHAR(120) NULL,
    ayah INT UNSIGNED NULL,
    page_number INT UNSIGNED NULL,
    is_completed TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_juz (user_id, juz),
    CONSTRAINT fk_quran_progress_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE daily_contents (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ramadhan_day TINYINT UNSIGNED NULL,
    content_date DATE NULL,
    type ENUM('ayah','hadith','quote') NOT NULL DEFAULT 'ayah',
    ayah_id INT UNSIGNED NULL,
    arabic_text TEXT NULL,
    translation TEXT NULL,
    source VARCHAR(160) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_ramadhan_day_type (ramadhan_day, type),
    UNIQUE KEY unique_content_date_type (content_date, type),
    CONSTRAINT fk_daily_ayah FOREIGN KEY (ayah_id) REFERENCES quran_ayahs(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE daily_content_reads (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    content_date DATE NOT NULL,
    type ENUM('ayah','hadith','quote') NOT NULL DEFAULT 'ayah',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_read_date_type (user_id, content_date, type),
    CONSTRAINT fk_read_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(80) NOT NULL UNIQUE,
    title VARCHAR(120) NOT NULL,
    description TEXT NOT NULL,
    icon_label VARCHAR(12) NOT NULL DEFAULT 'BD',
    xp_reward INT UNSIGNED NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    achievement_id INT UNSIGNED NOT NULL,
    unlocked_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_achievement (user_id, achievement_id),
    CONSTRAINT fk_user_achievement_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_user_achievement_achievement FOREIGN KEY (achievement_id) REFERENCES achievements(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (id, name, email, password_hash, timezone, city) VALUES
(1, 'Demo User', 'demo@ramadhan.local', NULL, 'Asia/Jakarta', 'jakarta');

INSERT INTO user_preferences (user_id, ramadhan_start, city, reminders_enabled, selected_fasting_day) VALUES
(1, CURDATE(), 'jakarta', 0, 1);

INSERT INTO quran_surahs (id, name_arabic, name_latin, total_ayah, revelation_place) VALUES
(2, 'البقرة', 'Al-Baqarah', 286, 'madinah'),
(3, 'آل عمران', 'Ali Imran', 200, 'madinah'),
(18, 'الكهف', 'Al-Kahfi', 110, 'makkah'),
(36, 'يس', 'Yasin', 83, 'makkah'),
(94, 'الشرح', 'Al-Insyirah', 8, 'makkah'),
(97, 'القدر', 'Al-Qadr', 5, 'makkah'),
(112, 'الإخلاص', 'Al-Ikhlas', 4, 'makkah');

INSERT INTO quran_ayahs (surah_id, ayah_number, juz, arabic_text, translation_id, theme) VALUES
(2, 183, 2, 'يَا أَيُّهَا الَّذِينَ آمَنُوا كُتِبَ عَلَيْكُمُ الصِّيَامُ كَمَا كُتِبَ عَلَى الَّذِينَ مِن قَبْلِكُمْ لَعَلَّكُمْ تَتَّقُونَ', 'Wahai orang-orang yang beriman, diwajibkan atas kamu berpuasa sebagaimana diwajibkan atas orang sebelum kamu agar kamu bertakwa.', 'puasa'),
(2, 184, 2, 'أَيَّامًا مَّعْدُودَاتٍ', 'Yaitu beberapa hari tertentu.', 'puasa'),
(2, 185, 2, 'شَهْرُ رَمَضَانَ الَّذِي أُنزِلَ فِيهِ الْقُرْآنُ', 'Bulan Ramadan adalah bulan yang di dalamnya diturunkan Al-Qur’an sebagai petunjuk bagi manusia.', 'ramadhan'),
(2, 186, 2, 'وَإِذَا سَأَلَكَ عِبَادِي عَنِّي فَإِنِّي قَرِيبٌ', 'Apabila hamba-hamba-Ku bertanya kepadamu tentang Aku, maka sesungguhnya Aku dekat.', 'doa'),
(2, 286, 3, 'لَا يُكَلِّفُ اللَّهُ نَفْسًا إِلَّا وُسْعَهَا', 'Allah tidak membebani seseorang melainkan sesuai dengan kesanggupannya.', 'ketenangan'),
(3, 133, 4, 'وَسَارِعُوا إِلَىٰ مَغْفِرَةٍ مِّن رَّبِّكُمْ', 'Bersegeralah menuju ampunan dari Tuhanmu.', 'taubat'),
(3, 134, 4, 'الَّذِينَ يُنفِقُونَ فِي السَّرَّاءِ وَالضَّرَّاءِ', 'Yaitu orang-orang yang berinfak, baik di waktu lapang maupun sempit.', 'sedekah'),
(18, 10, 15, 'رَبَّنَا آتِنَا مِن لَّدُنكَ رَحْمَةً', 'Ya Tuhan kami, berikanlah rahmat kepada kami dari sisi-Mu.', 'doa'),
(18, 110, 16, 'فَمَن كَانَ يَرْجُو لِقَاءَ رَبِّهِ فَلْيَعْمَلْ عَمَلًا صَالِحًا', 'Siapa yang mengharap pertemuan dengan Tuhannya hendaklah mengerjakan amal saleh.', 'amal'),
(36, 58, 23, 'سَلَامٌ قَوْلًا مِّن رَّبٍّ رَّحِيمٍ', 'Salam sebagai ucapan dari Tuhan Yang Maha Penyayang.', 'rahmat'),
(94, 5, 30, 'فَإِنَّ مَعَ الْعُسْرِ يُسْرًا', 'Maka sesungguhnya bersama kesulitan ada kemudahan.', 'harapan'),
(94, 6, 30, 'إِنَّ مَعَ الْعُسْرِ يُسْرًا', 'Sesungguhnya bersama kesulitan ada kemudahan.', 'harapan'),
(97, 1, 30, 'إِنَّا أَنزَلْنَاهُ فِي لَيْلَةِ الْقَدْرِ', 'Sesungguhnya Kami telah menurunkannya pada malam kemuliaan.', 'lailatul_qadr'),
(97, 3, 30, 'لَيْلَةُ الْقَدْرِ خَيْرٌ مِّنْ أَلْفِ شَهْرٍ', 'Malam kemuliaan itu lebih baik daripada seribu bulan.', 'lailatul_qadr'),
(112, 1, 30, 'قُلْ هُوَ اللَّهُ أَحَدٌ', 'Katakanlah, Dialah Allah Yang Maha Esa.', 'tauhid');

INSERT INTO daily_contents (ramadhan_day, type, ayah_id) VALUES
(1, 'ayah', 1),
(2, 'ayah', 2),
(3, 'ayah', 3),
(4, 'ayah', 4),
(5, 'ayah', 5),
(6, 'ayah', 6),
(7, 'ayah', 7),
(8, 'ayah', 8),
(9, 'ayah', 9),
(10, 'ayah', 10),
(11, 'ayah', 11),
(12, 'ayah', 12),
(13, 'ayah', 13),
(14, 'ayah', 14),
(15, 'ayah', 15);

INSERT INTO achievements (code, title, description, icon_label, xp_reward) VALUES
('first_fast', 'Niat Pertama', 'Selesaikan minimal 1 hari puasa.', 'NF', 50),
('seven_fast', '7 Hari Konsisten', 'Selesaikan 7 hari puasa.', '7H', 120),
('half_ramadhan', 'Nisfu Ramadhan', 'Selesaikan 15 hari puasa.', '15', 180),
('full_ramadhan', 'Full Ramadhan', 'Selesaikan 30 hari puasa.', '30', 420),
('prayer_guard', 'Penjaga Waktu', 'Centang 5 sholat wajib dalam satu hari.', 'JW', 90),
('sunnah_seeker', 'Pencari Sunnah', 'Selesaikan 2 target sholat sunnah hari ini.', 'SS', 80),
('first_juz', 'Juz Starter', 'Selesaikan 1 juz Al-Quran.', 'J1', 60),
('ten_juz', '10 Juz Runner', 'Selesaikan 10 juz Al-Quran.', '10', 180),
('khatam', 'Khatam Target', 'Selesaikan 30 juz Al-Quran.', 'KT', 520),
('xp_500', '500 XP', 'Kumpulkan minimal 500 XP Ramadhan.', 'XP', 100);
