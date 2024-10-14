-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 01:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `concert_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `concerts`
--

CREATE TABLE `concerts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `max_participants` int(11) DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `concerts`
--

INSERT INTO `concerts` (`id`, `name`, `date`, `location`, `max_participants`, `image`, `description`) VALUES
(7, 'Hivi', '2024-10-01', 'UMN', 999, 'uploads/girl_vampire_jewelry_1054796_1920x1080.jpg', 'HIVI merupakan sebuah grup musik pop Indonesia yang dibentuk di Jakarta pada tahun 2009. Grup musik ini beranggotakan tiga orang yaitu Neida Aleida, Ilham Aditama, dan Febrian Nindyo. Grup musik ini bergenre pop.'),
(12, 'Polyphia', '2024-11-24', 'Pradita', 5000, 'uploads/polyphia.jpg', 'Polyphia adalah band rock progresif instrumental yang berbasis di Plano, Texas, dibentuk pada tahun 2010. Grup ini terdiri dari gitaris Tim Henson dan Scott LePage, bassis Clay Gober, dan drummer Clay Aeschliman. Suara Polyphia terkenal karena menggabungkan bagian gitar virtuoso dengan gaya musik lainnya'),
(13, 'Arash Buana', '2024-10-14', 'UMN', 2, 'uploads/arash.jpg', 'Arash Buana ngonser di UMN coyy kapan lagi masa ga ikut sih');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `max_participants` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `concert_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `concert_id`, `name`, `email`, `registration_date`) VALUES
(1, 7, 'marco stefanus', 'marco@gmail.com', '2024-10-14 11:11:40'),
(2, 13, 'nartan adi chandra', 'natan.adichandra@gmail.com', '2024-10-14 11:13:58'),
(3, 13, 'marco', 'marco@gmail.com', '2024-10-14 11:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(5, 'natan', '$2y$10$MbX9CiO7q4jhWeYlh010oO3qdOik002Dy..Jd3iF.MEAoBVTFpbOu', 'admin', '2024-10-14 04:53:19'),
(9, 'ujang', '$2y$10$NCWiODNyGOLRsyHksYbq3.SXtyUK4TmSn2550n32LZnJi3RhfYq22', 'user', '2024-10-14 07:05:00'),
(11, 'marco', '$2y$10$z.Tfubj5MC4hg9oxTvH7tu0kFgyO5BuEOeKhKgYjg4S5oWlbg9vH6', 'user', '2024-10-14 10:36:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `concerts`
--
ALTER TABLE `concerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `concert_id` (`concert_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `concerts`
--
ALTER TABLE `concerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`concert_id`) REFERENCES `concerts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
