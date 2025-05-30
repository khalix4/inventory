-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 01:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sims`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CATEGORY_ID` int(11) NOT NULL,
  `CNAME` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CATEGORY_ID`, `CNAME`) VALUES
(1, 'Electronics'),
(2, 'Grocery'),
(3, 'Beverages'),
(4, 'Personal Care'),
(5, 'Household Items'),
(6, 'Baby Products'),
(7, 'Health & Wellness'),
(8, 'Stationery'),
(9, 'Home Appliances'),
(10, 'Clothing'),
(11, 'Footwear'),
(12, 'Frozen Foods'),
(13, 'Snacks'),
(14, 'Cleaning Supplies'),
(15, 'Pet Supplies'),
(16, 'Dairy Products'),
(17, 'Fruits & Vegetables'),
(18, 'Meat & Seafood'),
(19, 'Automotive'),
(20, 'Mobile Accessories');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CUST_ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(50) DEFAULT NULL,
  `LAST_NAME` varchar(50) DEFAULT NULL,
  `PHONE_NUMBER` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUST_ID`, `FIRST_NAME`, `LAST_NAME`, `PHONE_NUMBER`) VALUES
(96, 'John', 'Richard', '0808070609'),
(97, 'hunter', 'king', '080908090');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EMPLOYEE_ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(50) DEFAULT NULL,
  `LAST_NAME` varchar(50) DEFAULT NULL,
  `GENDER` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `PHONE_NUMBER` varchar(11) DEFAULT NULL,
  `JOB_ID` int(11) DEFAULT NULL,
  `HIRED_DATE` varchar(50) NOT NULL,
  `LOCATION_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EMPLOYEE_ID`, `FIRST_NAME`, `LAST_NAME`, `GENDER`, `EMAIL`, `PHONE_NUMBER`, `JOB_ID`, `HIRED_DATE`, `LOCATION_ID`) VALUES
(7, 'Samuel', 'Olubukun', 'Male', 'admin@admin.admin', '62376273565', 1, '2022-10-19', 161),
(13, 'Erik', 'Bello', 'Male', 'jedjedi@gmail.com', '0808090809', 1, '2025-05-22', 198),
(15, 'John', 'Doe', 'Male', 'johndoe@gmail.com', '0808090805', 1, '2025-05-23', 198);

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `JOB_ID` int(11) NOT NULL,
  `JOB_TITLE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`JOB_ID`, `JOB_TITLE`) VALUES
(1, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LOCATION_ID` int(11) NOT NULL,
  `PROVINCE` varchar(100) DEFAULT NULL,
  `CITY` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LOCATION_ID`, `PROVINCE`, `CITY`) VALUES
(161, 'abuja', 'abuja'),
(162, 'Abia', 'Umuahia'),
(163, 'Adamawa', 'Yola'),
(164, 'Akwa Ibom', 'Uyo'),
(165, 'Anambra', 'Awka'),
(166, 'Bauchi', 'Bauchi'),
(167, 'Bayelsa', 'Yenagoa'),
(168, 'Benue', 'Makurdi'),
(169, 'Borno', 'Maiduguri'),
(170, 'Cross River', 'Calabar'),
(171, 'Delta', 'Asaba'),
(172, 'Ebonyi', 'Abakaliki'),
(173, 'Edo', 'Benin City'),
(174, 'Ekiti', 'Ado-Ekiti'),
(175, 'Enugu', 'Enugu'),
(176, 'Gombe', 'Gombe'),
(177, 'Imo', 'Owerri'),
(178, 'Jigawa', 'Dutse'),
(179, 'Kaduna', 'Kaduna'),
(180, 'Kano', 'Kano'),
(181, 'Katsina', 'Katsina'),
(182, 'Kebbi', 'Birnin Kebbi'),
(183, 'Kogi', 'Lokoja'),
(184, 'Kwara', 'Ilorin'),
(185, 'Lagos', 'Ikeja'),
(186, 'Nasarawa', 'Lafia'),
(187, 'Niger', 'Minna'),
(188, 'Ogun', 'Abeokuta'),
(189, 'Ondo', 'Akure'),
(190, 'Osun', 'Oshogbo'),
(191, 'Oyo', 'Ibadan'),
(192, 'Plateau', 'Jos'),
(193, 'Rivers', 'Port Harcourt'),
(194, 'Sokoto', 'Sokoto'),
(195, 'Taraba', 'Jalingo'),
(196, 'Yobe', 'Damaturu'),
(197, 'Zamfara', 'Gusau'),
(198, 'FCT', 'Abuja');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `FIRST_NAME` varchar(50) DEFAULT NULL,
  `LAST_NAME` varchar(50) DEFAULT NULL,
  `LOCATION_ID` int(11) NOT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `PHONE_NUMBER` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `PRODUCT_ID` int(11) NOT NULL,
  `PRODUCT_NAME` varchar(100) NOT NULL,
  `CATEGORY_ID` int(11) NOT NULL,
  `COST_PER_CARTON` decimal(10,2) NOT NULL,
  `QTY_PER_CARTON` int(11) NOT NULL,
  `PROFIT_PERCENTAGE` decimal(5,2) NOT NULL,
  `TOTAL_QTY` int(11) NOT NULL,
  `MANUFACTURE_DATE` date NOT NULL,
  `EXPIRY_DATE` date DEFAULT NULL,
  `BARCODE_TEXT` varchar(50) DEFAULT NULL,
  `BARCODE_IMAGE` varchar(255) DEFAULT NULL,
  `NOTES` text DEFAULT NULL,
  `COST_PER_ITEM` decimal(10,2) NOT NULL DEFAULT 0.00,
  `SELLING_PRICE_PER_ITEM` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`PRODUCT_ID`, `PRODUCT_NAME`, `CATEGORY_ID`, `COST_PER_CARTON`, `QTY_PER_CARTON`, `PROFIT_PERCENTAGE`, `TOTAL_QTY`, `MANUFACTURE_DATE`, `EXPIRY_DATE`, `BARCODE_TEXT`, `BARCODE_IMAGE`, `NOTES`, `COST_PER_ITEM`, `SELLING_PRICE_PER_ITEM`) VALUES
(1, 'Samsung 32', 1, '120000.00', 50, '20.00', 40, '2024-12-01', '2025-05-31', 'S32LED202412', '../uploads/barcodes/barcode_682ec0c078f844.69586199.png', '32-inch smart TV with HDMI and USB support', '2400.00', '2880.00'),
(2, 'Indomie Instant Noodles - Chicken', 2, '3000.00', 40, '25.00', 400, '2025-01-10', '2026-01-10', 'INDCHKN0125', NULL, 'Best before 1 year', '75.00', '93.75'),
(3, 'Coca-Cola 500ml', 3, '2400.00', 24, '30.00', 96, '2025-02-01', '2025-12-31', 'COC500ML2025', NULL, 'Keep refrigerated', '100.00', '130.00'),
(4, 'Baby Diapers - Size 3', 6, '9500.00', 50, '15.00', 200, '2025-01-15', '2026-01-15', 'BBYDZ003', NULL, 'Soft, dry and comfortable', '190.00', '218.50'),
(5, 'Dettol Antiseptic 250ml', 14, '5800.00', 20, '18.00', 120, '2024-11-01', '2026-05-01', 'DETT2502024', NULL, 'Kills 99.9% germs', '290.00', '342.20'),
(6, 'Fresh Milk 1L', 16, '3600.00', 12, '20.00', 60, '2025-05-01', '2025-06-01', 'FMLK1L2025', NULL, 'Keep refrigerated, use within 7 days of opening', '300.00', '360.00'),
(7, 'Writing Pads (A4)', 8, '2400.00', 24, '40.00', 48, '2024-12-15', NULL, 'WPA4242024', NULL, '80 sheets each, ruled', '100.00', '140.00'),
(8, 'Car Engine Oil 5L', 19, '18000.00', 6, '22.00', 18, '2024-10-20', '2026-10-20', 'ENGOIL5L', NULL, 'SAE 5W-30 synthetic oil', '3000.00', '3660.00'),
(9, 'Men’s White T-Shirt', 10, '4000.00', 10, '35.00', 50, '2024-11-10', NULL, 'MWTS2024', NULL, '100% cotton, medium size', '400.00', '540.00'),
(10, 'Frozen Chicken 1kg', 12, '9500.00', 10, '28.00', 100, '2025-03-01', '2025-08-01', 'FCHKN1KG', NULL, 'Keep frozen at -18°C', '950.00', '1216.00'),
(11, 'chair', 5, '5000.00', 10, '20.00', 40, '2025-05-22', '2026-10-22', 'nah', NULL, 'nah', '500.00', '600.00'),
(13, 'chair', 5, '100000.00', 10, '19.99', 50, '2025-05-21', '2025-05-29', NULL, '../uploads/barcodes/22f41aaaeaa008edd27ac1a3561be8de.png', 'na', '10000.00', '11999.00'),
(14, 'Milo', 3, '50000.00', 10, '9.99', 20, '2025-05-22', '2025-05-31', NULL, '../uploads/barcodes/4967d432fb94f4a7159c81686fcd3d4f.png', 'Nah', '5000.00', '5499.50'),
(15, 'Milk', 3, '50000.00', 15, '12.00', 20, '2025-05-01', '2027-08-31', NULL, '../uploads/barcodes/7c89f91b9effb9da1dd3dadb7ac38aed.png', NULL, '3333.33', '3733.33');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `TYPE_ID` int(11) NOT NULL,
  `TYPE` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`TYPE_ID`, `TYPE`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `EMPLOYEE_ID` int(11) DEFAULT NULL,
  `USERNAME` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `TYPE_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `EMPLOYEE_ID`, `USERNAME`, `PASSWORD`, `TYPE_ID`) VALUES
(11, 7, 'admin', 'f865b53623b121fd34ee5426c792e5c33af8c227', 1),
(23, 13, 'bello', 'c3240b9898aede89ba5730b4b028355257d7f1d2', 1),
(24, 15, 'johndoe', '359e60a3e4f8c2a6372a257a80946f92946d027b', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CATEGORY_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CUST_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EMPLOYEE_ID`),
  ADD UNIQUE KEY `EMPLOYEE_ID` (`EMPLOYEE_ID`),
  ADD UNIQUE KEY `PHONE_NUMBER` (`PHONE_NUMBER`),
  ADD KEY `LOCATION_ID` (`LOCATION_ID`),
  ADD KEY `JOB_ID` (`JOB_ID`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`JOB_ID`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LOCATION_ID`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD UNIQUE KEY `PHONE_NUMBER` (`PHONE_NUMBER`),
  ADD KEY `LOCATION_ID` (`LOCATION_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`PRODUCT_ID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`TYPE_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `TYPE_ID` (`TYPE_ID`),
  ADD KEY `EMPLOYEE_ID` (`EMPLOYEE_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CUST_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EMPLOYEE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LOCATION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `PRODUCT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`LOCATION_ID`) REFERENCES `location` (`LOCATION_ID`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`JOB_ID`) REFERENCES `job` (`JOB_ID`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`LOCATION_ID`) REFERENCES `location` (`LOCATION_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`TYPE_ID`) REFERENCES `type` (`TYPE_ID`),
  ADD CONSTRAINT `users_ibfk_4` FOREIGN KEY (`EMPLOYEE_ID`) REFERENCES `employee` (`EMPLOYEE_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
