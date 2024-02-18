-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 14, 2024 lúc 06:29 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dacntt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `disease_history`
--

CREATE TABLE `disease_history` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `disease` text NOT NULL,
  `modified_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `disease_history`
--

INSERT INTO `disease_history` (`id`, `patient_id`, `disease`, `modified_date`) VALUES
(1, 1, 'Tri', '2024-02-15'),
(2, 1, 'Tri', '2024-02-15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `patients`
--

INSERT INTO `patients` (`id`, `full_name`, `birthday`, `address`) VALUES
(1, 'Benh Nhan 1', '1993-02-20', 'Khong BIet');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `full_name` varchar(50) NOT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `role` varchar(10) DEFAULT 'patient'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `birthday`, `address`, `role`) VALUES
(1, 'yta1', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyen Thi Ta', '1990-01-01', 'Ha Noi', 'nurse');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `disease_history`
--
ALTER TABLE `disease_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Chỉ mục cho bảng `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `disease_history`
--
ALTER TABLE `disease_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `disease_history`
--
ALTER TABLE `disease_history`
  ADD CONSTRAINT `disease_history_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `disease_history_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
