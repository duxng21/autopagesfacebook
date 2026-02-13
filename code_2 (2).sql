-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 11, 2026 lúc 11:27 AM
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
(1, '907468582460732', 'Duxng 2', 'https://scontent.fhan5-9.fna.fbcdn.net/v/t39.30808-1/629481801_2184480755626608_7894218572918503047_n.jpg?stp=cp0_dst-jpg_s50x50_tt6&_nc_cat=109&ccb=1-7&_nc_sid=f907e8&_nc_ohc=zk7zNj4k2voQ7kNvwH61FeW&_nc_oc=AdlU63X5lV7R_CnR0_7fEePrj1OG4wpCmvGVJ_afsz65ixaLLlxYtWzkPxZD0wSnc7M&_nc_zt=24&_nc_ht=scontent.fhan5-9.fna&edm=AJdBtusEAAAA&_nc_gid=rIcNm_LqfIKNTs2_xleeUA&_nc_tpa=Q5bMBQF6QRLAb67WzbsCoDKLBqTUql1-uF0bhmAIt6BkTqaqh8saBAcVcbv-aPYJJe0CJlT_5qgvuNRHDaM&oh=00_Afs_9FMOvJxZHscTWadbR7NPnmHA5OhojJxeo5OaqaLbzw&oe=6990C3A6', 'EAF2cVxD1TYsBQmrOcV6N7iY1tvhDljBQSMrYL0YdUEGpPbSbdq0Y65EZCSaKP3vBZCEHlUM0MtGEVtLzLK8975gwBVmfVwPXCXbdzZBILRRLC7BfvWO8HMful4ZBxBIjmH2FZBs66ZBEq5BFlcF60kmZAJyklbK0KhTE8ZAZAZCEO9sZBV9HEsQOZCNWSVRRXYz1DzE1nNCTroqneAAzjZAZCmLoinnmc6NSDlW3DsNKySLxoZD', 'EAF2cVxD1TYsBQkbClJmZALZBXxOIWZBtgP12mn8Ye3urTR6u6anH9Ak1egyzFQelD46slmz27C6yaVLcp9eQCZCzCqMO5uLZCkWgY0cxbBZCZBJUQxv2IgN0lHbjHbaSaaM2vnkqdnDgeCCqpzqwv57gEIAh6H0ZCrlZB0rVZAZCsaDPF5f62OG4E4ozdSOR9HKSXVj8lmypZBFr3K3xx5Ywnm3mxKvDnXR2ZBbgNqFpBPB7NkRE5tAZDZD', '2026-02-10 11:34:19'),
(6, '1019525864569427', 'Duxng', 'https://scontent.fhan5-6.fna.fbcdn.net/v/t39.30808-1/627745201_2183956792345671_6990971155954959983_n.jpg?stp=cp0_dst-jpg_s50x50_tt6&_nc_cat=107&ccb=1-7&_nc_sid=f907e8&_nc_ohc=4_KJ1n4z4Y4Q7kNvwGnI8J_&_nc_oc=AdkYNH31G2JI6oSZ7AznPxzkuk1dwQD24n0wZeF9TNydxLYsZjbLA6FamZUOmFAHs9w&_nc_zt=24&_nc_ht=scontent.fhan5-6.fna&edm=AJdBtusEAAAA&_nc_gid=kvgWPyiFSNYoH4Jb37CmrA&_nc_tpa=Q5bMBQF5GYYjbXBq9kFgr2pzppWlnK4eCKF97dHad6eB8bq3pnTXYEgjLdFrMvzOW4pXOfXAFACRkyTETyc&oh=00_AfvNgn8D7Z-3Yc7ByKXNoRv10-Ilz5Ow4tFZpsOa-7VRdQ&oe=6990C43C', 'EAF2cVxD1TYsBQmrOcV6N7iY1tvhDljBQSMrYL0YdUEGpPbSbdq0Y65EZCSaKP3vBZCEHlUM0MtGEVtLzLK8975gwBVmfVwPXCXbdzZBILRRLC7BfvWO8HMful4ZBxBIjmH2FZBs66ZBEq5BFlcF60kmZAJyklbK0KhTE8ZAZAZCEO9sZBV9HEsQOZCNWSVRRXYz1DzE1nNCTroqneAAzjZAZCmLoinnmc6NSDlW3DsNKySLxoZD', 'EAF2cVxD1TYsBQpxQP5WWIa25Kii3EZB7tgIzirOltTpB7gBanq42sp8AmNRp5OHifLmxWG5iuWA9ZAmb2usWHJNVkl2F8YFVgZAjAmDy7M7Juyxt5nGHPoqdNOsmSfSjpZCyve3ZChWR8suZBvJqpnLdMeDtXMBiPNMeRnFCCP0VZCtbHofx22I3uiJVHlfSTqTAdN8RysoiTDgkFCdAE5MmogfE9cxj5Y3gW6EKZCfAsQZDZD', '2026-02-10 11:40:16');

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
(2, 'Anime', '2026-02-11 14:24:03', '2026-02-11 14:56:45');

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
(2, '907468582460732', 2, '907468582460732_122094767859265600', 'Test ảnh', 'image', 'uploads/images/25288text-document-file-line-icon-illustration-vector.jpg', 'posted', NULL, '2026-02-10 01:46:55', '2026-02-10 08:46:55'),
(6, '1019525864569427', NULL, '1019525864569427_122096152839262419', 'Hi', 'none', NULL, 'posted', NULL, '2026-02-10 06:30:30', '2026-02-10 13:30:30'),
(7, '1019525864569427', NULL, '1019525864569427_122096153091262419', 'Text + img', 'image', 'uploads/posts/26711₊🎠⋮ ❛ céline ❜.jpg', 'posted', NULL, '2026-02-10 06:31:59', '2026-02-10 13:31:59'),
(8, '1019525864569427', NULL, '2061626654677524', 'Text + video', 'video', 'uploads/posts/39506video1.mp4', 'posted', NULL, '2026-02-10 06:32:33', '2026-02-10 13:32:33'),
(9, '1019525864569427', NULL, '1019525864569427_122096154285262419', 'Hi', 'none', NULL, 'posted', '2026-02-10 13:35:00', '2026-02-10 21:30:09', '2026-02-10 13:34:01'),
(10, '1019525864569427', NULL, '1019525864569427_122096156895262419', 'Hi', 'none', NULL, 'posted', '2026-02-10 06:49:00', '2026-02-10 21:30:09', '2026-02-10 13:37:25'),
(16, '1019525864569427', NULL, '1019525864569427_122096180709262419', 'Thơ 1: \r\n\r\nMỗi sáng dậy sớm thấy mặt trời\r\n\r\nNhìn đồng hồ bỗng nghĩ đến tôi. \r\n\r\n“Có nên ngủ thêm phút nữa không?” \r\n\r\nThay vì tự hỏi, ngủ lại thôi!\r\n\r\nThơ 2: \r\n\r\nHè đến rồi, nóng quá trời ơi\r\n\r\nQuạt thổi phành phạch, mồ hôi rơi. \r\n\r\nĐiều hòa không chịu nổi nóng nực\r\n\r\nDù 20 độ, vẫn chịu thôi!\r\n\r\nThơ 3: \r\n\r\nĐời ta như trò chơi vui vẻ,\r\n\r\nTìm em trong đó, mỗi ngày đêm.\r\n\r\nMặc kệ thời gian, dẫu gian khó,\r\n\r\nEm luôn là điểm sáng trong đêm.', 'image', 'uploads/posts/84025text-document-file-line-icon-illustration-vector.jpg', 'posted', NULL, '2026-02-10 07:18:16', '2026-02-10 14:18:16'),
(17, '1019525864569427', NULL, '1019525864569427_122096180883262419', 'Thơ 1: \r\n\r\nMỗi sáng dậy sớm thấy mặt trời\r\n\r\nNhìn đồng hồ bỗng nghĩ đến tôi. \r\n\r\n“Có nên ngủ thêm phút nữa không?” \r\n\r\nThay vì tự hỏi, ngủ lại thôi!\r\n\r\nThơ 2: \r\n\r\nHè đến rồi, nóng quá trời ơi\r\n\r\nQuạt thổi phành phạch, mồ hôi rơi. \r\n\r\nĐiều hòa không chịu nổi nóng nực\r\n\r\nDù 20 độ, vẫn chịu thôi!\r\n\r\nThơ 3: \r\n\r\nĐời ta như trò chơi vui vẻ,\r\n\r\nTìm em trong đó, mỗi ngày đêm.\r\n\r\nMặc kệ thời gian, dẫu gian khó,\r\n\r\nEm luôn là điểm sáng trong đêm.', 'image', 'uploads/posts/84025text-document-file-line-icon-illustration-vector.jpg', 'posted', NULL, '2026-02-10 07:18:47', '2026-02-10 14:18:47'),
(18, '907468582460732', NULL, '907468582460732_122094938889265600', 'Thơ 1: \r\n\r\nMỗi sáng dậy sớm thấy mặt trời\r\n\r\nNhìn đồng hồ bỗng nghĩ đến tôi. \r\n\r\n“Có nên ngủ thêm phút nữa không?” \r\n\r\nThay vì tự hỏi, ngủ lại thôi!\r\n\r\nThơ 2: \r\n\r\nHè đến rồi, nóng quá trời ơi\r\n\r\nQuạt thổi phành phạch, mồ hôi rơi. \r\n\r\nĐiều hòa không chịu nổi nóng nực\r\n\r\nDù 20 độ, vẫn chịu thôi!\r\n\r\nThơ 3: \r\n\r\nĐời ta như trò chơi vui vẻ,\r\n\r\nTìm em trong đó, mỗi ngày đêm.\r\n\r\nMặc kệ thời gian, dẫu gian khó,\r\n\r\nEm luôn là điểm sáng trong đêm.', 'image', 'uploads/posts/84025text-document-file-line-icon-illustration-vector.jpg', 'posted', NULL, '2026-02-10 07:18:52', '2026-02-10 14:18:52');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
