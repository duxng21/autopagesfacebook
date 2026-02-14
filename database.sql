-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 14, 2026 lúc 01:00 AM
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
(1, '907468582460732', 'Duxng 2', 'https://graph.facebook.com/907468582460732/picture?type=square', 'EAF2cVxD1TYsBQmXT42FIvfYpZBJowxrqlPM05BKRWJ4R51DXvqVSzZBecpdmixPiK0PMeCVON3Q02rSJ28cmhSl7AXpoS7XNoBm1asOxBxdc2lavZCX1rkiqZCE10Qx23s2nfu9XXuL1P4BBWZBfcVByhwq9wLTI1IHZCx4oScOreZC2JONlwps2YEgyMvAWZAtstzlNiaMTasRzOCZBBOROgTOXopZBLqCdQLCQZDZD', 'EAF2cVxD1TYsBQlnlUrRNGHSynD4pOtfugHGzz1foV8po2WIdQBLZCGWzGkEZAvlsdAIxyDytJnC2oCI4ZCYG1NakkWfKZBwJkOocnMTuTqTWhon1W1QpxKIGTCau9AUsxUd1MPYhLSLcjD7hq03v1cCLxbZBVZBvh8ELaniqBPGQgfMJ7kHPSl5Xb2B6FhUtKaE9s3Qevd391XfCfWusDYt3YJ9dY8t5iKQD9zPy3QfCEc', '2026-02-13 12:57:26'),
(2, '1019525864569427', 'Duxng', 'https://graph.facebook.com/1019525864569427/picture?type=square', 'EAF2cVxD1TYsBQmXT42FIvfYpZBJowxrqlPM05BKRWJ4R51DXvqVSzZBecpdmixPiK0PMeCVON3Q02rSJ28cmhSl7AXpoS7XNoBm1asOxBxdc2lavZCX1rkiqZCE10Qx23s2nfu9XXuL1P4BBWZBfcVByhwq9wLTI1IHZCx4oScOreZC2JONlwps2YEgyMvAWZAtstzlNiaMTasRzOCZBBOROgTOXopZBLqCdQLCQZDZD', 'EAF2cVxD1TYsBQr8zK5JZAptu65ot4IVtkdfKprLXNDLDYogHVZB5ESrAdEewrP8V6oyCxoUIYTzQGfqM1kYEBLLtGOVpOshJ2boNahy4YehfMZATjh4WnG5nPlGTrvixeZBw2w4DSnQn10kyT6Y7p2fkNGI7tZBiSZBUxrSU13twDBhyZAhWXH15tjcXdtUoZAAlGr4XPyTeY0k6ghyG1v7DcONvbLR9RoGkpFzpKGFJaIAX', '2026-02-13 12:57:26');

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
(5, '907468582460732', 5, '907468582460732_122098041831265600', 'Lên lịch test', 'none', NULL, 'scheduled', '2026-02-14 10:36:00', NULL, '2026-02-13 17:36:51');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
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
