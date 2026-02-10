-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 10, 2026 lúc 03:21 AM
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
  `page_avatar` varchar(500) DEFAULT NULL,
  `access_token` text NOT NULL,
  `token_page` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `fb_pages`
--

INSERT INTO `fb_pages` (`id`, `page_id`, `page_name`, `page_avatar`, `access_token`, `token_page`, `created_at`) VALUES
(3, '907468582460732', 'Duxng 2', 'https://graph.facebook.com/907468582460732/picture?type=square', 'EAF2cVxD1TYsBQluarRbz7mtz3fSJTUGlqzGemLq38ZAaqkcGxnPqupw5rtCAsWORkmlBwGggZCvqyBojgO6hrnEZAi1DGOz6tTE5pKUZCMETjmwhPVFcskF4veTN0bnO3gxHjOqK5i57m2XP4TpceR6ZARFwFDBwMZBCu5sNPKIJDMA6ScBsFJZCeYSAFpw0RyxX0VLFUFvk9cuEONXprtraBCrKQS1rjILUzlRjQZDZD', 'EAF2cVxD1TYsBQvxp0ZA3V1WQSw9ttNFPDxjYSR3RhvZBZAg8LaULCZBcZBW2sa9RhXHPsWipCbHAuZCyPZCnIIQ9nZBZCUO7XR61G1aulxZB8PoEUpLLmlRebrkqU10FpSJRZC1kAgISafLwSrBWZA4IEZB46POL0vkXFKfzzx3A2aAyxNnz5x2L9T7QZCBfYsNXQRTdXM8HXzoz22ImZBmMIj1bHZAMnuOVSdoczCVmhnAaQiC2sDAQ', '2026-02-09 21:26:07'),
(4, '1019525864569427', 'Duxng', 'https://graph.facebook.com/1019525864569427/picture?type=square', 'EAF2cVxD1TYsBQluarRbz7mtz3fSJTUGlqzGemLq38ZAaqkcGxnPqupw5rtCAsWORkmlBwGggZCvqyBojgO6hrnEZAi1DGOz6tTE5pKUZCMETjmwhPVFcskF4veTN0bnO3gxHjOqK5i57m2XP4TpceR6ZARFwFDBwMZBCu5sNPKIJDMA6ScBsFJZCeYSAFpw0RyxX0VLFUFvk9cuEONXprtraBCrKQS1rjILUzlRjQZDZD', 'EAF2cVxD1TYsBQtDBZBU2ePFmvqAkuj2HHzN4UP56hhAnSRDWnp8ZCbSZAWo8WWHGnCpiqB6IbrhUyZArhLK3ek61kHyZCMsv7OggZAXwv8ZB3SKfaJOVfaVTKZCLoUN9Bziw0DRTSC7B9GjgGgr49pIy7qhXH0tNy0GNHyxLQWEUq9imeHesQsdBJUjBcBivwizKOWM8ZCArZByMGC2CDSiknX1gLLj3gZAuWIphNt39otDRZCw5', '2026-02-09 21:26:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `page_id` varchar(50) DEFAULT NULL,
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

INSERT INTO `posts` (`id`, `page_id`, `fb_post_id`, `content`, `media_type`, `media_path`, `status`, `scheduled_at`, `posted_at`, `created_at`) VALUES
(2, '907468582460732', '907468582460732_122094767859265600', 'Test ảnh', 'image', 'uploads/images/25288text-document-file-line-icon-illustration-vector.jpg', 'posted', NULL, '2026-02-10 01:46:55', '2026-02-10 08:46:55');

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
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
