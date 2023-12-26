-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2023 at 01:05 PM
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
-- Database: `epic`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_informations`
--

CREATE TABLE `account_informations` (
  `account_information_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `dorm_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL,
  `dorm_room_number` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `street_name` varchar(250) DEFAULT NULL,
  `street_number` varchar(20) DEFAULT NULL,
  `parent_phone_number` varchar(15) NOT NULL,
  `parent_email_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_informations`
--

INSERT INTO `account_informations` (`account_information_id`, `booking_id`, `dorm_id`, `first_name`, `last_name`, `student_id`, `dorm_room_number`, `phone_number`, `email_address`, `street_name`, `street_number`, `parent_phone_number`, `parent_email_address`) VALUES
(85, 94, 11, 'Rustom', 'Codilan', 213123, 1, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '', '09975304890', 'rustomcodilan@gmail.com'),
(86, 95, 9, 'Rustom', 'Codilan', 213123, 1, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(87, 96, 5, 'Rustom', 'Codilan', 213123, 1, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(88, 97, 5, 'Rustom', 'Codilan', 213123, 232412, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(89, 98, 11, 'Rustom', 'Codilan', 213123, 142343, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(90, 99, 21, 'Rustom', 'Codilan', 213123, 142834, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(91, 100, 16, 'Rustom', 'Codilan', 213123, 1458794, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(92, 101, 12, 'Lloyd', 'Codilan', 213123, 156435, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(93, 102, 8, 'Rustom', 'Codilan', 213123, 184545, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com'),
(94, 103, 6, 'Rustom', 'Codilan', 213123, 1, '09975304890', 'rustomcodilan@gmail.com', 'Macabalan Piaping-itum', '2076', '09975304890', 'rustomcodilan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `serviceType` varchar(50) NOT NULL,
  `reference_code` varchar(50) NOT NULL,
  `card_holder_name` varchar(100) NOT NULL,
  `booking_date` date NOT NULL,
  `base_price` double(16,2) DEFAULT NULL,
  `additional_box_quantity` int(11) DEFAULT NULL,
  `additional_box_amount` double(16,2) DEFAULT NULL,
  `addtl_box_total_amount` double(16,2) DEFAULT NULL,
  `total_amount` double(16,2) NOT NULL,
  `notes` longtext NOT NULL,
  `picking_date` date DEFAULT NULL,
  `picking_time` time DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `serviceType`, `reference_code`, `card_holder_name`, `booking_date`, `base_price`, `additional_box_quantity`, `additional_box_amount`, `addtl_box_total_amount`, `total_amount`, `notes`, `picking_date`, `picking_time`, `status`) VALUES
(94, 'summer-storage', 'REF_65799dc2bbdc7', 'Michelle Rose Codilan', '2023-12-13', 425.00, 10, 50.00, 500.00, 1425.00, '', '2024-01-06', '12:30:00', 'Done'),
(95, 'summer-advantage', 'REF_6579a25828d07', 'Rustom Codilan', '2023-12-13', 0.00, 5, 50.00, 250.00, 625.00, '', '2023-12-29', '20:00:00', 'Scheduled'),
(96, 'summer-storage', 'REF_657c31922bcc5', 'Michelle Rose Codilan', '2023-12-15', 425.00, 0, 0.00, 0.00, 535.00, '', NULL, NULL, 'Pending'),
(97, 'summer-storage', 'REF_657c3415c9b14', 'Michelle Rose Codilan', '2023-12-15', 425.00, 9, 50.00, 450.00, 1015.00, '', NULL, NULL, 'Pending'),
(98, 'summer-storage', 'REF_657c349063254', 'Michelle Rose Codilan', '2023-12-15', 425.00, 10, 50.00, 500.00, 1505.00, '', NULL, NULL, 'Pending'),
(99, 'summer-storage', 'REF_657c369e99479', 'Rustom Codilan', '2023-12-15', 425.00, 10, 50.00, 500.00, 1105.00, '', '2023-12-16', '13:30:00', 'Scheduled'),
(100, 'summer-storage', 'REF_657c445096590', 'Michelle Rose Codilan', '2023-12-15', 425.00, 10, 50.00, 500.00, 1090.00, '', '2023-12-16', '07:30:00', 'Scheduled'),
(101, 'summer-storage', 'REF_657c4597ae31d', 'Rustom Codilan', '2023-12-15', 425.00, 5, 50.00, 250.00, 735.00, '', '2023-12-16', '07:00:00', 'Scheduled'),
(102, 'summer-storage', 'REF_657c511b6a51a', 'Michelle Rose Codilan', '2023-12-15', 425.00, 10, 50.00, 500.00, 1155.00, '', '2023-12-16', '07:00:00', 'Scheduled'),
(103, 'summer-storage', 'REF_657c51e4e326e', 'Michelle Rose Codilan', '2023-12-15', 425.00, 9, 50.00, 450.00, 1275.00, '', '2023-12-16', '07:00:00', 'Scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `booking_items`
--

CREATE TABLE `booking_items` (
  `booking_item_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(16,2) NOT NULL,
  `totalamount` double(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_items`
--

INSERT INTO `booking_items` (`booking_item_id`, `booking_id`, `item_id`, `size_id`, `quantity`, `price`, `totalamount`) VALUES
(182, 94, 15, 101, 2, 60.00, 120.00),
(183, 94, 19, 114, 1, 50.00, 50.00),
(184, 94, 28, 130, 3, 65.00, 195.00),
(185, 94, 25, 126, 3, 45.00, 135.00),
(186, 96, 26, 127, 2, 25.00, 50.00),
(187, 96, 31, 136, 2, 30.00, 60.00),
(188, 97, 28, 130, 1, 65.00, 65.00),
(189, 97, 23, 122, 1, 75.00, 75.00),
(190, 98, 23, 122, 2, 75.00, 150.00),
(191, 98, 23, 123, 2, 115.00, 230.00),
(192, 98, 2, 8, 2, 100.00, 200.00),
(193, 99, 22, 121, 2, 60.00, 120.00),
(194, 99, 31, 136, 2, 30.00, 60.00),
(195, 100, 31, 136, 3, 30.00, 90.00),
(196, 100, 32, 137, 3, 25.00, 75.00);

-- --------------------------------------------------------

--
-- Table structure for table `dorms`
--

CREATE TABLE `dorms` (
  `dorm_id` int(11) NOT NULL,
  `dorm_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dorms`
--

INSERT INTO `dorms` (`dorm_id`, `dorm_name`) VALUES
(2, 'BELK HALL'),
(3, 'BLESSING'),
(4, 'CAFFEY HALL'),
(5, 'CENTENNIAL SQUARE 1 '),
(6, 'CENTENNIAL SQUARE 2'),
(7, 'FINCH HALL'),
(8, 'GREEK VILLAGE'),
(9, 'MCCAIN PLACE TOWNHOMES'),
(10, 'MCEWEN'),
(11, 'MILLIS HALL'),
(12, 'NORTH COLLEGE COURT'),
(13, 'NORTH COLLEGE TERRACE'),
(14, 'NORTH COLLEGE TOWNHOMES'),
(15, 'NORTH HALL'),
(16, 'PANTHER COMMONS'),
(17, 'POINT PLACE'),
(18, 'UNIVERSITY CENTER 2'),
(19, 'UNIVERSITY LANDING TINY HOMES'),
(20, 'UNIVERSITY OWNED HOUSES'),
(21, 'UNIVERSITY VILLAGE'),
(22, 'ALDRIDGE VILLAGE 1'),
(23, 'ALDRIDGE VILLAGE 2'),
(24, 'WANEK CENTER '),
(25, 'WESLEY HALL'),
(26, 'WILSON'),
(27, 'YADKIN HALL'),
(28, 'YORK HALL'),
(29, 'OTHER');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`) VALUES
(2, 'Wardrobe Box '),
(15, 'TV '),
(16, 'Fridge '),
(17, 'Furniture '),
(18, 'Dresser'),
(19, 'Chair '),
(20, 'Plastic Bins '),
(21, 'Luggage '),
(22, 'Shelves '),
(23, 'Couch '),
(24, 'Futon'),
(25, 'Lamp'),
(26, 'Mirror'),
(27, 'Camp Trunk'),
(28, 'Bar cart'),
(29, 'Bean Bag Chair'),
(30, 'Duffle Bag'),
(31, 'Microwave '),
(32, 'Vacuum'),
(33, 'Swiffer/Mop/Broom'),
(34, 'Wall Art'),
(35, 'Drying Rack '),
(36, 'Mattress Pad'),
(37, 'Plastic rolling drawers'),
(38, 'Bike'),
(39, 'Golf Clubs'),
(40, 'Car');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` longtext NOT NULL,
  `messagedate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_informations`
--

CREATE TABLE `service_informations` (
  `service_information_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `is_boxes_included` varchar(10) NOT NULL,
  `box_quantity` int(11) NOT NULL,
  `is_storage_additional_item` varchar(10) NOT NULL,
  `is_storage_car_in_may` varchar(10) NOT NULL,
  `is_storage_vehicle_in_may` varchar(10) NOT NULL,
  `is_summer_school` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_informations`
--

INSERT INTO `service_informations` (`service_information_id`, `booking_id`, `is_boxes_included`, `box_quantity`, `is_storage_additional_item`, `is_storage_car_in_may`, `is_storage_vehicle_in_may`, `is_summer_school`) VALUES
(80, 94, 'Yes', 10, 'Yes', 'Yes', 'No', 'Yes'),
(81, 95, 'Yes', 5, 'Yes', '', '', ''),
(82, 96, 'Yes', 0, 'Yes', 'No', 'No', 'Yes'),
(83, 97, 'Yes', 9, 'Yes', 'No', 'Yes', 'No'),
(84, 98, 'Yes', 10, 'Yes', 'Yes', 'No', 'Yes'),
(85, 99, 'Yes', 10, 'Yes', 'No', 'No', 'No'),
(86, 100, 'Yes', 10, 'Yes', 'No', 'Yes', 'No'),
(87, 101, 'Yes', 5, 'Yes', 'Yes', 'No', 'Yes'),
(88, 102, 'Yes', 10, 'Yes', 'No', 'Yes', 'No'),
(89, 103, 'Yes', 9, 'Yes', 'No', 'Yes', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `cost` double(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `item_id`, `size`, `cost`) VALUES
(7, 2, 'SM (24\"x20\"X34\")', 70.00),
(8, 2, 'LG (24\"x24\"X48\")', 100.00),
(100, 15, '24\" OR LESS ', 45.00),
(101, 15, '36\" OR LESS', 60.00),
(102, 15, '46\" OR LESS', 75.00),
(103, 15, '56\" OR LESS', 85.00),
(104, 15, '65\" OR LESS ', 100.00),
(105, 16, 'SM (1.7 Cubic FT)', 45.00),
(106, 16, 'MED (2.7 Cubic FT)', 55.00),
(107, 16, 'LG (3.3 Cubic FT)', 65.00),
(108, 17, 'SM (Nite stand)', 45.00),
(109, 17, 'MED (TV Stand) ', 65.00),
(110, 17, 'LG (Desk) ', 100.00),
(111, 18, 'MD (4 drawers)', 65.00),
(112, 18, 'LG (6+ drawers)', 100.00),
(113, 19, 'SM (Desk) ', 30.00),
(114, 19, 'MED (Room chair)', 50.00),
(115, 20, 'SM', 45.00),
(116, 20, 'LG', 60.00),
(117, 21, 'SM', 30.00),
(118, 21, 'LG', 60.00),
(119, 22, 'SM (Two shelves)', 35.00),
(120, 22, 'MED Four shelves', 45.00),
(121, 22, 'LG (Six shelves)', 60.00),
(122, 23, 'Loveseat', 75.00),
(123, 23, 'Full Length', 115.00),
(124, 24, 'Standard size', 75.00),
(125, 25, 'Desk lamp', 25.00),
(126, 25, 'Floor lamp', 45.00),
(127, 26, 'Lightweight', 25.00),
(128, 26, 'Full Length', 70.00),
(129, 27, 'Standard size', 50.00),
(130, 28, 'Standard size', 65.00),
(131, 29, 'SM (32\"Wide)', 40.00),
(132, 29, 'MED (40\"Wide)', 50.00),
(133, 29, 'LG (52\" Plus Wide)', 65.00),
(134, 30, 'SM', 35.00),
(135, 30, 'LG', 50.00),
(136, 31, 'Standard size', 30.00),
(137, 32, 'Standard size', 25.00),
(138, 33, 'Standard size', 25.00),
(139, 34, 'SM (20\" Wide)', 25.00),
(140, 34, 'MED (30\" Wide)', 45.00),
(141, 34, 'LG (50\" Plus Wide)', 65.00),
(142, 35, 'Standard size', 15.00),
(143, 36, 'Twin Bed', 45.00),
(144, 36, 'Full Bed', 70.00),
(145, 37, 'SM (14\"X12\"X24\")', 45.00),
(146, 37, 'LG (15\'X21\"24)', 60.00),
(147, 38, 'Standard size', 65.00),
(148, 39, 'Standard size', 60.00),
(149, 40, 'Four months', 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `emailaddress` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `encryptedpass` varchar(100) NOT NULL,
  `usertype` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `emailaddress`, `username`, `password`, `encryptedpass`, `usertype`) VALUES
(6, 'Rustom', 'Codilan', 'rustomcodilan@gmail.com', 'r.codilan', '12345', '$2y$10$sE7LGsBgK4iJwLAKOSyWpe8BFGen81MKnZ.5KfuxO/Vm7SDr5lIRq', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_informations`
--
ALTER TABLE `account_informations`
  ADD PRIMARY KEY (`account_information_id`),
  ADD KEY `dorm_id` (`dorm_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `booking_items`
--
ALTER TABLE `booking_items`
  ADD PRIMARY KEY (`booking_item_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `dorms`
--
ALTER TABLE `dorms`
  ADD PRIMARY KEY (`dorm_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `service_informations`
--
ALTER TABLE `service_informations`
  ADD PRIMARY KEY (`service_information_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_informations`
--
ALTER TABLE `account_informations`
  MODIFY `account_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `booking_items`
--
ALTER TABLE `booking_items`
  MODIFY `booking_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `dorms`
--
ALTER TABLE `dorms`
  MODIFY `dorm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_informations`
--
ALTER TABLE `service_informations`
  MODIFY `service_information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_informations`
--
ALTER TABLE `account_informations`
  ADD CONSTRAINT `account_informations_ibfk_1` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`dorm_id`),
  ADD CONSTRAINT `account_informations_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `booking_items`
--
ALTER TABLE `booking_items`
  ADD CONSTRAINT `booking_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `booking_items_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`),
  ADD CONSTRAINT `booking_items_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `service_informations`
--
ALTER TABLE `service_informations`
  ADD CONSTRAINT `service_informations_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `sizes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
