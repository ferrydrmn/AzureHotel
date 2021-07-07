-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2021 at 12:38 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `id_management` int(11) NOT NULL,
  `id_card` int(11) NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `fname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `email` varchar(60) NOT NULL,
  `registration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `id_management`, `id_card`, `sex`, `fname`, `lname`, `address`, `phone_number`, `email`, `registration_date`) VALUES
(1, 2, 2147483647, 'male', 'John', 'Andrea', 'Desa Klapagading RT 01/RW 01 \r\nKecamatan Wangon', '08127890123', 'john.andrea@gmail.com', '2021-05-16'),
(2, 2, 2147483645, 'male', 'John', 'Wick', 'Blater RT 01', '123123123', 'john.wick@mhs.unsoed.ac.id', '2021-05-17');

-- --------------------------------------------------------

--
-- Stand-in structure for view `data_meminjam`
-- (See below for the actual view)
--
CREATE TABLE `data_meminjam` (
`id_book` int(11)
,`fname` varchar(25)
,`lname` varchar(25)
,`id_card` int(11)
,`phone_number` varchar(12)
,`id_room` int(11)
,`room_name` varchar(40)
,`id_type` int(11)
,`start_date` date
,`duration` int(11)
,`end_date` date
,`pay` int(11)
,`status` enum('active','finished')
);

-- --------------------------------------------------------

--
-- Table structure for table `management`
--

CREATE TABLE `management` (
  `id_management` int(11) NOT NULL,
  `id_card` varchar(12) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `level` enum('manager','receptionist','admin') NOT NULL,
  `profile_picture` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `management`
--

INSERT INTO `management` (`id_management`, `id_card`, `fname`, `lname`, `address`, `phone_number`, `sex`, `email`, `password`, `level`, `profile_picture`) VALUES
(1, '110202031718', 'Ferry', 'Darmawan', 'Jalan raya Purwokerto', '081278901234', 'male', 'ferry.darmawan@mhs.unsoed.ac.id', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'manager', 'user/FP1.png'),
(2, '110202031719', 'Michael', 'Joe', 'Desa Blater Purbalingga', '081278901233', 'male', 'michael.joe@mhs.unsoed.ac.id', 'e807f1fcf82d132f9bb018ca6738a19f', 'receptionist', 'img/profile.png'),
(3, '1102089123', 'Rifqi', 'Ahmad', 'Purwokerto\r\nDekat Rita Supermall', '081278901212', 'male', 'rifqi.ahmad@mhs.unsoed.ac.id', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'admin', 'user/FP3.png'),
(4, '2147483611', 'Heru', 'Wick', 'Desa Blater RT 01/01, Kecamatan Kalimanah Wetan\r\nKabupaten Purbalingga', '081278901232', 'male', 'heru.wick@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'receptionist', 'img/profile.png'),
(5, '1123341234', 'Spongebob', 'Squarepants', 'Desa Blater', '081278901232', 'male', 'spongebob@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'receptionist', 'img/profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `meminjam`
--

CREATE TABLE `meminjam` (
  `id_book` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_management` int(11) NOT NULL,
  `id_room` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `end_date` date NOT NULL,
  `pay` int(11) NOT NULL,
  `status` enum('active','finished') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meminjam`
--

INSERT INTO `meminjam` (`id_book`, `id_customer`, `id_management`, `id_room`, `start_date`, `duration`, `end_date`, `pay`, `status`) VALUES
(1, 1, 2, 1, '2021-05-16', 5, '2021-05-21', 400000, 'finished'),
(2, 1, 2, 2, '2021-05-16', 5, '2021-05-21', 400000, 'finished'),
(3, 1, 2, 3, '2021-05-16', 2, '2021-05-18', 160000, 'active'),
(4, 1, 2, 4, '2021-05-16', 2, '2021-05-18', 160000, 'active'),
(5, 1, 2, 5, '2021-05-16', 2, '2021-05-18', 160000, 'active'),
(6, 1, 2, 1, '2021-05-16', 4, '2021-05-20', 320000, 'finished'),
(7, 1, 2, 2, '2021-05-16', 4, '2021-05-20', 320000, 'finished'),
(8, 1, 2, 1, '2021-05-16', 3, '2021-05-19', 240000, 'finished'),
(9, 1, 2, 2, '2021-05-16', 7, '2021-05-23', 560000, 'active'),
(10, 2, 2, 6, '2021-05-17', 10, '2021-05-27', 2000000, 'finished');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id_room` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `status` enum('free','booked','maintenance') NOT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id_room`, `name`, `status`, `id_type`) VALUES
(1, 'K1', 'free', 1),
(2, 'K2', 'booked', 1),
(3, 'K3', 'booked', 1),
(4, 'K4', 'booked', 1),
(5, 'K5', 'booked', 1),
(6, 'V1', 'free', 2),
(7, 'V2', 'free', 2),
(8, 'V3', 'free', 2);

-- --------------------------------------------------------

--
-- Table structure for table `room_pict`
--

CREATE TABLE `room_pict` (
  `id_pict` int(11) NOT NULL,
  `path` varchar(100) NOT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_pict`
--

INSERT INTO `room_pict` (`id_pict`, `path`, `id_type`) VALUES
(1, 'galery/P11.png', 1),
(2, 'galery/P12.png', 1),
(3, 'galery/P13.png', 1),
(4, 'galery/P21.png', 2),
(5, 'galery/P22.png', 2),
(6, 'galery/P23.png', 2),
(7, 'galery/P31.png', 3),
(8, 'galery/P32.png', 3),
(9, 'galery/P33.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE `room_type` (
  `id_type` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `bedroom` int(11) NOT NULL,
  `bathroom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`id_type`, `name`, `price`, `description`, `bedroom`, `bathroom`) VALUES
(1, 'Reguler', 75000, 'Tipe kamar yang murah dan sangat nyaman.', 1, 1),
(2, 'VIP', 200000, 'Kamar dengan pelayanan dan fasilitas mewah.', 2, 1),
(3, 'Ekonomi', 300000, 'Digunakan untuk menginap dengan harga yang murah.', 2, 1);

-- --------------------------------------------------------

--
-- Structure for view `data_meminjam`
--
DROP TABLE IF EXISTS `data_meminjam`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `data_meminjam`  AS  select `meminjam`.`id_book` AS `id_book`,`customer`.`fname` AS `fname`,`customer`.`lname` AS `lname`,`customer`.`id_card` AS `id_card`,`customer`.`phone_number` AS `phone_number`,`room`.`id_room` AS `id_room`,`room`.`name` AS `room_name`,`room_type`.`id_type` AS `id_type`,`meminjam`.`start_date` AS `start_date`,`meminjam`.`duration` AS `duration`,`meminjam`.`end_date` AS `end_date`,`meminjam`.`pay` AS `pay`,`meminjam`.`status` AS `status` from (((`meminjam` join `customer` on(`meminjam`.`id_customer` = `customer`.`id_customer`)) join `room` on(`meminjam`.`id_room` = `room`.`id_room`)) join `room_type` on(`room`.`id_type` = `room_type`.`id_type`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD UNIQUE KEY `uk_id_card_customer` (`id_card`);

--
-- Indexes for table `management`
--
ALTER TABLE `management`
  ADD PRIMARY KEY (`id_management`);

--
-- Indexes for table `meminjam`
--
ALTER TABLE `meminjam`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `fk_customer` (`id_customer`),
  ADD KEY `fk_management` (`id_management`),
  ADD KEY `fk_id_room` (`id_room`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id_room`),
  ADD UNIQUE KEY `uk_room_name` (`name`),
  ADD KEY `fk_id_type` (`id_type`);

--
-- Indexes for table `room_pict`
--
ALTER TABLE `room_pict`
  ADD PRIMARY KEY (`id_pict`),
  ADD KEY `fk_id_type_2` (`id_type`);

--
-- Indexes for table `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`id_type`),
  ADD UNIQUE KEY `uk_type_name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `management`
--
ALTER TABLE `management`
  MODIFY `id_management` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `meminjam`
--
ALTER TABLE `meminjam`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id_room` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room_pict`
--
ALTER TABLE `room_pict`
  MODIFY `id_pict` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `room_type`
--
ALTER TABLE `room_type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meminjam`
--
ALTER TABLE `meminjam`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `fk_id_room` FOREIGN KEY (`id_room`) REFERENCES `room` (`id_room`),
  ADD CONSTRAINT `fk_management` FOREIGN KEY (`id_management`) REFERENCES `management` (`id_management`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_id_type` FOREIGN KEY (`id_type`) REFERENCES `room_type` (`id_type`);

--
-- Constraints for table `room_pict`
--
ALTER TABLE `room_pict`
  ADD CONSTRAINT `fk_id_type_2` FOREIGN KEY (`id_type`) REFERENCES `room_type` (`id_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
