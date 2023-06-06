-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2023 at 07:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Email_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `file_path` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `Email_id`, `created_at`, `token`, `file_path`) VALUES
(22, 'Nisarg', '$2y$10$SySdos70UnYhrAteuSy4z.oFXp15d7sEDIn45Pk7WS3JAnDGy.FZG', 'amlaninisarg15@gmail.com', '2023-06-03 12:29:04', 'PH0M0hQl', 'user_profile/wp12251869-interstellar-space-wallpapers.jpg'),
(24, 'kavin2903', '$2y$10$zQeVDr1WvJyk3xgfWXR8Ie5hOO7iXrR6QZcBLqMJF3HHbCmpx2Y4e', 'kavinshah290304@gmail.com', '2023-06-03 13:58:57', '7YCLCBG8', 'user_profile/wp12251869-interstellar-space-wallpapers.jpg'),
(25, 'Neha', '$2y$10$0ZS6jIifgk8gSgVZNNdxX.Mdlum/dYl6.6f6SMTx8aTaFAVHDdmGO', 'np1646122@gmail.com', '2023-06-03 20:48:53', 'KZuj9kkm', 'user_profile/wp12251869-interstellar-space-wallpapers.jpg'),
(26, 'Nisarg_amlani', '$2y$10$IzziqQuwBruO1vzUZgpYOOCWkaqjQAP9qNqYoYGi7mopR./ls6EY.', 'amlaninisarg07@gmail.com', '2023-06-03 20:59:59', 'VuwCBtXd', 'user_profile/wp12251869-interstellar-space-wallpapers.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
