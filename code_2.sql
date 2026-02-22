-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 22, 2026 lúc 03:38 AM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `code_2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$nIOuUW6PoLpvMC5RWw/jMeXtrlfKNE2KvjtUvAkVY.hgtjSrODTly', '2026-02-09 19:28:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `fb_pages`
--

CREATE TABLE `fb_pages` (
  `id` int NOT NULL,
  `page_id` varchar(50) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_avatar` text,
  `access_token` text NOT NULL,
  `token_page` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `fb_pages`
--

INSERT INTO `fb_pages` (`id`, `page_id`, `page_name`, `page_avatar`, `access_token`, `token_page`, `created_at`) VALUES
(1, '907468582460732', 'Duxng 2', 'https://scontent.fvii1-1.fna.fbcdn.net/v/t39.30808-1/629481801_2184480755626608_7894218572918503047_n.jpg?stp=cp0_dst-jpg_s50x50_tt6&_nc_cat=109&ccb=1-7&_nc_sid=f907e8&_nc_eui2=AeHpSaT7PL7PprUhgSx2wkwQGOcKcO2_lWoY5wpw7b-VaqyqPwi9G1o2SPPIRjW-XFKZqiUTZ78oYTTTWZHCruP5&_nc_ohc=FqmAg2FZaa8Q7kNvwHQoOnU&_nc_oc=Adld4CBISW8y2a2Uu-AhXTd-weMGny9mj8pHp6p_jnWXCnRBJZjJM3pZxwa3w10ZSnYJ55n3rtdVJDznKHL7V8HX&_nc_zt=24&_nc_ht=scontent.fvii1-1.fna&edm=AJdBtusEAAAA&_nc_gid=NLdeoU6h2-ODYphQ-4X_WA&_nc_tpa=Q5bMBQFfo6M99UV_TCbmc86s2ftm1QGpUZpsGRfIbCnXHtbs1SbPrUZtE_JUFq9fxIfoOo4dJPnLf6aUdqU&oh=00_Afuwb3SBTdhDbtdAYFYQ6Dw7Ffjy7lwKUyxWRhmZ_kSZGA&oe=6995D166', 'EAF2cVxD1TYsBQgFZA4EnoXOzMLF9cDc2Cx13ZBZBVTFChxQR3hfWSZBIZCiHJXDqKP5NZAQNoBY0ibzuPZBHsOCnDfpfF1ZCOsjVJLPiYpBV4F7WbH1jpk100b3J2xlop7ALPZBNUSq1nHXi2JfdxHoaFEIEw76gM35Rowj3zHrTbZCK4BgQ17VSr120tEhGrueUablwIZAEyBOookAGCrcWkmNpczQPjHKIZCoE', 'EAF2cVxD1TYsBQnC6OxEC2gZB7ZALohmmQa30b6cZBbqZBzxWTiPwAQuvLbZC2tUvYQMZAATZCEZCmiZAkaBzhszeWKW507OCDv2UxljSl6cYwRvnAJ9ZBxY07fD2ZClKQ0BuMu2bz6HYpUyEiWTlfoi986tPDle7LZCC321ZASgTwwLo14QlF9bPeCzGjYo3nWwignNrEgWOjvTZCj21ZAlGkkuab9IVn097BYuXywnZAZAiKlt8ZD', '2026-02-13 12:57:26'),
(2, '1019525864569427', 'Duxng', 'https://scontent.fvii1-1.fna.fbcdn.net/v/t39.30808-1/627745201_2183956792345671_6990971155954959983_n.jpg?stp=cp0_dst-jpg_s50x50_tt6&_nc_cat=107&ccb=1-7&_nc_sid=f907e8&_nc_eui2=AeHLzXut8DufdnsAxS2FeZYYcfrWycQE7Atx-tbJxATsCwwUzVshHcjOx7X8R-9cwCA2BDceHF-p40TazjTVQ5Wm&_nc_ohc=S9zrjVTxagkQ7kNvwGx_zKK&_nc_oc=AdmCbh47uWlE8Hyp78h5de4EkTOuqiKWJFBsuq5oRPVVl-FpqUDuUUyepaJUdRZnTegh5Uxwi6aaB_q_sLqNsdc8&_nc_zt=24&_nc_ht=scontent.fvii1-1.fna&edm=AJdBtusEAAAA&_nc_gid=z8b02wT87E1ABoovlvcN3A&_nc_tpa=Q5bMBQE5AH4NJyUyKX17s_PjVtr-D_MVHNc-Hyxuk4MObxSIRcmido757iWfsuHxpDjPQYkpbuj-bKj8xzs&oh=00_AftPC8m8zkySsFb652XQOvZ7jgkluicZNVrwJLkrR_KwBw&oe=6995D1FC', 'EAF2cVxD1TYsBQgFZA4EnoXOzMLF9cDc2Cx13ZBZBVTFChxQR3hfWSZBIZCiHJXDqKP5NZAQNoBY0ibzuPZBHsOCnDfpfF1ZCOsjVJLPiYpBV4F7WbH1jpk100b3J2xlop7ALPZBNUSq1nHXi2JfdxHoaFEIEw76gM35Rowj3zHrTbZCK4BgQ17VSr120tEhGrueUablwIZAEyBOookAGCrcWkmNpczQPjHKIZCoE', 'EAF2cVxD1TYsBQuzbIi962NXTZBoxh3AtD6jsiGm48E7N8ShzYGtsxqbyfoCHDeaXb1D2kC0n5ZAUYd9H8ialzWGFBsI7vIFC5wmBWmZCfNKmboBjFyZALjCWftBAooz0LpGS2MTAsd1meAu2g61LToxpmfFJMOUwyoffZBGXdeIhHdeYYWdRiDpVdbF8MoKb89SYAZADjXf6T3kCXbZCvi18KGakzBZCy2LNpNjhiXoOtZCwZD', '2026-02-13 12:57:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menus`
--

CREATE TABLE `menus` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(5, 'Tình yêu', '2026-02-13 12:57:56', '2026-02-13 12:57:56'),
(6, 'Anime', '2026-02-13 13:54:05', '2026-02-13 13:54:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `page_id` varchar(50) DEFAULT NULL,
  `menu_id` int DEFAULT NULL,
  `fb_post_id` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `media_type` enum('image','video','none') DEFAULT 'none',
  `media_path` varchar(255) DEFAULT NULL,
  `status` enum('draft','scheduled','posted') DEFAULT 'draft',
  `scheduled_at` datetime DEFAULT NULL,
  `posted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `page_id`, `menu_id`, `fb_post_id`, `content`, `media_type`, `media_path`, `status`, `scheduled_at`, `posted_at`, `created_at`) VALUES
(1, '1019525864569427', 5, '1019525864569427_122099052915262419', 'Yêu ăng Đẹt', 'image', 'uploads/posts/58736tải xuống.jpg', 'posted', NULL, '2026-02-13 05:58:24', '2026-02-13 12:58:24'),
(2, '1019525864569427', 6, '1019525864569427_122099124693262419', 'Hi', 'none', NULL, 'posted', NULL, '2026-02-13 07:54:44', '2026-02-13 14:54:44'),
(3, '1019525864569427', 6, '1019525864569427_122099201103262419', 'Hi', 'none', NULL, 'posted', NULL, '2026-02-13 09:59:28', '2026-02-13 16:59:28'),
(4, '907468582460732', 5, '907468582460732_122098041009265600', 'Hi', 'none', NULL, 'posted', NULL, '2026-02-13 10:35:41', '2026-02-13 17:35:41'),
(5, '907468582460732', 5, '907468582460732_122098041831265600', 'Lên lịch test', 'none', NULL, 'posted', '2026-02-14 10:36:00', '2026-02-14 15:47:28', '2026-02-13 17:36:51'),
(6, '1019525864569427', 5, '1019525864569427_122099897139262419', 'Yêu ăng Đẹt', 'image', 'uploads/posts/58736tải xuống.jpg', 'posted', NULL, '2026-02-14 01:47:26', '2026-02-14 08:47:26'),
(7, '1019525864569427', 6, '1019525864569427_122099897163262419', 'Hi', 'none', NULL, 'posted', NULL, '2026-02-14 01:47:28', '2026-02-14 08:47:28'),
(8, '1019525864569427', 5, '1019525864569427_122099916231262419', 'Yêu ăng Đẹt', 'image', 'uploads/posts/58736tải xuống.jpg', 'posted', NULL, '2026-02-14 02:41:08', '2026-02-14 09:41:08'),
(9, '1019525864569427', 6, '1019525864569427_122099945205262419', 'Hi', 'none', NULL, 'posted', NULL, '2026-02-14 03:02:21', '2026-02-14 10:02:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_queue`
--

CREATE TABLE `post_queue` (
  `id` int NOT NULL,
  `batch_id` varchar(40) NOT NULL,
  `source_no` int NOT NULL,
  `page_id` varchar(50) NOT NULL,
  `menu_id` int DEFAULT NULL,
  `content` text,
  `media_type` enum('image','video','none') DEFAULT 'none',
  `media_path` text,
  `scheduled_at` datetime NOT NULL,
  `status` enum('queued','processing','posted','failed','cancelled') DEFAULT 'queued',
  `fb_post_id` varchar(100) DEFAULT NULL,
  `retry_count` int DEFAULT '0',
  `last_error` text,
  `last_attempt_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `post_queue`
--

INSERT INTO `post_queue` (`id`, `batch_id`, `source_no`, `page_id`, `menu_id`, `content`, `media_type`, `media_path`, `scheduled_at`, `status`, `fb_post_id`, `retry_count`, `last_error`, `last_attempt_at`, `created_at`, `updated_at`) VALUES
(1, 'B20260214_023611_852cf4', 1, '1019525864569427', 5, 'Yêu ăng Đẹt', 'image', 'uploads/posts/58736tải xuống.jpg', '2026-02-14 09:40:00', 'posted', '1019525864569427_122099916231262419', 0, NULL, '2026-02-14 09:41:03', '2026-02-14 09:36:11', '2026-02-14 09:41:08'),
(2, 'B20260214_023611_852cf4', 2, '1019525864569427', 6, 'Hi', 'none', NULL, '2026-02-14 10:00:00', 'posted', '1019525864569427_122099945205262419', 0, NULL, '2026-02-14 10:02:16', '2026-02-14 09:36:11', '2026-02-14 10:02:21'),
(3, 'B20260214_023611_852cf4', 3, '1019525864569427', 6, 'Hi', 'none', NULL, '2026-02-15 09:40:00', 'queued', NULL, 0, NULL, NULL, '2026-02-14 09:36:11', '2026-02-14 09:36:11'),
(4, 'B20260214_023611_852cf4', 4, '1019525864569427', 5, 'Hi', 'none', NULL, '2026-02-15 10:00:00', 'queued', NULL, 0, NULL, NULL, '2026-02-14 09:36:11', '2026-02-14 09:36:11'),
(5, 'B20260214_023611_852cf4', 5, '1019525864569427', 5, 'Lên lịch test', 'none', NULL, '2026-02-16 09:40:00', 'queued', NULL, 0, NULL, NULL, '2026-02-14 09:36:11', '2026-02-14 09:36:11');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `fb_pages`
--
ALTER TABLE `fb_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_id` (`page_id`);

--
-- Chỉ mục cho bảng `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_menu_name` (`name`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_posts_menu_id` (`menu_id`);

--
-- Chỉ mục cho bảng `post_queue`
--
ALTER TABLE `post_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_queue_status_time` (`status`,`scheduled_at`),
  ADD KEY `idx_queue_page` (`page_id`),
  ADD KEY `idx_batch_id` (`batch_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `fb_pages`
--
ALTER TABLE `fb_pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `post_queue`
--
ALTER TABLE `post_queue`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
