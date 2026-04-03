-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 04:45 AM
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
-- Database: `eventms`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `EmailAtt` varchar(30) NOT NULL,
  `TicketID` varchar(8) NOT NULL,
  `EventID` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`EmailAtt`, `TicketID`, `EventID`) VALUES
('abdullah.al.mamun12@g.bracu.ac', 'TKT23496', 'EVT12973'),
('dummy@gmail.com', 'TKT31955', 'EVT27984'),
('dummy@gmail.com', 'TKT82461', 'EVT79261'),
('info@brac.net', 'TKT90773', 'EVT15791');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `EventID` varchar(8) NOT NULL,
  `Title` varchar(255) NOT NULL DEFAULT 'No Title',
  `VenueID` int(11) NOT NULL,
  `OrganizerEmail` varchar(30) DEFAULT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`EventID`, `Title`, `VenueID`, `OrganizerEmail`, `Date`) VALUES
('EVT05619', 'No Title', 45, 'ajarjun0513@gmail.com', '2024-10-31 19:00:00'),
('EVT08177', 'Shadhinota Concert', 46, 'ajarjun0513@gmail.com', '2024-12-16 15:00:00'),
('EVT12973', 'Half-yearly Meeting', 47, 'info@brac.net', '2024-10-15 09:30:00'),
('EVT15791', 'No Title', 43, 'arjun.saha@g.bracu.ac', '2024-10-15 09:00:00'),
('EVT27984', 'Hypocrisy', 49, 'info@brac.net', '2024-11-21 14:00:00'),
('EVT34456', 'No Title', 42, 'arjun.saha@g.bracu.ac', '2024-12-16 15:00:00'),
('EVT79261', 'No Title', 44, 'anika.anjum@gmail.com', '2024-11-21 14:00:00'),
('EVT80831', 'BRAC 50 Years Celebration', 48, 'info@brac.net', '2025-08-05 15:00:00');

--
-- Triggers `events`
--
DELIMITER $$
CREATE TRIGGER `before_insert_events` BEFORE INSERT ON `events` FOR EACH ROW BEGIN
    DECLARE random_number INT;
    SET random_number = FLOOR(RAND() * 100000);
    SET NEW.EventID = CONCAT('EVT', LPAD(random_number, 5, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `UserEmail` varchar(30) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `PASSWORD` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`UserEmail`, `NAME`, `PhoneNumber`, `PASSWORD`) VALUES
('arjun144948@gmail.com', 'arjun.saha21', '', '5e8667a439c68f5145dd2fcbecf02209'),
('abdullah.al.mamun12@g.bracu.ac', 'Arjun Saha', '01521799483', '25d55ad283aa400af464c76d713c07ad'),
('dummy@gmail.com', 'Dummy', '01123456789', '8de64354e677507895d6026cf5d51ebb'),
('info@brac.net', 'BRAC', '01316549565', 'ac40df6b0ecacd0a38ae59c70ef5192e');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `TicketID` varchar(8) NOT NULL,
  `EventID` varchar(8) NOT NULL,
  `EmailAtt` varchar(30) NOT NULL,
  `purchase_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`TicketID`, `EventID`, `EmailAtt`, `purchase_time`) VALUES
('TKT90773', 'EVT15791', 'info@brac.net', '2024-09-24 03:08:45'),
('TKT23496', 'EVT12973', 'arjun.saha@g.bracu.ac', '2024-09-24 03:20:28'),
('TKT31955', 'EVT27984', 'humaira@gmail.com', '2024-09-24 08:24:31'),
('TKT82461', 'EVT79261', 'anika.anjum@gmail.com', '2024-09-24 08:25:59');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(255) NOT NULL,
  `user_email` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `user_email`, `created_at`, `expires_at`) VALUES
('ghbpqd4kt77bupou43t7f2m9p7', 'dummy@gmail.com', '2024-09-24 08:23:18', '2024-09-24 05:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `TicketID` varchar(8) NOT NULL,
  `ticketType` enum('Regular','Premium','VIP') DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `EventID` varchar(8) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`TicketID`, `ticketType`, `Price`, `EventID`, `Time`) VALUES
('TKT23496', 'Premium', 2000, 'EVT12973', '2024-09-24 03:20:28'),
('TKT31955', 'Regular', 850, 'EVT27984', '2024-09-24 08:24:31'),
('TKT82461', 'Premium', 1500, 'EVT79261', '2024-09-24 08:25:59'),
('TKT90773', 'VIP', 7000, 'EVT15791', '2024-09-24 03:08:45');

--
-- Triggers `ticket`
--
DELIMITER $$
CREATE TRIGGER `before_insert_ticket` BEFORE INSERT ON `ticket` FOR EACH ROW BEGIN
    DECLARE random_number INT;
    SET random_number = FLOOR(RAND() * 100000);
    SET NEW.TicketID = CONCAT('TKT', LPAD(random_number, 5, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `ID` int(11) NOT NULL,
  `VenueName` varchar(255) NOT NULL,
  `Location` varchar(20) NOT NULL,
  `VenueSpace` varchar(30) NOT NULL,
  `Capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`ID`, `VenueName`, `Location`, `VenueSpace`, `Capacity`) VALUES
(38, 'Bangladesh China Friendship Conference Center', 'Agargaon', 'Concert Hall', 400),
(39, 'Dhaka Convention Center', 'Azimpur', 'Community Centre', 500),
(40, 'International Convention City Bashundhara', 'Purbachal', 'Auditorium', 20000),
(41, 'City Hall Convention Center', 'Chittagong', 'Art Galleries', 2500),
(42, 'International Convention City Bashundhara', 'Purbachal', 'Auditorium', 20000),
(43, 'City Hall Convention Center', 'Chittagong', 'Art Galleries', 2500),
(44, 'Tokyo Square Convention Center', 'Shyamoli', 'Community Centre', 250),
(45, 'Bangladesh China Friendship Conference Center', 'Agargaon', 'Auditorium', 12000),
(46, 'Bangladesh China Friendship Conference Center', 'Agargaon', 'Auditorium', 12000),
(47, 'Dhaka Convention Center', 'Azimpur', 'Community Centre', 500),
(48, 'International Convention City Bashundhara', 'Purbachal', 'Auditorium', 20000),
(49, 'Tokyo Square Convention Center', 'Shyamoli', 'Auditorium', 10000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD UNIQUE KEY `TicketID` (`TicketID`) USING BTREE,
  ADD KEY `EventID` (`EventID`),
  ADD KEY `EmailAtt` (`EmailAtt`) USING BTREE;

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`EventID`),
  ADD UNIQUE KEY `VenueID` (`VenueID`),
  ADD KEY `organizer` (`OrganizerEmail`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`UserEmail`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD KEY `EventID` (`EventID`),
  ADD KEY `EmailAtt` (`EmailAtt`),
  ADD KEY `TicketID` (`TicketID`) USING BTREE;

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `EventID` (`EventID`) USING BTREE;

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `ticketid` FOREIGN KEY (`TicketID`) REFERENCES `ticket` (`TicketID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `venueid` FOREIGN KEY (`VenueID`) REFERENCES `venue` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`TicketID`) REFERENCES `ticket` (`TicketID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_ibfk_3` FOREIGN KEY (`EmailAtt`) REFERENCES `participants` (`UserEmail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `participants` (`UserEmail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
