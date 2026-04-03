CREATE TABLE `attendees` (
  `EmailAtt` varchar(30) NOT NULL,
  `TicketID` varchar(8) NOT NULL,
  `EventID` varchar(8) NOT NULL
)

CREATE TABLE `events` (
  `EventID` varchar(8) NOT NULL,
  `Title` varchar(255) NOT NULL DEFAULT 'No Title',
  `VenueID` int(11) NOT NULL,
  `OrganizerEmail` varchar(30) DEFAULT NULL,
  `Date` datetime NOT NULL
)

CREATE TABLE `participants` (
  `UserEmail` varchar(30) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `PASSWORD` varchar(100) NOT NULL
)


CREATE TABLE `purchase` (
  `TicketID` varchar(8) NOT NULL,
  `EventID` varchar(8) NOT NULL,
  `EmailAtt` varchar(30) NOT NULL,
  `purchase_time` datetime DEFAULT current_timestamp()
)

CREATE TABLE `sessions` (
  `session_id` varchar(255) NOT NULL,
  `user_email` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL
)

CREATE TABLE `ticket` (
  `TicketID` varchar(8) NOT NULL,
  `ticketType` enum('Regular','Premium','VIP') DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `EventID` varchar(8) NOT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp()
)

CREATE TABLE `venue` (
  `ID` int(11) NOT NULL,
  `VenueName` varchar(255) NOT NULL,
  `Location` varchar(20) NOT NULL,
  `VenueSpace` varchar(30) NOT NULL,
  `Capacity` int(11) DEFAULT NULL
)