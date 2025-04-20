-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 08:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `id` int(11) NOT NULL,
  `numberplate` varchar(20) DEFAULT NULL,
  `current_bid` decimal(10,2) DEFAULT NULL,
  `end_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`id`, `numberplate`, `current_bid`, `end_time`) VALUES
(1, 'TN01AB1234', 700000.00, '2025-04-30 18:00:00'),
(2, 'MH02EP9078', 500000.00, '2025-04-23 19:32:53'),
(3, 'MH02EP9078', 44444444.00, '2025-04-23 19:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `asking_price` decimal(10,2) NOT NULL,
  `mileage` int(11) NOT NULL,
  `fuel_type` varchar(20) NOT NULL,
  `transmission` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `numberplate` varchar(20) NOT NULL,
  `seller_email` varchar(100) NOT NULL,
  `list_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`id`, `brand`, `model`, `year`, `asking_price`, `mileage`, `fuel_type`, `transmission`, `description`, `numberplate`, `seller_email`, `list_date`) VALUES
(1, 'Toyota', 'Corolla', 2020, 15500.00, 35000, 'Petrol', 'Automatic', 'Well maintained, single owner, full service history.', 'ABC1234', 'seller@example.com', '2025-04-16 21:16:50'),
(2, 'Honda', 'Civic', 2018, 13500.00, 42000, 'Petrol', 'Manual', 'Recently serviced, new tires.', 'XYZ5678', 'seller2@example.com', '2025-04-16 21:17:42'),
(3, 'Ford', 'Focus', 2019, 14000.00, 30000, 'Diesel', 'Automatic', 'Clean interior and exterior.', 'DEF4321', 'seller3@example.com', '2025-04-16 21:17:42'),
(4, 'BMW', '320i', 2017, 21000.00, 50000, 'Petrol', 'Automatic', 'Luxury sedan with sunroof.', 'GHI8765', 'seller4@example.com', '2025-04-16 21:17:42'),
(5, 'Audi', 'A4', 2021, 28000.00, 15000, 'Petrol', 'Automatic', 'Excellent condition, barely used.', 'JKL3456', 'seller5@example.com', '2025-04-16 21:17:42'),
(6, 'Hyundai', 'Elantra', 2022, 19000.00, 8000, 'Petrol', 'Manual', 'As good as new, first owner.', 'MNO1234', 'seller6@example.com', '2025-04-16 21:17:42'),
(7, 'Nissan', 'Altima', 2020, 16000.00, 27000, 'Petrol', 'Automatic', 'Smooth drive, accident free.', 'PQR5678', 'seller7@example.com', '2025-04-16 21:17:42'),
(8, 'Kia', 'Forte', 2019, 14500.00, 33000, 'Petrol', 'Manual', 'Great fuel efficiency.', 'STU4321', 'seller8@example.com', '2025-04-16 21:17:42'),
(9, 'Mazda', '3', 2018, 13000.00, 41000, 'Petrol', 'Automatic', 'Well maintained hatchback.', 'VWX8765', 'seller9@example.com', '2025-04-16 21:17:42'),
(10, 'Chevrolet', 'Malibu', 2021, 17500.00, 22000, 'Petrol', 'Automatic', 'One owner, leather seats.', 'YZA3456', 'seller10@example.com', '2025-04-16 21:17:42'),
(11, 'Volkswagen', 'Jetta', 2020, 16500.00, 25000, 'Diesel', 'Manual', 'Comfortable ride, good condition.', 'BCD1234', 'seller11@example.com', '2025-04-16 21:17:42'),
(12, 'Tesla', 'Model 3', 2022, 35000.00, 12000, 'Electric', 'Automatic', 'Fully electric, autopilot feature.', 'EFG5678', 'seller12@example.com', '2025-04-16 21:17:42'),
(13, 'Mercedes-Benz', 'C-Class', 2019, 33000.00, 29000, 'Petrol', 'Automatic', 'Luxury car, like new.', 'HIJ4321', 'seller13@example.com', '2025-04-16 21:17:42'),
(14, 'Subaru', 'Impreza', 2017, 12500.00, 46000, 'Petrol', 'Manual', 'AWD, great for snow.', 'KLM8765', 'seller14@example.com', '2025-04-16 21:17:42'),
(15, 'Lexus', 'IS 300', 2021, 32000.00, 18000, 'Petrol', 'Automatic', 'High-end features, smooth ride.', 'NOP3456', 'seller15@example.com', '2025-04-16 21:17:42'),
(16, 'Jeep', 'Compass', 2018, 17000.00, 38000, 'Diesel', 'Manual', 'SUV, good for off-roading.', 'QRS1234', 'seller16@example.com', '2025-04-16 21:17:42'),
(17, 'Renault', 'Duster', 2019, 15000.00, 34000, 'Diesel', 'Manual', 'Reliable SUV, spacious.', 'TUV5678', 'seller17@example.com', '2025-04-16 21:17:42'),
(18, 'Skoda', 'Octavia', 2020, 21000.00, 28000, 'Petrol', 'Automatic', 'Elegant design, powerful engine.', 'WXY4321', 'seller18@example.com', '2025-04-16 21:17:42'),
(19, 'Peugeot', '308', 2017, 11000.00, 52000, 'Diesel', 'Manual', 'Compact and efficient.', 'ZAB8765', 'seller19@example.com', '2025-04-16 21:17:42'),
(20, 'Volvo', 'S60', 2022, 29000.00, 10000, 'Petrol', 'Automatic', 'Top safety features included.', 'CDE3456', 'seller20@example.com', '2025-04-16 21:17:42'),
(21, 'Maruti Suzuki', 'Santro', 2025, 0.00, 25, 'Petrol', 'Manual', 'fer', '946E246C', '', '2025-04-16 21:24:03'),
(22, 'HONDA ', 'CIVIC', 2019, 0.00, 25, 'Petrol', 'Manual', 'CAR1', '2722E87C', '', '2025-04-16 22:44:43'),
(23, 'maruti ', 'maybach', 1900, 0.00, 20, 'Petrol', 'Manual', 'hhhh', '9906EA38', '', '2025-04-17 05:44:06'),
(24, 'maruti ', 'maybach', 2004, 0.00, 10, 'Petrol', 'Manual', 'hehehhe', '12672D3A', '', '2025-04-17 05:47:43'),
(25, 'maruti ', 'JJJ', 2005, 0.00, 7, 'Petrol', 'Automatic', 'HAH', 'D0F3648C', '', '2025-04-17 06:35:59'),
(26, 'Maruti', 'Suzuki', 2005, 0.00, 8, 'Petrol', 'Automatic', 'Hi', '76E13353', '', '2025-04-17 06:52:45'),
(27, 'maruti ', 'maybach', 2005, 0.00, 10, 'Petrol', 'Manual', 'hi', 'BE5013AD', '', '2025-04-17 07:10:15'),
(28, 'maruti ', 'maybach', 2004, 0.00, 20, 'Petrol', 'Manual', 'hi', '66CDFC22', '', '2025-04-17 20:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `id` int(11) NOT NULL,
  `numberplate` varchar(20) NOT NULL,
  `seller_email` varchar(100) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `asking_price` decimal(10,2) NOT NULL,
  `mileage` int(11) NOT NULL,
  `fuel_type` varchar(20) NOT NULL,
  `transmission` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `listing_type` enum('fixed_price','auction') NOT NULL,
  `auction_end` datetime DEFAULT NULL,
  `current_bid` decimal(10,2) DEFAULT NULL,
  `list_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','sold','expired') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`id`, `numberplate`, `seller_email`, `brand`, `model`, `year`, `asking_price`, `mileage`, `fuel_type`, `transmission`, `description`, `listing_type`, `auction_end`, `current_bid`, `list_date`, `status`) VALUES
(9, '76E13353', 'shaunak123@gmail.com', '', '', 0, 100000.00, 0, '', '', NULL, 'fixed_price', NULL, NULL, '2025-04-17 06:52:45', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` int(11) NOT NULL,
  `car_maker` varchar(50) DEFAULT NULL,
  `model_line` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `modification` varchar(100) DEFAULT NULL,
  `part_name` varchar(100) DEFAULT NULL,
  `part_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `car_maker`, `model_line`, `year`, `modification`, `part_name`, `part_price`) VALUES
(1, 'Toyota', 'Corolla', 2020, 'Base', 'Brake Pad', 4500.00),
(2, 'Toyota', 'Corolla', 2020, 'Base', 'Air Filter', 1200.00),
(3, 'Honda', 'Civic', 2019, 'VX', 'Clutch Kit', 7500.00),
(4, 'Hyundai', 'Verna', 2021, 'SX', 'Headlight', 6400.00),
(5, 'Hyundai', 'Verna', 2021, 'SX', 'Battery', 5600.00),
(6, 'Toyota', 'Corolla', 2018, '1.8L Petrol', 'Brake Pads', 120.00),
(7, 'Honda', 'Civic', 2012, '1.6L Petrol', 'Air Filter', 25.00),
(8, 'Ford', 'Focus', 2019, '1.5L Diesel', 'Oil Filter', 30.00),
(9, 'BMW', '320i', 2017, '2.0L Petrol Turbo', 'Headlight Assembly', 250.00),
(10, 'Audi', 'A4', 2016, '2.0L TFSI', 'Fuel Pump', 180.00),
(11, 'Hyundai', 'Elantra', 2022, '1.8L Petrol', 'Suspension Kit', 310.00),
(12, 'Nissan', 'Altima', 2020, '2.5L Petrol', 'Spark Plugs', 45.00),
(13, 'Kia', 'Forte', 2019, '2.0L Petrol', 'Battery', 100.00),
(14, 'Mazda', '3', 2010, '2.0L Petrol', 'Exhaust Muffler', 220.00),
(15, 'Chevrolet', 'Malibu', 2021, '1.5L Turbo', 'Radiator', 150.00),
(16, 'Volkswagen', 'Jetta', 2018, '1.4L TSI', 'AC Compressor', 280.00),
(17, 'Tesla', 'Model 3', 2022, 'Electric Dual Motor', 'Touchscreen Panel', 450.00),
(18, 'Mercedes-Benz', 'C-Class', 2019, 'C200 AMG Line', 'Control Arm', 200.00),
(19, 'Subaru', 'Impreza', 2013, 'AWD 2.0L', 'Timing Belt Kit', 175.00),
(20, 'Lexus', 'IS 300', 2015, '3.5L V6', 'Navigation System', 480.00),
(21, 'Jeep', 'Compass', 2018, '2.0L Diesel', 'Steering Rack', 260.00),
(22, 'Renault', 'Duster', 2019, '1.5L Petrol', 'Rear Bumper', 140.00),
(23, 'Skoda', 'Octavia', 2020, '1.8 TSI', 'Fog Light Assembly', 75.00),
(24, 'Peugeot', '308', 2017, '1.2L Diesel', 'EGR Valve', 90.00),
(25, 'Volvo', 'S60', 2022, '2.0L Turbo', 'Engine Mount', 130.00),
(26, 'Maruti Suzuki', 'Santro', 2025, '1.1L Petrol', 'Side Mirror', 40.00),
(27, 'Toyota', 'Corolla', 2018, '1.8L Petrol', 'Brake Pads', 120.00),
(28, 'Toyota', 'Corolla', 2018, '1.8L Petrol', 'Air Filter', 25.00),
(29, 'Toyota', 'Corolla', 2018, '1.8L Petrol', 'Alternator', 180.00),
(30, 'Honda', 'Civic', 2012, '1.6L Petrol', 'Radiator', 160.00),
(31, 'Honda', 'Civic', 2012, '1.6L Petrol', 'Fuel Pump', 140.00),
(32, 'Honda', 'Civic', 2012, '1.6L Petrol', 'Control Arm', 110.00),
(33, 'Ford', 'Focus', 2019, '1.5L Diesel', 'Battery', 95.00),
(34, 'Ford', 'Focus', 2019, '1.5L Diesel', 'Spark Plugs', 45.00),
(35, 'Ford', 'Focus', 2019, '1.5L Diesel', 'Timing Chain', 220.00),
(36, 'BMW', '320i', 2017, '2.0L Turbo Petrol', 'Headlight Assembly', 260.00),
(37, 'BMW', '320i', 2017, '2.0L Turbo Petrol', 'Steering Rack', 310.00),
(38, 'BMW', '320i', 2017, '2.0L Turbo Petrol', 'Front Bumper', 400.00),
(39, 'Audi', 'A4', 2016, '2.0L TFSI', 'Oil Filter', 35.00),
(40, 'Audi', 'A4', 2016, '2.0L TFSI', 'AC Compressor', 290.00),
(41, 'Audi', 'A4', 2016, '2.0L TFSI', 'Door Handle', 85.00),
(42, 'Hyundai', 'Elantra', 2022, '1.8L Petrol', 'Shock Absorbers', 180.00),
(43, 'Hyundai', 'Elantra', 2022, '1.8L Petrol', 'Wiper Motor', 90.00),
(44, 'Hyundai', 'Elantra', 2022, '1.8L Petrol', 'Coolant Hose', 20.00),
(45, 'Nissan', 'Altima', 2020, '2.5L Petrol', 'Crankshaft Sensor', 70.00),
(46, 'Nissan', 'Altima', 2020, '2.5L Petrol', 'Side Mirror', 50.00),
(47, 'Nissan', 'Altima', 2020, '2.5L Petrol', 'Door Lock Actuator', 120.00),
(48, 'Kia', 'Forte', 2019, '2.0L Petrol', 'Transmission Filter', 55.00),
(49, 'Kia', 'Forte', 2019, '2.0L Petrol', 'Window Motor', 95.00),
(50, 'Kia', 'Forte', 2019, '2.0L Petrol', 'Oxygen Sensor', 60.00),
(51, 'Mazda', '3', 2010, '2.0L Petrol', 'Steering Pump', 150.00),
(52, 'Mazda', '3', 2010, '2.0L Petrol', 'Rearview Mirror', 35.00),
(53, 'Mazda', '3', 2010, '2.0L Petrol', 'Radiator Cap', 10.00),
(54, 'Chevrolet', 'Malibu', 2021, '1.5L Turbo', 'Throttle Body', 140.00),
(55, 'Chevrolet', 'Malibu', 2021, '1.5L Turbo', 'Fuel Injector', 70.00),
(56, 'Chevrolet', 'Malibu', 2021, '1.5L Turbo', 'Ignition Coil', 55.00),
(57, 'Volkswagen', 'Jetta', 2018, '1.4L TSI', 'Water Pump', 100.00),
(58, 'Volkswagen', 'Jetta', 2018, '1.4L TSI', 'Glow Plugs', 65.00),
(59, 'Volkswagen', 'Jetta', 2018, '1.4L TSI', 'Timing Belt', 180.00),
(60, 'Tesla', 'Model 3', 2022, 'Dual Motor', 'Infotainment Screen', 600.00),
(61, 'Tesla', 'Model 3', 2022, 'Dual Motor', 'Electric Motor', 900.00),
(62, 'Tesla', 'Model 3', 2022, 'Dual Motor', 'Battery Cooling Pump', 150.00),
(63, 'Mercedes-Benz', 'C-Class', 2019, 'C200 AMG', 'Cabin Air Filter', 45.00),
(64, 'Mercedes-Benz', 'C-Class', 2019, 'C200 AMG', 'Strut Mount', 95.00),
(65, 'Mercedes-Benz', 'C-Class', 2019, 'C200 AMG', 'Door Trim Panel', 270.00),
(66, 'Subaru', 'Impreza', 2013, '2.0L AWD', 'Exhaust Manifold', 180.00),
(67, 'Subaru', 'Impreza', 2013, '2.0L AWD', 'Wheel Bearing', 80.00),
(68, 'Subaru', 'Impreza', 2013, '2.0L AWD', 'CV Joint', 95.00),
(69, 'Lexus', 'IS 300', 2015, '3.5L V6', 'Brake Caliper', 240.00),
(70, 'Lexus', 'IS 300', 2015, '3.5L V6', 'Sun Visor', 55.00),
(71, 'Lexus', 'IS 300', 2015, '3.5L V6', 'Fog Light', 65.00),
(72, 'Jeep', 'Compass', 2018, '2.0L Diesel', 'Gearbox Mount', 110.00),
(73, 'Jeep', 'Compass', 2018, '2.0L Diesel', 'Upper Control Arm', 95.00),
(74, 'Jeep', 'Compass', 2018, '2.0L Diesel', 'Radiator Fan', 180.00),
(75, 'Renault', 'Duster', 2019, '1.5L Petrol', 'Front Grille', 130.00),
(76, 'Renault', 'Duster', 2019, '1.5L Petrol', 'Starter Motor', 175.00),
(77, 'Renault', 'Duster', 2019, '1.5L Petrol', 'Hub Assembly', 90.00),
(78, 'Skoda', 'Octavia', 2020, '1.8 TSI', 'Door Window Switch', 35.00),
(79, 'Skoda', 'Octavia', 2020, '1.8 TSI', 'AC Blower', 100.00),
(80, 'Skoda', 'Octavia', 2020, '1.8 TSI', 'ABS Sensor', 85.00),
(81, 'Peugeot', '308', 2017, '1.2L Diesel', 'Clutch Kit', 210.00),
(82, 'Peugeot', '308', 2017, '1.2L Diesel', 'Window Regulator', 90.00),
(83, 'Peugeot', '308', 2017, '1.2L Diesel', 'Boot Latch', 40.00),
(84, 'Volvo', 'S60', 2022, '2.0L Turbo', 'Mass Airflow Sensor', 130.00),
(85, 'Volvo', 'S60', 2022, '2.0L Turbo', 'Timing Gear', 190.00),
(86, 'Volvo', 'S60', 2022, '2.0L Turbo', 'Brake Disc', 160.00),
(87, 'Maruti Suzuki', 'Santro', 2025, '1.1L Petrol', 'Tail Light', 60.00),
(88, 'Maruti Suzuki', 'Santro', 2025, '1.1L Petrol', 'Dashboard Panel', 75.00),
(89, 'Maruti Suzuki', 'Santro', 2025, '1.1L Petrol', 'Horn Relay', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `buyer_email` varchar(100) DEFAULT NULL,
  `numberplate` varchar(20) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `buyer_email`, `numberplate`, `purchase_date`) VALUES
(1, 'shaunak@gmail.com', 'TN01AB1234', '2025-04-16 17:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `user`, `rating`, `created_at`) VALUES
(1, 'shashank.kulkarni1411@gmail.com', 5, '2025-04-17 04:08:54'),
(2, 'satvikgupta4577@gmail.com', 4, '2025-04-17 11:15:35'),
(3, 'shanak@gmail.com', 5, '2025-04-17 12:16:46'),
(4, 'shaunak123@gmail.com', 4, '2025-04-17 12:30:17'),
(5, 'shaun765@gmail.com', 3, '2025-04-17 20:49:11'),
(6, 'shubh1223@gmail.com', 5, '2025-04-18 01:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'shashank.kulkarni1411@gmail.com', '$2y$10$LO6YEid2rSd4GEYH50.gfeXXPwrrpKKxEbJ6/WSGTyY4Y86UfS2da'),
(2, 'shaunak@gmail.com', '$2y$10$q3wxA7gt8IpCGVraDswkPOiKw31abyDVzFkTIVYPwxEuA1ZKpLAce'),
(3, 'satvikgupta4577@gmail.com', '$2y$10$RJh96EV1oXMtPXsn82G1xeUpILovvairXh75O7iOlFVW3Px8SP9eG'),
(4, 'hello@gmail.com', '$2y$10$kXu6rLOgRgrgLN6R7Nrogelq7YD8qAXj/kbT3mAsuPFLhsJG7XIZa'),
(5, 'sh@gmail.com', '$2y$10$K/FhQDWgrkpgazzL02U.8O/FYu58jnqY21C72RFjUIaw1u5H7kV.G'),
(6, 'satvikgupta260705@gmail.com', '$2y$10$HD4Gj8HC49ShPa4hzQ5sp.au/4bWxmGKmcDgrl5XE0hiezDptlkuC'),
(7, 'satvik7777@gmail.com', '$2y$10$yxdlCn2uuDxHkkWSToutuOPg.CloqZC./xov8kvVZgH0MvAdpk9Pm'),
(8, 'shashank@gmail.com', '$2y$10$3y96ktgoabzPXaoqSoSuHOnwWrDp0dprqfHZjZjyc6ejT52.TOqTq'),
(9, 'shanak@gmail.com', '$2y$10$d0DaZ6gtxpn4pa4KZFx8QOQjgDqLQQOG1wUQvgpI8EWbsYFLJOqWi'),
(10, 'shaunak123@gmail.com', '$2y$10$owi7nkr.rHT6G/dbUAqade/Aaeibbmocakqxzj8nHZ2F.WQpi/D1i'),
(11, 'shaun765@gmail.com', '$2y$10$fKQVL9ojvFO2g1hqxlAW8OSI9mGFA1IcbnGDW2Xe.epFhCH9alE6a'),
(12, 'shubh1223@gmail.com', '$2y$10$8Ul6BjrI4vV6oYlLqOMBV.F1uUQ8a9J6QouDGqnw0BfXqSlVVy0I2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numberplate` (`numberplate`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_email` (`seller_email`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `listings_ibfk_1` FOREIGN KEY (`seller_email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
