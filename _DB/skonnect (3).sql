-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 02:07 PM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'NULL = system action',
  `action` varchar(50) NOT NULL COMMENT 'approved|declined|published|flagged|deleted|created|updated|login|banned|unbanned|activated|deactivated',
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `created_at`) VALUES
(1, 13, 'thread_flagged', '{\"target_type\":\"thread\",\"target_id\":38,\"target_name\":\"This a thread\",\"target_user\":\"Icolet Etelevyssuraon\",\"notes\":\"Flagged for: spam. Added to mod queue.\"}', '::1', '2026-04-23 18:04:37'),
(2, 13, 'thread_pinned', '{\"target_type\":\"thread\",\"target_id\":37,\"target_name\":\"Can we start a community vegetable garden in the vacant lot at Phase 2?\",\"target_user\":\"Bicop Lmio\",\"notes\":\"Thread pinned to top of feed.\"}', '::1', '2026-04-23 18:06:20'),
(3, 13, 'thread_status_updated', '{\"target_type\":\"thread\",\"target_id\":35,\"target_name\":\"Process for getting a permit to start a home-based sari-sari store\",\"target_user\":\"Bicop Lmio\",\"notes\":\"Status changed to \\\"resolved\\\".\"}', '::1', '2026-04-23 18:39:40'),
(4, 13, 'mod_comment_posted', '{\"target_type\":\"thread\",\"target_id\":34,\"target_name\":\"How can I apply for a Resident ID card for my new helper?\",\"target_user\":\"Bicop Lmio\",\"notes\":\"Moderator posted a comment on this thread.\"}', '::1', '2026-04-23 18:40:01'),
(5, 13, 'thread_status_updated', '{\"target_type\":\"thread\",\"target_id\":34,\"target_name\":\"How can I apply for a Resident ID card for my new helper?\",\"target_user\":\"Bicop Lmio\",\"notes\":\"Status changed to \\\"responded\\\".\"}', '::1', '2026-04-23 18:40:07');

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
(45, 'something', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">What’s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'event', 0, NULL, '/SKonnect/assets/uploads/banners/69c68ef36a6587.00300096.jpg', 14, '2026-03-26 16:00:00', '2026-03-27 14:06:43', NULL, 'draft', NULL),
(46, 'IMPORTANT ANNOUNCEMENT', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice.<b> A café</b> that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><i>What’s interesting is how\r\npeople adapt to it</i>—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'program', 0, NULL, '/SKonnect/assets/uploads/banners/69d85c15859809.59659843.jpg', 14, '2026-04-09 16:00:00', '2026-04-10 02:10:29', NULL, 'active', NULL),
(47, 'PLACEHOLDER', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood’s routine. These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">What’s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. <o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">The biggest shifts usually\r\naren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it’s happening and obvious in hindsight. What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</span></p>', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69d85c66e75903.95101379.jpg', 14, '2026-04-09 16:00:00', '2026-04-10 02:11:50', NULL, 'active', NULL),
(48, 'NEW ANNOUNCEMENT', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a\r\ncrowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes\r\nthe center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back\r\nafter a few years, the difference is obvious.\r\nWhat’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal.&nbsp;<div><br></div><div>Technology evolves in a similar way. At first, a new tool\r\nfeels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it\r\nbecomes difficult to imagine doing things the old way.\r\nThe biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates something tedious can quietly\r\nchange how people work. In the end, progress tends to look subtle while it’s happening and obvious in\r\nhindsight.</div><div><br></div><div>What feels like a minor adjustment today can end up shaping routines, expectations, and even\r\nentire industries years down the line. Most people only realize the scale of the change once the old way\r\nof doing things starts to feel outdated.</div>', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69e8c03f000002.68453058.jpg', 14, '2026-04-21 16:00:00', '2026-04-22 12:34:07', NULL, 'active', NULL);

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
(36, 19, 41, '2026-04-03 01:21:10'),
(40, 21, 46, '2026-04-21 08:47:42'),
(41, 21, 42, '2026-04-21 08:47:44');

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
(51, 44, '/SKonnect/assets/uploads/attachments/69c68ed101db09.89644056.xlsx'),
(52, 46, '/SKonnect/assets/uploads/attachments/69d85c15a9ad85.58390264.pdf'),
(53, 47, '/SKonnect/assets/uploads/attachments/69d85c66f27b06.12599815.docx'),
(54, 47, '/SKonnect/assets/uploads/attachments/69d85c67190006.21012974.jpg'),
(55, 48, '/SKonnect/assets/uploads/attachments/69e8c03f12cc88.76784461.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `application_documents`
--

CREATE TABLE `application_documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(10) UNSIGNED DEFAULT NULL COMMENT 'Bytes',
  `mime_type` varchar(100) DEFAULT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_documents`
--

INSERT INTO `application_documents` (`id`, `application_id`, `file_name`, `file_path`, `file_size`, `mime_type`, `uploaded_at`) VALUES
(34, 19, 'SE101 - Flowchart.pdf', '/uploads/applications/app_19_69e46ad4bfd886.71225505_SE101_-_Flowchart.pdf', 36680, 'application/pdf', '2026-04-19 13:40:36'),
(35, 20, 'Reviewer Identification.pdf', '/uploads/applications/app_20_69e46b4b830181.44401125_Reviewer_Identification.pdf', 361837, 'application/pdf', '2026-04-19 13:42:35'),
(36, 20, 'SE101 - Project Proposal - Task Maker.pdf', '/uploads/applications/app_20_69e46bdc2d5c86.24884543_SE101_-_Project_Proposal_-_Task_Maker.pdf', 104844, 'application/pdf', '2026-04-19 13:45:00'),
(37, 21, 'SE101 - Assignment No.1 - Villete.pdf', '/uploads/applications/app_21_69e46ce73c8c04.64015492_SE101_-_Assignment_No.1_-_Villete.pdf', 304771, 'application/pdf', '2026-04-19 13:49:27'),
(38, 22, 'Sample PDF Attachment.pdf', '/uploads/applications/app_22_69e8c43e74b308.36257654_Sample_PDF_Attachment.pdf', 80561, 'application/pdf', '2026-04-22 20:51:10'),
(39, 22, 'IM101 BSCS - Advanced Database Systems Syllabus.pdf', '/uploads/applications/app_22_69e8c8ee5dcc85.79911261_IM101_BSCS_-_Advanced_Database_Systems_Syllabus.pdf', 802368, 'application/pdf', '2026-04-22 21:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `application_notes`
--

CREATE TABLE `application_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_id` int(10) UNSIGNED NOT NULL,
  `officer_id` int(10) UNSIGNED NOT NULL COMMENT 'FK → users.id',
  `note` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_notes`
--

INSERT INTO `application_notes` (`id`, `application_id`, `officer_id`, `note`, `created_at`) VALUES
(17, 20, 14, 'Need a footnote', '2026-04-19 13:43:24'),
(18, 20, 14, 'Request Approved! Congratulations! You get a t-shirt.', '2026-04-19 13:45:57'),
(19, 19, 14, 'Request Declined. Reason: Sorry', '2026-04-19 13:47:21'),
(20, 21, 14, 'No', '2026-04-19 13:56:37'),
(21, 22, 14, 'Hello', '2026-04-22 20:52:11'),
(22, 22, 14, 'Woah', '2026-04-22 21:11:34'),
(23, 22, 14, 'Request Approved! Approved! Please visit the nearest Brgy. Hall and receive your something.', '2026-04-23 05:48:19');

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

--
-- Dumping data for table `comment_replies`
--

INSERT INTO `comment_replies` (`id`, `comment_id`, `author_id`, `message`, `is_removed`, `removed_by_mod`, `removed_by_user`, `is_mod_comment`, `created_at`) VALUES
(38, 61, 19, 'This is a reply!', 0, 0, 0, 0, '2026-04-10 10:22:44'),
(40, 65, 19, 'Wow amazing', 0, 0, 0, 0, '2026-04-10 16:15:21'),
(41, 65, 19, 'Yo!', 0, 0, 0, 0, '2026-04-10 16:15:27'),
(43, 67, 19, 'okl', 0, 0, 0, 0, '2026-04-10 17:16:04'),
(44, 68, 21, 'reply', 0, 0, 0, 0, '2026-04-19 15:55:28'),
(45, 76, 21, 'relly', 0, 0, 0, 0, '2026-04-22 20:40:03'),
(46, 78, 19, 'hello', 0, 0, 0, 0, '2026-04-22 20:47:38');

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

--
-- Dumping data for table `comment_supports`
--

INSERT INTO `comment_supports` (`id`, `comment_id`, `user_id`, `created_at`) VALUES
(50, 61, 19, '2026-04-10 10:22:54'),
(53, 68, 21, '2026-04-19 15:55:24'),
(54, 78, 23, '2026-04-22 20:44:37'),
(55, 62, 23, '2026-04-23 19:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `event_time_end` time DEFAULT NULL,
  `location` varchar(120) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL COMMENT 'FK → users.id (sk_officer)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `event_date`, `event_time`, `event_time_end`, `location`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Barangay Summit Something', '2026-04-25', '19:00:00', NULL, 'Sauyo Hall Sta. Mesa Black', 'Bring towel', 14, '2026-04-21 09:10:17', '2026-04-21 09:10:17'),
(2, 'Dog feeding nation of the state', '2026-04-28', '08:00:00', NULL, 'Caloocan Sports Complex', 'This is event is in commemoration of the late dog.', 14, '2026-04-21 09:11:16', '2026-04-21 09:11:16'),
(3, 'Police Academic Dog Show', '2026-04-30', NULL, NULL, 'Quezon City Hall', 'Dogs', 14, '2026-04-21 09:15:38', '2026-04-21 09:15:38'),
(4, 'Starting Time', '2026-05-06', '08:00:00', '19:00:00', 'Luneta Park Rizal Death Place', 'Bayang Magiliw', 14, '2026-04-21 09:31:00', '2026-04-21 09:31:00'),
(5, 'Barangay Even', '2026-05-25', '08:00:00', '22:00:00', 'Sauyo Road', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 14, '2026-04-23 03:45:07', '2026-04-23 03:45:07');

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
  `is_dismissed` tinyint(1) NOT NULL DEFAULT 0,
  `is_official` tinyint(1) NOT NULL DEFAULT 0,
  `link` varchar(300) DEFAULT NULL,
  `ref_type` varchar(30) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `is_read`, `is_dismissed`, `is_official`, `link`, `ref_type`, `ref_id`, `created_at`) VALUES
(4, 19, 'announcement', 'New Announcement: NEW ANNOUNCEMENT', 'A new announcement has been posted: \"NEW ANNOUNCEMENT\". Cities change faster than most people notice. A café that used to be a quiet study spot becomes a\r\ncrowded hangout, an …', 1, 1, 0, 'announcements_page.php?id=48', 'announcement', 48, '2026-04-22 20:34:07'),
(5, 21, 'announcement', 'New Announcement: NEW ANNOUNCEMENT', 'A new announcement has been posted: \"NEW ANNOUNCEMENT\". Cities change faster than most people notice. A café that used to be a quiet study spot becomes a\r\ncrowded hangout, an …', 1, 0, 0, 'announcements_page.php?id=48', 'announcement', 48, '2026-04-22 20:34:07'),
(6, 23, 'announcement', 'New Announcement: NEW ANNOUNCEMENT', 'A new announcement has been posted: \"NEW ANNOUNCEMENT\". Cities change faster than most people notice. A café that used to be a quiet study spot becomes a\r\ncrowded hangout, an …', 1, 0, 0, 'announcements_page.php?id=48', 'announcement', 48, '2026-04-22 20:34:07'),
(7, 13, 'thread', 'New Reply to Your Comment', 'Icolet Etelevyssuraon replied to your comment on \"Thread Notification\": \"relly\"', 0, 0, 0, 'thread_view.php?id=40', 'thread', 40, '2026-04-22 20:40:03'),
(8, 19, 'thread', 'New Comment on Your Thread', 'Icorousius Dleavo Debrovaniael commented on your thread \"Thread Notification\": \"This a comment\"', 1, 0, 0, 'thread_view.php?id=40', 'thread', 40, '2026-04-22 20:44:34'),
(9, 23, 'thread', 'New Reply to Your Comment', 'Bicop Lmio replied to your comment on \"Thread Notification\": \"hello\"', 1, 0, 0, 'thread_view.php?id=40', 'thread', 40, '2026-04-22 20:47:38'),
(10, 19, 'thread', 'Official Response on Your Thread', 'A moderator (Maya Reyes) has officially responded to your thread \"Thread Notification\": \"another comment\"', 1, 0, 1, 'thread_view.php?id=40', 'thread', 40, '2026-04-22 20:49:40'),
(11, 19, 'new_service', 'New Service Available: School', 'A new Education service \"School\" is now available on the portal. Visit the Services page to view eligibility requirements and apply.', 1, 0, 0, 'services_page.php?id=31', 'service', 31, '2026-04-22 21:03:07'),
(12, 21, 'new_service', 'New Service Available: School', 'A new Education service \"School\" is now available on the portal. Visit the Services page to view eligibility requirements and apply.', 0, 0, 0, 'services_page.php?id=31', 'service', 31, '2026-04-22 21:03:07'),
(13, 23, 'new_service', 'New Service Available: School', 'A new Education service \"School\" is now available on the portal. Visit the Services page to view eligibility requirements and apply.', 0, 0, 0, 'services_page.php?id=31', 'service', 31, '2026-04-22 21:03:08'),
(14, 19, 'service', 'Action Required: Educational Helpingness', 'An officer has added a note to your \"Educational Helpingness\" request (REQ-#22) and is asking for additional information or documents. Please review and respond.', 1, 0, 0, 'my_requests_page.php?id=22', 'service_application', 22, '2026-04-22 21:11:34'),
(15, 19, 'service', 'Request Approved: Educational Helpingness', 'Your request for \"Educational Helpingness\" (REQ-#22) has been approved. Please check your request page for next steps and any additional instructions.', 1, 1, 0, 'my_requests_page.php?id=22', 'service_application', 22, '2026-04-23 05:48:19'),
(16, 21, 'thread', 'Official Response on Your Thread', 'A moderator (Maya Reyes) has officially responded to your thread \"Why Event Big\": \"Because comment\"', 0, 0, 1, 'thread_view.php?id=39', 'thread', 39, '2026-04-23 18:02:56'),
(17, 19, 'thread', 'Official Response on Your Thread', 'A moderator (Maya Reyes) has officially responded to your thread \"How can I apply for a Resident ID card for my new helper?\": \"Hello\"', 0, 0, 1, 'thread_view.php?id=34', 'thread', 34, '2026-04-23 18:39:57');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` enum('medical','education','scholarship','livelihood','assistance','legal','other') NOT NULL DEFAULT 'other',
  `service_type` enum('document','appointment','info') NOT NULL DEFAULT 'document' COMMENT 'document = online application, appointment = request-based, info = information/direct contact',
  `description` text NOT NULL,
  `approval_message` text NOT NULL COMMENT 'Instructions shown to residents when their application is approved',
  `eligibility` varchar(255) DEFAULT NULL,
  `processing_time` varchar(100) DEFAULT NULL,
  `requirements` text DEFAULT NULL COMMENT 'Raw text; lines starting with - are rendered as bullet points',
  `contact_info` text DEFAULT NULL COMMENT 'Used for info/walk-in type services only',
  `attachment_name` varchar(255) DEFAULT NULL COMMENT 'Display name of the downloadable form',
  `attachment_path` varchar(500) DEFAULT NULL COMMENT 'Server path or URL to the downloadable file',
  `max_capacity` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'NULL = unlimited; when current_count >= max_capacity the service auto-closes',
  `current_count` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Approved/accepted applicant count; auto-incremented by backend',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'FK to users table — officer who created the service',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `category`, `service_type`, `description`, `approval_message`, `eligibility`, `processing_time`, `requirements`, `contact_info`, `attachment_name`, `attachment_path`, `max_capacity`, `current_count`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(24, 'Global Medical Assistance', 'medical', 'appointment', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'Approved! Please visit the nearest hospital or something.', 'Registered Person', '3 years', '- Valid ID\r\n- Baranggay Clearance\r\n- Registration Form', '', 'Sample PDF Attachment.pdf', '/uploads/forms/form_69e22975347d81.11053593_Sample_PDF_Attachment.pdf', NULL, 0, 'active', 14, '2026-04-17 20:37:09', '2026-04-17 20:37:09'),
(25, 'Educational Helpingness', 'scholarship', 'document', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'Approved! Please visit the nearest Brgy. Hall and receive your something.', 'Student', '2-3 mins', '- School ID\r\n- Backpack\r\n- Shoes\r\n- Uniform\r\n- Notebook\r\n- Pen', '', 'Sample PDF Attachment.pdf', '/uploads/forms/form_69e229f6f1b306.05713442_Sample_PDF_Attachment.pdf', 100, 1, 'active', 14, '2026-04-17 20:39:18', '2026-04-22 20:51:10'),
(26, 'Linis Bahay Foundation typ shift', 'livelihood', 'appointment', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. \r\n\r\nCities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'Approved! We coming to yo house!', 'Resident of Brgy. Sauyo', '3 years', '- Baranggay Certificate\r\n- Certificate of Indigency\r\n- Meralco Bill', '', 'Sample PDF Attachment.pdf,HCI-Topical-Outline.pdf.pdf.pdf', '/uploads/forms/form_69e22c69d23488.80660534_Sample_PDF_Attachment.pdf,/uploads/forms/form_69e22c69d36d09.02236426_HCI-Topical-Outline.pdf.pdf.pdf', NULL, 0, 'active', 14, '2026-04-17 20:49:45', '2026-04-17 20:49:45'),
(27, 'Assistance', 'assistance', 'appointment', 'Earlier you said to make the approval message required. What if the service type is just Information & Direct Contact, which means residents who needs this service does not really apply for it, they just view the service and see information about. Services like disaster assistance or something, like there is a contact information and stuff, or like emergency assistance, these types of services doesn\'t really require the resident to \"apply\" or \"request\" for it directly on the system, these are types of services that is provided by the community but is more like something outside of a digital environment, do you get what i am saying? What approach should i do this. I was thinking something like, since the text field for it is required, i just put a placeholder saying if the service type is Info & Direct Contact, they just put something like \"N/A\" or something else, what do you think?', 'Approve! Thank you...', 'Youth', '2-5 decades', '- Yourself', '', 'FC (Revised).drawio.pdf', '/uploads/forms/form_69e22cfd185d80.23563185_FC__Revised_.drawio.pdf', NULL, 3, 'active', 14, '2026-04-17 20:52:13', '2026-04-18 16:33:50'),
(28, 'Actual Scholarship Sponsoring', 'scholarship', 'document', 'Earlier you said to make the approval message required. What if the service type is just Information & Direct Contact, which means residents who needs this service does not really apply for it, they just view the service and see information about. Services like disaster assistance or something, like there is a contact information and stuff, or like emergency assistance, these types of services doesn\'t really require the resident to \"apply\" or \"request\" for it directly on the system, these are types of services that is provided by the community but is more like something outside of a digital environment, do you get what i am saying? What approach should i do this. I was thinking something like, since the text field for it is required, i just put a placeholder saying if the service type is Info & Direct Contact, they just put something like \"N/A\" or something else, what do you think?', 'Congratulations! You are accepted...', 'Student of Quezon City University', '2-5 centuries', '- School ID\r\n- Reg Form\r\n- Enrollment Slip\r\n- Backer', '', 'Reviewer Identification.pdf', '/uploads/forms/form_69e22d6b010689.08885329_Reviewer_Identification.pdf', 500, 1, 'inactive', 14, '2026-04-17 20:54:03', '2026-04-19 15:35:52'),
(29, 'Disaster Risk Reduction Agency of Californificationality', 'assistance', 'info', 'The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way\r\nof doing things starts to feel outdated.', '', 'Registered Person of Earth', '10 decades', '', 'SK Hotline: 0919 999 92345\r\nPurok st. Amparo Subd. Makati City\r\nApartment Building 12c Floor 99', 'SE101 - Project Proposal - Task Maker.pdf', '/uploads/forms/form_69e245ba2fc100.35505818_SE101_-_Project_Proposal_-_Task_Maker.pdf', NULL, 0, 'inactive', 14, '2026-04-17 22:37:46', '2026-04-17 23:03:59'),
(30, 'Free T-Shirt', 'legal', 'document', 'Its a t-shirt. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal. Technology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way.', 'Congratulations! You get a t-shirt.', 'person', '2-3 mins', '- Pants', '', 'SE101 - Flowchart.pdf', '/uploads/forms/form_69e24da0222181.19233802_SE101_-_Flowchart.pdf', 10, 2, 'active', 14, '2026-04-17 23:11:28', '2026-04-19 13:49:27'),
(31, 'School', 'education', 'document', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'Please visit the nearest school.', 'Student', '3-5 millenia', '- Student ID\r\n- Mask\r\n- Bag\r\n- Notebook', '', 'Sample PDF Attachment.pdf', '/uploads/forms/form_69e8c70ba4b281.71610798_Sample_PDF_Attachment.pdf', NULL, 0, 'active', 14, '2026-04-22 21:03:07', '2026-04-22 21:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `service_applications`
--

CREATE TABLE `service_applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `resident_id` int(10) UNSIGNED NOT NULL COMMENT 'FK to users/residents table',
  `full_name` varchar(150) NOT NULL DEFAULT '',
  `contact` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `status` enum('pending','action_required','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `purpose` text DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fulfillment_file` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_applications`
--

INSERT INTO `service_applications` (`id`, `service_id`, `resident_id`, `full_name`, `contact`, `email`, `address`, `status`, `purpose`, `submitted_at`, `updated_at`, `fulfillment_file`) VALUES
(19, 30, 19, 'Juan etelliv', '09199531108', 'leovillete878@gmail.com', 'Caloocan City', 'rejected', 'Exxplained something in bried details...', '2026-04-19 13:40:36', '2026-04-19 13:47:21', NULL),
(20, 30, 21, 'Ycorous Ivestine Aylan Joundus', '09199531108', 'lvillete778@gmail.com', 'Caloocan City', 'approved', 'Details Details... Edited', '2026-04-19 13:42:35', '2026-04-19 13:45:57', NULL),
(21, 30, 19, 'Juan etelliv', '09199531108', 'leovillete878@gmail.com', 'Caloocan City', 'action_required', 't-shioiiiirrttt', '2026-04-19 13:49:27', '2026-04-19 13:56:37', NULL),
(22, 25, 19, 'Ico Elliets', '09199531108', 'leovillete878@gmail.com', 'Caloocan City', 'approved', 'What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a similar way. At first, a new tool\r\nfeels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it\r\nbecomes difficult to imagine doing things the old way. hello okay', '2026-04-22 20:51:10', '2026-04-23 05:48:19', NULL);

--
-- Triggers `service_applications`
--
DELIMITER $$
CREATE TRIGGER `trg_release_slot_on_rejection` AFTER UPDATE ON `service_applications` FOR EACH ROW BEGIN
    IF (NEW.status IN ('rejected', 'cancelled')) AND (OLD.status NOT IN ('rejected', 'cancelled')) THEN
        UPDATE `services`
        SET `current_count` = GREATEST(0, `current_count` - 1)
        WHERE `id` = NEW.service_id;

        UPDATE `services`
        SET `status` = 'active'
        WHERE `id` = NEW.service_id
          AND `max_capacity` IS NOT NULL
          AND `current_count` < `max_capacity`
          AND `status` = 'inactive';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_reserve_slot_on_insert` AFTER INSERT ON `service_applications` FOR EACH ROW BEGIN
    UPDATE `services`
    SET `current_count` = `current_count` + 1
    WHERE `id` = NEW.service_id;

    UPDATE `services`
    SET `status` = 'inactive'
    WHERE `id` = NEW.service_id
      AND `max_capacity` IS NOT NULL
      AND `current_count` >= `max_capacity`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`key`, `value`, `updated_at`) VALUES
('brgy_about', '', '2026-04-23 08:20:25'),
('brgy_address', '', '2026-04-23 08:20:25'),
('brgy_contact', '', '2026-04-23 08:20:25'),
('brgy_email', '', '2026-04-23 08:20:25'),
('brgy_municipality', '', '2026-04-23 08:20:25'),
('brgy_name', '', '2026-04-23 08:20:25'),
('brgy_province', '', '2026-04-23 08:20:25'),
('favicon_path', '', '2026-04-23 08:20:25'),
('logo_path', '', '2026-04-23 08:20:25'),
('sys_email', '', '2026-04-23 08:20:25'),
('sys_name', 'SKonnect', '2026-04-23 08:20:25'),
('sys_tagline', '', '2026-04-23 08:20:25'),
('sys_version', '1.0.0', '2026-04-23 08:20:25');

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

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `author_id`, `category`, `subject`, `message`, `status`, `is_removed`, `removed_by_user`, `is_flagged`, `is_pinned`, `created_at`, `updated_at`) VALUES
(25, 19, 'inquiry', 'Why a Thread', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. \r\nWhat’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal. Technology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way.', 'resolved', 0, 0, 0, 0, '2026-04-10 10:18:52', '2026-04-10 10:50:29'),
(26, 19, 'complaint', 'Broken streetlight on Main Street near the park', 'Can we get more trash bins along the jogging path?', 'pending', 0, 0, 0, 0, '2026-04-10 10:25:01', '2026-04-10 10:25:01'),
(27, 19, 'inquiry', 'Which color should we paint the new community gate?', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'pending', 0, 0, 0, 0, '2026-04-10 10:26:10', '2026-04-10 10:26:10'),
(28, 19, 'suggestion', 'This is a very long thread title intended to test the responsive layout of the dashboard sidebar and card views', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'pending', 0, 0, 0, 0, '2026-04-10 10:26:45', '2026-04-10 10:26:45'),
(29, 19, 'other', 'Found: Brown puppy with a blue collar near the gym', 'What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal. Technology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way.', 'resolved', 0, 0, 0, 0, '2026-04-10 10:27:34', '2026-04-10 17:08:49'),
(30, 19, 'inquiry', 'What are the requirements for building a new fence?', 'What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal. Technology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way.', 'pending', 0, 0, 0, 0, '2026-04-10 10:28:19', '2026-04-10 17:10:46'),
(31, 19, 'suggestion', 'Proposal for a community \"Plant Swap\" next Saturday', 'The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'pending', 0, 0, 0, 0, '2026-04-10 10:28:45', '2026-04-10 10:28:45'),
(32, 19, 'complaint', 'Loud karaoke session at House #42 beyond 11 PM', 'The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'pending', 0, 0, 0, 0, '2026-04-10 10:30:00', '2026-04-10 10:30:00'),
(33, 19, 'complaint', 'White sedan constantly blocking the fire hydrant on Daisy St.', 'The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'pending', 0, 0, 0, 0, '2026-04-10 10:30:26', '2026-04-10 10:30:26'),
(34, 19, 'inquiry', 'How can I apply for a Resident ID card for my new helper?', 'The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'responded', 0, 0, 0, 0, '2026-04-10 10:30:43', '2026-04-23 18:40:03'),
(35, 19, 'inquiry', 'Process for getting a permit to start a home-based sari-sari store', 'The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'resolved', 0, 0, 0, 0, '2026-04-10 10:31:32', '2026-04-23 18:39:36'),
(36, 19, 'inquiry', 'When is the next community general assembly meeting?', 'The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'pending', 0, 0, 0, 0, '2026-04-10 10:31:53', '2026-04-10 17:10:44'),
(37, 19, 'suggestion', 'Can we start a community vegetable garden in the vacant lot at Phase 2?', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'responded', 0, 0, 0, 1, '2026-04-10 10:35:02', '2026-04-23 18:06:20'),
(38, 21, 'complaint', 'This a thread', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'pending', 0, 0, 1, 0, '2026-04-19 15:53:54', '2026-04-23 18:04:37'),
(39, 21, 'event_question', 'Why Event Big', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a\r\ncrowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes\r\nthe center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back\r\nafter a few years, the difference is obvious.\r\nWhat’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the\r\n“new” version of the place starts to feel normal. Technology evolves in a similar way. At first, a new tool\r\nfeels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it\r\nbecomes difficult to imagine doing things the old way.\r\nThe biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates something tedious can quietly\r\nchange how people work. In the end, progress tends to look subtle while it’s happening and obvious in\r\nhindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even\r\nentire industries years down the line. Most people only realize the scale of the change once the old way\r\nof doing things starts to feel outdated.', 'responded', 0, 0, 0, 0, '2026-04-21 18:22:13', '2026-04-23 18:02:48'),
(40, 19, 'suggestion', 'Thread Notification', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious.', 'responded', 0, 0, 0, 0, '2026-04-22 20:32:56', '2026-04-22 20:36:35');

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

--
-- Dumping data for table `thread_bookmarks`
--

INSERT INTO `thread_bookmarks` (`id`, `thread_id`, `user_id`, `created_at`) VALUES
(214, 37, 19, '2026-04-10 11:41:13'),
(215, 31, 19, '2026-04-10 11:41:14'),
(216, 25, 19, '2026-04-10 11:41:16'),
(218, 38, 21, '2026-04-19 15:54:10'),
(219, 37, 21, '2026-04-19 15:54:14'),
(220, 36, 21, '2026-04-19 15:54:15');

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

--
-- Dumping data for table `thread_comments`
--

INSERT INTO `thread_comments` (`id`, `thread_id`, `author_id`, `message`, `is_removed`, `removed_by_mod`, `removed_by_user`, `is_mod_comment`, `created_at`) VALUES
(61, 25, 19, 'This is a comment!', 0, 0, 0, 0, '2026-04-10 10:22:36'),
(62, 37, 13, 'No', 0, 0, 0, 1, '2026-04-10 10:49:44'),
(63, 25, 13, 'Because', 0, 0, 0, 1, '2026-04-10 10:50:21'),
(65, 29, 19, 'Wowo', 0, 0, 0, 0, '2026-04-10 16:15:12'),
(66, 29, 13, 'Okay', 0, 0, 0, 1, '2026-04-10 17:09:00'),
(67, 28, 13, 'This is a long comment', 0, 0, 0, 1, '2026-04-10 17:15:15'),
(68, 38, 21, 'Comment', 0, 0, 0, 0, '2026-04-19 15:55:21'),
(69, 34, 21, 'Repleid', 0, 0, 0, 0, '2026-04-19 15:55:40'),
(70, 39, 21, 'Huh', 0, 0, 0, 0, '2026-04-21 18:22:30'),
(71, 37, 21, 'Commented', 0, 0, 0, 0, '2026-04-21 18:29:14'),
(72, 40, 21, 'Comment', 0, 0, 0, 0, '2026-04-22 20:35:12'),
(73, 40, 21, 'Comment', 0, 0, 0, 0, '2026-04-22 20:35:15'),
(74, 40, 21, 'Comment', 0, 0, 0, 0, '2026-04-22 20:35:16'),
(75, 40, 19, 'Commented', 0, 0, 0, 0, '2026-04-22 20:35:42'),
(76, 40, 13, 'Hello Comment', 0, 0, 0, 1, '2026-04-22 20:36:41'),
(77, 40, 23, 'proper comment', 0, 0, 0, 0, '2026-04-22 20:40:31'),
(78, 40, 23, 'This a comment', 0, 0, 0, 0, '2026-04-22 20:44:34'),
(79, 40, 13, 'another comment', 0, 0, 0, 1, '2026-04-22 20:49:40'),
(80, 39, 13, 'Because comment', 0, 0, 0, 1, '2026-04-23 18:02:56'),
(81, 34, 13, 'Hello', 0, 0, 0, 1, '2026-04-23 18:39:57');

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

--
-- Dumping data for table `thread_images`
--

INSERT INTO `thread_images` (`id`, `thread_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(56, 26, 'images (2).jpg', 'uploads/threads/26_69d85f7d267a0.jpg', '2026-04-10 10:25:01'),
(57, 29, 'parrot.jpg', 'uploads/threads/29_69d8601662958.jpg', '2026-04-10 10:27:34'),
(58, 29, 'shbrek.jpg', 'uploads/threads/29_69d86016790b8.jpg', '2026-04-10 10:27:34'),
(59, 29, 'images (2).jpg', 'uploads/threads/29_69d860168f430.jpg', '2026-04-10 10:27:34'),
(60, 31, 'highres-Canon-EOS-M50-Black-2_1519289103.jpg', 'uploads/threads/31_69d8605d108d8.jpg', '2026-04-10 10:28:45'),
(61, 32, 'images (1).jpg', 'uploads/threads/32_69d860a8ea218.jpg', '2026-04-10 10:30:00'),
(62, 40, 'images.jpg', 'uploads/threads/40_69e8bff8d9490.jpg', '2026-04-22 20:32:56'),
(63, 40, 'parrot.jpg', 'uploads/threads/40_69e8bff8e5a38.jpg', '2026-04-22 20:32:56'),
(64, 40, 'images (1).jpg', 'uploads/threads/40_69e8bff8ed418.jpg', '2026-04-22 20:32:56'),
(65, 40, 'highres-Canon-EOS-M50-Black-2_1519289103.jpg', 'uploads/threads/40_69e8bff90ff78.jpg', '2026-04-22 20:32:57');

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

--
-- Dumping data for table `thread_reports`
--

INSERT INTO `thread_reports` (`id`, `thread_id`, `reporter_id`, `category`, `note`, `status`, `created_at`) VALUES
(15, 36, 13, 'inappropriate', NULL, 'dismissed', '2026-04-10 17:07:57'),
(16, 30, 13, 'misinformation', NULL, 'dismissed', '2026-04-10 17:09:32'),
(17, 38, 13, 'spam', NULL, 'pending', '2026-04-23 18:04:37');

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

--
-- Dumping data for table `thread_supports`
--

INSERT INTO `thread_supports` (`id`, `thread_id`, `user_id`, `created_at`) VALUES
(138, 25, 19, '2026-04-10 10:22:13'),
(140, 33, 19, '2026-04-10 10:42:27'),
(141, 31, 19, '2026-04-10 10:42:28'),
(142, 32, 19, '2026-04-10 10:42:29'),
(144, 36, 19, '2026-04-14 09:02:07'),
(145, 37, 19, '2026-04-14 09:02:09'),
(146, 37, 21, '2026-04-14 13:33:38'),
(147, 34, 21, '2026-04-19 13:35:59'),
(148, 36, 21, '2026-04-19 13:36:02'),
(149, 32, 21, '2026-04-19 13:36:03'),
(151, 38, 21, '2026-04-19 15:54:07'),
(154, 37, 23, '2026-04-23 19:58:37');

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
  `verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `age`, `email`, `password`, `is_verified`, `role`, `otp_code`, `otp_expires`, `created_at`, `verified_at`) VALUES
(12, 'Rey', 'Santos', 'Cruz', 'male', '2000-03-15', 25, 'admin@skonnect.com', '$2y$10$KzsjmePIGxKHotu8yqddMeo.0ymj9w8yV2pQzWG8Lq.uERZMXrBTS', 1, 'admin', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42'),
(13, 'Maya', 'Reyes', 'Lim', 'female', '1998-07-22', 27, 'moderator@skonnect.com', '$2y$10$TJ.CZA5ds2Zy1/WM0AInzOJ1h2gkdgILcaXT.s.MRt/k6Aq2E3g1K', 1, 'moderator', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42'),
(14, 'Carlo', 'Mendoza', 'Bautista', 'male', '1995-11-05', 30, 'officer@skonnect.com', '$2y$10$fMLkG3QvcG0mJI359fgqr.2aC4aE.e4NFB2Bk4meQySGsuICdhPCO', 1, 'sk_officer', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42'),
(19, 'Bicop', 'Lmio', 'Limoy', 'male', '2000-06-12', 25, 'leovillete878@gmail.com', '$2y$10$KmqiIiwZjc/kaBBF2Fse4.9RRHFVb5LdwELbBDh.DowjqNYeYLl7i', 1, 'resident', NULL, NULL, '2026-04-01 07:07:15', '2026-04-01 07:07:40'),
(21, 'Icolet', 'Etelevyssuraon', 'M', 'male', '2005-12-06', 20, 'lvillete778@gmail.com', '$2y$10$knYxZt1PVjvM1vZBKkntQuigJUo8MCQxEtZxiiP8T0ltYmfRPXOsW', 1, 'resident', NULL, NULL, '2026-04-14 05:32:51', '2026-04-14 05:33:17'),
(23, 'Icorousius Dleavo', 'Debrovaniael', 'Chapo', 'male', '2009-09-09', 16, 'villete.leonardo.buya@gmail.com', '$2y$10$o6edMbxNV/aZaEckjNA4BO1pSDSkRR0XR26HJnKjmfY7Ew2hXtHKu', 1, 'resident', NULL, NULL, '2026-04-19 06:09:03', '2026-04-19 06:09:35');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `trg_user_profile_init` AFTER INSERT ON `users` FOR EACH ROW INSERT IGNORE INTO `user_profiles` (`user_id`) VALUES (NEW.`id`)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_user_status_init` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO `user_status` (`user_id`) VALUES (NEW.`id`)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_id` int(11) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL COMMENT 'CRITICAL — required for full profile',
  `purok` varchar(100) DEFAULT NULL COMMENT 'CRITICAL — required for full profile',
  `street_address` varchar(255) DEFAULT NULL,
  `civil_status` enum('single','married','widowed','separated','annulled') DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `educational_attainment` enum('elementary','high_school','senior_high','vocational','college_level','college_graduate','post_graduate') DEFAULT NULL,
  `school_institution` varchar(255) DEFAULT NULL,
  `course_strand` varchar(255) DEFAULT NULL,
  `employment_status` enum('student','employed','unemployed','self_employed') DEFAULT NULL,
  `is_registered_voter` tinyint(1) NOT NULL DEFAULT 0,
  `avatar_path` varchar(500) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`user_id`, `mobile_number`, `purok`, `street_address`, `civil_status`, `nationality`, `religion`, `educational_attainment`, `school_institution`, `course_strand`, `employment_status`, `is_registered_voter`, `avatar_path`, `updated_at`) VALUES
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-21 12:49:47'),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-21 12:49:47'),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-21 12:49:47'),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-21 12:49:47'),
(21, '09199119191', 'Purok 3', '123 Sampaguita Hall', 'single', 'Filipino', 'Roman Iglesia Ni Chrirst Almighty', NULL, NULL, NULL, NULL, 0, NULL, '2026-04-21 13:38:28'),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2026-04-21 12:49:47');

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

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE `user_status` (
  `user_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `banned_reason` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `feed_ban_level` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=none, 2=7-day ban, 3=permanent ban',
  `feed_ban_expires` datetime DEFAULT NULL COMMENT 'NULL = permanent; populated for level-2 7-day bans'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`user_id`, `is_active`, `is_banned`, `banned_reason`, `is_deleted`, `deleted_at`, `feed_ban_level`, `feed_ban_expires`) VALUES
(12, 1, 0, NULL, 0, NULL, 0, NULL),
(13, 1, 0, NULL, 0, NULL, 0, NULL),
(14, 1, 0, NULL, 0, NULL, 0, NULL),
(19, 1, 0, NULL, 0, NULL, 0, NULL),
(21, 1, 0, NULL, 0, NULL, 0, NULL),
(23, 1, 0, NULL, 0, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_al_user` (`user_id`),
  ADD KEY `idx_al_action` (`action`),
  ADD KEY `idx_al_created` (`created_at`);

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
-- Indexes for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_doc_application` (`application_id`);

--
-- Indexes for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_an_application` (`application_id`);

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_event_date` (`event_date`),
  ADD KEY `fk_event_author` (`created_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_user` (`user_id`),
  ADD KEY `idx_notif_user_dismissed` (`user_id`,`is_dismissed`),
  ADD KEY `idx_notif_user_read` (`user_id`,`is_read`),
  ADD KEY `idx_notif_created` (`created_at`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_type` (`service_type`);

--
-- Indexes for table `service_applications`
--
ALTER TABLE `service_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_service` (`service_id`),
  ADD KEY `idx_resident` (`resident_id`),
  ADD KEY `idx_app_status` (`status`),
  ADD KEY `idx_sa_resident` (`resident_id`),
  ADD KEY `idx_sa_service` (`service_id`),
  ADD KEY `idx_sa_status` (`status`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

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
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_sanctions`
--
ALTER TABLE `user_sanctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_us_user` (`user_id`),
  ADD KEY `idx_us_issued` (`issued_by`),
  ADD KEY `idx_us_report` (`report_id`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `idx_us_active` (`is_active`),
  ADD KEY `idx_us_banned` (`is_banned`),
  ADD KEY `idx_us_deleted` (`is_deleted`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `announcement_bookmarks`
--
ALTER TABLE `announcement_bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `announcement_files`
--
ALTER TABLE `announcement_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `application_documents`
--
ALTER TABLE `application_documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `application_notes`
--
ALTER TABLE `application_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `comment_replies`
--
ALTER TABLE `comment_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `comment_reports`
--
ALTER TABLE `comment_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `comment_supports`
--
ALTER TABLE `comment_supports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `service_applications`
--
ALTER TABLE `service_applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `thread_bookmarks`
--
ALTER TABLE `thread_bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `thread_comments`
--
ALTER TABLE `thread_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `thread_images`
--
ALTER TABLE `thread_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `thread_reports`
--
ALTER TABLE `thread_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `thread_supports`
--
ALTER TABLE `thread_supports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_sanctions`
--
ALTER TABLE `user_sanctions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_al_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Constraints for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD CONSTRAINT `fk_appdoc_application` FOREIGN KEY (`application_id`) REFERENCES `service_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `application_notes`
--
ALTER TABLE `application_notes`
  ADD CONSTRAINT `fk_an_application` FOREIGN KEY (`application_id`) REFERENCES `service_applications` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_event_author` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_applications`
--
ALTER TABLE `service_applications`
  ADD CONSTRAINT `fk_app_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `fk_up_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_sanctions`
--
ALTER TABLE `user_sanctions`
  ADD CONSTRAINT `fk_us_issuer` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_us_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_status`
--
ALTER TABLE `user_status`
  ADD CONSTRAINT `fk_user_status_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
