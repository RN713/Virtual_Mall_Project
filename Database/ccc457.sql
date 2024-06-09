-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09 يونيو 2024 الساعة 15:42
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccc457`
--

-- --------------------------------------------------------

--
-- بنية الجدول `additem`
--

CREATE TABLE `additem` (
  `Item_Name` varchar(20) NOT NULL,
  `Item_Price` int(10) NOT NULL,
  `Item_Image` varchar(200) NOT NULL,
  `Name_store` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `addstore`
--

CREATE TABLE `addstore` (
  `Name_store` varchar(20) NOT NULL,
  `Logo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `home`
--

CREATE TABLE `home` (
  `Name_store` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `name_customer`
--

CREATE TABLE `name_customer` (
  `name_cust` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `register`
--

CREATE TABLE `register` (
  `name_cust` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `store`
--

CREATE TABLE `store` (
  `Item_Name` varchar(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `name_cust` varchar(20) NOT NULL,
  `Item_Price` int(10) NOT NULL,
  `Name_store` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `update_store`
--

CREATE TABLE `update_store` (
  `Name_store` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `view_orders`
--

CREATE TABLE `view_orders` (
  `date` date NOT NULL,
  `email` varchar(80) NOT NULL,
  `order_number` int(15) NOT NULL,
  `total_price` int(10) NOT NULL,
  `Name_store` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additem`
--
ALTER TABLE `additem`
  ADD PRIMARY KEY (`Item_Name`),
  ADD KEY `Name_store` (`Name_store`);

--
-- Indexes for table `addstore`
--
ALTER TABLE `addstore`
  ADD PRIMARY KEY (`Name_store`);

--
-- Indexes for table `home`
--
ALTER TABLE `home`
  ADD KEY `Name_store` (`Name_store`);

--
-- Indexes for table `name_customer`
--
ALTER TABLE `name_customer`
  ADD KEY `name_cust` (`name_cust`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD KEY `Item_Name` (`Item_Name`),
  ADD KEY `Name_store` (`Name_store`);

--
-- Indexes for table `update_store`
--
ALTER TABLE `update_store`
  ADD KEY `Name_store` (`Name_store`);

--
-- Indexes for table `view_orders`
--
ALTER TABLE `view_orders`
  ADD KEY `email` (`email`),
  ADD KEY `Name_store` (`Name_store`);

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `additem`
--
ALTER TABLE `additem`
  ADD CONSTRAINT `additem_ibfk_1` FOREIGN KEY (`Name_store`) REFERENCES `addstore` (`Name_store`);

--
-- قيود الجداول `update_store`
--
ALTER TABLE `update_store`
  ADD CONSTRAINT `update_store_ibfk_1` FOREIGN KEY (`Name_store`) REFERENCES `addstore` (`Name_store`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
