-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2023 at 09:52 AM
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
-- Database: `my_home`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_num` bigint(11) NOT NULL,
  `family_income` float NOT NULL,
  `num_cars` int(11) NOT NULL,
  `misc_expenses` float NOT NULL,
  PRIMARY KEY (`email`) USING BTREE,
  UNIQUE KEY `phone_num` (`phone_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`name`, `email`, `phone_num`, `family_income`, `num_cars`, `misc_expenses`) VALUES
('hello', 'doesisworkfromhere@gmail.com', 2147483647, 555, 5, 5555),
('Ian Finnigan', 'pleasework@gmail.com', 2088814537, 1e26, 16, 10000),
('Test McSample', 'sample@gmail.com', 5556667777, 10000, 1, 100),
('test test', 'testingduplicatephone@gmail.com', 987654321, 123, 54, 12343),
('try not same', 'thisiscompletelynew@gmail.com', 1234567890, 6, 6, 6),
('youcanchangethemnow', 'thisshouldgoincustomertable@gmail.com', 8989898989, 88, 1000, 999);

-- --------------------------------------------------------

--
-- Table structure for table `customservice`
--

CREATE TABLE IF NOT EXISTS `customservice` (
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cemail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cost` float NOT NULL,
  `description` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `terms` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `penalty` varchar(1028) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasservice`
--

CREATE TABLE IF NOT EXISTS `hasservice` (
  `owner_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `service_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `provider_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `custom` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`owner_email`,`service_name`,`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasservice`
--

INSERT INTO `hasservice` (`owner_email`, `service_name`, `provider_email`, `address`, `custom`) VALUES
('pleasework@gmail.com', 'Standard Electricity', 'jamesp@gmail.com', 'Not Specified', 0),
('pleasework@gmail.com', 'Super Insurance', 'vendortest@gmail.com', 'Not Specified', 0);

-- --------------------------------------------------------

--
-- Table structure for table `home`
--

CREATE TABLE IF NOT EXISTS `home` (
  `address` varchar(255) NOT NULL,
  `lot_size` float NOT NULL,
  `cooling_type` varchar(128) NOT NULL,
  `construction_type` varchar(128) NOT NULL,
  `garage_size` float NOT NULL,
  `year_built` int(11) NOT NULL,
  `property_type` varchar(128) NOT NULL,
  `heating_type` varchar(128) NOT NULL,
  `heating_time` time NOT NULL,
  `num_floors` int(11) NOT NULL,
  `floor_space` float NOT NULL,
  `roof` float NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `foundation` varchar(128) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `owner_email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home`
--

INSERT INTO `home` (`address`, `lot_size`, `cooling_type`, `construction_type`, `garage_size`, `year_built`, `property_type`, `heating_type`, `heating_time`, `num_floors`, `floor_space`, `roof`, `bathrooms`, `foundation`, `bedrooms`, `owner_email`) VALUES
('1010 10th street', 0, 'if there\'smore than one of this i fucked up', 'this has been replaced.', 7, 1010, 'home', 'test test', '00:00:05', 45, 123344, 0, 67, 'concrete', 5, 'sample@gmail.com'),
('123 Main Street', 123, 'There should only be one of these now', 'I think i fixed it', 5, 10101, 'Home', 'Fireplace', '00:00:04', 34, 5623550, 0, 1, 'please', 6, 'thirdtimesthecharm@yahoo.com'),
('444 4th Street', 0, 'if there\'smore than one of this i fucked up', 'this has been replaced.', 7, 1010, 'home', 'test test', '00:00:05', 45, 123344, 0, 67, 'concrete', 5, 'pleasework@gmail.com'),
('555 5th street', 0, 'if there\'smore than one of this i fucked up', 'this has been replaced.', 7, 1010, 'home', 'test test', '00:00:05', 45, 123344, 0, 67, 'concrete', 5, 'doesisworkfromhere@gmail.com'),
('616161 89th street', 0, 'if there\'smore than one of this i fucked up', 'this has been replaced.', 7, 1010, 'home', 'test test', '00:00:05', 45, 123344, 0, 67, 'concrete', 5, 'thirdtimesthecharm@yahoo.com'),
('777 7th street', 0, 'if there\'smore than one of this i fucked up', 'this has been replaced.', 7, 1010, 'home', 'test test', '00:00:05', 45, 123344, 0, 67, 'concrete', 5, 'thirdtimesthecharm@yahoo.com'),
('888 9th street', 0, 'if there\'smore than one of this i fucked up', 'this has been replaced.', 7, 1010, 'home', 'test test', '00:00:05', 45, 123344, 0, 67, 'concrete', 5, 'thirdtimesthecharm@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `cemail` varchar(100) NOT NULL,
  `pemail` varchar(100) NOT NULL,
  `sname` varchar(100) NOT NULL,
  `cost` float NOT NULL,
  `terms` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `penalty` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Not Specified',
  `custom` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cemail`,`pemail`,`sname`,`address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`cemail`, `pemail`, `sname`, `cost`, `terms`, `penalty`, `address`, `custom`) VALUES
('pleasework@gmail.com', 'jamesp@gmail.com', 'Standard Electricity', 0, '', '', '', 0),
('pleasework@gmail.com', 'jamesp@gmail.com', 'Standard Electricity', 200, 'sdghfsdgh', 'gfdhdfgh', '615 12th street', 0),
('pleasework@gmail.com', 'jamesp@gmail.com', 'Standard Electricity', 200, 'Lorem ipsum.', 'Electricity will be shut down', 'Not Specified', 0),
('pleasework@gmail.com', 'samplevend@gmail.com', 'Ultra Power', 55550, 'lorem ipsum', 'Termination of service', '444 4th Street', 0),
('pleasework@gmail.com', 'samplevend@gmail.com', 'Ultra Power', 90, 'payment on the 15th of every month, free car air freshener on signup', 'service never gets cut off unless i skip payments for a whole year', '615 12th street', 0),
('pleasework@gmail.com', 'samplevend@gmail.com', 'Ultra Power', 3.40282e38, 'lorem ipsum', 'Termination of service', 'Not Specified', 0);

-- --------------------------------------------------------

--
-- Table structure for table `outsideservice`
--

CREATE TABLE IF NOT EXISTS `outsideservice` (
  `customer_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cost` float NOT NULL,
  `description` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `terms` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `penalty` varchar(1028) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `provider` varchar(128) NOT NULL,
  PRIMARY KEY (`customer_email`,`name`,`address`,`provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outsideservice`
--

INSERT INTO `outsideservice` (`customer_email`, `type`, `name`, `cost`, `description`, `terms`, `penalty`, `address`, `provider`) VALUES
('ghghghghghg@gmail.com', '', '', 0, '', '', '', '', ''),
('ghghghghghg@gmail.com', 'dental insurance', 'dental insurance', 55555, 'lorem ipsum', 'lorem ipsum', 'lorem ipsum', '', ''),
('pleasework@gmail.com', 'Transport', 'Private Jet Flight', 100000, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', ''),
('pleasework@gmail.com', 'Electricity', 'Simple Out Electric', 500, 'Basic electric plan', 'Lorem ipsum', 'Cesation of service', '615 12th street', 'James P. Electricity'),
('pleasework@gmail.com', 'Insurance', 'Super Dental Service', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', ''),
('thirdtimesthecharm@yahoo.com', 'dfgh', 'fdhjgfh', 111, 'dfhgjgf', 'ghjfg', 'fghj', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE IF NOT EXISTS `provider` (
  `email` varchar(255) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`email`, `name`, `type`) VALUES
('jamesp@gmail.com', 'James P. Electricity', 'Electricity'),
('samplevend@gmail.com', 'ElectriCorp', 'Electricity Provider'),
('vendortest@gmail.com', 'Progressive', 'Insurance');

-- --------------------------------------------------------

--
-- Table structure for table `quoterequest`
--

CREATE TABLE IF NOT EXISTS `quoterequest` (
  `pname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `sname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`pname`,`email`,`sname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quoterequest`
--

INSERT INTO `quoterequest` (`pname`, `cname`, `address`, `sname`, `email`) VALUES
('James P. Electricity', 'Ian Finnigan', '615 12th street', 'Standard Electricity', 'pleasework@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `name` varchar(255) NOT NULL,
  `type` varchar(128) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `cost` float NOT NULL,
  `description` varchar(2048) NOT NULL,
  `terms` varchar(2048) NOT NULL,
  `penalty` varchar(1028) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`name`, `type`, `provider`, `cost`, `description`, `terms`, `penalty`) VALUES
('Standard Electricity', 'Electricity', 'jamesp@gmail.com', 200, 'The basic electricity plan designed for common users.', 'Lorem ipsum.', 'Electricity will be shut down'),
('Super Insurance', 'Car Insurance', 'vendortest@gmail.com', 100, 'the best insurance money can buy, lorem ipsum etc etc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('Ultra Power', 'Electricity', 'samplevend@gmail.com', 3.40282e38, 'The most expensive electricity ever', 'lorem ipsum', 'Termination of service');

-- --------------------------------------------------------

--
-- Table structure for table `unverifiedservice`
--

CREATE TABLE IF NOT EXISTS `unverifiedservice` (
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cemail` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cost` float NOT NULL,
  `description` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `terms` varchar(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `penalty` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `provider` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `custom` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unverifiedservice`
--

INSERT INTO `unverifiedservice` (`name`, `cemail`, `address`, `type`, `cost`, `description`, `terms`, `penalty`, `provider`, `custom`) VALUES
('Standard Electricity', 'pleasework@gmail.com', '615 12th street', 'Electricity', 500, 'Definitily custom', 'Standard terms of service', 'service will be cut off', 'James P. Electricity', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` varchar(64) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password_hash`, `user_type`) VALUES
('asftgsdafgdrs@gmail.com', '$2y$10$Crzcxa4QPiZI4dGtp3uBduG8xDdjFHZo3G9Z8Yh937pvmjvLA4pp6', 'Client'),
('asftgsdafgds@gmail.com', '$2y$10$t2CX7jV/pEcxYRapBxj4keLbWZhzX2mmi8QaFDEwbsbwovgm0qMES', 'Client'),
('definitelynotvendor@live.com', '$2y$10$GwFcSISDBfLqSn7YIv5/gerf8XPvgg0L70lF54a6m/VjOWDFPlC6u', 'Vendor'),
('doesisworkfromhere@gmail.com', '$2y$10$mG8uWRR53zg.AUP/c9lkLuWB0lHkXfvt1FpQwBmzoVBxMc1kQz.4e', 'Client'),
('doublecheck@hotmail.com', '$2y$10$A5/TC4vH1hmm34gNZ5eIQOSpudxh3YPx8rdbPw06w5WxVBGMyP5gG', 'Vendor'),
('ghghghghghg@gmail.com', '$2y$10$8eiTIjCF9CfUge8yK706devhsDr7FYwjpAEcIFhEiIzUl/3UCTn9q', 'Client'),
('gibberish@gmail.com', '$2y$10$HMMacb3YTLSqzTR1qnyTeuuwokwGLoE9r/CWBScEDsSRl3WpIQNA.', 'Client'),
('gointocustomertable2@gmail.com', '$2y$10$Wr6yX3vCvC0s7g7VzyOVU.RXZAZcX4w/5ZW4eQoeo5uagZu/XKMrS', 'Client'),
('gointocustomertable@gmail.com', '$2y$10$oeuIfMPNZRQG7GFfpUE3geq3V2THa0ZPiCI/cwinpHzxFPLCLgbqa', 'Client'),
('helloworld@idk.com', '$2y$10$rRRmnKfETh97rVwtxXPKnuNxBH6IeUhvtTuw6Q3NDGlvuh.667t6u', 'Client'),
('ian9921broadcast@gmail.com', '$2y$10$loKp/1awzDPMy6eo5okJGuCIZd/IrhdQj2H2oDI/XHbE98lkiuWfe', 'Vendor'),
('imnotavendor@gmail.com', '$2y$10$XNncLBoFfhqqkCm1eI2v7.K6Z6VkED92zRLncuMx0so8R5qaUpsv2', 'Vendor'),
('jamesp@gmail.com', '$2y$10$HcaBpbD4PKFYp38gNoLMEejqil.MtY/dO6UZvRH9STHn6U5bzHY0O', 'Vendor'),
('pleasework@gmail.com', '$2y$10$JsBMPw2veFfMeJnGH8/Jk.ASF8jLMeUrIAqqF1XiWDN32pmc7wtwy', 'Client'),
('sample@gmail.com', '$2y$10$6Ki3a09xEjoTuJNFecsbQuLcphaEzH5ZHfgFOlQo79pfeg5bAsOXW', 'Client'),
('samplevend@gmail.com', '$2y$10$ZNnqWJFZN4C4Wkcyr561Tu3Wgw3TjdnSvWJ9ElD5mOmYlA7YV4IdO', 'Vendor'),
('testingduplicatephone@gmail.com', '$2y$10$8BSHX2cWV9jdjsbkc84bwujBnA87q3lYitrX2/4bSsl6vxUnd5wJa', 'Client'),
('thirdtimesthecharm@yahoo.com', '$2y$10$ZdaAVrl.geQOw/7m3kmRSulskzxH9C4kxc.IhOgFST0fFUkUmU6Nu', 'Client'),
('thisiscompletelynew@gmail.com', '$2y$10$iddk5SPx5/sKqX9Q1pXpG.MhVcqAECYoUuCvMBn2N2ZcrZkm.DuIO', 'Client'),
('thisshouldgoincustomertable@gmail.com', '$2y$10$lUNiHCYvafk3f.7IHyX3qesUJVolt9twoR61DgnsBkyO7RUXQ0AVC', 'Client'),
('varg9436@vandals.uidaho.edu', '$2y$10$7EuduTD6aKONF211fFLqfukTAGzp.TquK1EII/leBa2liFV4lQmgm', 'Client'),
('vendortest@gmail.com', '$2y$10$PqLU837bA9WU8chdJNZ9JOUQYNWTAHkp2IxQyvGSNlnRX0nFNMXAe', 'Vendor');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
