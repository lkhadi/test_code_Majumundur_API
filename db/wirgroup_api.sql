-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2019 at 07:47 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wirgroup_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `points`, `id_customer`) VALUES
(5, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `id_merchant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `id_merchant`) VALUES
(1, 'Pepaya', 22222.00, 5),
(2, 'Durian', 5555.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `date_trans` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `id_customer`, `id_product`, `date_trans`) VALUES
(17, 1, 1, '0000-00-00'),
(18, 1, 1, '0000-00-00'),
(19, 1, 1, '0000-00-00'),
(20, 1, 1, '2019-06-28'),
(21, 1, 1, '2019-06-28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `role`) VALUES
(1, 'lalu kismara', 'lalu', '$2y$10$ypMgrmg1uiFthcEYfrL47.65L4i49QFxXKYsap3ZIkxbA6fYcm50C', 'customer'),
(2, 'lalu kismara', 'lal3u', '$2y$10$XOPQjXiZl2UYqEqozP8OyuUR6yetnexu0Ex6T.t7itQh.wi2Gs8vu', 'customer'),
(4, 'lalu kismara', 'lal34', '$2y$10$Y7jdLrkJJEiBRty3FJufEOoGt5h6lwvozeE5LjqD7uM/201N2VKAy', 'customer'),
(5, 'Penjual', 'penjual', '$2y$10$tsmx1rJh5drWa9bp9.Ptmu4nUBuVF9sfSC6F220qmYJl3vjoI8lh2', 'merchant');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idcustomer_points` (`id_customer`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_merchant` (`id_merchant`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer` (`id_customer`),
  ADD KEY `fk_product` (`id_product`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `fk_idcustomer_points` FOREIGN KEY (`id_customer`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_merchant` FOREIGN KEY (`id_merchant`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`id_customer`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
