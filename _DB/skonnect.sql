-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2026 at 05:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skonnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` enum('event','program','notice','meeting','urgent') NOT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `featured_at` timestamp NULL DEFAULT NULL,
  `banner_img` varchar(500) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expired_at` date DEFAULT NULL,
  `status` enum('active','draft','archived') NOT NULL DEFAULT 'active',
  `archived_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `category`, `featured`, `featured_at`, `banner_img`, `author_id`, `published_at`, `updated_at`, `expired_at`, `status`, `archived_at`) VALUES
(40, 'ANNOUNCEMENT TITLE', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><b>Cities change faster than\r\nmost people notice. </b>A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><i>What’s interesting is how\r\npeople adapt to it</i>—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><u>The biggest shifts usually\r\naren’t flashy innovations;</u> they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69c68e17e33289.50372744.jpg', 14, '2026-03-26 16:00:00', '2026-03-27 14:03:03', NULL, 'active', NULL),
(41, 'MEDICAL ANNOUNCEMENT 2060', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">What’s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'program', 0, NULL, '/SKonnect/assets/uploads/banners/69c68e442dff06.34528427.jpg', 14, '2026-03-26 16:00:00', '2026-03-27 14:04:12', NULL, 'active', NULL),
(42, 'COMMUNITY MEETING', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><b>What’s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. </b><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'meeting', 0, NULL, '/SKonnect/assets/uploads/banners/69c68e81da9a83.56227044.jpg', 14, '2026-03-26 16:00:00', '2026-03-27 14:04:49', NULL, 'active', NULL),
(43, 'SCHOLARSHIP 2060', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">What’s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><u>The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</u></span></p>', 'event', 0, NULL, '/SKonnect/assets/uploads/banners/69c68eaa23be06.92635504.jpg', 14, '2026-03-26 16:00:00', '2026-03-27 14:05:30', NULL, 'active', NULL),
(44, 'SUMN ANNOUNCEMENT', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">What’s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'urgent', 1, '2026-03-27 07:06:08', '/SKonnect/assets/uploads/banners/69c68ed0deda07.80537005.jpg', 14, '2026-03-26 16:00:00', '2026-03-27 14:06:08', NULL, 'active', NULL),
(45, 'something', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">What’s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'event', 0, NULL, '/SKonnect/assets/uploads/banners/69c68ef36a6587.00300096.jpg', 14, '2026-03-26 16:00:00', '2026-03-27 14:06:43', NULL, 'draft', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_bookmarks`
--

CREATE TABLE `announcement_bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_bookmarks`
--

INSERT INTO `announcement_bookmarks` (`id`, `user_id`, `announcement_id`, `created_at`) VALUES
(35, 19, 40, '2026-04-03 01:21:09'),
(36, 19, 41, '2026-04-03 01:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_files`
--

CREATE TABLE `announcement_files` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `file_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_files`
--

INSERT INTO `announcement_files` (`id`, `announcement_id`, `file_path`) VALUES
(46, 40, '/SKonnect/assets/uploads/attachments/69c68e18298105.67308419.pdf'),
(47, 41, '/SKonnect/assets/uploads/attachments/69c68e4440bf09.62442081.pdf'),
(48, 42, '/SKonnect/assets/uploads/attachments/69c68e81e4db88.93675084.docx'),
(49, 42, '/SKonnect/assets/uploads/attachments/69c68e820b1586.28761263.pdf'),
(50, 43, '/SKonnect/assets/uploads/attachments/69c68eaa328987.95501266.xlsx'),
(51, 44, '/SKonnect/assets/uploads/attachments/69c68ed101db09.89644056.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `comment_replies`
--

CREATE TABLE `comment_replies` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_removed` tinyint(1) NOT NULL DEFAULT 0,
  `removed_by_mod` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = hidden by a moderator sanction (shows tombstone); 0 = not mod-removed',
  `removed_by_user` tinyint(1) NOT NULL DEFAULT 0,
  `is_mod_comment` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_reports`
--

CREATE TABLE `comment_reports` (
  `id` int(11) NOT NULL,
  `target_type` enum('comment','reply') NOT NULL,
  `target_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `category` enum('inappropriate','spam','misinformation','harassment') NOT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','reviewed','dismissed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_supports`
--

CREATE TABLE `comment_supports` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `ref_type` varchar(30) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category` enum('inquiry','complaint','suggestion','event_question','other') NOT NULL,
  `subject` varchar(120) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','responded','resolved') NOT NULL DEFAULT 'pending',
  `is_removed` tinyint(1) NOT NULL DEFAULT 0,
  `removed_by_user` tinyint(1) NOT NULL DEFAULT 0,
  `is_flagged` tinyint(1) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_bookmarks`
--

CREATE TABLE `thread_bookmarks` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_comments`
--

CREATE TABLE `thread_comments` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_removed` tinyint(1) NOT NULL DEFAULT 0,
  `removed_by_mod` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 = hidden by a moderator sanction (shows tombstone); 0 = not mod-removed',
  `removed_by_user` tinyint(1) NOT NULL DEFAULT 0,
  `is_mod_comment` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_images`
--

CREATE TABLE `thread_images` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_reports`
--

CREATE TABLE `thread_reports` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `category` enum('inappropriate','spam','misinformation','harassment') NOT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','reviewed','dismissed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_supports`
--

CREATE TABLE `thread_supports` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `birth_date` date NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `role` enum('resident','moderator','sk_officer','admin') NOT NULL DEFAULT 'resident',
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `feed_ban_level` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=none, 2=7-day ban, 3=permanent ban',
  `feed_ban_expires` datetime DEFAULT NULL COMMENT 'NULL = permanent; populated for level-2 7-day bans'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `age`, `email`, `password`, `is_verified`, `role`, `otp_code`, `otp_expires`, `created_at`, `verified_at`, `is_deleted`, `feed_ban_level`, `feed_ban_expires`) VALUES
(12, 'Rey', 'Santos', 'Cruz', 'male', '2000-03-15', 25, 'admin@skonnect.com', '$2y$10$KzsjmePIGxKHotu8yqddMeo.0ymj9w8yV2pQzWG8Lq.uERZMXrBTS', 1, 'admin', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42', 0, 0, NULL),
(13, 'Maya', 'Reyes', 'Lim', 'female', '1998-07-22', 27, 'moderator@skonnect.com', '$2y$10$TJ.CZA5ds2Zy1/WM0AInzOJ1h2gkdgILcaXT.s.MRt/k6Aq2E3g1K', 1, 'moderator', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42', 0, 0, NULL),
(14, 'Carlo', 'Mendoza', 'Bautista', 'male', '1995-11-05', 30, 'officer@skonnect.com', '$2y$10$fMLkG3QvcG0mJI359fgqr.2aC4aE.e4NFB2Bk4meQySGsuICdhPCO', 1, 'sk_officer', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42', 0, 0, NULL),
(18, 'Ico', 'Etelyev', 'Yukab', 'male', '2005-06-12', 20, 'lvillete778@gmail.com', '$2y$10$2YrL6VeRce6Ka7bzT9AkveDZRtk.a1JoORi0kYrdEtsVmCu3thqQG', 1, 'resident', NULL, NULL, '2026-03-27 12:07:22', '2026-03-27 12:08:29', 0, 2, '2026-04-11 11:41:20'),
(19, 'Bicop', 'Lmio', 'Limoy', 'male', '2000-06-12', 25, 'leovillete878@gmail.com', '$2y$10$KmqiIiwZjc/kaBBF2Fse4.9RRHFVb5LdwELbBDh.DowjqNYeYLl7i', 1, 'resident', NULL, NULL, '2026-04-01 07:07:15', '2026-04-01 07:07:40', 0, 0, NULL),
(20, 'Mixsom', 'Debrova', 'Alien', 'male', '2001-06-12', 24, 'villete.leonardo.buya@gmail.com', '$2y$10$Lb0dMaIFJFOIR/N6CLvVV.Vduk9eJQ7qAEUYETtV4x0tyD4uRsbay', 1, 'resident', NULL, NULL, '2026-04-05 03:49:53', '2026-04-05 03:50:13', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_sanctions`
--

CREATE TABLE `user_sanctions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issued_by` int(11) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT 1,
  `reason` text NOT NULL,
  `report_id` int(11) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sanctions`
--

INSERT INTO `user_sanctions` (`id`, `user_id`, `issued_by`, `level`, `reason`, `report_id`, `expires_at`, `is_active`, `created_at`) VALUES
(15, 18, 13, 2, '(No additional reason provided)', 19, '2026-04-11 11:41:03', 1, '2026-04-04 17:41:03'),
(16, 18, 13, 2, '(No additional reason provided)', 18, '2026-04-11 11:41:20', 1, '2026-04-04 17:41:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_announcement_authorA` (`author_id`);

--
-- Indexes for table `announcement_bookmarks`
--
ALTER TABLE `announcement_bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_announcement` (`user_id`,`announcement_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_announcement_id` (`announcement_id`);

--
-- Indexes for table `announcement_files`
--
ALTER TABLE `announcement_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`);

--
-- Indexes for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reply_comment` (`comment_id`),
  ADD KEY `fk_reply_author` (`author_id`);

--
-- Indexes for table `comment_reports`
--
ALTER TABLE `comment_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_comment_report` (`target_type`,`target_id`,`reporter_id`),
  ADD KEY `fk_cr_reporter` (`reporter_id`);

--
-- Indexes for table `comment_supports`
--
ALTER TABLE `comment_supports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_comment_support` (`comment_id`,`user_id`),
  ADD KEY `fk_csupport_user` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_user` (`user_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_thread_author` (`author_id`),
  ADD KEY `idx_is_pinned` (`is_pinned`);

--
-- Indexes for table `thread_bookmarks`
--
ALTER TABLE `thread_bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_bookmark` (`thread_id`,`user_id`),
  ADD KEY `fk_bookmark_user` (`user_id`);

--
-- Indexes for table `thread_comments`
--
ALTER TABLE `thread_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_thread` (`thread_id`),
  ADD KEY `fk_comment_author` (`author_id`);

--
-- Indexes for table `thread_images`
--
ALTER TABLE `thread_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_img_thread` (`thread_id`);

--
-- Indexes for table `thread_reports`
--
ALTER TABLE `thread_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_thread_report` (`thread_id`,`reporter_id`),
  ADD KEY `fk_tr_thread` (`thread_id`),
  ADD KEY `fk_tr_reporter` (`reporter_id`);

--
-- Indexes for table `thread_supports`
--
ALTER TABLE `thread_supports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_thread_support` (`thread_id`,`user_id`),
  ADD KEY `fk_support_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_otp` (`otp_code`),
  ADD KEY `idx_role` (`role`);

--
-- Indexes for table `user_sanctions`
--
ALTER TABLE `user_sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_us_user` (`user_id`),
  ADD KEY `idx_us_issued` (`issued_by`),
  ADD KEY `idx_us_report` (`report_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `announcement_bookmarks`
--
ALTER TABLE `announcement_bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `announcement_files`
--
ALTER TABLE `announcement_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `comment_reports`
--
ALTER TABLE `comment_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `comment_supports`
--
ALTER TABLE `comment_supports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `thread_bookmarks`
--
ALTER TABLE `thread_bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `thread_comments`
--
ALTER TABLE `thread_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `thread_images`
--
ALTER TABLE `thread_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `thread_reports`
--
ALTER TABLE `thread_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `thread_supports`
--
ALTER TABLE `thread_supports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_sanctions`
--
ALTER TABLE `user_sanctions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `fk_announcement_authorA` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcement_bookmarks`
--
ALTER TABLE `announcement_bookmarks`
  ADD CONSTRAINT `fk_bm_announcement` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bm_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcement_files`
--
ALTER TABLE `announcement_files`
  ADD CONSTRAINT `fk_attachment_announcement` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_replies`
--
ALTER TABLE `comment_replies`
  ADD CONSTRAINT `fk_reply_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reply_comment` FOREIGN KEY (`comment_id`) REFERENCES `thread_comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_reports`
--
ALTER TABLE `comment_reports`
  ADD CONSTRAINT `fk_cr_reporter` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_supports`
--
ALTER TABLE `comment_supports`
  ADD CONSTRAINT `fk_csupport_comment` FOREIGN KEY (`comment_id`) REFERENCES `thread_comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_csupport_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `fk_thread_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thread_bookmarks`
--
ALTER TABLE `thread_bookmarks`
  ADD CONSTRAINT `fk_bookmark_thread` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bookmark_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thread_comments`
--
ALTER TABLE `thread_comments`
  ADD CONSTRAINT `fk_comment_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_thread` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thread_images`
--
ALTER TABLE `thread_images`
  ADD CONSTRAINT `fk_img_thread` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thread_reports`
--
ALTER TABLE `thread_reports`
  ADD CONSTRAINT `fk_tr_reporter` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_tr_thread` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thread_supports`
--
ALTER TABLE `thread_supports`
  ADD CONSTRAINT `fk_support_thread` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_support_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sanctions`
--
ALTER TABLE `user_sanctions`
  ADD CONSTRAINT `fk_us_issuer` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_us_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
