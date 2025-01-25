-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2024 at 01:58 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_master`
--

CREATE TABLE `client_master` (
  `id` int(6) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `state` varchar(40) NOT NULL,
  `city` varchar(40) NOT NULL,
  `pin` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_master`
--

INSERT INTO `client_master` (`id`, `name`, `email`, `phone`, `address`, `state`, `city`, `pin`) VALUES
(1, 'Shweta Rathore', 'shweta@gmail.com', '7836803258', 'Noida', '18', '435', '201303'),
(10, 'sam', 'sam@gmail.com', '8077769939', 'Gurugram', '13', '272', '201301'),
(21, 'Alok', 'alok@gmail.com', '7886785776', 'Noida', '34', '596', '201303'),
(22, 'Rathore', 'rathore@gmail.com', '7896541239', 'Noida', '6', '106', '301201'),
(26, 'rtrytryryryr', 'demo@dedoe.com', '9662147890', 'lklkjlkjl', '12', '409', '435435');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `email`, `phone`) VALUES
(1, 'Shwetajjhhjkhkjhkh', 'Rathore', 'shweta@gmail.com', '8077769939'),
(2, 'rathore', 'rathore', 's@gmail.com', '2334345467'),
(3, 'Pooja', 'rathore', 'test@gmail.com', '8077769939');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item`
--

CREATE TABLE `invoice_item` (
  `id` int(6) UNSIGNED NOT NULL,
  `item_name` varchar(20) NOT NULL,
  `item_price` int(11) NOT NULL DEFAULT 0,
  `qty` int(5) NOT NULL DEFAULT 0,
  `invoice_id` int(5) NOT NULL,
  `item_id` int(6) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_item`
--

INSERT INTO `invoice_item` (`id`, `item_name`, `item_price`, `qty`, `invoice_id`, `item_id`, `total`) VALUES
(357, 'car', 4000, 2, 98, 21, 8000),
(358, 'paint', 300, 1, 98, 6, 300),
(359, 'desk', 78, 3, 98, 28, 234),
(360, 'desk', 78, 1, 109, 28, 78),
(361, 'test', 123, 1, 109, 17, 123),
(362, 'car', 4000, 1, 109, 21, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_master`
--

CREATE TABLE `invoice_master` (
  `invoice_id` int(5) NOT NULL,
  `invoice_no` int(5) NOT NULL,
  `invoice_date` date NOT NULL,
  `client_id` int(6) NOT NULL DEFAULT 0,
  `grand_total` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_master`
--

INSERT INTO `invoice_master` (`invoice_id`, `invoice_no`, `invoice_date`, `client_id`, `grand_total`) VALUES
(98, 100, '2023-11-28', 1, 8534),
(109, 102, '2023-11-01', 22, 4201);

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE `item_master` (
  `id` int(6) NOT NULL,
  `item_name` varchar(20) NOT NULL,
  `item_description` varchar(30) NOT NULL,
  `price` int(20) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`id`, `item_name`, `item_description`, `price`, `path`) VALUES
(6, 'paint', 'draw', 300, 'uploads/sanMRec.png'),
(17, 'test', 'drrf', 123, 'uploads/sansoftlogo.png'),
(21, 'car', 'to drive', 4000, 'uploads/contact-form.png'),
(25, 'phone', 'call', 60, 'uploads/Screenshot from 2023-10-20 10-59-08.png'),
(28, 'desk', 'use for', 788, 'uploads/Screenshot from 2023-10-20 10-59-08.png');

-- --------------------------------------------------------

--
-- Table structure for table `ms_district_master`
--

CREATE TABLE `ms_district_master` (
  `district_id` int(10) NOT NULL,
  `district_name` varchar(100) DEFAULT NULL,
  `state_id` smallint(5) NOT NULL DEFAULT 99,
  `state_name` varchar(100) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ms_district_master`
--

INSERT INTO `ms_district_master` (`district_id`, `district_name`, `state_id`, `state_name`, `status`) VALUES
(1, 'Adilabad', 32, 'TELANGANA', 1),
(2, 'Agra', 34, 'UTTAR PRADESH', 1),
(3, 'Ahmed Nagar', 21, 'MAHARASHTRA', 1),
(4, 'Ahmedabad', 12, 'GUJARAT', 1),
(5, 'Aizawl', 24, 'MIZORAM', 1),
(6, 'Ajmer', 29, 'RAJASTHAN', 1),
(7, 'Akola', 21, 'MAHARASHTRA', 1),
(8, 'Alappuzha', 18, 'KERALA', 1),
(9, 'Aligarh', 34, 'UTTAR PRADESH', 1),
(10, 'Alirajpur', 20, 'MADHYA PRADESH', 1),
(11, 'Allahabad', 34, 'UTTAR PRADESH', 1),
(12, 'Almora', 35, 'UTTARAKHAND', 1),
(13, 'Alwar', 29, 'RAJASTHAN', 1),
(14, 'Ambala', 13, 'HARYANA', 1),
(15, 'Ambedkar Nagar', 34, 'UTTAR PRADESH', 1),
(16, 'Amravati', 21, 'MAHARASHTRA', 1),
(17, 'Amreli', 12, 'GUJARAT', 1),
(18, 'Amritsar', 28, 'PUNJAB', 1),
(19, 'Anand', 12, 'GUJARAT', 1),
(20, 'Ananthapur', 2, 'ANDHRA PRADESH', 1),
(21, 'Ananthnag', 15, 'JAMMU & KASHMIR', 1),
(22, 'Angul', 26, 'ODISHA', 1),
(23, 'Anuppur', 20, 'MADHYA PRADESH', 1),
(24, 'Araria', 5, 'BIHAR', 1),
(25, 'Ariyalur', 31, 'TAMIL NADU', 1),
(26, 'Arwal', 5, 'BIHAR', 1),
(27, 'Ashok Nagar', 20, 'MADHYA PRADESH', 1),
(28, 'Auraiya', 34, 'UTTAR PRADESH', 1),
(29, 'Aurangabad', 21, 'MAHARASHTRA', 1),
(30, 'Aurangabad(BH)', 5, 'BIHAR', 1),
(31, 'Azamgarh', 34, 'UTTAR PRADESH', 1),
(32, 'Bagalkot', 17, 'KARNATAKA', 1),
(33, 'Bageshwar', 35, 'UTTARAKHAND', 1),
(34, 'Bagpat', 34, 'UTTAR PRADESH', 1),
(35, 'Bahraich', 34, 'UTTAR PRADESH', 1),
(36, 'Balaghat', 20, 'MADHYA PRADESH', 1),
(37, 'Balangir', 26, 'ODISHA', 1),
(38, 'Baleswar', 26, 'ODISHA', 1),
(39, 'Ballia', 34, 'UTTAR PRADESH', 1),
(40, 'Balrampur', 34, 'UTTAR PRADESH', 1),
(41, 'Banaskantha', 12, 'GUJARAT', 1),
(42, 'Banda', 34, 'UTTAR PRADESH', 1),
(43, 'Bandipur', 15, 'JAMMU & KASHMIR', 1),
(44, 'Bangalore', 17, 'KARNATAKA', 1),
(45, 'Bangalore Rural', 17, 'KARNATAKA', 1),
(46, 'Banka', 5, 'BIHAR', 1),
(47, 'Bankura', 36, 'WEST BENGAL', 1),
(48, 'Banswara', 29, 'RAJASTHAN', 1),
(49, 'Barabanki', 34, 'UTTAR PRADESH', 1),
(50, 'Baramulla', 15, 'JAMMU & KASHMIR', 1),
(51, 'Baran', 29, 'RAJASTHAN', 1),
(52, 'Bardhaman', 36, 'WEST BENGAL', 1),
(53, 'Bareilly', 34, 'UTTAR PRADESH', 1),
(54, 'Bargarh', 26, 'ODISHA', 1),
(55, 'Barmer', 29, 'RAJASTHAN', 1),
(56, 'Barnala', 28, 'PUNJAB', 1),
(57, 'Barpeta', 4, 'ASSAM', 1),
(58, 'Barwani', 20, 'MADHYA PRADESH', 1),
(59, 'Bastar', 7, 'CHATTISGARH', 1),
(60, 'Basti', 34, 'UTTAR PRADESH', 1),
(61, 'Bathinda', 28, 'PUNJAB', 1),
(62, 'Beed', 21, 'MAHARASHTRA', 1),
(63, 'Begusarai', 5, 'BIHAR', 1),
(64, 'Belgaum', 17, 'KARNATAKA', 1),
(65, 'Bellary', 17, 'KARNATAKA', 1),
(66, 'Betul', 20, 'MADHYA PRADESH', 1),
(67, 'Bhadrak', 26, 'ODISHA', 1),
(68, 'Bhagalpur', 5, 'BIHAR', 1),
(69, 'Bhandara', 21, 'MAHARASHTRA', 1),
(70, 'Bharatpur', 29, 'RAJASTHAN', 1),
(71, 'Bharuch', 12, 'GUJARAT', 1),
(72, 'Bhavnagar', 12, 'GUJARAT', 1),
(73, 'Bhilwara', 29, 'RAJASTHAN', 1),
(74, 'Bhind', 20, 'MADHYA PRADESH', 1),
(75, 'Bhiwani', 13, 'HARYANA', 1),
(76, 'Bhojpur', 5, 'BIHAR', 1),
(77, 'Bhopal', 20, 'MADHYA PRADESH', 1),
(78, 'Bidar', 17, 'KARNATAKA', 1),
(79, 'Bijapur(CGH)', 7, 'CHATTISGARH', 1),
(80, 'Bijapur(KAR)', 17, 'KARNATAKA', 1),
(81, 'Bijnor', 34, 'UTTAR PRADESH', 1),
(82, 'Bikaner', 29, 'RAJASTHAN', 1),
(83, 'Bilaspur (HP)', 14, 'HIMACHAL PRADESH', 1),
(84, 'Bilaspur(CGH)', 7, 'CHATTISGARH', 1),
(85, 'Birbhum', 36, 'WEST BENGAL', 1),
(86, 'Bishnupur', 22, 'MANIPUR', 1),
(87, 'Bokaro', 16, 'JHARKHAND', 1),
(88, 'Bongaigaon', 4, 'ASSAM', 1),
(89, 'Boudh', 26, 'ODISHA', 1),
(90, 'Budaun', 34, 'UTTAR PRADESH', 1),
(91, 'Budgam', 15, 'JAMMU & KASHMIR', 1),
(92, 'Bulandshahr', 34, 'UTTAR PRADESH', 1),
(93, 'Buldhana', 21, 'MAHARASHTRA', 1),
(94, 'Bundi', 29, 'RAJASTHAN', 1),
(95, 'Burhanpur', 20, 'MADHYA PRADESH', 1),
(96, 'Buxar', 5, 'BIHAR', 1),
(97, 'Cachar', 4, 'ASSAM', 1),
(98, 'Central Delhi', 10, 'DELHI', 1),
(99, 'Chamba', 14, 'HIMACHAL PRADESH', 1),
(100, 'Chamoli', 35, 'UTTARAKHAND', 1),
(101, 'Champawat', 35, 'UTTARAKHAND', 1),
(102, 'Champhai', 24, 'MIZORAM', 1),
(103, 'Chamrajnagar', 17, 'KARNATAKA', 1),
(104, 'Chandauli', 34, 'UTTAR PRADESH', 1),
(105, 'Chandel', 22, 'MANIPUR', 1),
(106, 'Chandigarh', 6, 'CHANDIGARH', 1),
(107, 'Chandrapur', 21, 'MAHARASHTRA', 1),
(108, 'Changlang', 3, 'ARUNACHAL PRADESH', 1),
(109, 'Chatra', 16, 'JHARKHAND', 1),
(110, 'Chennai', 31, 'TAMIL NADU', 1),
(111, 'Chhatarpur', 20, 'MADHYA PRADESH', 1),
(112, 'Chhindwara', 20, 'MADHYA PRADESH', 1),
(113, 'Chickmagalur', 17, 'KARNATAKA', 1),
(114, 'Chikkaballapur', 17, 'KARNATAKA', 1),
(115, 'Chitradurga', 17, 'KARNATAKA', 1),
(116, 'Chitrakoot', 34, 'UTTAR PRADESH', 1),
(117, 'Chittoor', 2, 'ANDHRA PRADESH', 1),
(118, 'Chittorgarh', 29, 'RAJASTHAN', 1),
(119, 'Churachandpur', 22, 'MANIPUR', 1),
(120, 'Churu', 29, 'RAJASTHAN', 1),
(121, 'Coimbatore', 31, 'TAMIL NADU', 1),
(122, 'Cooch Behar', 36, 'WEST BENGAL', 1),
(123, 'Cuddalore', 31, 'TAMIL NADU', 1),
(124, 'Cuddapah', 2, 'ANDHRA PRADESH', 1),
(125, 'Cuttack', 26, 'ODISHA', 1),
(126, 'Dadra & Nagar Haveli', 8, 'DADRA & NAGAR HAVELI', 1),
(127, 'Dahod', 12, 'GUJARAT', 1),
(128, 'Dakshina Kannada', 17, 'KARNATAKA', 1),
(129, 'Daman', 9, 'DAMAN & DIU', 1),
(130, 'Damoh', 20, 'MADHYA PRADESH', 1),
(131, 'Dantewada', 7, 'CHATTISGARH', 1),
(132, 'Darbhanga', 5, 'BIHAR', 1),
(133, 'Darjiling', 36, 'WEST BENGAL', 1),
(134, 'Darrang', 4, 'ASSAM', 1),
(135, 'Datia', 20, 'MADHYA PRADESH', 1),
(136, 'Dausa', 29, 'RAJASTHAN', 1),
(137, 'Davangere', 17, 'KARNATAKA', 1),
(138, 'Debagarh', 26, 'ODISHA', 1),
(139, 'Dehradun', 35, 'UTTARAKHAND', 1),
(140, 'Deoghar', 16, 'JHARKHAND', 1),
(141, 'Deoria', 34, 'UTTAR PRADESH', 1),
(142, 'Dewas', 20, 'MADHYA PRADESH', 1),
(143, 'Dhalai', 33, 'TRIPURA', 1),
(144, 'Dhamtari', 7, 'CHATTISGARH', 1),
(145, 'Dhanbad', 16, 'JHARKHAND', 1),
(146, 'Dhar', 20, 'MADHYA PRADESH', 1),
(147, 'Dharmapuri', 31, 'TAMIL NADU', 1),
(148, 'Dharwad', 17, 'KARNATAKA', 1),
(149, 'Dhemaji', 4, 'ASSAM', 1),
(150, 'Dhenkanal', 26, 'ODISHA', 1),
(151, 'Dholpur', 29, 'RAJASTHAN', 1),
(152, 'Dhubri', 4, 'ASSAM', 1),
(153, 'Dhule', 21, 'MAHARASHTRA', 1),
(154, 'Dibang Valley', 3, 'ARUNACHAL PRADESH', 1),
(155, 'Dibrugarh', 4, 'ASSAM', 1),
(156, 'Dimapur', 25, 'NAGALAND', 1),
(157, 'Dindigul', 31, 'TAMIL NADU', 1),
(158, 'Dindori', 20, 'MADHYA PRADESH', 1),
(159, 'Diu', 9, 'DAMAN & DIU', 1),
(160, 'Doda', 15, 'JAMMU & KASHMIR', 1),
(161, 'Dumka', 16, 'JHARKHAND', 1),
(162, 'Dungarpur', 29, 'RAJASTHAN', 1),
(163, 'Durg', 7, 'CHATTISGARH', 1),
(164, 'East Champaran', 5, 'BIHAR', 1),
(165, 'East Delhi', 10, 'DELHI', 1),
(166, 'East Garo Hills', 23, 'MEGHALAYA', 1),
(167, 'East Godavari', 2, 'ANDHRA PRADESH', 1),
(168, 'East Kameng', 3, 'ARUNACHAL PRADESH', 1),
(169, 'East Khasi Hills', 23, 'MEGHALAYA', 1),
(170, 'East Midnapore', 36, 'WEST BENGAL', 1),
(171, 'East Nimar', 20, 'MADHYA PRADESH', 1),
(172, 'East Siang', 3, 'ARUNACHAL PRADESH', 1),
(173, 'East Sikkim', 30, 'SIKKIM', 1),
(174, 'East Singhbhum', 16, 'JHARKHAND', 1),
(175, 'Ernakulam', 18, 'KERALA', 1),
(176, 'Erode', 31, 'TAMIL NADU', 1),
(177, 'Etah', 34, 'UTTAR PRADESH', 1),
(178, 'Etawah', 34, 'UTTAR PRADESH', 1),
(179, 'Faizabad', 34, 'UTTAR PRADESH', 1),
(180, 'Faridabad', 13, 'HARYANA', 1),
(181, 'Faridkot', 28, 'PUNJAB', 1),
(182, 'Farrukhabad', 34, 'UTTAR PRADESH', 1),
(183, 'Fatehabad', 13, 'HARYANA', 1),
(184, 'Fatehgarh Sahib', 28, 'PUNJAB', 1),
(185, 'Fatehpur', 34, 'UTTAR PRADESH', 1),
(186, 'Fazilka', 28, 'PUNJAB', 1),
(187, 'Firozabad', 34, 'UTTAR PRADESH', 1),
(188, 'Firozpur', 28, 'PUNJAB', 1),
(189, 'Gadag', 17, 'KARNATAKA', 1),
(190, 'Gadchiroli', 21, 'MAHARASHTRA', 1),
(191, 'Gajapati', 26, 'ODISHA', 1),
(192, 'Gandhi Nagar', 12, 'GUJARAT', 1),
(193, 'Ganganagar', 29, 'RAJASTHAN', 1),
(194, 'Ganjam', 26, 'ODISHA', 1),
(195, 'Garhwa', 16, 'JHARKHAND', 1),
(196, 'Gariaband', 7, 'CHATTISGARH', 1),
(197, 'Gautam Buddha Nagar', 34, 'UTTAR PRADESH', 1),
(198, 'Gaya', 5, 'BIHAR', 1),
(199, 'Ghaziabad', 34, 'UTTAR PRADESH', 1),
(200, 'Ghazipur', 34, 'UTTAR PRADESH', 1),
(201, 'Giridh', 16, 'JHARKHAND', 1),
(202, 'Goalpara', 4, 'ASSAM', 1),
(203, 'Godda', 16, 'JHARKHAND', 1),
(204, 'Golaghat', 4, 'ASSAM', 1),
(205, 'Gonda', 34, 'UTTAR PRADESH', 1),
(206, 'Gondia', 21, 'MAHARASHTRA', 1),
(207, 'Gopalganj', 5, 'BIHAR', 1),
(208, 'Gorakhpur', 34, 'UTTAR PRADESH', 1),
(209, 'Gulbarga', 17, 'KARNATAKA', 1),
(210, 'Gumla', 16, 'JHARKHAND', 1),
(211, 'Guna', 20, 'MADHYA PRADESH', 1),
(212, 'Guntur', 2, 'ANDHRA PRADESH', 1),
(213, 'Gurdaspur', 28, 'PUNJAB', 1),
(214, 'Gurgaon', 13, 'HARYANA', 1),
(215, 'Gwalior', 20, 'MADHYA PRADESH', 1),
(216, 'Hailakandi', 4, 'ASSAM', 1),
(217, 'Hamirpur', 34, 'UTTAR PRADESH', 1),
(218, 'Hamirpur(HP)', 14, 'HIMACHAL PRADESH', 1),
(219, 'Hanumangarh', 29, 'RAJASTHAN', 1),
(220, 'Harda', 20, 'MADHYA PRADESH', 1),
(221, 'Hardoi', 34, 'UTTAR PRADESH', 1),
(222, 'Haridwar', 35, 'UTTARAKHAND', 1),
(223, 'Hassan', 17, 'KARNATAKA', 1),
(224, 'Hathras', 34, 'UTTAR PRADESH', 1),
(225, 'Haveri', 17, 'KARNATAKA', 1),
(226, 'Hazaribag', 16, 'JHARKHAND', 1),
(227, 'Hingoli', 21, 'MAHARASHTRA', 1),
(228, 'Hisar', 13, 'HARYANA', 1),
(229, 'Hooghly', 36, 'WEST BENGAL', 1),
(230, 'Hoshangabad', 20, 'MADHYA PRADESH', 1),
(231, 'Hoshiarpur', 28, 'PUNJAB', 1),
(232, 'Howrah', 36, 'WEST BENGAL', 1),
(233, 'Hyderabad', 32, 'TELANGANA', 1),
(234, 'Idukki', 18, 'KERALA', 1),
(235, 'Imphal East', 22, 'MANIPUR', 1),
(236, 'Imphal West', 22, 'MANIPUR', 1),
(237, 'Indore', 20, 'MADHYA PRADESH', 1),
(238, 'Jabalpur', 20, 'MADHYA PRADESH', 1),
(239, 'Jagatsinghapur', 26, 'ODISHA', 1),
(240, 'Jaintia Hills', 23, 'MEGHALAYA', 1),
(241, 'Jaipur', 29, 'RAJASTHAN', 1),
(242, 'Jaisalmer', 29, 'RAJASTHAN', 1),
(243, 'Jajapur', 26, 'ODISHA', 1),
(244, 'Jalandhar', 28, 'PUNJAB', 1),
(245, 'Jalaun', 34, 'UTTAR PRADESH', 1),
(246, 'Jalgaon', 21, 'MAHARASHTRA', 1),
(247, 'Jalna', 21, 'MAHARASHTRA', 1),
(248, 'Jalor', 29, 'RAJASTHAN', 1),
(249, 'Jalpaiguri', 36, 'WEST BENGAL', 1),
(250, 'Jammu', 15, 'JAMMU & KASHMIR', 1),
(251, 'Jamnagar', 12, 'GUJARAT', 1),
(252, 'Jamtara', 16, 'JHARKHAND', 1),
(253, 'Jamui', 5, 'BIHAR', 1),
(254, 'Janjgir-champa', 7, 'CHATTISGARH', 1),
(255, 'Jashpur', 7, 'CHATTISGARH', 1),
(256, 'Jaunpur', 34, 'UTTAR PRADESH', 1),
(257, 'Jehanabad', 5, 'BIHAR', 1),
(258, 'Jhabua', 20, 'MADHYA PRADESH', 1),
(259, 'Jhajjar', 13, 'HARYANA', 1),
(260, 'Jhalawar', 29, 'RAJASTHAN', 1),
(261, 'Jhansi', 34, 'UTTAR PRADESH', 1),
(262, 'Jharsuguda', 26, 'ODISHA', 1),
(263, 'Jhujhunu', 29, 'RAJASTHAN', 1),
(264, 'Jind', 13, 'HARYANA', 1),
(265, 'Jodhpur', 29, 'RAJASTHAN', 1),
(266, 'Jorhat', 4, 'ASSAM', 1),
(267, 'Junagadh', 12, 'GUJARAT', 1),
(268, 'Jyotiba Phule Nagar', 34, 'UTTAR PRADESH', 1),
(269, 'K.V.Rangareddy', 32, 'TELANGANA', 1),
(270, 'Kachchh', 12, 'GUJARAT', 1),
(271, 'Kaimur (Bhabua)', 5, 'BIHAR', 1),
(272, 'Kaithal', 13, 'HARYANA', 1),
(273, 'Kalahandi', 26, 'ODISHA', 1),
(274, 'Kamrup', 4, 'ASSAM', 1),
(275, 'Kanchipuram', 31, 'TAMIL NADU', 1),
(276, 'Kandhamal', 26, 'ODISHA', 1),
(277, 'Kangra', 14, 'HIMACHAL PRADESH', 1),
(278, 'Kanker', 7, 'CHATTISGARH', 1),
(279, 'Kannauj', 34, 'UTTAR PRADESH', 1),
(280, 'Kannur', 18, 'KERALA', 1),
(281, 'Kanpur Dehat', 34, 'UTTAR PRADESH', 1),
(282, 'Kanpur Nagar', 34, 'UTTAR PRADESH', 1),
(283, 'Kanyakumari', 31, 'TAMIL NADU', 1),
(284, 'Kapurthala', 28, 'PUNJAB', 1),
(285, 'Karaikal', 27, 'PONDICHERRY', 1),
(286, 'Karauli', 29, 'RAJASTHAN', 1),
(287, 'Karbi Anglong', 4, 'ASSAM', 1),
(288, 'Kargil', 15, 'JAMMU & KASHMIR', 1),
(289, 'Karim Nagar', 32, 'TELANGANA', 1),
(290, 'Karimganj', 4, 'ASSAM', 1),
(291, 'Karnal', 13, 'HARYANA', 1),
(292, 'Karur', 31, 'TAMIL NADU', 1),
(293, 'Kasargod', 18, 'KERALA', 1),
(294, 'Kathua', 15, 'JAMMU & KASHMIR', 1),
(295, 'Katihar', 5, 'BIHAR', 1),
(296, 'Katni', 20, 'MADHYA PRADESH', 1),
(297, 'Kaushambi', 34, 'UTTAR PRADESH', 1),
(298, 'Kawardha', 7, 'CHATTISGARH', 1),
(299, 'Kendrapara', 26, 'ODISHA', 1),
(300, 'Kendujhar', 26, 'ODISHA', 1),
(301, 'Khagaria', 5, 'BIHAR', 1),
(302, 'Khammam', 32, 'TELANGANA', 1),
(303, 'Khandwa', 20, 'MADHYA PRADESH', 1),
(304, 'Khargone', 20, 'MADHYA PRADESH', 1),
(305, 'Kheda', 12, 'GUJARAT', 1),
(306, 'Kheri', 34, 'UTTAR PRADESH', 1),
(307, 'Khorda', 26, 'ODISHA', 1),
(308, 'Khunti', 16, 'JHARKHAND', 1),
(309, 'Kinnaur', 14, 'HIMACHAL PRADESH', 1),
(310, 'Kiphire', 25, 'NAGALAND', 1),
(311, 'Kishanganj', 5, 'BIHAR', 1),
(312, 'Kodagu', 17, 'KARNATAKA', 1),
(313, 'Koderma', 16, 'JHARKHAND', 1),
(314, 'Kohima', 25, 'NAGALAND', 1),
(315, 'Kokrajhar', 4, 'ASSAM', 1),
(316, 'Kolar', 17, 'KARNATAKA', 1),
(317, 'Kolasib', 24, 'MIZORAM', 1),
(318, 'Kolhapur', 21, 'MAHARASHTRA', 1),
(319, 'Kolkata', 36, 'WEST BENGAL', 1),
(320, 'Kollam', 18, 'KERALA', 1),
(321, 'Koppal', 17, 'KARNATAKA', 1),
(322, 'Koraput', 26, 'ODISHA', 1),
(323, 'Korba', 7, 'CHATTISGARH', 1),
(324, 'Koriya', 7, 'CHATTISGARH', 1),
(325, 'Kota', 29, 'RAJASTHAN', 1),
(326, 'Kottayam', 18, 'KERALA', 1),
(327, 'Kozhikode', 18, 'KERALA', 1),
(328, 'Krishna', 2, 'ANDHRA PRADESH', 1),
(329, 'Krishnagiri', 31, 'TAMIL NADU', 1),
(330, 'Kulgam', 15, 'JAMMU & KASHMIR', 1),
(331, 'Kullu', 14, 'HIMACHAL PRADESH', 1),
(332, 'Kupwara', 15, 'JAMMU & KASHMIR', 1),
(333, 'Kurnool', 2, 'ANDHRA PRADESH', 1),
(334, 'Kurukshetra', 13, 'HARYANA', 1),
(335, 'Kurung Kumey', 3, 'ARUNACHAL PRADESH', 1),
(336, 'Kushinagar', 34, 'UTTAR PRADESH', 1),
(337, 'Lahul & Spiti', 14, 'HIMACHAL PRADESH', 1),
(338, 'Lakhimpur', 4, 'ASSAM', 1),
(339, 'Lakhisarai', 5, 'BIHAR', 1),
(340, 'Lakshadweep', 19, 'LAKSHADWEEP', 1),
(341, 'Lalitpur', 34, 'UTTAR PRADESH', 1),
(342, 'Latehar', 16, 'JHARKHAND', 1),
(343, 'Latur', 21, 'MAHARASHTRA', 1),
(344, 'Lawngtlai', 24, 'MIZORAM', 1),
(345, 'Leh', 15, 'JAMMU & KASHMIR', 1),
(346, 'Lohardaga', 16, 'JHARKHAND', 1),
(347, 'Lohit', 3, 'ARUNACHAL PRADESH', 1),
(348, 'Longleng', 25, 'NAGALAND', 1),
(349, 'Lower Dibang Valley', 3, 'ARUNACHAL PRADESH', 1),
(350, 'Lower Subansiri', 3, 'ARUNACHAL PRADESH', 1),
(351, 'Lucknow', 34, 'UTTAR PRADESH', 1),
(352, 'Ludhiana', 28, 'PUNJAB', 1),
(353, 'Lunglei', 24, 'MIZORAM', 1),
(354, 'Madhepura', 5, 'BIHAR', 1),
(355, 'Madhubani', 5, 'BIHAR', 1),
(356, 'Madurai', 31, 'TAMIL NADU', 1),
(357, 'Mahabub Nagar', 32, 'TELANGANA', 1),
(358, 'Maharajganj', 34, 'UTTAR PRADESH', 1),
(359, 'Mahasamund', 7, 'CHATTISGARH', 1),
(360, 'Mahe', 27, 'PONDICHERRY', 1),
(361, 'Mahendragarh', 13, 'HARYANA', 1),
(362, 'Mahesana', 12, 'GUJARAT', 1),
(363, 'Mahoba', 34, 'UTTAR PRADESH', 1),
(364, 'Mainpuri', 34, 'UTTAR PRADESH', 1),
(365, 'Malappuram', 18, 'KERALA', 1),
(366, 'Malda', 36, 'WEST BENGAL', 1),
(367, 'Malkangiri', 26, 'ODISHA', 1),
(368, 'Mammit', 24, 'MIZORAM', 1),
(369, 'Mandi', 14, 'HIMACHAL PRADESH', 1),
(370, 'Mandla', 20, 'MADHYA PRADESH', 1),
(371, 'Mandsaur', 20, 'MADHYA PRADESH', 1),
(372, 'Mandya', 17, 'KARNATAKA', 1),
(373, 'Mansa', 28, 'PUNJAB', 1),
(374, 'Marigaon', 4, 'ASSAM', 1),
(375, 'Mathura', 34, 'UTTAR PRADESH', 1),
(376, 'Mau', 34, 'UTTAR PRADESH', 1),
(377, 'Mayurbhanj', 26, 'ODISHA', 1),
(378, 'Medak', 32, 'TELANGANA', 1),
(379, 'Medinipur', 36, 'WEST BENGAL', 1),
(380, 'Meerut', 34, 'UTTAR PRADESH', 1),
(381, 'Mirzapur', 34, 'UTTAR PRADESH', 1),
(382, 'Moga', 28, 'PUNJAB', 1),
(383, 'Mohali', 28, 'PUNJAB', 1),
(384, 'Mokokchung', 25, 'NAGALAND', 1),
(385, 'Mon', 25, 'NAGALAND', 1),
(386, 'Moradabad', 34, 'UTTAR PRADESH', 1),
(387, 'Morena', 20, 'MADHYA PRADESH', 1),
(388, 'Muktsar', 28, 'PUNJAB', 1),
(389, 'Mumbai', 21, 'MAHARASHTRA', 1),
(390, 'Munger', 5, 'BIHAR', 1),
(391, 'Murshidabad', 36, 'WEST BENGAL', 1),
(392, 'Muzaffarnagar', 34, 'UTTAR PRADESH', 1),
(393, 'Muzaffarpur', 5, 'BIHAR', 1),
(394, 'Mysore', 17, 'KARNATAKA', 1),
(395, 'Nabarangapur', 26, 'ODISHA', 1),
(396, 'Nadia', 36, 'WEST BENGAL', 1),
(397, 'Nagaon', 4, 'ASSAM', 1),
(398, 'Nagapattinam', 31, 'TAMIL NADU', 1),
(399, 'Nagaur', 29, 'RAJASTHAN', 1),
(400, 'Nagpur', 21, 'MAHARASHTRA', 1),
(401, 'Nainital', 35, 'UTTARAKHAND', 1),
(402, 'Nalanda', 5, 'BIHAR', 1),
(403, 'Nalbari', 4, 'ASSAM', 1),
(404, 'Nalgonda', 32, 'TELANGANA', 1),
(405, 'Namakkal', 31, 'TAMIL NADU', 1),
(406, 'Nanded', 21, 'MAHARASHTRA', 1),
(407, 'Nandurbar', 21, 'MAHARASHTRA', 1),
(408, 'Narayanpur', 7, 'CHATTISGARH', 1),
(409, 'Narmada', 12, 'GUJARAT', 1),
(410, 'Narsinghpur', 20, 'MADHYA PRADESH', 1),
(411, 'Nashik', 21, 'MAHARASHTRA', 1),
(412, 'Navsari', 12, 'GUJARAT', 1),
(413, 'Nawada', 5, 'BIHAR', 1),
(414, 'Nawanshahr', 28, 'PUNJAB', 1),
(415, 'Nayagarh', 26, 'ODISHA', 1),
(416, 'Neemuch', 20, 'MADHYA PRADESH', 1),
(417, 'Nellore', 2, 'ANDHRA PRADESH', 1),
(418, 'New Delhi', 10, 'DELHI', 1),
(419, 'Nicobar', 1, 'ANDAMAN & NICOBAR ISLANDS', 1),
(420, 'Nilgiris', 31, 'TAMIL NADU', 1),
(421, 'Nizamabad', 32, 'TELANGANA', 1),
(422, 'North 24 Parganas', 36, 'WEST BENGAL', 1),
(423, 'North And Middle Andaman', 1, 'ANDAMAN & NICOBAR ISLANDS', 1),
(424, 'North Cachar Hills', 4, 'ASSAM', 1),
(425, 'North Delhi', 10, 'DELHI', 1),
(426, 'North Dinajpur', 36, 'WEST BENGAL', 1),
(427, 'North East Delhi', 10, 'DELHI', 1),
(428, 'North Goa', 11, 'GOA', 1),
(429, 'North Sikkim', 30, 'SIKKIM', 1),
(430, 'North Tripura', 33, 'TRIPURA', 1),
(431, 'North West Delhi', 10, 'DELHI', 1),
(432, 'Nuapada', 26, 'ODISHA', 1),
(433, 'Osmanabad', 21, 'MAHARASHTRA', 1),
(434, 'Pakur', 16, 'JHARKHAND', 1),
(435, 'Palakkad', 18, 'KERALA', 1),
(436, 'Palamau', 16, 'JHARKHAND', 1),
(437, 'Pali', 29, 'RAJASTHAN', 1),
(438, 'Panch Mahals', 12, 'GUJARAT', 1),
(439, 'Panchkula', 13, 'HARYANA', 1),
(440, 'Panipat', 13, 'HARYANA', 1),
(441, 'Panna', 20, 'MADHYA PRADESH', 1),
(442, 'Papum Pare', 3, 'ARUNACHAL PRADESH', 1),
(443, 'Parbhani', 21, 'MAHARASHTRA', 1),
(444, 'Patan', 12, 'GUJARAT', 1),
(445, 'Pathanamthitta', 18, 'KERALA', 1),
(446, 'Pathankot', 28, 'PUNJAB', 1),
(447, 'Patiala', 28, 'PUNJAB', 1),
(448, 'Patna', 5, 'BIHAR', 1),
(449, 'Pauri Garhwal', 35, 'UTTARAKHAND', 1),
(450, 'Perambalur', 31, 'TAMIL NADU', 1),
(451, 'Peren', 25, 'NAGALAND', 1),
(452, 'Phek', 25, 'NAGALAND', 1),
(453, 'Pilibhit', 34, 'UTTAR PRADESH', 1),
(454, 'Pithoragarh', 35, 'UTTARAKHAND', 1),
(455, 'Pondicherry', 27, 'PONDICHERRY', 1),
(456, 'Poonch', 15, 'JAMMU & KASHMIR', 1),
(457, 'Porbandar', 12, 'GUJARAT', 1),
(458, 'Prakasam', 2, 'ANDHRA PRADESH', 1),
(459, 'Pratapgarh', 34, 'UTTAR PRADESH', 1),
(460, 'Pudukkottai', 31, 'TAMIL NADU', 1),
(461, 'Pulwama', 15, 'JAMMU & KASHMIR', 1),
(462, 'Pune', 21, 'MAHARASHTRA', 1),
(463, 'Puri', 26, 'ODISHA', 1),
(464, 'Purnia', 5, 'BIHAR', 1),
(465, 'Puruliya', 36, 'WEST BENGAL', 1),
(466, 'Raebareli', 34, 'UTTAR PRADESH', 1),
(467, 'Raichur', 17, 'KARNATAKA', 1),
(468, 'Raigarh', 7, 'CHATTISGARH', 1),
(469, 'Raigarh(MH)', 21, 'MAHARASHTRA', 1),
(470, 'Raipur', 7, 'CHATTISGARH', 1),
(471, 'Raisen', 20, 'MADHYA PRADESH', 1),
(472, 'Rajauri', 15, 'JAMMU & KASHMIR', 1),
(473, 'Rajgarh', 20, 'MADHYA PRADESH', 1),
(474, 'Rajkot', 12, 'GUJARAT', 1),
(475, 'Rajnandgaon', 7, 'CHATTISGARH', 1),
(476, 'Rajsamand', 29, 'RAJASTHAN', 1),
(477, 'Ramanagar', 17, 'KARNATAKA', 1),
(478, 'Ramanathapuram', 31, 'TAMIL NADU', 1),
(479, 'Ramgarh', 16, 'JHARKHAND', 1),
(480, 'Rampur', 34, 'UTTAR PRADESH', 1),
(481, 'Ranchi', 16, 'JHARKHAND', 1),
(482, 'Ratlam', 20, 'MADHYA PRADESH', 1),
(483, 'Ratnagiri', 21, 'MAHARASHTRA', 1),
(484, 'Rayagada', 26, 'ODISHA', 1),
(485, 'Reasi', 15, 'JAMMU & KASHMIR', 1),
(486, 'Rewa', 20, 'MADHYA PRADESH', 1),
(487, 'Rewari', 13, 'HARYANA', 1),
(488, 'Ri Bhoi', 23, 'MEGHALAYA', 1),
(489, 'Rohtak', 13, 'HARYANA', 1),
(490, 'Rohtas', 5, 'BIHAR', 1),
(491, 'Ropar', 28, 'PUNJAB', 1),
(492, 'Rudraprayag', 35, 'UTTARAKHAND', 1),
(493, 'Rupnagar', 28, 'PUNJAB', 1),
(494, 'Sabarkantha', 12, 'GUJARAT', 1),
(495, 'Sagar', 20, 'MADHYA PRADESH', 1),
(496, 'Saharanpur', 34, 'UTTAR PRADESH', 1),
(497, 'Saharsa', 5, 'BIHAR', 1),
(498, 'Sahibganj', 16, 'JHARKHAND', 1),
(499, 'Saiha', 24, 'MIZORAM', 1),
(500, 'Salem', 31, 'TAMIL NADU', 1),
(501, 'Samastipur', 5, 'BIHAR', 1),
(502, 'Sambalpur', 26, 'ODISHA', 1),
(503, 'Sangli', 21, 'MAHARASHTRA', 1),
(504, 'Sangrur', 28, 'PUNJAB', 1),
(505, 'Sant Kabir Nagar', 34, 'UTTAR PRADESH', 1),
(506, 'Sant Ravidas Nagar', 34, 'UTTAR PRADESH', 1),
(507, 'Saran', 5, 'BIHAR', 1),
(508, 'Satara', 21, 'MAHARASHTRA', 1),
(509, 'Satna', 20, 'MADHYA PRADESH', 1),
(510, 'Sawai Madhopur', 29, 'RAJASTHAN', 1),
(511, 'Sehore', 20, 'MADHYA PRADESH', 1),
(512, 'Senapati', 22, 'MANIPUR', 1),
(513, 'Seoni', 20, 'MADHYA PRADESH', 1),
(514, 'Seraikela-kharsawan', 16, 'JHARKHAND', 1),
(515, 'Serchhip', 24, 'MIZORAM', 1),
(516, 'Shahdol', 20, 'MADHYA PRADESH', 1),
(517, 'Shahjahanpur', 34, 'UTTAR PRADESH', 1),
(518, 'Shajapur', 20, 'MADHYA PRADESH', 1),
(519, 'Sheikhpura', 5, 'BIHAR', 1),
(520, 'Sheohar', 5, 'BIHAR', 1),
(521, 'Sheopur', 20, 'MADHYA PRADESH', 1),
(522, 'Shimla', 14, 'HIMACHAL PRADESH', 1),
(523, 'Shimoga', 17, 'KARNATAKA', 1),
(524, 'Shivpuri', 20, 'MADHYA PRADESH', 1),
(525, 'Shopian', 15, 'JAMMU & KASHMIR', 1),
(526, 'Shrawasti', 34, 'UTTAR PRADESH', 1),
(527, 'Sibsagar', 4, 'ASSAM', 1),
(528, 'Siddharthnagar', 34, 'UTTAR PRADESH', 1),
(529, 'Sidhi', 20, 'MADHYA PRADESH', 1),
(530, 'Sikar', 29, 'RAJASTHAN', 1),
(531, 'Simdega', 16, 'JHARKHAND', 1),
(532, 'Sindhudurg', 21, 'MAHARASHTRA', 1),
(533, 'Singrauli', 20, 'MADHYA PRADESH', 1),
(534, 'Sirmaur', 14, 'HIMACHAL PRADESH', 1),
(535, 'Sirohi', 29, 'RAJASTHAN', 1),
(536, 'Sirsa', 13, 'HARYANA', 1),
(537, 'Sitamarhi', 5, 'BIHAR', 1),
(538, 'Sitapur', 34, 'UTTAR PRADESH', 1),
(539, 'Sivaganga', 31, 'TAMIL NADU', 1),
(540, 'Siwan', 5, 'BIHAR', 1),
(541, 'Solan', 14, 'HIMACHAL PRADESH', 1),
(542, 'Solapur', 21, 'MAHARASHTRA', 1),
(543, 'Sonapur', 26, 'ODISHA', 1),
(544, 'Sonbhadra', 34, 'UTTAR PRADESH', 1),
(545, 'Sonipat', 13, 'HARYANA', 1),
(546, 'Sonitpur', 4, 'ASSAM', 1),
(547, 'South 24 Parganas', 36, 'WEST BENGAL', 1),
(548, 'South Andaman', 1, 'ANDAMAN & NICOBAR ISLANDS', 1),
(549, 'South Delhi', 10, 'DELHI', 1),
(550, 'South Dinajpur', 36, 'WEST BENGAL', 1),
(551, 'South Garo Hills', 23, 'MEGHALAYA', 1),
(552, 'South Goa', 11, 'GOA', 1),
(553, 'South Sikkim', 30, 'SIKKIM', 1),
(554, 'South Tripura', 33, 'TRIPURA', 1),
(555, 'South West Delhi', 10, 'DELHI', 1),
(556, 'Srikakulam', 2, 'ANDHRA PRADESH', 1),
(557, 'Srinagar', 15, 'JAMMU & KASHMIR', 1),
(558, 'Sultanpur', 34, 'UTTAR PRADESH', 1),
(559, 'Sundergarh', 26, 'ODISHA', 1),
(560, 'Supaul', 5, 'BIHAR', 1),
(561, 'Surat', 12, 'GUJARAT', 1),
(562, 'Surendra Nagar', 12, 'GUJARAT', 1),
(563, 'Surguja', 7, 'CHATTISGARH', 1),
(564, 'Tamenglong', 22, 'MANIPUR', 1),
(565, 'Tapi', 12, 'GUJARAT', 1),
(566, 'Tarn Taran', 28, 'PUNJAB', 1),
(567, 'Tawang', 3, 'ARUNACHAL PRADESH', 1),
(568, 'Tehri Garhwal', 35, 'UTTARAKHAND', 1),
(569, 'Thane', 21, 'MAHARASHTRA', 1),
(570, 'Thanjavur', 31, 'TAMIL NADU', 1),
(571, 'The Dangs', 12, 'GUJARAT', 1),
(572, 'Theni', 31, 'TAMIL NADU', 1),
(573, 'Thiruvananthapuram', 18, 'KERALA', 1),
(574, 'Thoubal', 22, 'MANIPUR', 1),
(575, 'Thrissur', 18, 'KERALA', 1),
(576, 'Tikamgarh', 20, 'MADHYA PRADESH', 1),
(577, 'Tinsukia', 4, 'ASSAM', 1),
(578, 'Tirap', 3, 'ARUNACHAL PRADESH', 1),
(579, 'Tiruchirappalli', 31, 'TAMIL NADU', 1),
(580, 'Tirunelveli', 31, 'TAMIL NADU', 1),
(581, 'Tiruvallur', 31, 'TAMIL NADU', 1),
(582, 'Tiruvannamalai', 31, 'TAMIL NADU', 1),
(583, 'Tiruvarur', 31, 'TAMIL NADU', 1),
(584, 'Tonk', 29, 'RAJASTHAN', 1),
(585, 'Tuensang', 25, 'NAGALAND', 1),
(586, 'Tumkur', 17, 'KARNATAKA', 1),
(587, 'Tuticorin', 31, 'TAMIL NADU', 1),
(588, 'Udaipur', 29, 'RAJASTHAN', 1),
(589, 'Udham Singh Nagar', 35, 'UTTARAKHAND', 1),
(590, 'Udhampur', 15, 'JAMMU & KASHMIR', 1),
(591, 'Udupi', 17, 'KARNATAKA', 1),
(592, 'Ujjain', 20, 'MADHYA PRADESH', 1),
(593, 'Ukhrul', 22, 'MANIPUR', 1),
(594, 'Umaria', 20, 'MADHYA PRADESH', 1),
(595, 'Una', 14, 'HIMACHAL PRADESH', 1),
(596, 'Unnao', 34, 'UTTAR PRADESH', 1),
(597, 'Upper Siang', 3, 'ARUNACHAL PRADESH', 1),
(598, 'Upper Subansiri', 3, 'ARUNACHAL PRADESH', 1),
(599, 'Uttara Kannada', 17, 'KARNATAKA', 1),
(600, 'Uttarkashi', 35, 'UTTARAKHAND', 1),
(601, 'Vadodara', 12, 'GUJARAT', 1),
(602, 'Vaishali', 5, 'BIHAR', 1),
(603, 'Valsad', 12, 'GUJARAT', 1),
(604, 'Varanasi', 34, 'UTTAR PRADESH', 1),
(605, 'Vellore', 31, 'TAMIL NADU', 1),
(606, 'Vidisha', 20, 'MADHYA PRADESH', 1),
(607, 'Villupuram', 31, 'TAMIL NADU', 1),
(608, 'Virudhunagar', 31, 'TAMIL NADU', 1),
(609, 'Visakhapatnam', 2, 'ANDHRA PRADESH', 1),
(610, 'Vizianagaram', 2, 'ANDHRA PRADESH', 1),
(611, 'Warangal', 32, 'TELANGANA', 1),
(612, 'Wardha', 21, 'MAHARASHTRA', 1),
(613, 'Washim', 21, 'MAHARASHTRA', 1),
(614, 'Wayanad', 18, 'KERALA', 1),
(615, 'West Champaran', 5, 'BIHAR', 1),
(616, 'West Delhi', 10, 'DELHI', 1),
(617, 'West Garo Hills', 23, 'MEGHALAYA', 1),
(618, 'West Godavari', 2, 'ANDHRA PRADESH', 1),
(619, 'West Kameng', 3, 'ARUNACHAL PRADESH', 1),
(620, 'West Khasi Hills', 23, 'MEGHALAYA', 1),
(621, 'West Midnapore', 36, 'WEST BENGAL', 1),
(622, 'West Nimar', 20, 'MADHYA PRADESH', 1),
(623, 'West Siang', 3, 'ARUNACHAL PRADESH', 1),
(624, 'West Sikkim', 30, 'SIKKIM', 1),
(625, 'West Singhbhum', 16, 'JHARKHAND', 1),
(626, 'West Tripura', 33, 'TRIPURA', 1),
(627, 'Wokha', 25, 'NAGALAND', 1),
(628, 'Yadgir', 17, 'KARNATAKA', 1),
(629, 'Yamuna Nagar', 13, 'HARYANA', 1),
(630, 'Yavatmal', 21, 'MAHARASHTRA', 1),
(631, 'Zunhebotto', 25, 'NAGALAND', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ms_state_master`
--

CREATE TABLE `ms_state_master` (
  `state_id` smallint(5) NOT NULL,
  `state_name` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=>Active, 0=>Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ms_state_master`
--

INSERT INTO `ms_state_master` (`state_id`, `state_name`, `status`) VALUES
(1, 'ANDAMAN & NICOBAR ISLANDS', 1),
(2, 'ANDHRA PRADESH', 1),
(3, 'ARUNACHAL PRADESH', 1),
(4, 'ASSAM', 1),
(5, 'BIHAR', 1),
(6, 'CHANDIGARH', 1),
(7, 'CHATTISGARH', 1),
(8, 'DADRA & NAGAR HAVELI', 1),
(9, 'DAMAN & DIU', 1),
(10, 'DELHI', 1),
(11, 'GOA', 1),
(12, 'GUJARAT', 1),
(13, 'HARYANA', 1),
(14, 'HIMACHAL PRADESH', 1),
(15, 'JAMMU & KASHMIR', 1),
(16, 'JHARKHAND', 1),
(17, 'KARNATAKA', 1),
(18, 'KERALA', 1),
(19, 'LAKSHADWEEP', 1),
(20, 'MADHYA PRADESH', 1),
(21, 'MAHARASHTRA', 1),
(22, 'MANIPUR', 1),
(23, 'MEGHALAYA', 1),
(24, 'MIZORAM', 1),
(25, 'NAGALAND', 1),
(26, 'ODISHA', 1),
(27, 'PONDICHERRY', 1),
(28, 'PUNJAB', 1),
(29, 'RAJASTHAN', 1),
(30, 'SIKKIM', 1),
(31, 'TAMIL NADU', 1),
(32, 'TELANGANA', 1),
(33, 'TRIPURA', 1),
(34, 'UTTAR PRADESH', 1),
(35, 'UTTARAKHAND', 1),
(36, 'WEST BENGAL', 1),
(99, 'Others', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `id` int(6) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(8) NOT NULL,
  `name` varchar(25) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `email`, `password`, `name`, `phone`) VALUES
(98, 'rathoreee@gmail.com', 'gtdwfrhh', 'rathore', '7865547372'),
(100, 'rathor@gmail.com', '@Shweta1', 'rathore', '7887998789'),
(103, 'alok@gmail.com', 'Khus@123', 'alok', '8077769939');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_master`
--
ALTER TABLE `client_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK145` (`invoice_id`),
  ADD KEY `FK22` (`item_id`);

--
-- Indexes for table `invoice_master`
--
ALTER TABLE `invoice_master`
  ADD PRIMARY KEY (`invoice_id`) USING BTREE,
  ADD UNIQUE KEY `invoice_no` (`invoice_no`),
  ADD KEY `FK123` (`client_id`);

--
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `itemname` (`item_name`) USING BTREE;

--
-- Indexes for table `ms_district_master`
--
ALTER TABLE `ms_district_master`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `ms_state_master`
--
ALTER TABLE `ms_state_master`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_master`
--
ALTER TABLE `client_master`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_item`
--
ALTER TABLE `invoice_item`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=363;

--
-- AUTO_INCREMENT for table `invoice_master`
--
ALTER TABLE `invoice_master`
  MODIFY `invoice_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `ms_district_master`
--
ALTER TABLE `ms_district_master`
  MODIFY `district_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=848;

--
-- AUTO_INCREMENT for table `ms_state_master`
--
ALTER TABLE `ms_state_master`
  MODIFY `state_id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD CONSTRAINT `FK145` FOREIGN KEY (`invoice_id`) REFERENCES `invoice_master` (`invoice_id`),
  ADD CONSTRAINT `FK22` FOREIGN KEY (`item_id`) REFERENCES `item_master` (`id`);

--
-- Constraints for table `invoice_master`
--
ALTER TABLE `invoice_master`
  ADD CONSTRAINT `FK123` FOREIGN KEY (`client_id`) REFERENCES `client_master` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
