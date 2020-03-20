-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2020 at 07:36 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pckart`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(25) NOT NULL,
  `cat_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_img`) VALUES
(2, 'LAPTOP', '200320060249download-lap.jpg'),
(4, 'MOUSE', '200320115811mouse.png'),
(5, 'KEYBOARD', '210320120029keyboard.png'),
(6, 'CPU', '210320120057cpu.png'),
(7, 'COMPUTER', '210320120139computer.png'),
(8, 'SPEAKER', '210320120332speaker.png'),
(9, 'PENDRIVE', '210320120426pendrive.png');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Cusmomer_id` int(11) NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(15) NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Password` varchar(35) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cusmomer_id`, `FirstName`, `LastName`, `UserName`, `Password`, `Phone`, `Email`) VALUES
(1, 'anas', 'intekhaab', 'anas', '12345', '2345678902', 'anas@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_id` int(11) NOT NULL,
  `product-id` int(11) NOT NULL,
  `Customer_id` int(11) NOT NULL,
  `Address` varchar(40) NOT NULL,
  `status` int(1) NOT NULL,
  `Ordered` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int(11) NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(15) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(35) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `FirstName`, `LastName`, `Username`, `Password`, `Email`, `Address`, `Phone`, `Role`) VALUES
(8, 'srijith', 'nair', 'srijith', '827ccb0eea8a706c4c34a16891f84e7b', 'asfas@gmail.com', 'E-199 SECOND FLOOR', '9811763004', 0),
(9, 'adnan', 'shamsi', 'adnan', 'd1a0a9e9391af09e978c4c3d11711e75', 'adnanshamsi12345@gmail.com', 'E-167 SECOND FLOOR', '9811763001', 1),
(10, 'suyash', 'chauhan', 'suyash', '0c4d3abb4818bca3806999fe6f309782', 'suyash@gmail.com', 'E-170 SECOND FLOOR', '1112223335', 0),
(14, 'a', 'a', 'a', '0cc175b9c0f1b6a831c399e269772661', 'a@a.a', 'a', '1234554321', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_id` int(11) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `category_id` int(11) NOT NULL,
  `Brand` varchar(35) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `first_image` varchar(50) NOT NULL,
  `second_image` varchar(50) NOT NULL,
  `Dealer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_id`, `Name`, `category_id`, `Brand`, `Description`, `Price`, `Quantity`, `first_image`, `second_image`, `Dealer_id`) VALUES
(7, 'LENOVO IDEAPAD 330', 2, 'LENOVO', 'i5 8-generation \r\nFHD \r\nSLIM black colour', 50000, 3, '200320060658download (1).png', '200320060658download.jpg', 14),
(8, 'MAC 323', 2, 'APPLE', 'asdga\r\nsdggag\r\ndgadgagsgs', 60000, 5, '200320061000downloadj.jpg', '200320061000downloadq.jpg', 14),
(9, 'LENOVO THINKPAD 440', 2, 'LENOVO', 'gfsdg\r\nadsfsgsdg\r\ndsgdssgsg\r\nadfs', 30000, 5, '200320061107download.jpg', '200320061107download3.jpg', 14),
(10, 'DELL VOTRO 980', 2, 'DELL', 'safasga\r\nsdfhdss\r\ngdsgsghs', 63000, 4, '200320061254downloadq.jpg', '200320061254downloadz.jpg', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cusmomer_id`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD UNIQUE KEY `Phone No.` (`Phone`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`,`Phone`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Cusmomer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
