-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2026 at 02:19 PM
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
(26, 'THIS IS ANNOUNCEMENT', '<p class=\"MsoNormal\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><b>Cities change faster than\r\nmost people notice. A café that used to be a quiet study spot becomes a crowded\r\nhangout, an empty lot turns into a condo tower, and a street that felt ordinary\r\nsuddenly becomes the center of a neighborhood\'s routine. </b><i>These changes rarely\r\nhappen overnight, but when you look back after a few years, the difference is\r\nobvious. </i><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align: right;\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><u>What\'s interesting is how\r\npeople adapt to it—new habits form, new shortcuts appear, and eventually the\r\n"new" version of the place starts to feel normal. Technology evolves in a\r\nsimilar way. At first, a new tool feels unnecessary or complicated, but once\r\npeople figure out how it fits into their daily workflow, it becomes difficult\r\nto imagine doing things the old way. </u><o:p></o:p></span></p>\r\n\r\n<p class=\"MsoNormal\" style=\"text-align: center;\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85); background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\"><b>The biggest shifts usually\r\naren\'t flashy innovations; they\'re small improvements that remove friction. A\r\nslightly faster system, a cleaner interface, or a feature that automates\r\nsomething tedious can quietly change how people work. In the end, progress\r\ntends to look subtle while it\'s happening and obvious in hindsight.</b> <i>What feels\r\nlike a minor adjustment today can end up shaping routines, expectations, and\r\neven entire industries years down the line. Most people only realize the scale\r\nof the change once the old way of doing things starts to feel outdated.</i></span></p>', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69afe72d46ff09.24530889.jpg', 14, '2026-03-09 16:00:00', '2026-03-10 09:41:01', NULL, 'active', NULL),
(27, 'ANNOUNCEMENT PART 2', '<p class=\"MsoNormal\" style=\"text-align: center;\"><span style=\"font-size: 10pt; line-height: 115%; font-family: Arial, &quot;sans-serif&quot;; color: rgb(51, 65, 85);\">Cities change faster than most people notice.</span></p>', 'event', 0, NULL, '/SKonnect/assets/uploads/banners/69afe77c0e9982.33389332.jpg', 14, '2026-03-09 16:00:00', '2026-03-10 09:42:20', NULL, 'active', NULL),
(28, 'ANNOUNCEMENT ABOUT', '<p class=\"MsoNormal\"><b>Cities change faster than most people notice.</b></p>', 'urgent', 0, NULL, '/SKonnect/assets/uploads/banners/69afe7adaad982.13032275.jpg', 14, '2026-03-09 16:00:00', '2026-03-10 09:43:09', NULL, 'active', NULL),
(29, 'ANNOUNCEMENT DETAIL', '<p class=\"MsoNormal\">Cities change faster than most people notice.</p>', 'meeting', 1, '2026-03-10 02:44:03', '/SKonnect/assets/uploads/banners/69afe7e31e3983.05128124.jpg', 14, '2026-03-09 16:00:00', '2026-03-10 09:44:03', NULL, 'active', NULL),
(30, 'ANNOUNCEMENT: TITLE', '<p class=\"MsoNormal\"><u>Cities change faster than most people notice.</u></p>', 'program', 1, '2026-03-10 02:44:51', '/SKonnect/assets/uploads/banners/69afe813589305.35494688.jpg', 14, '2026-03-09 16:00:00', '2026-03-12 12:16:11', NULL, 'archived', '2026-03-12 12:16:11'),
(31, 'LIMITED ANNOUNCEMENT', '<p class=\"MsoNormal\"><i>Cities change faster than most people notice.</i></p>', 'program', 0, NULL, '/SKonnect/assets/uploads/banners/69afe85084c388.52807783.jpg', 14, '2026-03-09 16:00:00', '2026-03-12 00:09:47', '2026-03-11', 'archived', '2026-03-12 00:09:47'),
(32, 'SHREK', '<div style=\"text-align: center;\"><b><i><u>shrek</u></i></b></div>', 'urgent', 0, NULL, '/SKonnect/assets/uploads/banners/69afe897dd6309.31103272.jpg', 14, '2026-03-09 16:00:00', '2026-03-10 09:48:15', NULL, 'archived', '2026-03-10 09:48:15'),
(33, 'FINAL ANNOUNCEMENT', '<p class=\"MsoNormal\"><u><b><i>Cities change faster than most people notice.</i></b></u></p>', 'notice', 0, NULL, '/SKonnect/assets/uploads/banners/69afe8ca542e02.55525821.jpg', 14, '2026-03-09 16:00:00', '2026-03-10 09:47:54', NULL, 'draft', NULL),
(34, 'SCBRTEV', '<b>AAAAAAAAAAAAAAAAAAAAAA</b>', 'program', 1, '2026-03-12 02:45:43', '/SKonnect/assets/uploads/banners/69b28b47a03487.36488750.jpg', 14, '2026-03-11 16:00:00', '2026-03-12 09:45:43', NULL, 'active', NULL),
(35, 'SUMN', '<p class=\"MsoNormal\">Cities change faster than most people notice.</p>', 'event', 0, NULL, '/SKonnect/assets/uploads/banners/69b29083e93408.35570242.jpg', 14, '2026-03-11 16:00:00', '2026-03-12 10:08:03', NULL, 'active', NULL),
(36, 'SUMN ANNOUCNEMENTs', 'wor dsi fdfnei sindas psndai sdianw sodnask sidnpa.', 'notice', 1, '2026-03-12 03:23:56', '/SKonnect/assets/uploads/banners/69b2943c7a8f09.69565276.jpg', 14, '2026-03-11 16:00:00', '2026-03-12 10:23:56', NULL, 'active', NULL);

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

INSERT INTO `announcement_bookmarks` (`id`, `user_id`, `announcement_id`, `created_at`) VALUES
(6, 16, 26, '2026-03-12 10:52:46'),
(9, 16, 28, '2026-03-12 10:58:25'),
(13, 16, 34, '2026-03-12 11:54:28'),
(14, 16, 30, '2026-03-12 11:54:31'),
(15, 17, 26, '2026-03-12 13:05:10'),
(16, 17, 28, '2026-03-12 13:05:11'),
(17, 17, 35, '2026-03-12 13:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_files`
--

CREATE TABLE `announcement_files` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) NOT NULL,
  `file_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `announcement_files` (`id`, `announcement_id`, `file_path`) VALUES
(28, 26, '/SKonnect/assets/uploads/attachments/69afe72d585485.12483495.pdf'),
(29, 26, '/SKonnect/assets/uploads/attachments/69afe72d631282.08105108.docx'),
(30, 27, '/SKonnect/assets/uploads/attachments/69afe77c1bc885.13038723.pdf'),
(31, 28, '/SKonnect/assets/uploads/attachments/69afe7adb55902.07055831.docx'),
(32, 29, '/SKonnect/assets/uploads/attachments/69afe7e329f184.35302798.pdf'),
(33, 30, '/SKonnect/assets/uploads/attachments/69afe81363ce09.66793592.pdf'),
(34, 31, '/SKonnect/assets/uploads/attachments/69afe85095da80.54316681.xlsx'),
(35, 32, '/SKonnect/assets/uploads/attachments/69afe897e9d684.00068557.pdf'),
(36, 32, '/SKonnect/assets/uploads/attachments/69afe89803db82.77614094.docx'),
(37, 33, '/SKonnect/assets/uploads/attachments/69afe8ca5c7b00.66501644.xlsx'),
(38, 34, '/SKonnect/assets/uploads/attachments/69b28b47caee08.45949229.xlsx'),
(39, 36, '/SKonnect/assets/uploads/attachments/69b2943c883b07.82706176.docx');

-- --------------------------------------------------------

--
-- Table structure for table `users`
-- *** UPDATED: added is_active, is_banned, is_deleted, banned_reason, deleted_at ***
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
  `is_active` tinyint(1) DEFAULT 1,
  `is_banned` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `banned_reason` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `role` enum('resident','moderator','sk_officer','admin') NOT NULL DEFAULT 'resident',
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `age`, `email`, `password`, `is_verified`, `is_active`, `is_banned`, `is_deleted`, `banned_reason`, `deleted_at`, `role`, `otp_code`, `otp_expires`, `created_at`, `verified_at`) VALUES
(12, 'Rey', 'Santos', 'Cruz', 'male', '2000-03-15', 25, 'admin@skonnect.com', '$2y$10$KzsjmePIGxKHotu8yqddMeo.0ymj9w8yV2pQzWG8Lq.uERZMXrBTS', 1, 1, 0, 0, NULL, NULL, 'admin', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42'),
(13, 'Maya', 'Reyes', 'Lim', 'female', '1998-07-22', 27, 'moderator@skonnect.com', '$2y$10$TJ.CZA5ds2Zy1/WM0AInzOJ1h2gkdgILcaXT.s.MRt/k6Aq2E3g1K', 1, 1, 0, 0, NULL, NULL, 'moderator', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42'),
(14, 'Carlo', 'Mendoza', 'Bautista', 'male', '1995-11-05', 30, 'officer@skonnect.com', '$2y$10$fMLkG3QvcG0mJI359fgqr.2aC4aE.e4NFB2Bk4meQySGsuICdhPCO', 1, 1, 0, 0, NULL, NULL, 'sk_officer', NULL, NULL, '2026-03-04 09:09:42', '2026-03-04 09:09:42'),
(16, 'Bico', 'Sico', 'Qiko', 'male', '2000-06-01', 25, 'lvillete778@gmail.com', '$2y$10$81dUyp094tK6Q2f1FunUGumzPC8ihrKWTUQVXyJBdV.uwRLtQ2rSm', 1, 1, 0, 0, NULL, NULL, 'resident', NULL, NULL, '2026-03-04 23:42:45', '2026-03-04 23:43:10'),
(17, 'Leonardo', 'Da Bink', 'name', 'male', '2000-12-06', 25, 'leovillete878@gmail.com', '$2y$10$i13F0LkhcH4AGgYUlcYq3.jSJr7iKCtSJcCpzVc68jof0jT61aGGe', 1, 1, 0, 0, NULL, NULL, 'resident', NULL, NULL, '2026-03-12 13:04:16', '2026-03-12 13:04:35');

-- --------------------------------------------------------

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
-- Indexes for table `users`
-- *** NOTE: email is NOT UNIQUE here intentionally ***
-- *** para pede ulit magamit ang email ng deleted accounts ***
-- *** Instead, unique check ay sa application level (PHP) ***
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_otp` (`otp_code`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_is_deleted` (`is_deleted`),
  ADD KEY `idx_is_active` (`is_active`),
  ADD KEY `idx_is_banned` (`is_banned`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `announcement_bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `announcement_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints
--

ALTER TABLE `announcements`
  ADD CONSTRAINT `fk_announcement_authorA` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `announcement_bookmarks`
  ADD CONSTRAINT `fk_bm_announcement` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bm_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `announcement_files`
  ADD CONSTRAINT `fk_attachment_announcement` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;