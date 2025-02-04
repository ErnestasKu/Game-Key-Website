-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 11:03 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamestoredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id_user` varchar(32) NOT NULL,
  `id_key` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id_user`, `id_key`) VALUES
('35ecae0798c7115d3d8b0787363eff63', 4),
('dcb3f443ea60f71f8451d7029a4a1fb7', 4),
('dcb3f443ea60f71f8451d7029a4a1fb7', 9),
('dcb3f443ea60f71f8451d7029a4a1fb7', 18);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id_game` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `release_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id_game`, `title`, `description`, `release_date`) VALUES
(1, 'The Legend of Heroes', 'A turn-based RPG with a deep story set in the land of Zemuria.', '2024-05-10'),
(2, 'Mystic Quest', 'An action-adventure game where the protagonist must save the kingdom.', '2023-08-15'),
(3, 'Skyfall Saga', 'A futuristic shooter where players battle in the skies of a dystopian world.', '2023-12-01'),
(4, 'Dungeon Masters', 'A strategy game where players control a group of adventurers in a dungeon.', '2024-01-20'),
(5, 'Fury Road', 'A racing game in a post-apocalyptic world with vehicle combat and speed challenges.', '2025-03-10'),
(6, 'Balatro', 'The poker roguelike. Balatro is a hypnotically satisfying deckbuilder where you play illegal poker hands, discover game-changing jokers, and trigger adrenaline-pumping, outrageous combos.', '2024-02-20'),
(7, 'Fallout 4', 'Bethesda Game Studios, the award-winning creators of Fallout 3 and The Elder Scrolls V: Skyrim, welcome you to the world of Fallout 4 – their most ambitious game ever, and the next generation of open-world gaming.', '2015-11-10'),
(8, 'Darkest Dungeon®', 'Darkest Dungeon is a challenging gothic roguelike turn-based RPG about the psychological stresses of adventuring. Recruit, train, and lead a team of flawed heroes against unimaginable horrors, stress, disease, and the ever-encroaching dark. Can you keep your heroes together when all hope is lost?', '2016-01-16'),
(9, 'Divinity: Original Sin 2 - Definitive Edition', 'The critically acclaimed RPG that raised the bar, from the creators of Baldur\'s Gate 3. Gather your party. Master deep, tactical combat. Venture as a party of up to four - but know that only one of you will have the chance to become a God.', '2017-09-14'),
(10, '0123456789 0123456789 0123456789 ', '0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 01234', '2025-02-05'),
(11, '0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 0123456789 01', 's', '2024-12-31'),
(12, 'NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 ', 'NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 NEW123 ', '2024-12-31'),
(13, 'Farming Simulator 25', 'Farming Simulator 25 invites you to join the rewarding farm life, single-handedly or cooperatively in multiplayer. This Farm is Your Farm!', '2024-11-12'),
(14, 'Stardew Valley', 'You\'ve inherited your grandfather\'s old farm plot in Stardew Valley. Armed with hand-me-down tools and a few coins, you set out to begin your new life. Can you learn to live off the land and turn these overgrown fields into a thriving home?', '2016-02-26'),
(15, 'BioShock Infinite', 'Indebted to the wrong people, with his life on the line, veteran of the U.S. Cavalry and now hired gun, Booker DeWitt has only one opportunity to wipe his slate clean. He must rescue Elizabeth, a mysterious girl imprisoned since childhood and locked up in the flying city of Columbia.', '2013-03-26'),
(16, 'NBA 2K25', 'Command every court with authenticity and realism Powered by ProPLAY™, giving you ultimate control over how you play in NBA 2K25. Define your legacy in MyCAREER, MyTEAM, MyNBA, and The W.', '2024-10-28'),
(17, 'Cyberpunk 2077', 'Cyberpunk 2077 is an open-world, action-adventure RPG set in the dark future of Night City — a dangerous megalopolis obsessed with power, glamor, and ceaseless body modification.', '2020-12-10'),
(18, 'The Sims™ 4', 'Play with life and discover the possibilities. Unleash your imagination and create a world of Sims that’s wholly unique. Explore and customize every detail from Sims to homes–and much more.', '2014-09-02'),
(19, 'Raft', 'Raft™ throws you and your friends into an epic oceanic adventure! Alone or together, players battle to survive a perilous voyage across a vast sea! Gather debris, scavenge reefs and build your own floating home, but be wary of the man-eating sharks!', '2022-06-20'),
(20, 'Forza Horizon 5', 'Explore the vibrant open world landscapes of Mexico with limitless, fun driving action in the world’s greatest cars. Join a thrilling game of chase with our new 5v1 Multiplayer Experience: Hide & Seek.', '2021-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `game_key`
--

CREATE TABLE `game_key` (
  `id_key` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `code` varchar(25) NOT NULL,
  `platform` enum('steam','epic','gog','xbox','playstation') NOT NULL,
  `status` enum('available','sold','expired','suspended') NOT NULL,
  `id_seller` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_key`
--

INSERT INTO `game_key` (`id_key`, `id_game`, `price`, `code`, `platform`, `status`, `id_seller`) VALUES
(1, 3, '10.20', 'XXXX-XXXX-XXXX-XXXX-XXXX-', 'steam', 'sold', '0f46c667f2c1d55a088d8d03189567a9'),
(2, 3, '11.00', 'XXXX-XXXX-XXXX-XXXX-XXXT-', 'steam', 'sold', '0f46c667f2c1d55a088d8d03189567a9'),
(3, 3, '9.99', 'ANDYVBDTPSYFNWYFQLFYSBYFK', 'gog', 'sold', '0f46c667f2c1d55a088d8d03189567a9'),
(4, 3, '9.99', 'XXXX-XXXX-XXXX-XXXX-XXhh-', 'gog', 'available', '0f46c667f2c1d55a088d8d03189567a9'),
(5, 3, '9.99', 'XXXX-XXXX-XXXX-fXXX-XXhh-', 'playstation', 'sold', '0f46c667f2c1d55a088d8d03189567a9'),
(6, 2, '12.00', 'iXXX-XXXX-XXXX-XXXX-XXXG-', 'gog', 'sold', '0f46c667f2c1d55a088d8d03189567a9'),
(7, 1, '7.00', '123asdasda1203as2d1a', 'steam', 'available', '0f46c667f2c1d55a088d8d03189567a9'),
(8, 3, '10.00', 'ASDFGHJJJffffJJRTSD', 'gog', 'sold', '35ecae0798c7115d3d8b0787363eff63'),
(9, 3, '10.00', 'ASDFGHJJJJfJRTeSD', 'gog', 'sold', '35ecae0798c7115d3d8b0787363eff63'),
(10, 3, '10.00', 'ASDFGHJJJJJRdTSD', 'gog', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(11, 3, '10.00', 'ASDFGHJJJJJsefdesfRTSD', 'gog', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(12, 3, '10.00', 'ASDFGHJJJJJRsefsefTSDges', 'gog', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(13, 5, '33.00', 'dfwwwwwwwwwwww??', 'playstation', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(14, 1, '49.99', 'qwerty', 'epic', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(15, 1, '49.99', 'qwerty', 'steam', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(16, 1, '49.99', 'qwerty  effe', 'steam', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(17, 3, '13.99', 'QWERTYUIOP', 'steam', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(18, 1, '1.00', 'ASDFGHJKL', 'steam', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(19, 3, '12.00', 'zcxvzxcba', 'epic', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(20, 3, '12.00', 'zcxvzxcbaasas', 'epic', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(21, 5, '15.00', 'jrsytxvnxcty', 'xbox', 'sold', '35ecae0798c7115d3d8b0787363eff63'),
(22, 5, '15.00', 'bxbfrdegbe', 'xbox', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(23, 4, '999.99', 'SUCKITLOSER', 'steam', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(24, 4, '999.99', 'YOUJUSTGOTSCAMMED', 'steam', 'available', '35ecae0798c7115d3d8b0787363eff63'),
(25, 4, '999.99', 'xd', 'steam', 'available', '35ecae0798c7115d3d8b0787363eff63');

-- --------------------------------------------------------

--
-- Table structure for table `game_order`
--

CREATE TABLE `game_order` (
  `id_order` int(11) NOT NULL,
  `id_user` varchar(32) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_order`
--

INSERT INTO `game_order` (`id_order`, `id_user`, `order_date`, `price`) VALUES
(11, '1704b06ce32174344368ec6901b45b46', '2025-01-02 20:36:41', '11.00'),
(12, '1704b06ce32174344368ec6901b45b46', '2025-01-02 20:37:13', '9.99'),
(13, '1704b06ce32174344368ec6901b45b46', '2025-01-02 20:50:51', '22.20'),
(14, '35ecae0798c7115d3d8b0787363eff63', '2025-01-03 17:16:40', '9.99'),
(15, 'dcb3f443ea60f71f8451d7029a4a1fb7', '2025-01-04 16:52:58', '10.00'),
(16, '0f46c667f2c1d55a088d8d03189567a9', '2025-01-06 09:59:55', '10.00'),
(17, '0f46c667f2c1d55a088d8d03189567a9', '2025-01-06 10:37:13', '15.00');

-- --------------------------------------------------------

--
-- Table structure for table `keys_in_order`
--

CREATE TABLE `keys_in_order` (
  `id_key` int(11) NOT NULL,
  `id_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keys_in_order`
--

INSERT INTO `keys_in_order` (`id_key`, `id_order`) VALUES
(2, 11),
(5, 12),
(1, 13),
(6, 13),
(3, 14),
(8, 15),
(9, 16),
(21, 17);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id_user` varchar(32) NOT NULL,
  `shop_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id_user`, `shop_title`) VALUES
('0f46c667f2c1d55a088d8d03189567a9', 'Ern\'s shop'),
('35ecae0798c7115d3d8b0787363eff63', 'seller\'s shop'),
('dcb3f443ea60f71f8451d7029a4a1fb7', 'The admin shop thing');

-- --------------------------------------------------------

--
-- Table structure for table `shop_ratings`
--

CREATE TABLE `shop_ratings` (
  `id_user` varchar(32) NOT NULL,
  `id_seller` varchar(32) NOT NULL,
  `rating` tinyint(1) UNSIGNED NOT NULL,
  `review_text` text DEFAULT NULL,
  `review_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop_ratings`
--

INSERT INTO `shop_ratings` (`id_user`, `id_seller`, `rating`, `review_text`, `review_date`) VALUES
('1704b06ce32174344368ec6901b45b46', '0f46c667f2c1d55a088d8d03189567a9', 4, 'It\'s ok, I guess?', '2025-01-03'),
('35ecae0798c7115d3d8b0787363eff63', '0f46c667f2c1d55a088d8d03189567a9', 1, 'This guy blows!', '2025-01-03');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` tinyint(1) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `last_login_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `role`, `balance`, `last_login_date`, `creation_date`) VALUES
('0f46c667f2c1d55a088d8d03189567a9', 'ernkup', '920afbe11077219d1d2da958edc20a16', 'ernkup@ktu.lt', 1, '684.12', '2025-01-06 10:36:58', '2024-12-29 07:05:22'),
('1704b06ce32174344368ec6901b45b46', 'zzzz', 'd34ad7af363159ed4bbe18c0e43c681f', 'zzzz@ktu.lt', 3, '801.29', '2024-12-29 09:32:19', '2024-12-29 09:32:19'),
('35ecae0798c7115d3d8b0787363eff63', 'seller', 'eae47aaa7417da62434795a011ccb0ec', 'seller@mail.com', 3, '1025.01', '2025-01-03 15:47:31', '2025-01-03 15:47:31'),
('bcd9076590de40db1dad43c2140d1d3d', 'user', '96da763b7a969b1028ee3007569eaf3a', 'user@mail.com', 2, '500.00', '2025-01-04 16:23:43', '2025-01-04 16:23:43'),
('dcb3f443ea60f71f8451d7029a4a1fb7', 'admin', '6e5b5410415bde908bd4dee15dfb167a', 'admin@mail.com', 1, '4990.00', '2025-01-06 14:11:23', '2025-01-03 19:49:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id_user`,`id_key`),
  ADD KEY `ci_key_key` (`id_key`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id_game`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `game_key`
--
ALTER TABLE `game_key`
  ADD PRIMARY KEY (`id_key`),
  ADD UNIQUE KEY `uq_code_platform` (`code`,`platform`),
  ADD KEY `gk_game_game` (`id_game`),
  ADD KEY `gk_seller_user` (`id_seller`);

--
-- Indexes for table `game_order`
--
ALTER TABLE `game_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `go_user_user` (`id_user`);

--
-- Indexes for table `keys_in_order`
--
ALTER TABLE `keys_in_order`
  ADD PRIMARY KEY (`id_key`),
  ADD KEY `kio_order_order` (`id_order`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `shop_ratings`
--
ALTER TABLE `shop_ratings`
  ADD PRIMARY KEY (`id_user`,`id_seller`),
  ADD KEY `sr_seller_user` (`id_seller`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `uq_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `game_key`
--
ALTER TABLE `game_key`
  MODIFY `id_key` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `game_order`
--
ALTER TABLE `game_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `ci_key_key` FOREIGN KEY (`id_key`) REFERENCES `game_key` (`id_key`),
  ADD CONSTRAINT `ci_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `game_key`
--
ALTER TABLE `game_key`
  ADD CONSTRAINT `gk_game_game` FOREIGN KEY (`id_game`) REFERENCES `game` (`id_game`),
  ADD CONSTRAINT `gk_seller_user` FOREIGN KEY (`id_seller`) REFERENCES `shop` (`id_user`);

--
-- Constraints for table `game_order`
--
ALTER TABLE `game_order`
  ADD CONSTRAINT `go_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `keys_in_order`
--
ALTER TABLE `keys_in_order`
  ADD CONSTRAINT `kio_key_key` FOREIGN KEY (`id_key`) REFERENCES `game_key` (`id_key`),
  ADD CONSTRAINT `kio_order_order` FOREIGN KEY (`id_order`) REFERENCES `game_order` (`id_order`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `shop_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `shop_ratings`
--
ALTER TABLE `shop_ratings`
  ADD CONSTRAINT `sr_seller_user` FOREIGN KEY (`id_seller`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `sr_user_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
