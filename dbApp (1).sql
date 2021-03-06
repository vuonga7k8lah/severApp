-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 19, 2021 at 12:55 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbApp`
--

-- --------------------------------------------------------

--
-- Table structure for table `DichVu`
--

CREATE TABLE `DichVu` (
  `ID` int(11) NOT NULL,
  `TenDV` text NOT NULL,
  `Gia` int(11) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `DichVu`
--

INSERT INTO `DichVu` (`ID`, `TenDV`, `Gia`, `TrangThai`) VALUES
(1, 'abc ddsds', 1000000, 1),
(2, 'Dịch vụ xe đưa đón sân bay', 1000000, 1),
(3, 'Dịch vụ Spa', 1500000, 1),
(5, 'spa', 32121321, 0);

-- --------------------------------------------------------

--
-- Table structure for table `HoaDon`
--

CREATE TABLE `HoaDon` (
  `ID` int(11) NOT NULL,
  `IDPhong` int(11) NOT NULL,
  `IDUser` int(11) NOT NULL,
  `infoKhach` text NOT NULL,
  `Option` varchar(100) NOT NULL DEFAULT 'TheoPhong',
  `DichVu` text NOT NULL,
  `ThanhToan` varchar(110) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `HoaDon`
--

INSERT INTO `HoaDon` (`ID`, `IDPhong`, `IDUser`, `infoKhach`, `Option`, `DichVu`, `ThanhToan`, `createDate`) VALUES
(1, 1, 2, '{\"Ten\":\"LE A\",\"CMT\":\"232323333232\",\"SDT\":\"21829121\",\"DiaChi\":\"vu0103n quu00e1n-Hu00e0 u0110u00f4ng-Hu00e0 Nu1ed9i\"}', 'TheoPhong', '1,2,3', '2000000', '2021-05-16 03:38:21'),
(3, 2, 2, '{\"Ten\":\"LE A\",\"CMT\":\"232323333232\",\"SDT\":\"21829121\",\"DiaChi\":\"vu0103n quu00e1n-Hu00e0 u0110u00f4ng-Hu00e0 Nu1ed9i\"}', 'TheoPhong', '1', '1000', '2021-06-12 14:41:24'),
(4, 3, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"43232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoPhong', '1,2,3', '4500000', '2021-06-26 03:21:47'),
(5, 3, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"43232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoPhong', '1', '2000000', '2021-07-05 12:37:21'),
(6, 4, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoPhong', '1,2,3', '4600000', '2021-07-05 13:48:25'),
(7, 1, 1, '{\"Ten\":\"NVA\",\"CMT\":\"03165151\",\"SDT\":\"0316547979\",\"DiaChi\":\"Ha Noi\"}', 'TheoPhong', '1', '2000000', '2021-07-05 14:20:22'),
(9, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-05 23:18:27'),
(10, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 13:51:03'),
(11, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 13:52:38'),
(12, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 13:53:07'),
(13, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 13:53:28'),
(14, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 13:57:51'),
(15, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 14:08:10'),
(16, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 14:11:13'),
(17, 5, 1, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-10 14:11:59'),
(18, 5, 5, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1,2', '24243534534', '2021-07-16 04:49:18'),
(19, 5, 1, '{\"Ten\":\"hekkekeke\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-11 14:23:00'),
(20, 5, 1, '{\"Ten\":\"hekkekeke\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-11 14:25:41'),
(21, 2, 1, '{\"Ten\":\"Bu1ed1 Vu01b0u01a1ng Nhu00e9\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1,2,3', '3500000', '2021-07-11 14:26:46'),
(22, 5, 5, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-15 14:11:58'),
(23, 5, 2, '{\"Ten\":\"abcc\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1', '1000000', '2021-07-15 14:37:35'),
(24, 5, 6, '{\"Ten\":\"hhahahaaa\",\"CMT\":\"32121321\",\"SDT\":\"0043232424\",\"DiaChi\":\"Ha Noi\"}', 'TheoGio', '1,2,3', '3500000', '2021-07-15 14:45:42'),
(25, 6, 1, '{\"Ten\":\" admin\",\"CMT\":\"\",\"SDT\":\"3213123\",\"DiaChi\":\"\"}', 'TheoPhong', '1', '100000', '2021-10-18 05:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `Phong`
--

CREATE TABLE `Phong` (
  `ID` int(11) NOT NULL,
  `IDTang` int(11) NOT NULL,
  `TenPhong` text NOT NULL,
  `Gia` int(11) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL,
  `TuSua` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Phong`
--

INSERT INTO `Phong` (`ID`, `IDTang`, `TenPhong`, `Gia`, `TrangThai`, `TuSua`) VALUES
(1, 1, 'Phòng 101', 1000000, 0, 0),
(2, 1, 'Phòng 102', 1000000, 1, 0),
(3, 1, 'Phòng 103', 1000000, 0, 0),
(4, 2, 'Phòng 201', 1100000, 0, 0),
(5, 2, 'Phòng 202', 1100000, 1, 0),
(6, 2, 'Phòng 203', 1100000, 1, 0),
(7, 3, 'Phòng 301', 800000, 0, 0),
(8, 3, 'Phòng 302', 800000, 0, 0),
(10, 1, 'Phòng 107', 1000000, 1, 0),
(11, 1, 'abc ddsdsgfdgf', 1000000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Tang`
--

CREATE TABLE `Tang` (
  `ID` int(11) NOT NULL,
  `TenTang` text NOT NULL,
  `SoPhong` int(11) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Tang`
--

INSERT INTO `Tang` (`ID`, `TenTang`, `SoPhong`, `TrangThai`) VALUES
(1, 'Tầng 1', 5, 1),
(2, 'Tầng 2', 5, 1),
(3, 'Tầng 3', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `HoTen` text NOT NULL,
  `diachi` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `HoTen`, `diachi`, `create_date`) VALUES
(1, 'Le Hung Vuong', 'Thai Nguyen', '2021-05-13 16:05:34'),
(2, 'Le Hung Vuong1', 'Thai Nguyen1', '2021-05-13 16:05:34'),
(3, 'Le Hung Vuong2', 'Thai Nguyen2', '2021-05-13 16:05:34'),
(4, 'Le Hung Vuong3', 'Thai Nguyen3', '2021-05-13 16:05:34'),
(5, 'Le Hung Vuong4', 'Thai Nguyen4', '2021-05-13 16:05:34'),
(6, 'Le Hung Vuong5', 'Thai Nguyen5', '2021-05-13 16:05:34'),
(7, 'Le Hung Vuong6', 'Thai Nguyen6', '2021-05-13 16:05:34'),
(8, 'Le Hung Vuong7', 'Thai Nguyen7', '2021-05-13 16:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `ThanhToan`
--

CREATE TABLE `ThanhToan` (
  `ID` int(11) NOT NULL,
  `IDHoaDon` int(11) NOT NULL,
  `TongTien` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ThanhToan`
--

INSERT INTO `ThanhToan` (`ID`, `IDHoaDon`, `TongTien`, `createDate`) VALUES
(3, 1, 2000000, '2021-06-08 01:59:16'),
(4, 1, 342423423, '2021-06-17 07:34:36'),
(5, 1, 234234234, '2021-06-18 01:45:25'),
(6, 4, 4500000, '2021-06-26 03:25:19'),
(7, 4, 4500000, '2021-06-26 03:26:08'),
(8, 9, 10680000, '2021-07-06 07:05:16'),
(9, 4, 4500000, '2021-07-06 07:07:18'),
(10, 6, 4600000, '2021-07-06 07:07:23'),
(11, 7, 2000000, '2021-07-06 07:07:26'),
(12, 18, 31250000, '2021-07-11 14:22:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `HoTen` text NOT NULL,
  `userName` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `NgaySinh` date NOT NULL,
  `CMT` varchar(11) NOT NULL,
  `DiaChi` text NOT NULL,
  `level` int(11) NOT NULL DEFAULT 1,
  `token` text NOT NULL,
  `email` text NOT NULL,
  `code` text DEFAULT NULL,
  `createDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `HoTen`, `userName`, `password`, `NgaySinh`, `CMT`, `DiaChi`, `level`, `token`, `email`, `code`, `createDate`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '1998-04-27', '12232434', 'Hà Nội', 2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJRCI6IjEiLCJ1c2VyTmFtZSI6ImFkbWluIiwiSG9UZW4iOiJhZG1pbiJ9.234-aSxbQPO_Ozd4kcffsavH1FRWBgBx61dga5ZrAWE', 'vuonga7k8lah@gmail.com', 'vuongKMA_61075b0a7f306', '2021-08-12 06:28:31'),
(2, 'Nguyễn Văn A', 'nhanvien1', '762a76304e177037e1814b8c3575b0ae', '2000-03-19', '892329483', 'Hà Nội', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJRCI6IjIiLCJ1c2VyTmFtZSI6Im5oYW52aWVuMSIsIkhvVGVuIjoiTmd1eVx1MWVjNW4gVlx1MDEwM24gQSJ9.f0qE0WwgYe84T4ZB0mFjIHJWZSjrrC-Ck3zno-mP8mI', '', NULL, '2021-08-01 04:22:48'),
(4, 'Lê Văn a', 'nhanvien2', 'df88847550ee279705c6d17ce56c61d2', '1998-04-10', '12345678901', 'Thái Nguyên', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJRCI6IjQiLCJ1c2VyTmFtZSI6Im5oYW52aWVuMiIsIkhvVGVuIjoiTFx1MDBlYSBWXHUwMTAzbiBhIn0.F-QS1EU4THAfVWqkp-MvQBPB2EbtvGTTzJrkVk7CXQw', '', NULL, '2021-06-06 08:52:52'),
(5, 'Lê Văn b', 'nhanvien3', 'cd6c666e2836a2682b9a41d065aa1d55', '1998-04-10', '12345678901', 'Thái Nguyên', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJRCI6IjUiLCJ1c2VyTmFtZSI6Im5oYW52aWVuMyIsIkhvVGVuIjoiTFx1MDBlYSBWXHUwMTAzbiBiIn0.bp1rau_WkQP9qel_AZcuzKk6tkZXqq4c7EtlZeLcgLM', '', NULL, '2021-06-26 03:58:36'),
(6, 'Hehe', 'nhanvien4', '75ec368af32c3ba04f6abae2e45558b5', '1998-04-27', '437483784', 'hồ chí chí minh', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJRCI6IjYiLCJ1c2VyTmFtZSI6Im5oYW52aWVuNCIsIkhvVGVuIjoiSGVoZSJ9.o-RBk0UyCne6Iy0gEvoMtQktG9DIB_t1IUfZSoIb3qA', 'vuongdttn1998@gmail.com', 'vuongKMA_6114c90f27702', '2021-08-12 07:09:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DichVu`
--
ALTER TABLE `DichVu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `HoaDon`
--
ALTER TABLE `HoaDon`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_12122` (`IDPhong`),
  ADD KEY `fk_123212` (`IDUser`);

--
-- Indexes for table `Phong`
--
ALTER TABLE `Phong`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_1212` (`IDTang`);

--
-- Indexes for table `Tang`
--
ALTER TABLE `Tang`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ThanhToan`
--
ALTER TABLE `ThanhToan`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_2313rerw21` (`IDHoaDon`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DichVu`
--
ALTER TABLE `DichVu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `HoaDon`
--
ALTER TABLE `HoaDon`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `Phong`
--
ALTER TABLE `Phong`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Tang`
--
ALTER TABLE `Tang`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ThanhToan`
--
ALTER TABLE `ThanhToan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `HoaDon`
--
ALTER TABLE `HoaDon`
  ADD CONSTRAINT `fk_12122` FOREIGN KEY (`IDPhong`) REFERENCES `Phong` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_123212` FOREIGN KEY (`IDUser`) REFERENCES `users` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `Phong`
--
ALTER TABLE `Phong`
  ADD CONSTRAINT `fk_1212` FOREIGN KEY (`IDTang`) REFERENCES `Tang` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `ThanhToan`
--
ALTER TABLE `ThanhToan`
  ADD CONSTRAINT `fk_2313rerw21` FOREIGN KEY (`IDHoaDon`) REFERENCES `HoaDon` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
