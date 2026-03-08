-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2026 at 02:01 PM
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
(8, 'THIS A ANNOUNCEMENT SDKS', 'RRAAAAAHHH!!! Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal.\r\n\r\nTechnology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way. The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work.\r\n\r\nIn the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'event', 1, '2026-03-07 20:56:00', '/SKonnect/assets/uploads/banners/69abda58a5de87.28722771.jpg', 14, '2026-03-06 16:00:00', '2026-03-08 03:56:00', '2026-03-08', 'active', NULL),
(9, 'APRIL ANOUNCEMUNT', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal.\r\n\r\nTechnology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way. The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work.\r\n\r\nIn the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69abd33f6fdd85.92713649.jpg', 14, '2026-03-06 16:00:00', '2026-03-07 08:25:11', '2026-04-09', 'archived', NULL),
(10, 'SHREEEEEEEEEEIKIISSUUAHUSHAUB', '<div style=\"text-align: justify;\"><span style=\"color: var(--off-text-body);\"><b>Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new”&nbsp;</b></span></div><div style=\"text-align: justify;\"><br></div><div style=\"text-align: justify;\"><i>version of the place starts to feel normal.\r\n\r\nTechnology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way.&nbsp;</i></div><div style=\"text-align: justify;\"><br></div><div style=\"text-align: justify;\"><u>T</u><span style=\"color: var(--off-text-body);\"><u>he biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work.\r\n\r\nIn the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line.</u>&nbsp;</span></div><div style=\"text-align: justify;\"><span style=\"color: var(--off-text-body);\"><br></span></div><div style=\"text-align: justify;\"><span style=\"color: var(--off-text-body);\">Most people only realize the scale of the change once the old way of doing things starts to feel outdated.</span></div>', 'urgent', 0, NULL, '/SKonnect/assets/uploads/banners/69abdfc83f7a06.63831597.jpg', 14, '2026-03-06 16:00:00', '2026-03-08 02:27:47', '2026-03-14', 'active', NULL),
(11, 'Lebn', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal.\r\n\r\nTechnology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way. The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work.\r\n\r\nIn the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.', 'program', 1, NULL, '/SKonnect/assets/uploads/banners/69abd3b1436e87.84234426.jpg', 14, '2026-03-06 16:00:00', '2026-03-07 07:28:49', '2026-03-17', 'active', NULL),
(13, 'BRUH', 'Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal.\r\n\r\nTechnology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way. The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work.', 'meeting', 0, NULL, '/SKonnect/assets/uploads/banners/69abdf2cdb7b89.16449847.jpg', 14, '2026-03-06 16:00:00', '2026-03-08 12:58:20', '2026-03-10', 'draft', NULL),
(14, 'FEATURES ANONMENT', 'Words a lot of words', 'meeting', 1, NULL, '/SKonnect/assets/uploads/banners/69ac193fd84f00.24907886.jpg', 14, '2026-03-06 16:00:00', '2026-03-07 12:25:35', '2026-03-08', 'active', NULL),
(16, 'Detals', 'BNdsyuhbduhabds', 'urgent', 0, NULL, '/SKonnect/assets/uploads/banners/69ac2a8782f507.57464327.jpg', 14, '2026-03-06 16:00:00', '2026-03-07 13:39:19', NULL, 'draft', NULL),
(17, 'NEW ANNONECMENT', '<div style=\"text-align: center;\"><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\">Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes <u>the center of a neighborhood’s routine.&nbsp;</u></span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div><div style=\"text-align: right;\"><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\">These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—<i>new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal.</i> Technology evolves in a similar way.&nbsp;</span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><b>At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way. </b>The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight.&nbsp;</span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div style=\"text-align: justify;\"><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><b>What </b>feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated.</span></div></div><div style=\"text-align: justify;\"><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div style=\"text-align: justify;\"><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div style=\"text-align: justify;\"><ul><li><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\">Hello</span></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">This&nbsp;</span></font></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">Is</span></font></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">A</span></font></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">List</span></font></li></ul><div><font color=\"#334155\"><span style=\"font-size: 15.5px;\"><br></span></font></div><div><ol><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">This</span></font></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">one</span></font></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">is</span></font></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">numbered</span></font></li><li><font color=\"#334155\"><span style=\"font-size: 15.5px;\">list</span></font></li></ol><div><font color=\"#334155\"><span style=\"font-size: 15.5px;\"><br></span></font></div></div><div><font color=\"#334155\"><span style=\"font-size: 15.5px;\"><a href=\"https://youtube.com\" target=\"_blank\" rel=\"noopener noreferrer\">https://youtube.com</a><br></span></font></div></div>', 'event', 0, NULL, '/SKonnect/assets/uploads/banners/69acdba5067208.54888083.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 04:09:20', NULL, 'archived', NULL),
(18, 'Something', '<div style=\"text-align: center;\"><b>Details</b></div>', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69ace3a33c3489.10586748.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 02:49:07', NULL, 'active', NULL),
(19, 'ABUDABIIIIABDHSABDHBJHDW', '<b>Some words</b>', 'program', 0, NULL, '/SKonnect/assets/uploads/banners/69ace57702fa85.06781619.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 02:56:55', '2026-03-09', 'active', NULL),
(20, 'esvdcfbsuabdiasubd', '<b>saduaisbndiuabnisnd</b>', 'urgent', 0, NULL, '/SKonnect/assets/uploads/banners/69ace908a51688.59594321.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 03:12:08', NULL, 'active', NULL),
(21, 'SHMREK', 'wordssss', 'program', 1, NULL, '/SKonnect/assets/uploads/banners/69acedd61baf87.23220689.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 03:32:38', NULL, 'active', NULL),
(22, 'LEBON YAMES', '<b>balls</b>', 'notice', 1, '2026-03-07 20:56:42', '/SKonnect/assets/uploads/banners/69aceeb59be889.58208525.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 03:56:42', NULL, 'active', NULL),
(23, 'UNC ANONMENT', '<span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\">RRAAAAAHHH!!! Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal.&nbsp;</span><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><b>Technology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way.&nbsp;</b></span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></span></div><div><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\">The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated</span></div>', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69ad5a579e14c1.13977982.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 11:15:35', NULL, 'active', NULL),
(24, 'SHBREVEUSOMENT', '<div style=\"text-align: justify;\"><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><b>RRAAAAAHHH!!! Cities change faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new”&nbsp;</b></span></div><b><font color=\"#334155\"><div style=\"text-align: justify;\"><span style=\"font-size: 15.5px;\"><br></span></div></font><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><div style=\"text-align: justify;\">version of the place starts to feel normal. Technology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way. The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system,&nbsp;</div></span><font color=\"#334155\"><div style=\"text-align: justify;\"><span style=\"font-size: 15.5px;\"><br></span></div></font><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><div style=\"text-align: justify;\">a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progress tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end u</div></span><font color=\"#334155\"><div style=\"text-align: justify;\"><span style=\"font-size: 15.5px;\"><br></span></div></font><span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><div style=\"text-align: justify;\">p shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated</div></span></b>', 'meeting', 1, '2026-03-08 04:18:35', '/SKonnect/assets/uploads/banners/69ad5b0b59b8c7.97487123.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 11:18:35', NULL, 'active', NULL),
(25, 'SOMETHING PURPOSES', '<span style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><b>Cities change</b> faster than most people notice. A café that used to be a quiet study spot becomes a crowded hangout, an empty lot turns into a condo tower, and a street that felt ordinary suddenly becomes the center of a neighborhood’s routine. These changes rarely happen overnight, but when you look back after a few years, the difference is obvious. What’s interesting is how people adapt to it—new habits form, new shortcuts appear, and eventually the “new” version of the place starts to feel normal.&nbsp;</span><div style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></div><div style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></div><div style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><span style=\"font-weight: 700;\">Technology evolves in a similar way. At first, a new tool feels unnecessary or complicated, but once people figure out how it fits into their daily workflow, it becomes difficult to imagine doing things the old way.&nbsp;</span></div><div style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><br></div><div style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><u>The biggest shifts usually aren’t flashy innovations; they’re small improvements that remove friction. A slightly faster system, a cleaner interface, or a feature that automates something tedious can quietly change how people work. In the end, progre</u></div><div style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><i><br></i></div><div style=\"color: rgb(51, 65, 85); font-size: 15.5px;\"><i>ss tends to look subtle while it’s happening and obvious in hindsight. What feels like a minor adjustment today can end up shaping routines, expectations, and even entire industries years down the line. Most people only realize the scale of the change once the old way of doing things starts to feel outdated</i></div>', 'program', 0, NULL, '/SKonnect/assets/uploads/banners/69ad722799bc47.33486639.jpg', 14, '2026-03-07 16:00:00', '2026-03-08 12:57:11', '2026-03-09', 'active', NULL);

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
(1, 8, '/SKonnect/assets/uploads/attachments/69abd2e8c1fe85.22559137.pdf'),
(2, 9, '/SKonnect/assets/uploads/attachments/69abd33f7b6389.40799032.docx'),
(3, 9, '/SKonnect/assets/uploads/attachments/69abd33f8bbf02.11793880.xlsx'),
(4, 9, '/SKonnect/assets/uploads/attachments/69abd33fccbc85.48370542.pdf'),
(5, 10, '/SKonnect/assets/uploads/attachments/69abd38a269f85.88296441.docx'),
(6, 10, '/SKonnect/assets/uploads/attachments/69abd38a42b307.01253328.pdf'),
(7, 11, '/SKonnect/assets/uploads/attachments/69abd3b14b0009.68712151.docx'),
(10, 8, '/SKonnect/assets/uploads/attachments/69abda58b21384.18840809.pdf'),
(11, 8, '/SKonnect/assets/uploads/attachments/69abda58bc5481.23614037.docx'),
(12, 13, '/SKonnect/assets/uploads/attachments/69abdf2ce48408.38391575.pdf'),
(14, 14, '/SKonnect/assets/uploads/attachments/69ac0b2a493e08.79256420.pdf'),
(15, 8, '/SKonnect/assets/uploads/attachments/69ac120cd6b285.69025179.xlsx'),
(16, 14, '/SKonnect/assets/uploads/attachments/69ac193fe82d84.69880479.docx'),
(17, 17, '/SKonnect/assets/uploads/attachments/69acdba53c2806.12500537.pdf'),
(18, 18, '/SKonnect/assets/uploads/attachments/69ace3a34a9c00.64719518.docx'),
(19, 19, '/SKonnect/assets/uploads/attachments/69ace5770b4786.97008294.pdf'),
(20, 21, '/SKonnect/assets/uploads/attachments/69acedd62c0b09.39708431.xlsx'),
(21, 22, '/SKonnect/assets/uploads/attachments/69aceeb5a85c06.43720516.pdf'),
(22, 22, '/SKonnect/assets/uploads/attachments/69aceeb5b87900.27968849.docx'),
(23, 23, '/SKonnect/assets/uploads/attachments/69ad5a5824cac8.64241103.pdf'),
(24, 24, '/SKonnect/assets/uploads/attachments/69ad5b0b860ec4.14714836.pdf'),
(25, 24, '/SKonnect/assets/uploads/attachments/69ad5b0b901145.26315155.docx'),
(26, 25, '/SKonnect/assets/uploads/attachments/69ad7227e306c1.54846688.pdf'),
(27, 25, '/SKonnect/assets/uploads/attachments/69ad72280e1646.96780698.docx');

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
(16, 'Bico', 'Sico', 'Qiko', 'male', '2000-06-01', 25, 'lvillete778@gmail.com', '$2y$10$81dUyp094tK6Q2f1FunUGumzPC8ihrKWTUQVXyJBdV.uwRLtQ2rSm', 1, 'resident', NULL, NULL, '2026-03-04 23:42:45', '2026-03-04 23:43:10');

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
-- Indexes for table `announcement_files`
--
ALTER TABLE `announcement_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `announcement_files`
--
ALTER TABLE `announcement_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
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
-- Constraints for table `announcement_files`
--
ALTER TABLE `announcement_files`
  ADD CONSTRAINT `fk_attachment_announcement` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
