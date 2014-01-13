-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2014 at 03:13 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `raspberrypints`
--
USE `raspberrypints`;

-- --------------------------------------------------------

--
-- Dumping data for table `beers`
--

INSERT INTO `beers` (`beerid`, `name`, `style`, `notes`, `og`, `fg`, `srm`, `ibu`, `kegstart`, `kegremain`, `active`, `tapnumber`) VALUES
(1, 'Darth Vader', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38, 66, '5.00', '5', 1, 1),
(2, 'OktoberFAST', 'Marzen', 'Dark copper body. Thick, chewy, off-white head. Toasty and earthy aromas. Mid-bodied with a semi-bitter, highly-attenuated finish.', '1.051', '1.013', 13, 20, '5.00', '4.5', 1, 2),
(3, 'Strong Scotch', 'Scotch Ale', 'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.', '1.074', '1.019', 18, 27, '5.0', '4', 1, 3),
(4, 'Darth Vader2', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38, 66, '5.0', '3', 1, 4),
(5, 'OktoberFAST2', 'Marzen', 'Dark copper body. Thick, chewy, off-white head. Toasty and earthy aromas. Mid-bodied with a semi-bitter, highly-attenuated finish.', '1.051', '1.013', 13, 20, '5.0', '2.5', 1, 5),
(6, 'Strong Scotch2', 'Scotch Ale', 'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.', '1.074', '1.019', 18, 27, '5.0', '2', 1, 6),
(7, 'Darth Vader3', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38, 66, '5.0', '1.5', 1, 7),
(8, 'OktoberFAST3', 'Marzen', 'Dark copper body. Thick, chewy, off-white head. Toasty and earthy aromas. Mid-bodied with a semi-bitter, highly-attenuated finish.', '1.051', '1.013', 13, 20, '5', '1', 1, 8),
(9, 'Strong Scotch3', 'Scotch Ale', 'Slightly sweet. Hints of malt and toffee. Finishes with roasted nuts and coffee. Complex and roasty.', '1.074', '1.019', 18, 27, '5', '.5', 1, 9),
(10, 'Darth Vader4', 'Cascadian Dark Ale', 'Rich, toasty malt flavor. Generous amounts of pine, citrus and roasted coffee. Herbal aroma with a punch of IPA hops at the finish.', '1.066', '1.016', 38, 66, '5.0', '0', 1, 10);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;