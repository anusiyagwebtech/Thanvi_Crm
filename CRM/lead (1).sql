-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2020 at 06:14 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lead`
--

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `fid` int(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `process` varchar(255) DEFAULT NULL,
  `last` varchar(255) DEFAULT NULL,
  `next` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`fid`, `name`, `process`, `last`, `next`) VALUES
(1, 'sathyagarks', 'Completed', 'ascsacsacll', 'qwdqwd11'),
(2, 'suresh', NULL, 'ascsacsac', 'qwdqwd'),
(3, '', NULL, 'ascsacsac', 'qwdqwd');

-- --------------------------------------------------------

--
-- Table structure for table `lead_form`
--

CREATE TABLE `lead_form` (
  `lid` int(50) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `sentthrough` varchar(255) DEFAULT NULL,
  `sentto` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `proposal` varchar(255) DEFAULT NULL,
  `leadtype` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lead_form`
--

INSERT INTO `lead_form` (`lid`, `type`, `document`, `sentthrough`, `sentto`, `date`, `proposal`, `leadtype`, `domain`) VALUES
(1, 'call', NULL, 'call', '', '', 'asdcsdfcw', '', 'Android'),
(2, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'status', 'type', 'SEO'),
(3, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'status', 'type', 'SEO'),
(4, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'status', 'type', 'SEO'),
(5, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'statu', 'type', 'SEO'),
(6, 'Message', NULL, 'message', 'sent', '18/02/2020', 'status', 'type', 'SEO'),
(7, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'status', 'type', 'SEO'),
(8, 'Message', NULL, 'message', 'sent ', '18/02/2020', 'status', 'type', 'SEO'),
(9, 'Message', NULL, 'message', 'sent ', '18/02/2020', 'statu', 'type', 'SEO'),
(10, 'Message', NULL, 'message', 'se', '18/02/2020', 'statu', 'type', 'SEO'),
(11, 'Message', NULL, 'message', 'se', '18/02/2020', 'statu', 'type', 'SEO'),
(12, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'sta', 'type', 'SEO'),
(13, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'sta', 'type', 'SEO'),
(14, 'Message', NULL, 'message', 'sent to', '18/02/2020', 'sta', 'type', 'SEO'),
(15, 'Message', NULL, 'call', 'sent to', '18/02/2020', 'status', 'type', 'SEO'),
(16, 'Message', NULL, 'message', 'sent', '18/02/2020', 'status', 'type', 'SEO'),
(17, 'call', NULL, 'message', 'sent to', '18/02/2020', 'status', 'type', 'SEO'),
(18, 'Message', '', 'message', 'sent toupdated', '28/02/202updated', 'status updated', 'leadupdated', 'Android');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `val1` varchar(255) DEFAULT NULL,
  `val2` varchar(255) DEFAULT NULL,
  `val3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `val1`, `val2`, `val3`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Table structure for table `usermaster`
--

CREATE TABLE `usermaster` (
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `changepwd` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `permissiongroup` int(30) NOT NULL,
  `status` int(11) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sitelocid` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usermaster`
--

INSERT INTO `usermaster` (`uid`, `username`, `password`, `changepwd`, `userid`, `permissiongroup`, `status`, `ip`, `updated_by`, `date`, `sitelocid`) VALUES
(313, 'tamilselvi', 'tamil.r', 'tamil.r', 'NME00002', 2, 1, '220.158.140.150', 1, '2016-11-28 08:53:22', 0),
(314, '8807870476', '8807870476', '8807870476', 'NMA00008', 3, 1, '220.158.140.150', 1, '2016-12-03 06:32:50', 0),
(315, '9095198980', '9095198980', '9095198980', 'NMA00009', 3, 1, '220.158.140.150', 1, '2016-12-03 07:23:20', 0),
(316, '9655129186', '9655129186', '9655129186', 'NMA00011', 3, 1, '106.201.181.242', 1, '2016-12-05 10:33:13', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `lead_form`
--
ALTER TABLE `lead_form`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usermaster`
--
ALTER TABLE `usermaster`
  ADD KEY `tid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `fid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lead_form`
--
ALTER TABLE `lead_form`
  MODIFY `lid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
