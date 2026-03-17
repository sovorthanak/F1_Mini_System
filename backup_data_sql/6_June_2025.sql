-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2025 at 04:53 PM
-- Server version: 10.11.13-MariaDB
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fastoneisp_mini_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admin@dev.com|103.139.16.4', 'i:1;', 1746516107),
('admin@dev.com|103.139.16.4:timer', 'i:1746516107;', 1746516107),
('laytongly@gmail.com|103.139.16.4', 'i:3;', 1746495720),
('laytongly@gmail.com|103.139.16.4:timer', 'i:1746495720;', 1746495720),
('laytongly@gmail.com|127.0.0.1', 'i:1;', 1745892965),
('laytongly@gmail.com|127.0.0.1:timer', 'i:1745892965;', 1745892965),
('minisystem@fastone.com|103.139.16.4', 'i:1;', 1749023217),
('minisystem@fastone.com|103.139.16.4:timer', 'i:1749023217;', 1749023217),
('minisystem@fastone.com|116.212.135.141', 'i:1;', 1746157179),
('minisystem@fastone.com|116.212.135.141:timer', 'i:1746157179;', 1746157179),
('minisystem@fastone.com|203.144.76.0', 'i:1;', 1748253326),
('minisystem@fastone.com|203.144.76.0:timer', 'i:1748253326;', 1748253326),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:10:{i:0;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"create role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"view role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"update role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"delete role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:17:\"create permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"view permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"update permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:17:\"delete permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:9:\"edit role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:15:\"edit permission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:4:\"User\";s:1:\"c\";s:3:\"web\";}}}', 1748934864),
('vannakchh1@gmai|103.139.16.4', 'i:1;', 1748233410),
('vannakchh1@gmai|103.139.16.4:timer', 'i:1748233410;', 1748233410);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers_info`
--

CREATE TABLE `customers_info` (
  `customer_id` varchar(100) NOT NULL,
  `customer_name` varchar(120) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `pppoe` varchar(100) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `internet_fee` varchar(255) NOT NULL,
  `ip_fee` varchar(255) NOT NULL,
  `ip_quantity` int(11) NOT NULL,
  `bill_cycle` int(11) NOT NULL,
  `alt_customer_name` varchar(255) NOT NULL,
  `lat_long` varchar(50) DEFAULT NULL,
  `alt_address_line_1` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `tariff_name` varchar(255) NOT NULL,
  `bandwidth` varchar(255) NOT NULL,
  `installation_fee` varchar(255) NOT NULL,
  `first_start_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `last_updated` timestamp NULL DEFAULT NULL,
  `update_attempts` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `number_of_invoices` int(11) NOT NULL DEFAULT 0,
  `province` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers_info`
--

INSERT INTO `customers_info` (`customer_id`, `customer_name`, `phone_number`, `pppoe`, `ip_address`, `address_line_1`, `currency`, `internet_fee`, `ip_fee`, `ip_quantity`, `bill_cycle`, `alt_customer_name`, `lat_long`, `alt_address_line_1`, `agent`, `tariff_name`, `bandwidth`, `installation_fee`, `first_start_date`, `start_date`, `end_date`, `complete_date`, `status`, `last_updated`, `update_attempts`, `created_by`, `created_at`, `updated_by`, `number_of_invoices`, `province`) VALUES
('000000', 'Lun Savun', '017321298', NULL, NULL, 'Borey Phnom Penh Sok San Plan6  St.Lum No.G3 , Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'U.S. Dollar', '216', '0', 0, 12, 'លន់ សាវុន', NULL, 'បុរីភ្នំពេញសុខសាន្ត គំរោងទី៦ ផ្លូវលំ ផ្ទះលេខ G៣ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Mr. Uch Kaing', 'FAST_HOME', '35 Mbps', '0', '2024-08-18', '2025-08-18', '2026-08-18', '2025-05-17', 'Active', '2025-05-07 08:05:50', 0, 'Admin', '2025-05-07 08:05:50', NULL, 1, 'Phnom Penh'),
('000001', 'Doung Kimhak', '077883337', NULL, NULL, '#458 St 24BT, Sangkat Beong Tom Pun, Khan mean chey, Phnom Penh', 'U.S. Dollar', '242', '0', 0, 12, 'ដួង គឹមហាក់', NULL, 'ផ្ទះលេខ ៤៥៨ ផ្លូវ ២៤BT សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'Mr. Gouv Leangchea', 'SSIA', '10 Mbps', '0', '2024-08-11', '2025-08-11', '2026-08-11', '2025-05-10', 'Active', '2025-05-07 08:16:10', 0, 'Admin', '2025-05-07 08:16:10', NULL, 1, 'Phnom Penh'),
('000003', 'San Sopheap', '090999123', NULL, NULL, 'Borey Phnom Penh Sok San St.Lum No.G1, Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'U.S. Dollar', '216', '0', 0, 12, 'សាន សុភាព', NULL, 'បុរីភ្នំពេញសុខសាន្ត ផ្លូវលំ ផ្ទះលេខជី១ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ ភ្នំពេញ', 'Mr. Uch Kaing', 'FAST_HOME', '35 Mbps', '0', '2025-05-20', '2026-05-20', '2027-05-20', '2025-05-19', 'Active', '2025-05-07 09:22:42', 0, 'Admin', '2025-05-07 09:22:42', NULL, 1, 'Phnom Penh'),
('000004', 'Seang Sophalla', '012665201', NULL, NULL, 'Borey Phnom Penh Sok San St.Lum No.B14, Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'U.S. Dollar', '440', '0', 0, 12, 'ស៊ាង សុផល្លា', NULL, 'បុរីភ្នំពេញសុខសាន្ត ផ្លូវលំ ផ្ទះលេខបេ១៤ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ ភ្នំពេញ', 'Mr. Uch Kaing', 'SSIA', '20 Mbps', '0', '2025-05-09', '2026-05-09', '2027-05-09', '2025-05-08', 'Active', '2025-05-07 09:39:52', 0, 'Admin', '2025-05-07 09:39:52', NULL, 1, 'Phnom Penh'),
('000005', 'Kim Nang', '087893939', NULL, NULL, 'Building Luxury 7F-Room709', 'U.S. Dollar', '120', '0', 1, 1, 'គីម​ ណាង', NULL, 'អគារលុចសារី ជាន់ទី៧ បន្ទប់លេខ ៧០៩', 'Mr. Dao KiHeng', 'SME', '30 Mbps', '0', '2025-05-19', '2025-06-19', '2025-07-19', '2025-05-18', 'Active', '2025-05-09 02:36:15', 0, 'Admin', '2025-05-09 02:36:15', NULL, 1, 'Phnom Penh'),
('00001', 'SAMNANG SE', NULL, NULL, '123.123.123', 'Kampot', 'U.S. Dollar', '300', '1', 1, 1, 'SAMNANG SE', NULL, 'កំពត', 'unspecified', 'Home Save', '50 Mbps', '50', '2025-04-29', '2025-06-29', '2025-07-29', NULL, 'Active', '2025-06-03 09:28:35', 18, 'Admin', '2025-04-28 20:48:14', 'Vorthanak', 2, 'Kampot'),
('000141', 'Sath Chanvatana (Line 2)', '0712898888', NULL, NULL, 'Borey New World Chamkadong, St.03 No.107, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'U.S. Dollar', '220', '0', 0, 12, 'សាត ច័ន្ទវឌ្ឍនា', NULL, 'បុរីពិភពថ្មីចំការដូង ផ្លូវលេខ ០៣ ផ្ទះលេខ ១០៧ សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'Mr. Uch Kaing', 'SIA', '15 Mbps', '0', '2025-02-07', '2026-02-07', '2027-02-07', '2025-05-06', 'Active', '2025-05-07 04:38:49', 0, 'Admin', '2025-05-07 04:38:49', NULL, 1, 'Phnom Penh'),
('000163', 'Ven Dara', '098799199', NULL, NULL, 'Borey Hok Chheng, #13, St. H.C, Sangkat Dangkor, Khan Dangkor, Phnom Penh', 'U.S. Dollar', '180', '0', 0, 12, 'វ៉ែន ដារ៉ា', NULL, 'បុរីហុកឆេង ផ្ទះលេខ១៣ ផ្លូវអេចស៊ី សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'Mr. Gouv Leangchea', 'Home Save', '10 Mbps', '0', '2025-05-10', '2026-05-10', '2027-05-10', '2025-05-09', 'Active', '2025-05-07 09:32:41', 0, 'Admin', '2025-05-07 09:32:41', NULL, 1, 'Phnom Penh'),
('000198', 'Heng Samphors', '0969999785', 'pphmca000198', NULL, 'No.14 Borey Phnompenh Sok San plan 6, Sangkat Chaom  Chav, Khan  Porsenchey, Phnom Penh', 'U.S. Dollar', '180', '0', 0, 12, 'ហេង សម្ផស្ស', NULL, 'ផ្ទះលេខ ១៤ បុរីភ្នំពេញសុខសាន្ត គំរោងទី៦ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Mr. Se Samnang', 'Home Save', '10 Mbps', '0', '2024-09-05', '2025-09-05', '2026-09-05', '2025-05-04', 'Active', '2025-05-13 08:33:04', 1, 'Admin', '2025-05-07 08:02:25', 'Admin', 2, 'Phnom Penh'),
('000200', 'Yun Bunchhay', '087777838', NULL, NULL, 'No.1025 St 2004 Sangkat Ou Baek K\'am, Khan Sen sok, Phnom Penh', 'U.S. Dollar', '216', '0', 0, 12, 'យន្ត ប៊ុនឆៃ', NULL, 'ផ្ទះលេខ 1025 ផ្លូវ 2004 សង្កាត់អូរបែកក្អម ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ', 'Mr. Gouv Leangchea', 'FAST_HOME', '35 Mbps', '0', '2024-09-15', '2025-09-15', '2026-09-15', '2025-05-14', 'Active', '2025-05-07 07:55:37', 0, 'Admin', '2025-05-07 07:55:37', NULL, 1, 'Phnom Penh'),
('000211', 'Chea Pohok', '089788168', 'pphmca000211', NULL, 'Borey Phnom Penh Sok San Plan6  St.Lum No.G2 , Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'U.S. Dollar', '216', '0', 0, 12, 'ជា ប៉ូហុក', NULL, 'បុរីភ្នំពេញសុខសាន្ត គំរោងទី៦ ផ្លូវលំ ផ្ទះលេខ G២ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Mr. Uch Kaing', 'FAST_HOME', '35 Mbps', '50', '2024-10-08', '2025-10-08', '2026-10-08', '2025-05-06', 'Active', '2025-05-07 03:47:32', 0, 'Admin', '2025-05-07 03:47:32', NULL, 1, 'Phnom Penh'),
('000218', 'Long Ananpanha', '077879779', 'pphmca000218', NULL, '# E-127, st BL01, Sangkat Dangkor, Khan Dangkor, Phnom Penh', 'U.S. Dollar', '216', '0', 0, 12, 'ឡុង អានន្ថ​បញ្ញា', NULL, 'ផ្ទះលេខ អ៊ី-១២៧ ផ្លូវ បេអិល​ ០១ សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Mr. Gouv Leangchea', 'FAST_HOME', '35 Mbps', '0', '2024-12-01', '2025-12-01', '2026-12-01', '2025-05-31', 'Active', '2025-05-07 07:32:22', 0, 'Admin', '2025-05-07 07:32:22', NULL, 1, 'Phnom Penh'),
('000219', 'Chath Mao', '070706097', 'pphmca000219', NULL, '#111A St.271  Phum1   Sangkat Beoung Salang , Khan Toul Kork, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 12, 'ចាត  ម៉ៅ', NULL, 'ផ្ទះលេខ១១១អេ ផ្លូវ២៧១ ភូមិ១ សង្កាត់បឹងសាឡាង ខណ្ឌទួលគោក រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2024-11-18', '2025-11-18', '2026-11-18', '2025-05-17', 'Active', '2025-05-07 07:41:59', 0, 'Admin', '2025-05-07 07:41:59', NULL, 1, 'Phnom Penh'),
('000221', 'Ly Veth', '070706097', 'pphcmb202247', NULL, 'No 3, St 24BT, Sangkat Boeng Tumpun, Khan meanchey, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 6, 'លី វុិត', NULL, 'ផ្ទះលេខ ៣ ផ្លូវ ២៤BT សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2025-05-14', '2025-11-14', '2026-05-14', '2025-05-13', 'Active', '2025-05-07 09:30:22', 0, 'Admin', '2025-05-07 09:30:22', NULL, 1, 'Phnom Penh'),
('000223', 'Ork Reaksmey', '0966407456', 'pphssa202249', NULL, 'No B1-B4, St Hanoi, Sangkat Phnom Penh Tmey, Khan Sen Sok, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 12, 'អោក  រស្មី', NULL, 'ផ្ទះលេខ B1-B4 ផ្លូវហាណូយ សង្កាត់ភ្នំពេញថ្មី ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ', 'Unspecified', 'Home Save', '10 Mbps', '0', '2024-11-25', '2025-11-25', '2026-11-25', '2025-05-24', 'Active', '2025-05-07 07:37:57', 0, 'Admin', '2025-05-07 07:37:57', NULL, 1, 'Phnom Penh'),
('000234', 'Phea Nano', '093599998', NULL, NULL, 'Street Mong Rithy, Sangkat Kouk Klaing, Khan Sen Sok, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 6, 'ភា ណាណូ', NULL, 'ផ្លូវម៉ុងរិទ្ធី សង្កាត់គោកឃ្លាំង ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2025-01-13', '2025-07-13', '2026-01-13', '2025-05-12', 'Active', '2025-05-07 07:15:29', 0, 'Admin', '2025-05-07 07:15:29', NULL, 1, 'Phnom Penh'),
('000235', 'Koeurn Sreyneat', '0965055402', 'pphcmb000235', NULL, 'No 72, St 49BT, Phum Sansam Kosal, Sangkat Boeng Tumpun, Khan Meanchey, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 12, 'គឿន ស្រីនាត', NULL, 'ផ្ទះលេខ ៧២ ផ្លូវ ៤៩BT ភូមិសន្សំកុសល សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'Sale Admin', 'Home Save', '10 Mbps', '0', '2025-01-24', '2026-01-24', '2027-01-24', '2025-05-23', 'Active', '2025-05-07 04:41:45', 0, 'Admin', '2025-05-07 04:41:45', NULL, 1, 'Phnom Penh'),
('000240', 'Rith Som Ang', NULL, NULL, NULL, 'St 810, Sangkat 4, Or 2, sihanoukville', 'U.S. Dollar', '220', '0', 0, 12, 'រិទ្ធ សំអាង', NULL, 'ផ្លូវ ៨១០ សង្កាត់ ៤​ អូរ២  ក្រុងព្រះសីហនុ', 'Mr. Uch Kaing', 'SSIA', '10 Mbps', '0', '2025-02-15', '2026-02-15', '2027-02-15', '2025-05-14', 'Active', '2025-05-07 04:19:44', 0, 'Admin', '2025-05-07 04:19:44', NULL, 1, 'Phnom Penh'),
('000244', 'Ly Chingchheng', '087440654', 'pphcmb000244', NULL, 'No 27, St 472, Phum 1, Sangkat Toul tompong 2, Khan Chamkarmon, Phnom Penh.', 'U.S. Dollar', '90', '0', 0, 12, 'លី​ ជីញឆេង', NULL, 'ផ្ទះលេខ ២៧ ផ្លូវ ៤៧២ ភូមិ១ សង្កាត់ទួលទំពូង២ ខណ្ឌចំការមន រាជធានីភ្នំពេញ', 'unspecified', 'Home Save', '10 Mbps', '0', '2025-03-01', '2026-03-01', '2027-03-01', '2025-04-30', 'Active', '2025-05-07 09:01:51', 0, 'Admin', '2025-05-07 09:01:51', NULL, 1, 'Phnom Penh'),
('000263', 'Sok Vandy', '070706097', 'pphmca000263', NULL, '.# 508, Street 5, PCD, Thmey Village, Sangkat Dangkor, Khan Dangkor, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 6, 'សុខ វណ្ឌី', NULL, 'ផ្ទះលេខ៥០៨ ផ្លូវ ៥ប៉េស៊ីឌី ភូមិថ្មី សង្កាត់ដង្កោ ខណ្ឌដង្កោ​ ភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2025-05-09', '2025-11-09', '2026-05-09', '2025-05-08', 'Active', '2025-05-07 09:37:04', 0, 'Admin', '2025-05-07 09:37:04', NULL, 1, 'Phnom Penh'),
('000284', 'Tham Vantoto (sola)', '087707706', NULL, NULL, '#Depo Tela, St Sola, Sangkat Stueng Mean Chey, Phnom Penh', 'U.S. Dollar', '180', '0', 0, 12, 'ថាម វ៉ាន់តូតូ (សូឡា)', NULL, '#ដេប៉ូតេលា ផ្លូវសូឡា សង្កាត់ស្ទឹងមានជ័យ រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2025-05-27', '2026-05-27', '2027-05-27', '2025-05-26', 'Active', '2025-05-07 09:13:39', 0, 'Admin', '2025-05-07 09:13:39', NULL, 1, 'Phnom Penh'),
('000285', 'Kong Visal', '012257257', 'pphssa000285', NULL, '#126, st lum, phum tuek thla, sangkat tuek thla, khan sen sok, Phnom Penh', 'U.S. Dollar', '180', '0', 0, 12, 'គង់ វិសាល', NULL, '#១២៦, ផ្លូវលំ, ភូមិទឹកថ្លា, សង្កាត់ទឹកថ្លា, ខណ្ឌសែនសុខ, រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2025-05-27', '2026-05-27', '2027-05-27', '2025-05-26', 'Active', '2025-05-07 09:11:14', 0, 'Admin', '2025-05-07 09:11:14', NULL, 1, 'Phnom Penh'),
('000286', 'Kong Visal Nary', '015909459', 'pphssa000286', NULL, '#126, st lum, phum tuek thla, sangkat tuek thla, khan sen sok, Phnom Penh', 'U.S. Dollar', '180', '0', 0, 12, 'គង់ វិសាល​ ណារី', NULL, '#១២៦, ផ្លូវលំ, ភូមិទឹកថ្លា, សង្កាត់ទឹកថ្លា, ខណ្ឌសែនសុខ, រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2025-05-01', '2026-05-01', '2027-05-01', '2025-05-31', 'Active', '2025-05-07 08:55:47', 0, 'Admin', '2025-05-07 08:55:47', NULL, 1, 'Phnom Penh'),
('000305', 'Math Monita-GoldenSea BD', '095797973', NULL, NULL, 'Eakareach Street, Sangkat 3, Sihanoukville', 'U.S. Dollar', '300', '10.00', 8, 1, 'ម៉ាត់ ម៉ូនីតា', NULL, 'ផ្លូវឯករាជ្យ សង្កាត់៣ ក្រុងព្រះសីហនុ', 'Mr. Gouv Leangchea', 'DIA', '15 Mbps', '0', '2025-05-17', '2025-06-17', '2025-07-17', NULL, 'Active', '2025-05-13 07:09:20', 2, 'Admin', '2025-05-07 09:27:18', 'Admin', 1, 'Phnom Penh'),
('000310', 'Roeun Vothna', '0963890870', 'pphssa202378', NULL, '#19, St 1019 (Hanoi), S.k PhnomPenh Thmey, Khan Sensok.', 'U.S. Dollar', '180', '0', 0, 12, 'រឿន វឌ្ឍនា', NULL, 'ផ្ទះលេខ 19 ផ្លូវ 1019 (ហាណូយ) សង្កាត់ភ្នំពេញថ្មី ខណ្ឌសែនសុខ។', 'Unspecified', 'Home Save', '10 Mbps', '0', '2025-05-20', '2026-05-20', '2027-05-20', '2025-05-19', 'Active', '2025-05-07 08:10:31', 0, 'Admin', '2025-05-07 08:10:31', NULL, 1, 'Phnom Penh'),
('000314', 'Eung Porou', '012648686', NULL, NULL, 'St 132Z, Songkat Tuek Laork I, Khan Tuol Kouk, Phnom Penh.', 'U.S. Dollar', '90', '0', 0, 6, 'អ៊ឹង ប៉អ៊ូ', NULL, 'ផ្លូវ 132Z សង្កាត់ ទឹកល្អក់ទី១ ខណ្ឌទួលគោក រាជធានីភ្នំពេញ', 'Mr. Gouv Leangchea', 'Home Save', '10 Mbps', '0', '2025-05-06', '2025-11-06', '2026-05-06', '2025-05-05', 'Active', '2025-05-07 04:00:09', 0, 'Admin', '2025-05-07 04:00:09', NULL, 1, 'Phnom Penh'),
('000315', 'Chat Ry', '070200330', 'pphmca000315', NULL, '#50 St Phum Thmei, Sangkat Dangkao, Khan Dangkor, Phnom Penh.', 'U.S. Dollar', '90', '0', 0, 6, 'ចាត​ រី', NULL, 'ផ្ទះលេខ ៥០ ភូមិថ្មី សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'Home Save', '10 Mbps', '0', '2025-05-11', '2025-11-11', '2026-05-11', '2025-05-10', 'Active', '2025-05-07 03:56:11', 0, 'Admin', '2025-05-07 03:56:11', NULL, 1, 'Phnom Penh'),
('000318', 'Yao Youxi', '070804080', 'fo202300090', NULL, 'Phum 1, Sangkat 1, Sihanoukville', 'U.S. Dollar', '720', '0', 0, 6, 'យ៉ាវ​ យ៉ូវស៊ី', NULL, 'ភូមិ១ សង្កាត់១ ក្រុងព្រះសីហនុ', 'Mr. Dao KiHeng', 'SME', '30 Mbps', '0', '2025-04-24', '2025-10-24', '2026-04-24', '2025-04-23', 'Active', '2025-05-07 03:41:33', 0, 'Admin', '2025-05-07 03:41:33', NULL, 1, 'Phnom Penh'),
('000323', 'Chuon Phanny', '016658898', 'pphmca000323', NULL, '#6A, St Toul Pongro, Sangkat Chom Chao khan Porsenchey, Phnom Penh.', 'U.S. Dollar', '216', '0', 0, 12, 'ជួន ផានី', NULL, 'ផ្ទះលេខ 6A ស្តុបទួលពង្រ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ។', 'Unspecified', 'FAST_HOME', '35 Mbps', '0', '2024-11-21', '2025-11-21', '2026-11-21', '2025-05-20', 'Active', '2025-05-07 07:40:00', 0, 'Admin', '2025-05-07 07:40:00', NULL, 1, 'Phnom Penh'),
('000324', 'Nget Tityaridh', '010345076', 'pphmca000324', NULL, '#14, st 4A, Borey Piphup Thmey Chamka Doung I, Phoum Sambour, Sangkat Dang Kor, Khan Dangkor, Phnom Penh', 'U.S. Dollar', '54', '0', 0, 6, 'ង៉ែត ទិត្យារិទ្ធ', NULL, 'ផ្ទះលេខ ១៤ ផ្លូវ ៤A បុរីពិភពថ្មីចំការដូង ភូមិសំបួរ សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Sale Admin', 'FAST_HOME', '35 Mbps', '0', '2024-12-06', '2025-12-06', '2026-06-06', '2025-05-05', 'Active', '2025-05-07 07:29:49', 0, 'Admin', '2025-05-07 07:29:49', NULL, 2, 'Phnom Penh'),
('000328', 'Peang Khuong', '016629252', 'pphtkb202396', NULL, '#190BE1, Street 182, Sangkat Phsar Depo 1, Khan Toul Kork, Phnom Penh.', 'U.S. Dollar', '216', '0', 0, 12, 'ពាង ឃួង', NULL, 'ផ្ទះលេខ ១៩០ប៉េអឺ១ ផ្លូវ ១៨២​ សង្កាត់ផ្សារដេប៉ូ១ ខណ្ឌទួលគោក រាជធានីភ្នំពេញ', 'Mr. Uch Kaing', 'FAST_HOME', '35 Mbps', '0', '2024-12-17', '2025-12-17', '2026-12-17', '2025-05-16', 'Active', '2025-05-07 07:24:08', 0, 'Admin', '2025-05-07 07:24:08', NULL, 1, 'Phnom Penh'),
('000330', 'Kang Yawcameron', '0718762178', 'pphmca202398', NULL, 'Street lou 5, Sangkat Stueng Mean Chey, Phnom Penh.', 'U.S. Dollar', '54', '0', 0, 6, 'កង យ៉ាវកាម៉េរ៉ូន', NULL, 'ផ្លូវលូ៥ សង្កាត់ស្ទឹងមានជ័យ រាជធានីភ្នំពេញ', 'Sale Admin', 'FAST_HOME', '35 Mbps', '0', '2024-12-22', '2025-06-22', '2025-12-22', '2025-05-21', 'Active', '2025-05-07 07:21:03', 0, 'Admin', '2025-05-07 07:21:03', NULL, 1, 'Phnom Penh'),
('000331', 'Kong Rithy', '093222060', 'pphmca000331', NULL, 'House 12C, Street Betong, Commune Stueng Mean chey 1, District Mean Chey, Phnom Penh.', 'U.S. Dollar', '200', '0', 0, 6, 'គង់ រិទ្ធី', NULL, 'ផ្ទះលេខ ១២ស៊ី ផ្លូវបេតុង សង្កាត់ស្ទឹងមានជ័យ១ ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ។', 'Mr. Tep Theara', 'FAST_HOME', '50 Mbps', '0', '2025-01-09', '2025-07-09', '2026-01-09', '2025-05-08', 'Active', '2025-05-07 07:18:24', 0, 'Admin', '2025-05-07 07:18:24', NULL, 1, 'Phnom Penh'),
('000335', 'Ev VouchLak', '069609666', 'pphmca000335', NULL, '# A13, St betong, Prey Sor Village, Sangkat Prey Sor, Khan Dangkor, Phnom Penh.', 'U.S. Dollar', '151.2', '0', 0, 12, 'អ៊ីវ វួចឡាក់', NULL, 'ផ្ទះលេខ អេ១៣ ផ្លូវបេតុង ភូមិព្រៃស សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ។', 'Mr. Gouv Leangchea', 'FAST_HOME', '35 Mbps', '0', '2025-01-19', '2026-01-19', '2027-01-19', '2025-05-18', 'Active', '2025-05-07 07:10:10', 0, 'Admin', '2025-05-07 07:10:10', NULL, 1, 'Phnom Penh'),
('000336', 'Nay Chansaneath', '069747610', 'pphcmb000336', NULL, '# 125, Street 32BT, Sangkat Boeung Tumpun, Khan Meanchey, Phnom Penh.', 'U.S. Dollar', '108', '0', 0, 6, 'ណៃ ច័ន្ទសានាថ', NULL, 'ផ្ទះលេខ ១២៥ ផ្លូវ ៣២BT សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ, រាជធានីភ្នំពេញ', 'Mr. Gouv Leangchea', 'FAST_HOME', '35 Mbps', '0', '2025-05-01', '2025-11-01', '2026-05-01', '2025-04-30', 'Active', '2025-05-07 04:14:15', 0, 'Admin', '2025-05-07 04:14:15', NULL, 1, 'Phnom Penh'),
('000350', 'Chheang Bunpiv', '012568889', 'pph7ma000350', NULL, '# 21, Street 232, Village 2, Sangkat Boeng Prolit, Khan 7 Makara, Phnom Penh', 'U.S. Dollar', '216', '0', 0, 12, 'ឈៀង ប៊ុនពីវ', '11.5579198, 104.9186501', 'ផ្ទះលេខ២១ ផ្លូវ២៣២ ភូមិ២ សង្កាត់បឹងព្រលិត ខណ្ឌ៧មករា រាជធានីភ្នំពេញ', 'Mr. Uch Kaing', 'FAST_HOME', '35 Mbps', '0', '2025-05-06', '2026-05-06', '2027-05-06', '2025-05-05', 'Active', '2025-05-06 07:50:50', 0, 'Admin', '2025-05-06 07:50:50', NULL, 1, 'Phnom Penh'),
('000358', 'Chem Leanghor', NULL, 'pphmca000358', NULL, 'St, lom , Sangkat Chom Chao khan Porsenchey, Phnom Penh.', 'U.S. Dollar', '216', '0', 0, 12, 'ចែម លាងហ័រ', NULL, 'ផ្លូវលំ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Mr. Uch Kaing', 'FAST_HOME', '35 Mbps', '0', '2025-05-20', '2026-05-20', '2027-05-20', '2025-05-19', 'Active', '2025-05-07 09:19:19', 0, 'Admin', '2025-05-07 09:19:19', NULL, 1, 'Phnom Penh'),
('000359', 'Dara Phanit', '098263352', 'pphmca000359', NULL, 'House No number , St BT , Boeung Tamat , SangKat Dangkor , Phnom Penh .', 'U.S. Dollar', '151.2', '0', 0, 12, 'តារា ផានិត', NULL, 'ផ្លូវបេតុង បឹងតាម៉ាត សង្កាត់ដង្កោ រាជធានីភ្នំពេញ', 'Mr. Se Samnang', 'FAST_HOME', '35 Mbps', '0', '2025-05-03', '2026-05-03', '2027-05-03', '2025-05-02', 'Active', '2025-05-09 02:48:25', 0, 'Admin', '2025-05-09 02:48:25', NULL, 1, 'Phnom Penh'),
('000362', 'Vinh Setha', '092959808', 'pphmca000362', NULL, '# H-15, Sai Kang Street, Sangkat Choam Chao, Khan Por Senchey, Phnom Penh.', 'U.S. Dollar', '250', '0', 0, 12, 'វិញ​ សេថា', NULL, 'ផ្ទះលេខ​h-15​ ផ្លូវលេខ​ សៃកង សង្កាត់ ចោមចៅ ខណ្ឌ ពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Sale Admin', 'Home Save', '15 Mbps', '0', '2025-05-10', '2026-05-10', '2027-05-10', '2025-05-09', 'Active', '2025-05-07 08:18:29', 0, 'Admin', '2025-05-07 08:18:29', NULL, 1, 'Phnom Penh'),
('000368', 'Sok Channy', '087235258', NULL, NULL, 'Borey Orkide Villa The Royal, House TR16-16, St. Daliya Phnom Penh', 'U.S. Dollar', '248.5', '0', 0, 12, 'សុខ ចាន់នី', NULL, 'បុរី អ័រគីដេ វីឡា ដឹ រ៉ូយ៉ាល់ ផ្ទះ ធីអរ១៦-១៦ ផ្លូវដាលីយ៉ា ភ្នំពេញ', 'Agency MongKol', 'FAST_HOME', '35 Mbps', '0', '2025-05-23', '2026-05-23', '2027-05-23', '2025-05-22', 'Active', '2025-05-09 03:25:43', 0, 'Admin', '2025-05-09 03:25:43', NULL, 1, 'Phnom Penh'),
('000379', 'Srou Thearith', '070538841', 'pphcmb000379', NULL, 'No. R21 ,St Phle Chhouk (Borey Lorn City ) , Sangkat Chom Chao , Phnom Penh .', 'U.S. Dollar', '216', '0', 0, 12, 'ស្រ៊ូ​ ធារិទ្ធ', NULL, 'ផ្ទះលេខ​ អរ២១ ផ្លូវផ្លែឈូក (​បុរីលនស៊ីធី)​ សង្កាត់ចោមចៅ រាជធានីភ្នំពេញ', 'Mr. Se Samnang', 'FAST_HOME', '35 Mbps', '0', '2025-05-12', '2026-05-12', '2027-05-12', '2025-05-11', 'Active', '2025-05-07 08:24:56', 0, 'Admin', '2025-05-07 08:24:56', NULL, 1, 'Phnom Penh'),
('000385', 'Sath Chanvatana', '0712898888', NULL, NULL, 'Borey New World Chamkadong, St.03 No.124, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'U.S. Dollar', '220', '0', 0, 12, 'សាត ច័ន្ទវឌ្ឍនា', NULL, 'បុរីពិភពថ្មីចំការដូង ផ្លូវលេខ ០៣ ផ្ទះលេខ ១២៤ សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'Mr. Uch Kaing', 'SIA', '15 Mbps', '0', '2025-05-09', '2026-05-09', '2027-05-09', '2025-05-08', 'Active', '2025-05-07 08:20:53', 0, 'Admin', '2025-05-07 08:20:53', NULL, 1, 'Phnom Penh'),
('000386', 'Say Punleu', '0887611088', NULL, NULL, 'Borey New World Chamkadong, St.09 No.288, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'U.S. Dollar', '220', '0', 0, 12, 'សយ ពន្លឺ', NULL, 'បុរីពិភពថ្មី ចំការដូងផ្លូវលេខ ០៩ លេខ ២៨៨ សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'Mr. Uch Kaing', 'SIA', '15 Mbps', '0', '2025-05-01', '2026-05-01', '2027-05-01', '2025-05-31', 'Active', '2025-05-07 08:22:50', 0, 'Admin', '2025-05-07 08:22:50', NULL, 1, 'Phnom Penh'),
('000387', 'Lay Measroth', '098444845', NULL, NULL, 'Borey Hong Long, # 8, Street 6, Sangkat Prey Sar, Khan Dangkor, Phnom Penh', 'U.S. Dollar', '216', '0', 0, 12, 'ឡាយ មាសរដ្ឋ', NULL, 'បុរីហុងឡាយ ផ្ទះលេខ8 ផ្លូវលេខ6 សង្កាត់ព្រៃស ខណ្ឌដង្កោ ភ្នំពេញ', 'Mr. Uch Kaing', 'FAST_HOME', '35 Mbps', '0', '2025-05-18', '2026-05-18', '2027-05-18', '2025-05-17', 'Active', '2025-05-07 08:12:54', 0, 'Admin', '2025-05-07 08:12:54', NULL, 1, 'Phnom Penh'),
('000389', 'Huang Yudong', '0962668888', 'pphmca000389', NULL, 'House No. 862, Road 1019, Phoum Toul Pongro, Sang Kat Choum Choa, Khan Mean Chay,Phnom Penh.', 'U.S. Dollar', '514', '0', 0, 12, 'ហ័ង អ៊ីតុង', NULL, 'ផ្ទះលេខ 862 ផ្លូវ 1019 ភូមិ ទួលពង្រ សង្កាត់ ចោមចៅ ខណ្ឌ មានជ័យ រាជធានីភ្នំពេញ', 'Mr. Uch Kaing', 'SSIA', '20 Mbps', '0', '2025-05-09', '2026-05-09', '2027-05-09', '2025-05-08', 'Active', '2025-05-07 04:10:13', 0, 'Admin', '2025-05-07 04:10:13', NULL, 1, 'Phnom Penh'),
('000409', 'Tep Sengmeng', '010252509', 'pphcmb000409', NULL, 'Borey Ratanak House 2 st 8, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'U.S. Dollar', '108', '0', 0, 12, 'ទេព សេងម៉េង', NULL, 'បុរីរតនៈ ផ្ទះលេខ២ ផ្លូវលេខ៨ សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'FAST_HOME', '35 Mbps', '50', '2024-08-06', '2025-08-06', '2026-08-06', '2025-05-05', 'Active', '2025-05-07 08:08:24', 0, 'Admin', '2025-05-07 08:08:24', NULL, 1, 'Phnom Penh'),
('000418', 'Ith Sophorn', '085715231', 'pphcmb000418', NULL, 'Building 29, Floor-7 Mao Tse Toung Blvd, Sangkat Toul Tompong, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 3, 'អ៊ិត សុភាន់', '11.544148, 104.912179', 'អគារលេខ២៩ ជាន់ទី៧ មហាវិថីម៉ៅសេទុង សង្កាត់ទួលទំពូង រាជធានីភ្នំពេញ', 'Mr. Sorn Daniel', 'FAST_HOME', '50 Mbps', '0', '2025-05-05', '2025-08-05', '2025-11-05', '2025-05-04', 'Active', '2025-05-06 08:15:39', 0, 'Admin', '2025-05-06 08:15:39', NULL, 1, 'Phnom Penh'),
('000505', 'Nhean Sorakmuny', '015789516', 'pphcmb000505', NULL, 'Borey Phnom Penh Sok San Plan6, #H5, Sangkat Chaom Chau, Khan Pou Sen Chey, Phnom Penh.', 'U.S. Dollar', '108', '0', 0, 6, 'ញាណ សុរមន្នី', '11.510165, 104.858362', 'បុរីភ្នំពេញសុខសាន្ត Plan6 #H5 សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ។', 'Mr. Tep Theara', 'FAST_HOME', '35 Mbps', '0', '2025-05-06', '2025-11-06', '2026-05-06', '2025-05-05', 'Active', '2025-05-07 04:03:24', 0, 'Admin', '2025-05-07 04:03:24', NULL, 1, 'Phnom Penh'),
('000506', 'Khorn Youra', '010368078', 'pphssa000506', NULL, '#D3, Sangkat Kakab, Khan Pou Senchey, Phnom Penh.', 'U.S. Dollar', '180', '0', 0, 12, 'ឃន​ យូរ៉ា', NULL, '#D3 សង្កាត់កាកាប ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Mr. Gouv Leangchea', 'Home Save', '10 Mbps', '50', '2025-05-06', '2026-05-06', '2027-05-06', '2025-05-05', 'Active', '2025-05-07 07:50:50', 0, 'Admin', '2025-05-07 07:50:50', NULL, 1, 'Phnom Penh'),
('000622', 'Nob Nalin', '069329977', 'pphcmb000622', NULL, 'Borey Phnom Penh Thmey (Takhmao Central Park) #69, St 21, Sangkat Takhmao, Khan Takhmao', 'U.S. Dollar', '216', '0', 0, 12, 'ណុប ណាលីន', NULL, 'បុរីភ្នំពេញថ្មី (Takhmao Central Park) ផ្ទះលេខ ៦៩ ផ្លូវ ២១ សង្កាត់តាខ្មៅ ខណ្ឌតាខ្មៅ​ រាជធានីភ្នំពេញ', 'Agency Jing Jing', 'FAST_HOME', '35 Mbps', '0', '2024-10-10', '2025-10-10', '2026-10-10', '2025-05-09', 'Active', '2025-05-07 07:47:38', 0, 'Admin', '2025-05-07 07:47:38', NULL, 1, 'Phnom Penh'),
('000635', 'Praing Senghong', '087737377', 'pphcmb000635', NULL, 'No. 24, St P01 (Chip Mong Land 50M) , Sangkat Dangkor , Khan Dangkor , Phnom Penh .', 'U.S. Dollar', '151.2', '0', 0, 12, 'ប្រាំង សេងហុង', NULL, 'ផ្ទះលេខ ២៤, ផ្លូវ P01 (ជីបម៉ុងលែន ៥០​ ម៉ែត្រ) សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'Mr. Tep Theara', 'FAST_HOME', '35 Mbps', '0', '2024-10-16', '2025-10-16', '2026-10-16', '2025-05-15', 'Active', '2025-05-07 07:45:14', 0, 'Admin', '2025-05-07 07:45:14', NULL, 1, 'Phnom Penh'),
('000693', 'Kim Nang', '087893939', NULL, NULL, 'SHV-Luxury-Building', 'U.S. Dollar', '560', '0', 0, 3, 'គីម​ ណាង', '10°36\'43.7\"N 103°31\'52.0\"E', 'អគារលុចសារី ក្រុងព្រះសីហនុ', 'Mr. Dao KiHeng', 'SME', '50 Mbps', '0', '2025-04-18', '2025-07-18', '2025-10-18', '2025-04-17', 'Active', '2025-05-06 09:06:32', 0, 'Admin', '2025-05-06 09:06:32', NULL, 1, 'Phnom Penh'),
('000727', 'Hem Kuntheam', '012596787', 'pphcmb000727', NULL, 'Borey Phnom Penh Thmey ( Radiant Park) # S09 , st sunflower Phum Prokar, Sangkat Prey Sa, Khan Dangkor, Phnom Penh.', 'U.S. Dollar', '216', '0', 0, 12, 'ហែម​ គន្ធាម', '11°30\'28.1\"N 104°52\'22.9\"E', 'បុរីភ្នំពេញថ្មី (សួនច្បាររស្មី) ផ្ទះលេខ S09 ផ្លូវផ្កាឈូករ័ត្ន ភូមិប្រការ សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Agency Jing Jing', 'FAST_HOME', '35 Mbps', '0', '2025-05-24', '2026-05-24', '2027-05-24', '2025-05-23', 'Active', '2025-05-07 04:45:09', 0, 'Admin', '2025-05-07 04:45:09', NULL, 1, 'Phnom Penh'),
('000761', 'Mol Chandollar', '087632065', 'pphcmb000761', NULL, 'Borey Phnom Penh Thmey (Takhmao Central Park) #38, St A, sangkat takhmao, khan takhmao', 'U.S. Dollar', '216', '0', 0, 12, 'ម៉ុល ច័ន្ទដុល្លា', NULL, 'បុរីភ្នំពេញថ្មី (តាខ្មៅ Central Park) ផ្ទះលេខ៣៨ ផ្លូវA សង្កាត់តាខ្មៅ ខណ្ឌតាខ្មៅ', 'Agency Jing Jing', 'FAST_HOME', '35 Mbps', '35', '2025-05-12', '2026-05-12', '2027-05-12', '2025-05-11', 'Active', '2025-05-07 07:27:29', 0, 'Admin', '2025-05-07 07:27:29', NULL, 1, 'Phnom Penh'),
('000804', 'Pech Somanet', '010499298', 'pphcmb000804', NULL, '72I, Street Betong, Phum Trapeang Thloeng, Sangkat Chaom Chau, Khan Pou senchey Phnom Penh.', 'U.S. Dollar', '151.2', '0', 0, 12, 'ពេជ សូម៉ានេត', '11°31\'38.8\"N 104°51\'11.4\"E', 'ផ្ទះលេខ 72I ផ្លូវបេតុង ភូមិត្រពាំងថ្លឹង សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Mr. Se Samnang', 'FAST_HOME', '35 Mbps', '35', '2025-05-13', '2026-05-13', '2027-05-13', '2025-05-12', 'Active', '2025-05-07 04:31:14', 0, 'Admin', '2025-05-07 04:31:14', NULL, 1, 'Phnom Penh'),
('000805', 'Hout Sophearin', '0719676108', 'pphcmb000805', NULL, 'Borey Penghout Beoung Snor, #658 ,Street Clasteur, Sangkat Nirouth, Khan Chba Ampov,  Phnom Penh.', 'U.S. Dollar', '108', '0', 0, 12, 'ហួត សុភារិន', '11°31\'09.9\"N 104°57\'35.1\"E', 'បុរីប៉េងហួតបឹងស្នោរ ផ្ទះលេខ៦៥៨ ផ្លូវលំ សង្កាត់និរោធ ខណ្ឌច្បារអំពៅ រាជធានីភ្នំពេញ', 'Sale Admin', 'FAST_HOME', '35 Mbps', '0', '2025-05-16', '2026-05-16', '2027-05-16', '2025-05-15', 'Active', '2025-05-07 07:12:52', 0, 'Admin', '2025-05-07 07:12:52', NULL, 1, 'Phnom Penh'),
('000832', 'Kim Sinat', '010874242', 'pphcmb000832', NULL, 'Borey Phnom Penh Thmey ( Radiant Park) # G31 , St Golden Champa Phum Prokar, Sangkat Prey Sa, Khan Dangkor, Phnom Penh.', 'U.S. Dollar', '360', '0', 0, 12, 'គីម ស៊ីណាត', '11°30\'30.0\"N 104°52\'21.8\"E', 'បុរីភ្នំពេញថ្មី (សួនច្បាររស្មី) ផ្ទះលេខ G31 ផ្លូវមាសចំប៉ា ភូមិប្រការ សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Agency Jing Jing', 'FAST_HOME', '50 Mbps', '0', '2025-05-19', '2026-05-19', '2027-05-19', '2025-05-18', 'Active', '2025-05-07 04:47:48', 0, 'Admin', '2025-05-07 04:47:48', NULL, 1, 'Phnom Penh'),
('000839', 'Leng Kok', '0887777535', 'pphcmb000839', NULL, 'Borey Phnom Penh Thmey ( Radiant Park) # S05 , st sunflower Phum Prokar, Sangkat Prey Sa, Khan Dangkor, Phnom Penh.', 'U.S. Dollar', '216', '0', 0, 12, 'ឡេង កុក', '11°30\'28.2\"N 104°52\'24.1\"E', 'បុរីភ្នំពេញថ្មី (សួនរស្មី) ផ្ទះលេខ S05 ផ្លូវផ្កាឈូករ័ត្ន ភូមិប្រការ សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Agency Jing Jing', 'FAST_HOME', '35 Mbps', '0', '2025-05-10', '2026-05-10', '2027-05-10', '2025-05-09', 'Active', '2025-05-07 04:34:31', 0, 'Admin', '2025-05-07 04:34:31', NULL, 1, 'Phnom Penh'),
('000876', 'Wang Jia', '087235258', NULL, NULL, 'Borey Peng Huoth The Star Platinum Athina, #A10, Street 16, Sangkat Nirouth, Khan Chbar Ampov, Phnom Penh.', 'U.S. Dollar', '360', '0', 0, 1, 'វ៉ាង ជា', '11°31\'44.4\"N 104°57\'18.7\"E', 'បុរី ប៉េងហួត ដឹស្តា ផ្លាទីនីម អាធីណា ផ្ទះលេខ អេ១០ ផ្លូវលេខ ១៦ សង្កាត់និរោធ ខណ្ឌច្បារអំពៅ រាជធានីភ្នំពេញ', 'Agency MongKol', 'US IP', '10 Mbps', '0', '2025-05-26', '2025-06-26', '2025-07-26', '2025-05-25', 'Active', '2025-05-07 03:13:10', 0, 'Admin', '2025-05-07 03:13:10', NULL, 1, 'Phnom Penh'),
('000877', 'Aoeng Dalin', '070593058', 'pphcmb000877', NULL, 'Borey Piphup Thmey Kour Srov II,House 46, Street 09B,Sangkat Preaek Kampues, Khan Dangkao, Phnom Penh', 'U.S. Dollar', '90', '0', 0, 12, 'អ៊ឹង ដាលីន', '11.4409288, 104.8965835', 'បុរីពិភពថ្មីកួរស្រូវ២ ផ្ទះលេខ៤៦ ផ្លូវលេខ០៩ប៊ី សង្កាត់ព្រែកកំពឹស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Sale Admin', 'Home Save', '10 Mbps', '0', '2025-03-07', '2026-03-07', '2027-03-07', '2025-03-06', 'Active', '2025-05-06 09:10:18', 0, 'Admin', '2025-05-06 09:10:18', NULL, 1, 'Phnom Penh'),
('000897', 'Sam Choungveng', '081580866', 'pph7ma000897', NULL, 'House No. 4, Street 161, Sangkat Orussey 2, Khan 7 Makara, Phnom Penh.', 'U.S. Dollar', '75.6', '0', 0, 6, 'សំ ឈូងវេង', '11.562514, 104.915032', 'ផ្ទះលេខ៤ ផ្លូវលេខ១៦១ សង្កាត់អូរឬស្សី២ ខណ្ឌ៧មករា រាជធានីភ្នំពេញ', 'Mr. Sorn Daniel', 'FAST_HOME', '35 Mbps', '35', '2025-05-18', '2025-11-18', '2026-05-18', '2025-05-17', 'Active', '2025-05-07 03:52:30', 0, 'Admin', '2025-05-07 03:52:30', NULL, 1, 'Phnom Penh'),
('000898', 'Nou Bou', '070638858', 'pphcmb000898', NULL, 'Borey Morakot SH, House 21,22 St 8m, Sangkat Prey Sar, Khan Dangkor, Phnom Penh.', 'U.S. Dollar', '151.2', '0', 0, 12, 'នូ ប៊ូ', '11°29\'40.3\"N 104°51\'42.7\"E', 'បុរីមរកត SH ផ្ទះ 21,22 ផ្លូវ 8m សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Mr. Se Samnang', 'FAST_HOME', '35 Mbps', '0', '2025-03-20', '2026-03-20', '2027-03-20', '2025-03-19', 'Active', '2025-05-06 09:56:58', 0, 'Admin', '2025-05-06 09:56:58', NULL, 1, 'Phnom Penh'),
('000899', 'Put Thearak', '069800029', 'pph7ma000899', NULL, '#25E, St 136, Sangkat Phsar Thmey 3, Khan Doun Penh, Phnom Penh.', 'U.S. Dollar', '216', '0', 0, 12, 'ពុធ ធារៈ', '11.569325, 104.923378', 'ផ្ទះលេខ 25E ផ្លូវ 136 សង្កាត់ផ្សារថ្មី 3 ខណ្ឌដូនពេញ រាជធានីភ្នំពេញ', 'Mr. Tep Theara', 'FAST_HOME', '35 Mbps', '50', '2025-03-28', '2026-03-28', '2027-03-28', NULL, 'Active', '2025-05-06 07:42:32', 2, 'Admin', '2025-05-01 21:25:09', 'Admin', 1, 'Phnom Penh'),
('000998', 'Thol Mary', '0968333384', NULL, NULL, 'No. B10 , St lom, Borey Try Kim, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'U.S. Dollar', '151.20', '0', 0, 12, 'ថុល ម៉ារី', '11.494979, 104.885073', 'ផ្ទះលេខ B10 ផ្លូវលំ បុរីទ្រីគីម សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Mr. Se Samnang', 'FAST_HOME', '35 Mbps', '0', '2025-05-26', '2026-05-26', '2027-05-26', '2026-05-25', 'Active', '2025-05-26 09:52:50', 0, 'Admin', '2025-05-26 09:52:50', NULL, 1, 'Phnom Penh'),
('001001', 'B3-1F-24 小时早餐店', NULL, 'sme20250201007', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 21:12:22', 0, 'Admin', '2025-05-28 21:12:22', NULL, 1, 'Kampot'),
('001002', 'C5-B栋-1楼-红酒小炒', NULL, NULL, NULL, 'Kampot', 'U.S. Dollar', '75.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '5 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001003', 'CY-B10-2F-R209', NULL, 'sme20231206002', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001004', 'CY-B1-3F-R305', NULL, 'sme20231219002', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-19', '2025-06-19', '2025-07-19', '2025-06-19', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001005', 'CY-B1-3F-R306', NULL, 'sme20230812004', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001006', 'CY-B1-3F-R316', NULL, 'sme20240514002', NULL, 'Kampot', 'U.S. Dollar', '225.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '15 Mbps', '0', '2025-06-14', '2025-06-14', '2025-07-14', '2025-06-14', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001007', 'CY-B1-4F-R405', NULL, 'sme20241203005', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-03', '2025-07-03', '2025-08-03', '2025-06-03', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001008', 'CY-B1-6F-R603', NULL, 'sme20240920003', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001009', 'CY-B1-6F-R604', NULL, 'sme20241015001', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-15', '2025-06-15', '2025-07-15', '2025-06-15', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001010', 'CY-B1-6F-R615', NULL, 'sme20241028002', NULL, 'Kampot', 'U.S. Dollar', '75.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '5 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001011', 'CY-B1-6F-R616', NULL, 'sme20240121001', NULL, 'Kampot', 'U.S. Dollar', '225.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '15 Mbps', '0', '2025-06-21', '2025-06-21', '2025-07-21', '2025-06-21', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001012', 'CY-B1-6F-R617', NULL, 'sme20250518006', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-18', '2025-06-18', '2025-07-18', '2025-06-18', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001013', 'CY-B1-6F-R626', NULL, 'sme20250127001', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001014', 'CY-B1-WENWEN', NULL, 'fo20230217003', NULL, 'Kampot', 'U.S. Dollar', '70.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001015', 'CY-B3-78win', NULL, 'sme20241213001', NULL, 'Kampot', 'U.S. Dollar', '70.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-13', '2025-07-13', '2025-08-13', '2025-06-13', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001016', 'CY-B3-Gaming', NULL, 'sme20240805001', NULL, 'Kampot', 'U.S. Dollar', '210.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '30 Mbps', '0', '2025-06-05', '2025-07-05', '2025-08-05', '2025-06-05', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001017', 'CY-B3-Gaming-2', NULL, 'fo20250320011', NULL, 'Kampot', 'U.S. Dollar', '450.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '30 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001018', 'CY-B3-Massage', NULL, 'sme20250405004', NULL, 'Kampot', 'U.S. Dollar', '70.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-05', '2025-07-05', '2025-08-05', '2025-06-05', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001019', 'CY-B7-2F-206', NULL, 'fo20250515001', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-15', '2025-06-15', '2025-07-15', '2025-06-15', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001020', 'CY-B7-2F-R209', NULL, 'fo20250408008', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-08', '2025-07-08', '2025-08-08', '2025-06-08', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001021', 'CY-B7-2F-R210', NULL, 'fo20250410004', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-10', '2025-07-10', '2025-08-10', '2025-06-10', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001022', 'CY-B7-2F-R211', NULL, 'fo20250412004', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-12', '2025-07-12', '2025-08-12', '2025-06-12', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001023', 'CY-B7-2F-R216', NULL, 'fo20250520010', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001024', 'CY-B7-3F-309', NULL, 'fo20240817004', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001025', 'CY-B7-4F-410', NULL, 'sme20241219001', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001026', 'CY-B7-6F-R618', NULL, 'sme20241216007', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001027', 'CY-B7-7F-R713', NULL, 'fo20241213004', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-15', '2025-06-15', '2025-07-15', '2025-06-15', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001028', 'CY-B7-7F-R719', NULL, 'sme20241015006', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-15', '2025-06-15', '2025-07-15', '2025-06-15', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001029', 'CY-B7-7F-R720', NULL, 'sme20240421002', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001030', 'CY-B7-8F-810', NULL, 'sme20240717010', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001031', 'CY-B7-8F-812', NULL, 'sme20240717012', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001032', 'CY-B7-8F-817', NULL, 'sme20250420010', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001033', 'CY-B7-8F-817-2', NULL, 'sme20250426008', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001034', 'CY-B8B-Container-K02', NULL, 'sme20241027003', NULL, 'Kampot', 'U.S. Dollar', '140.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '20 Mbps', '0', '2025-06-11', '2025-07-11', '2025-08-11', '2025-06-11', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001035', 'CY-B8-Hospital', NULL, 'sme20240711003', NULL, 'Kampot', 'U.S. Dollar', '35.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '5 Mbps', '0', '2025-06-11', '2025-07-11', '2025-08-11', '2025-06-11', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001036', 'CY-B9-3F-320', NULL, 'sme20250404004', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-05', '2025-07-05', '2025-08-05', '2025-06-05', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001037', 'CY-B9-3F-328', NULL, 'sme20250123022', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001038', 'CY-B9-3F-337', NULL, 'sme20250116005', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001039', 'CY-B9-3F-R309', NULL, 'sme20250228014', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001040', 'CY-B9-4F-3A03', NULL, 'sme20240826001', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-16', '2025-06-16', '2025-07-16', '2025-06-16', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001041', 'CY-B9-4F-3A05', NULL, 'sme20250306022', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-06', '2025-07-06', '2025-08-06', '2025-06-06', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001042', 'CY-B9-4F-3A07', NULL, 'sme20240914005', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001043', 'CY-B9-4F-3A09', NULL, 'sme20241214001', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001044', 'CY-B9-4F-3A11', NULL, 'sme20250308008', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-08', '2025-07-08', '2025-08-08', '2025-06-08', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001045', 'CY-B9-4F-3A13', NULL, 'sme20250423005', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001046', 'CY-B9-4F-3A15', NULL, 'sme20250123020', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001047', 'CY-B9-4F-3A16', NULL, 'sme20250306023', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-06', '2025-07-06', '2025-08-06', '2025-06-06', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001048', 'CY-B9-4F-3A18', NULL, 'sme20250311011', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-11', '2025-07-11', '2025-08-11', '2025-06-11', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001049', 'CY-B9-4F-3A20', NULL, 'fo20240204004', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001050', 'CY-B9-4F-3A25', NULL, 'sme20240318003', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001051', 'CY-B9-4F-3A27', NULL, 'fo20241116001', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001052', 'CY-B9-5F-503', NULL, 'fo20250412013', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-09', '2025-07-09', '2025-08-09', '2025-06-09', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001053', 'CY-B9-5F-507', NULL, 'sme20240919004', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001054', 'CY-B9-5F-509', NULL, 'sme20240731003', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001055', 'CY-B9-5F-512', NULL, 'sme20240207006', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001056', 'CY-B9-5F-513', NULL, 'fo20240625003', NULL, 'Kampot', 'U.S. Dollar', '450.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '30 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001057', 'CY-B9-5F-515', NULL, 'fo20241108002', NULL, 'Kampot', 'U.S. Dollar', '450.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '30 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001058', 'CY-B9-5F-517', NULL, 'sme20240604005', NULL, 'Kampot', 'U.S. Dollar', '450.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '30 Mbps', '0', '2025-06-15', '2025-06-15', '2025-07-15', '2025-06-15', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001059', 'CY-B9-5F-523', NULL, 'fo20240303001', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-04', '2025-07-04', '2025-08-04', '2025-06-04', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001060', 'CY-B9-5F-525', NULL, 'sme20240815002', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-18', '2025-06-18', '2025-07-18', '2025-06-18', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001061', 'CY-B9-5F-527', NULL, 'fo20240301002', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001062', 'CY-B9-5F-529', NULL, 'fo20240301003', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001063', 'CY-B9-5F-535', NULL, 'sme20240615002', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001064', 'CY-B9-5F-537', NULL, 'sme20250402005', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-02', '2025-07-02', '2025-08-02', '2025-06-02', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001065', 'CY-B9-5F-R519', NULL, 'sme20250413007', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '10 Mbps', '0', '2025-06-13', '2025-07-13', '2025-08-13', '2025-06-13', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001066', 'CY-B9-6F-606', NULL, 'sme20250312007', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-12', '2025-07-12', '2025-08-12', '2025-06-12', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot');
INSERT INTO `customers_info` (`customer_id`, `customer_name`, `phone_number`, `pppoe`, `ip_address`, `address_line_1`, `currency`, `internet_fee`, `ip_fee`, `ip_quantity`, `bill_cycle`, `alt_customer_name`, `lat_long`, `alt_address_line_1`, `agent`, `tariff_name`, `bandwidth`, `installation_fee`, `first_start_date`, `start_date`, `end_date`, `complete_date`, `status`, `last_updated`, `update_attempts`, `created_by`, `created_at`, `updated_by`, `number_of_invoices`, `province`) VALUES
('001067', 'CY-B9-6F-613', NULL, 'fo20240810005', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001068', 'CY-B9-6F-619', NULL, 'sme2024118007', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001069', 'CY-B9-6F-620', NULL, 'sme20240704001', NULL, 'Kampot', 'U.S. Dollar', '450.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '30 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001070', 'CY-B9-6F-622', NULL, 'sme20240226001', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001071', 'CY-B9-6F-637', NULL, 'sme20240916004', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001072', 'CY-B9-6F-639', NULL, 'sme20241215007', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-15', '2025-06-15', '2025-07-15', '2025-06-15', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 0, 'Kampot'),
('001073', 'CY-B9-7F-721', NULL, 'sme20240718001', NULL, 'Kampot', 'U.S. Dollar', '300.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '20 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001074', 'CY-B9-7F-722', NULL, 'fo20240207005', NULL, 'Kampot', 'U.S. Dollar', '450.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '30 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001075', 'CY-B9-R702', NULL, 'sme20250223004', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001076', 'CY-C5-1F-B-Chaoxian-Restaurant', NULL, 'sme20250506001', NULL, 'Kampot', 'U.S. Dollar', '75.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '5 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001077', 'CY-C5-1F-B-Hospital-诊所', NULL, 'sme20250428003', NULL, 'Kampot', 'U.S. Dollar', '75.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '5 Mbps', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001078', 'B7-7F-R718', NULL, 'sme20250514005', NULL, 'Kampot', 'U.S. Dollar', '474.19', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'SME', '20 Mbps', '0', '2025-05-14', '2025-06-14', '2025-07-14', '2025-05-14', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('001079', 'CY-B9-4F-3A21', NULL, 'sme20241117003', NULL, 'Kampot', 'U.S. Dollar', '150.00', '0', 0, 1, '', NULL, 'កំពត', 'Sale Admin', 'DIA', '10 Mbps ', '0', '2025-06-01', '2025-07-01', '2025-08-01', '2025-06-01', 'Active', '2025-05-29 10:00:00', 0, 'Admin', '2025-05-29 10:00:00', NULL, 1, 'Kampot'),
('Test001', 'Vorthanak', NULL, NULL, NULL, 'Phnom Penh', 'U.S. Dollar', '100', '0', 1, 3, 'Vorthanak', NULL, 'Phnom Penh', 'unspecified', 'Home Save', '50 Mbps', '0', '2025-06-05', '2025-09-05', '2025-12-05', '2025-12-04', 'Active', '2025-06-05 04:08:33', 1, 'Admin', '2025-06-05 04:08:15', 'Admin', 1, 'Phnom Penh'),
('Test002', 'Vorthanak', NULL, NULL, NULL, 'Phnom Penh', 'U.S. Dollar', '50', '10', 1, 3, 'Vorthanak', NULL, 'Phnom Penh', 'unspecified', 'Home Save', '30 Mbps', '50', '2025-07-05', '2025-07-05', '2025-10-05', NULL, 'Deactivated', '2025-06-05 09:21:08', 2, 'Admin', '2025-06-05 09:18:19', 'Admin', 0, 'Phnom Penh');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` varchar(10) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `customer_name` varchar(120) NOT NULL,
  `address_line_1` varchar(255) NOT NULL,
  `alt_customer_name` varchar(255) NOT NULL,
  `alt_address_line_1` varchar(255) NOT NULL,
  `tariff_name` varchar(255) NOT NULL,
  `bandwidth` varchar(255) NOT NULL,
  `internet_fee` varchar(255) NOT NULL,
  `bill_cycle` int(11) NOT NULL,
  `installation_or_not` varchar(255) DEFAULT NULL,
  `installation_fee` varchar(255) DEFAULT NULL,
  `installation_quantity` int(11) DEFAULT NULL,
  `ip_fee` varchar(255) NOT NULL,
  `ip_quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Unpaid',
  `payment_date` date DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL,
  `update_attempts` int(11) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `customer_id`, `customer_name`, `address_line_1`, `alt_customer_name`, `alt_address_line_1`, `tariff_name`, `bandwidth`, `internet_fee`, `bill_cycle`, `installation_or_not`, `installation_fee`, `installation_quantity`, `ip_fee`, `ip_quantity`, `total_amount`, `payment_status`, `payment_date`, `start_date`, `end_date`, `last_updated`, `update_attempts`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
('INV0001', '000000', 'Lun Savun', 'Borey Phnom Penh Sok San Plan6  St.Lum No.G3 , Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'លន់ សាវុន', 'បុរីភ្នំពេញសុខសាន្ត គំរោងទី៦ ផ្លូវលំ ផ្ទះលេខ G៣ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2024-08-18', '2025-08-18', '2025-05-27 08:36:01', 0, 'Unknown', NULL, '2025-05-27 15:36:01', '2025-05-27 15:36:01'),
('INV0002', '000001', 'Doung Kimhak', '#458 St 24BT, Sangkat Beong Tom Pun, Khan mean chey, Phnom Penh', 'ដួង គឹមហាក់', 'ផ្ទះលេខ ៤៥៨ ផ្លូវ ២៤BT សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'SSIA', '10 Mbps', '242', 12, 'false', '0', NULL, '0', 0, 242.00, 'Unpaid', NULL, '2024-08-11', '2025-08-11', '2025-05-27 08:36:02', 0, 'Unknown', NULL, '2025-05-27 15:36:02', '2025-05-27 15:36:02'),
('INV0003', '000003', 'San Sopheap', 'Borey Phnom Penh Sok San St.Lum No.G1, Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'សាន សុភាព', 'បុរីភ្នំពេញសុខសាន្ត ផ្លូវលំ ផ្ទះលេខជី១ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ ភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2025-05-20', '2026-05-20', '2025-05-27 08:36:04', 0, 'Unknown', NULL, '2025-05-27 15:36:04', '2025-05-27 15:36:04'),
('INV0004', '000004', 'Seang Sophalla', 'Borey Phnom Penh Sok San St.Lum No.B14, Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'ស៊ាង សុផល្លា', 'បុរីភ្នំពេញសុខសាន្ត ផ្លូវលំ ផ្ទះលេខបេ១៤ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ ភ្នំពេញ', 'SSIA', '20 Mbps', '440', 12, 'false', '0', NULL, '0', 0, 440.00, 'Unpaid', NULL, '2025-05-09', '2026-05-09', '2025-05-27 08:36:04', 0, 'Unknown', NULL, '2025-05-27 15:36:04', '2025-05-27 15:36:04'),
('INV0005', '000005', 'Kim Nang', 'Building Luxury 7F-Room709', 'គីម​ ណាង', 'អគារលុចសារី ជាន់ទី៧ បន្ទប់លេខ ៧០៩', 'SME', '30 Mbps', '120', 1, 'false', '0', NULL, '0', 1, 120.00, 'Unpaid', NULL, '2025-05-19', '2025-06-19', '2025-05-27 08:36:05', 0, 'Unknown', NULL, '2025-05-27 15:36:05', '2025-05-27 15:36:05'),
('INV0006', '00001', 'SAMNANG SE', 'OCIC', 'SAMNANG SE', 'ALC', 'Home Save', '10 Mbps', '100', 1, 'true', '50', NULL, '1', 1, 151.00, 'Paid', '2025-06-04', '2025-04-29', '2025-05-29', '2025-06-04 02:16:04', 1, 'Unknown', 'Admin', '2025-05-27 15:36:07', '2025-06-04 09:16:04'),
('INV0007', '000141', 'Sath Chanvatana (Line 2)', 'Borey New World Chamkadong, St.03 No.107, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'សាត ច័ន្ទវឌ្ឍនា', 'បុរីពិភពថ្មីចំការដូង ផ្លូវលេខ ០៣ ផ្ទះលេខ ១០៧ សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'SIA', '15 Mbps', '220', 12, 'false', '0', NULL, '0', 0, 220.00, 'Unpaid', NULL, '2025-02-07', '2026-02-07', '2025-05-27 08:36:07', 0, 'Unknown', NULL, '2025-05-27 15:36:07', '2025-05-27 15:36:07'),
('INV0008', '000163', 'Ven Dara', 'Borey Hok Chheng, #13, St. H.C, Sangkat Dangkor, Khan Dangkor, Phnom Penh', 'វ៉ែន ដារ៉ា', 'បុរីហុកឆេង ផ្ទះលេខ១៣ ផ្លូវអេចស៊ី សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'Home Save', '10 Mbps', '180', 12, 'false', '0', NULL, '0', 0, 180.00, 'Unpaid', NULL, '2025-05-10', '2026-05-10', '2025-05-27 08:36:08', 0, 'Unknown', NULL, '2025-05-27 15:36:08', '2025-05-27 15:36:08'),
('INV0009', '000198', 'Heng Samphors', 'No.14 Borey Phnompenh Sok San plan 6, Sangkat Chaom  Chav, Khan  Porsenchey, Phnom Penh', 'ហេង សម្ផស្ស', 'ផ្ទះលេខ ១៤ បុរីភ្នំពេញសុខសាន្ត គំរោងទី៦ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '180', 12, 'false', '0', NULL, '0', 0, 180.00, 'Unpaid', NULL, '2024-09-05', '2025-09-05', '2025-05-27 08:36:08', 0, 'Unknown', NULL, '2025-05-27 15:36:08', '2025-05-27 15:36:08'),
('INV0010', '000200', 'Yun Bunchhay', 'No.1025 St 2004 Sangkat Ou Baek K\'am, Khan Sen sok, Phnom Penh', 'យន្ត ប៊ុនឆៃ', 'ផ្ទះលេខ 1025 ផ្លូវ 2004 សង្កាត់អូរបែកក្អម ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2024-09-15', '2025-09-15', '2025-05-27 08:36:08', 0, 'Unknown', NULL, '2025-05-27 15:36:08', '2025-05-27 15:36:08'),
('INV0011', '000211', 'Chea Pohok', 'Borey Phnom Penh Sok San Plan6  St.Lum No.G2 , Sangkat Chaom Chau , Khan Pou SenChey, Phnom Penh', 'ជា ប៉ូហុក', 'បុរីភ្នំពេញសុខសាន្ត គំរោងទី៦ ផ្លូវលំ ផ្ទះលេខ G២ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'true', '50', NULL, '0', 0, 266.00, 'Unpaid', NULL, '2024-10-08', '2025-10-08', '2025-05-27 08:36:08', 0, 'Unknown', NULL, '2025-05-27 15:36:08', '2025-05-27 15:36:08'),
('INV0012', '000218', 'Long Ananpanha', '# E-127, st BL01, Sangkat Dangkor, Khan Dangkor, Phnom Penh', 'ឡុង អានន្ថ​បញ្ញា', 'ផ្ទះលេខ អ៊ី-១២៧ ផ្លូវ បេអិល​ ០១ សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2024-12-01', '2025-12-01', '2025-05-27 08:36:09', 0, 'Unknown', NULL, '2025-05-27 15:36:09', '2025-05-27 15:36:09'),
('INV0013', '000219', 'Chath Mao', '#111A St.271  Phum1   Sangkat Beoung Salang , Khan Toul Kork, Phnom Penh', 'ចាត  ម៉ៅ', 'ផ្ទះលេខ១១១អេ ផ្លូវ២៧១ ភូមិ១ សង្កាត់បឹងសាឡាង ខណ្ឌទួលគោក រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 12, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2024-11-18', '2025-11-18', '2025-05-27 08:36:09', 0, 'Unknown', NULL, '2025-05-27 15:36:09', '2025-05-27 15:36:09'),
('INV0014', '000221', 'Ly Veth', 'No 3, St 24BT, Sangkat Boeng Tumpun, Khan meanchey, Phnom Penh', 'លី វុិត', 'ផ្ទះលេខ ៣ ផ្លូវ ២៤BT សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 6, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-05-14', '2025-11-14', '2025-05-27 08:36:09', 0, 'Unknown', NULL, '2025-05-27 15:36:09', '2025-05-27 15:36:09'),
('INV0015', '000223', 'Ork Reaksmey', 'No B1-B4, St Hanoi, Sangkat Phnom Penh Tmey, Khan Sen Sok, Phnom Penh', 'អោក  រស្មី', 'ផ្ទះលេខ B1-B4 ផ្លូវហាណូយ សង្កាត់ភ្នំពេញថ្មី ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 12, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2024-11-25', '2025-11-25', '2025-05-27 08:36:10', 0, 'Unknown', NULL, '2025-05-27 15:36:10', '2025-05-27 15:36:10'),
('INV0016', '000234', 'Phea Nano', 'Street Mong Rithy, Sangkat Kouk Klaing, Khan Sen Sok, Phnom Penh', 'ភា ណាណូ', 'ផ្លូវម៉ុងរិទ្ធី សង្កាត់គោកឃ្លាំង ខណ្ឌសែនសុខ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 6, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-01-13', '2025-07-13', '2025-05-27 08:36:11', 0, 'Unknown', NULL, '2025-05-27 15:36:11', '2025-05-27 15:36:11'),
('INV0017', '000235', 'Koeurn Sreyneat', 'No 72, St 49BT, Phum Sansam Kosal, Sangkat Boeng Tumpun, Khan Meanchey, Phnom Penh', 'គឿន ស្រីនាត', 'ផ្ទះលេខ ៧២ ផ្លូវ ៤៩BT ភូមិសន្សំកុសល សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 12, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-01-24', '2026-01-24', '2025-05-27 08:36:11', 0, 'Unknown', NULL, '2025-05-27 15:36:11', '2025-05-27 15:36:11'),
('INV0018', '000240', 'Rith Som Ang', 'St 810, Sangkat 4, Or 2, sihanoukville', 'រិទ្ធ សំអាង', 'ផ្លូវ ៨១០ សង្កាត់ ៤​ អូរ២  ក្រុងព្រះសីហនុ', 'SSIA', '10 Mbps', '220', 12, 'false', '0', NULL, '0', 0, 220.00, 'Unpaid', NULL, '2025-02-15', '2026-02-15', '2025-05-27 08:36:12', 0, 'Unknown', NULL, '2025-05-27 15:36:12', '2025-05-27 15:36:12'),
('INV0019', '000244', 'Ly Chingchheng', 'No 27, St 472, Phum 1, Sangkat Toul tompong 2, Khan Chamkarmon, Phnom Penh.', 'លី​ ជីញឆេង', 'ផ្ទះលេខ ២៧ ផ្លូវ ៤៧២ ភូមិ១ សង្កាត់ទួលទំពូង២ ខណ្ឌចំការមន រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 12, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-03-01', '2026-03-01', '2025-05-27 08:36:13', 0, 'Unknown', NULL, '2025-05-27 15:36:13', '2025-05-27 15:36:13'),
('INV0020', '000263', 'Sok Vandy', '.# 508, Street 5, PCD, Thmey Village, Sangkat Dangkor, Khan Dangkor, Phnom Penh', 'សុខ វណ្ឌី', 'ផ្ទះលេខ៥០៨ ផ្លូវ ៥ប៉េស៊ីឌី ភូមិថ្មី សង្កាត់ដង្កោ ខណ្ឌដង្កោ​ ភ្នំពេញ', 'Home Save', '10 Mbps', '90', 6, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-05-09', '2025-11-09', '2025-05-27 08:36:13', 0, 'Unknown', NULL, '2025-05-27 15:36:13', '2025-05-27 15:36:13'),
('INV0021', '000284', 'Tham Vantoto (sola)', '#Depo Tela, St Sola, Sangkat Stueng Mean Chey, Phnom Penh', 'ថាម វ៉ាន់តូតូ (សូឡា)', '#ដេប៉ូតេលា ផ្លូវសូឡា សង្កាត់ស្ទឹងមានជ័យ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '180', 12, 'false', '0', NULL, '0', 0, 180.00, 'Unpaid', NULL, '2025-05-27', '2026-05-27', '2025-05-27 08:36:13', 0, 'Unknown', NULL, '2025-05-27 15:36:13', '2025-05-27 15:36:13'),
('INV0022', '000285', 'Kong Visal', '#126, st lum, phum tuek thla, sangkat tuek thla, khan sen sok, Phnom Penh', 'គង់ វិសាល', '#១២៦, ផ្លូវលំ, ភូមិទឹកថ្លា, សង្កាត់ទឹកថ្លា, ខណ្ឌសែនសុខ, រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '180', 12, 'false', '0', NULL, '0', 0, 180.00, 'Unpaid', NULL, '2025-05-27', '2026-05-27', '2025-05-27 08:36:13', 0, 'Unknown', NULL, '2025-05-27 15:36:13', '2025-05-27 15:36:13'),
('INV0023', '000286', 'Kong Visal Nary', '#126, st lum, phum tuek thla, sangkat tuek thla, khan sen sok, Phnom Penh', 'គង់ វិសាល​ ណារី', '#១២៦, ផ្លូវលំ, ភូមិទឹកថ្លា, សង្កាត់ទឹកថ្លា, ខណ្ឌសែនសុខ, រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '180', 12, 'false', '0', NULL, '0', 0, 180.00, 'Unpaid', NULL, '2025-05-01', '2026-05-01', '2025-05-27 08:36:14', 0, 'Unknown', NULL, '2025-05-27 15:36:14', '2025-05-27 15:36:14'),
('INV0024', '000305', 'Math Monita-GoldenSea BD', 'Eakareach Street, Sangkat 3, Sihanoukville', 'ម៉ាត់ ម៉ូនីតា', 'ផ្លូវឯករាជ្យ សង្កាត់៣ ក្រុងព្រះសីហនុ', 'DIA', '15 Mbps', '300', 1, 'false', '0', NULL, '10.00', 8, 380.00, 'Unpaid', NULL, '2025-05-17', '2025-06-17', '2025-05-27 08:36:14', 0, 'Unknown', NULL, '2025-05-27 15:36:14', '2025-05-27 15:36:14'),
('INV0025', '000310', 'Roeun Vothna', '#19, St 1019 (Hanoi), S.k PhnomPenh Thmey, Khan Sensok.', 'រឿន វឌ្ឍនា', 'ផ្ទះលេខ 19 ផ្លូវ 1019 (ហាណូយ) សង្កាត់ភ្នំពេញថ្មី ខណ្ឌសែនសុខ។', 'Home Save', '10 Mbps', '180', 12, 'false', '0', NULL, '0', 0, 180.00, 'Unpaid', NULL, '2025-05-20', '2026-05-20', '2025-05-27 08:36:14', 0, 'Unknown', NULL, '2025-05-27 15:36:14', '2025-05-27 15:36:14'),
('INV0026', '000314', 'Eung Porou', 'St 132Z, Songkat Tuek Laork I, Khan Tuol Kouk, Phnom Penh.', 'អ៊ឹង ប៉អ៊ូ', 'ផ្លូវ 132Z សង្កាត់ ទឹកល្អក់ទី១ ខណ្ឌទួលគោក រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 6, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-05-06', '2025-11-06', '2025-05-27 08:36:15', 0, 'Unknown', NULL, '2025-05-27 15:36:15', '2025-05-27 15:36:15'),
('INV0027', '000315', 'Chat Ry', '#50 St Phum Thmei, Sangkat Dangkao, Khan Dangkor, Phnom Penh.', 'ចាត​ រី', 'ផ្ទះលេខ ៥០ ភូមិថ្មី សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 6, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-05-11', '2025-11-11', '2025-05-27 08:36:16', 0, 'Unknown', NULL, '2025-05-27 15:36:16', '2025-05-27 15:36:16'),
('INV0028', '000318', 'Yao Youxi', 'Phum 1, Sangkat 1, Sihanoukville', 'យ៉ាវ​ យ៉ូវស៊ី', 'ភូមិ១ សង្កាត់១ ក្រុងព្រះសីហនុ', 'SME', '30 Mbps', '720', 6, 'false', '0', NULL, '0', 0, 720.00, 'Unpaid', NULL, '2025-04-24', '2025-10-24', '2025-05-27 08:36:16', 0, 'Unknown', NULL, '2025-05-27 15:36:16', '2025-05-27 15:36:16'),
('INV0029', '000323', 'Chuon Phanny', '#6A, St Toul Pongro, Sangkat Chom Chao khan Porsenchey, Phnom Penh.', 'ជួន ផានី', 'ផ្ទះលេខ 6A ស្តុបទួលពង្រ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ។', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2024-11-21', '2025-11-21', '2025-05-27 08:36:17', 0, 'Unknown', NULL, '2025-05-27 15:36:17', '2025-05-27 15:36:17'),
('INV0030', '000324', 'Nget Tityaridh', '#14, st 4A, Borey Piphup Thmey Chamka Doung I, Phoum Sambour, Sangkat Dang Kor, Khan Dangkor, Phnom Penh', 'ង៉ែត ទិត្យារិទ្ធ', 'ផ្ទះលេខ ១៤ ផ្លូវ ៤A បុរីពិភពថ្មីចំការដូង ភូមិសំបួរ សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '54', 6, 'false', '0', NULL, '0', 0, 54.00, 'Unpaid', NULL, '2024-12-06', '2025-06-06', '2025-05-27 08:36:18', 0, 'Unknown', NULL, '2025-05-27 15:36:18', '2025-05-27 15:36:18'),
('INV0031', '000328', 'Peang Khuong', '#190BE1, Street 182, Sangkat Phsar Depo 1, Khan Toul Kork, Phnom Penh.', 'ពាង ឃួង', 'ផ្ទះលេខ ១៩០ប៉េអឺ១ ផ្លូវ ១៨២​ សង្កាត់ផ្សារដេប៉ូ១ ខណ្ឌទួលគោក រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2024-12-17', '2025-12-17', '2025-05-27 08:36:18', 0, 'Unknown', NULL, '2025-05-27 15:36:18', '2025-05-27 15:36:18'),
('INV0032', '000330', 'Kang Yawcameron', 'Street lou 5, Sangkat Stueng Mean Chey, Phnom Penh.', 'កង យ៉ាវកាម៉េរ៉ូន', 'ផ្លូវលូ៥ សង្កាត់ស្ទឹងមានជ័យ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '54', 6, 'false', '0', NULL, '0', 0, 54.00, 'Unpaid', NULL, '2024-12-22', '2025-06-22', '2025-05-27 08:36:18', 0, 'Unknown', NULL, '2025-05-27 15:36:18', '2025-05-27 15:36:18'),
('INV0033', '000331', 'Kong Rithy', 'House 12C, Street Betong, Commune Stueng Mean chey 1, District Mean Chey, Phnom Penh.', 'គង់ រិទ្ធី', 'ផ្ទះលេខ ១២ស៊ី ផ្លូវបេតុង សង្កាត់ស្ទឹងមានជ័យ១ ខណ្ឌមានជ័យ រាជធានីភ្នំពេញ។', 'FAST_HOME', '50 Mbps', '200', 6, 'false', '0', NULL, '0', 0, 200.00, 'Unpaid', NULL, '2025-01-09', '2025-07-09', '2025-05-27 08:36:19', 0, 'Unknown', NULL, '2025-05-27 15:36:19', '2025-05-27 15:36:19'),
('INV0034', '000335', 'Ev VouchLak', '# A13, St betong, Prey Sor Village, Sangkat Prey Sor, Khan Dangkor, Phnom Penh.', 'អ៊ីវ វួចឡាក់', 'ផ្ទះលេខ អេ១៣ ផ្លូវបេតុង ភូមិព្រៃស សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ។', 'FAST_HOME', '35 Mbps', '151.2', 12, 'false', '0', NULL, '0', 0, 151.20, 'Unpaid', NULL, '2025-01-19', '2026-01-19', '2025-05-27 08:36:20', 0, 'Unknown', NULL, '2025-05-27 15:36:20', '2025-05-27 15:36:20'),
('INV0035', '000336', 'Nay Chansaneath', '# 125, Street 32BT, Sangkat Boeung Tumpun, Khan Meanchey, Phnom Penh.', 'ណៃ ច័ន្ទសានាថ', 'ផ្ទះលេខ ១២៥ ផ្លូវ ៣២BT សង្កាត់បឹងទំពុន ខណ្ឌមានជ័យ, រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '108', 6, 'false', '0', NULL, '0', 0, 108.00, 'Unpaid', NULL, '2025-05-01', '2025-11-01', '2025-05-27 08:36:20', 0, 'Unknown', NULL, '2025-05-27 15:36:20', '2025-05-27 15:36:20'),
('INV0036', '000350', 'Chheang Bunpiv', '# 21, Street 232, Village 2, Sangkat Boeng Prolit, Khan 7 Makara, Phnom Penh', 'ឈៀង ប៊ុនពីវ', 'ផ្ទះលេខ២១ ផ្លូវ២៣២ ភូមិ២ សង្កាត់បឹងព្រលិត ខណ្ឌ៧មករា រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2025-05-06', '2026-05-06', '2025-05-27 08:36:20', 0, 'Unknown', NULL, '2025-05-27 15:36:20', '2025-05-27 15:36:20'),
('INV0037', '000358', 'Chem Leanghor', 'St, lom , Sangkat Chom Chao khan Porsenchey, Phnom Penh.', 'ចែម លាងហ័រ', 'ផ្លូវលំ សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2025-05-20', '2026-05-20', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0038', '000359', 'Dara Phanit', 'House No number , St BT , Boeung Tamat , SangKat Dangkor , Phnom Penh .', 'តារា ផានិត', 'ផ្លូវបេតុង បឹងតាម៉ាត សង្កាត់ដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '151.2', 12, 'false', '0', NULL, '0', 0, 151.20, 'Unpaid', NULL, '2025-05-03', '2026-05-03', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0039', '000362', 'Vinh Setha', '# H-15, Sai Kang Street, Sangkat Choam Chao, Khan Por Senchey, Phnom Penh.', 'វិញ​ សេថា', 'ផ្ទះលេខ​h-15​ ផ្លូវលេខ​ សៃកង សង្កាត់ ចោមចៅ ខណ្ឌ ពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Home Save', '15 Mbps', '250', 12, 'false', '0', NULL, '0', 0, 250.00, 'Unpaid', NULL, '2025-05-10', '2026-05-10', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0040', '000368', 'Sok Channy', 'Borey Orkide Villa The Royal, House TR16-16, St. Daliya Phnom Penh', 'សុខ ចាន់នី', 'បុរី អ័រគីដេ វីឡា ដឹ រ៉ូយ៉ាល់ ផ្ទះ ធីអរ១៦-១៦ ផ្លូវដាលីយ៉ា ភ្នំពេញ', 'FAST_HOME', '35 Mbps', '248.5', 12, 'false', '0', NULL, '0', 0, 248.50, 'Unpaid', NULL, '2025-05-23', '2026-05-23', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0041', '000379', 'Srou Thearith', 'No. R21 ,St Phle Chhouk (Borey Lorn City ) , Sangkat Chom Chao , Phnom Penh .', 'ស្រ៊ូ​ ធារិទ្ធ', 'ផ្ទះលេខ​ អរ២១ ផ្លូវផ្លែឈូក (​បុរីលនស៊ីធី)​ សង្កាត់ចោមចៅ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2025-05-12', '2026-05-12', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0042', '000385', 'Sath Chanvatana', 'Borey New World Chamkadong, St.03 No.124, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'សាត ច័ន្ទវឌ្ឍនា', 'បុរីពិភពថ្មីចំការដូង ផ្លូវលេខ ០៣ ផ្ទះលេខ ១២៤ សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'SIA', '15 Mbps', '220', 12, 'false', '0', NULL, '0', 0, 220.00, 'Unpaid', NULL, '2025-05-09', '2026-05-09', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0043', '000386', 'Say Punleu', 'Borey New World Chamkadong, St.09 No.288, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'សយ ពន្លឺ', 'បុរីពិភពថ្មី ចំការដូងផ្លូវលេខ ០៩ លេខ ២៨៨ សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'SIA', '15 Mbps', '220', 12, 'false', '0', NULL, '0', 0, 220.00, 'Unpaid', NULL, '2025-05-01', '2026-05-01', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0044', '000387', 'Lay Measroth', 'Borey Hong Long, # 8, Street 6, Sangkat Prey Sar, Khan Dangkor, Phnom Penh', 'ឡាយ មាសរដ្ឋ', 'បុរីហុងឡាយ ផ្ទះលេខ8 ផ្លូវលេខ6 សង្កាត់ព្រៃស ខណ្ឌដង្កោ ភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2025-05-18', '2026-05-18', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0045', '000389', 'Huang Yudong', 'House No. 862, Road 1019, Phoum Toul Pongro, Sang Kat Choum Choa, Khan Mean Chay,Phnom Penh.', 'ហ័ង អ៊ីតុង', 'ផ្ទះលេខ 862 ផ្លូវ 1019 ភូមិ ទួលពង្រ សង្កាត់ ចោមចៅ ខណ្ឌ មានជ័យ រាជធានីភ្នំពេញ', 'SSIA', '20 Mbps', '514', 12, 'false', '0', NULL, '0', 0, 514.00, 'Unpaid', NULL, '2025-05-09', '2026-05-09', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0046', '000409', 'Tep Sengmeng', 'Borey Ratanak House 2 st 8, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'ទេព សេងម៉េង', 'បុរីរតនៈ ផ្ទះលេខ២ ផ្លូវលេខ៨ សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '108', 12, 'true', '50', NULL, '0', 0, 158.00, 'Unpaid', NULL, '2024-08-06', '2025-08-06', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0047', '000418', 'Ith Sophorn', 'Building 29, Floor-7 Mao Tse Toung Blvd, Sangkat Toul Tompong, Phnom Penh', 'អ៊ិត សុភាន់', 'អគារលេខ២៩ ជាន់ទី៧ មហាវិថីម៉ៅសេទុង សង្កាត់ទួលទំពូង រាជធានីភ្នំពេញ', 'FAST_HOME', '50 Mbps', '90', 3, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-05-05', '2025-08-05', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0048', '000505', 'Nhean Sorakmuny', 'Borey Phnom Penh Sok San Plan6, #H5, Sangkat Chaom Chau, Khan Pou Sen Chey, Phnom Penh.', 'ញាណ សុរមន្នី', 'បុរីភ្នំពេញសុខសាន្ត Plan6 #H5 សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ។', 'FAST_HOME', '35 Mbps', '108', 6, 'false', '0', NULL, '0', 0, 108.00, 'Unpaid', NULL, '2025-05-06', '2025-11-06', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0049', '000506', 'Khorn Youra', '#D3, Sangkat Kakab, Khan Pou Senchey, Phnom Penh.', 'ឃន​ យូរ៉ា', '#D3 សង្កាត់កាកាប ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '180', 12, 'true', '50', NULL, '0', 0, 230.00, 'Unpaid', NULL, '2025-05-06', '2026-05-06', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0050', '000622', 'Nob Nalin', 'Borey Phnom Penh Thmey (Takhmao Central Park) #69, St 21, Sangkat Takhmao, Khan Takhmao', 'ណុប ណាលីន', 'បុរីភ្នំពេញថ្មី (Takhmao Central Park) ផ្ទះលេខ ៦៩ ផ្លូវ ២១ សង្កាត់តាខ្មៅ ខណ្ឌតាខ្មៅ​ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2024-10-10', '2025-10-10', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0051', '000635', 'Praing Senghong', 'No. 24, St P01 (Chip Mong Land 50M) , Sangkat Dangkor , Khan Dangkor , Phnom Penh .', 'ប្រាំង សេងហុង', 'ផ្ទះលេខ ២៤, ផ្លូវ P01 (ជីបម៉ុងលែន ៥០​ ម៉ែត្រ) សង្កាត់ដង្កោ ខណ្ឌដង្កោ ភ្នំពេញ', 'FAST_HOME', '35 Mbps', '151.2', 12, 'false', '0', NULL, '0', 0, 151.20, 'Unpaid', NULL, '2024-10-16', '2025-10-16', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0052', '000693', 'Kim Nang', 'SHV-Luxury-Building', 'គីម​ ណាង', 'អគារលុចសារី ក្រុងព្រះសីហនុ', 'SME', '50 Mbps', '560', 3, 'false', '0', NULL, '0', 0, 560.00, 'Unpaid', NULL, '2025-04-18', '2025-07-18', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0053', '000727', 'Hem Kuntheam', 'Borey Phnom Penh Thmey ( Radiant Park) # S09 , st sunflower Phum Prokar, Sangkat Prey Sa, Khan Dangkor, Phnom Penh.', 'ហែម​ គន្ធាម', 'បុរីភ្នំពេញថ្មី (សួនច្បាររស្មី) ផ្ទះលេខ S09 ផ្លូវផ្កាឈូករ័ត្ន ភូមិប្រការ សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2025-05-24', '2026-05-24', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0054', '000761', 'Mol Chandollar', 'Borey Phnom Penh Thmey (Takhmao Central Park) #38, St A, sangkat takhmao, khan takhmao', 'ម៉ុល ច័ន្ទដុល្លា', 'បុរីភ្នំពេញថ្មី (តាខ្មៅ Central Park) ផ្ទះលេខ៣៨ ផ្លូវA សង្កាត់តាខ្មៅ ខណ្ឌតាខ្មៅ', 'FAST_HOME', '35 Mbps', '216', 12, 'true', '35', NULL, '0', 0, 251.00, 'Unpaid', NULL, '2025-05-12', '2026-05-12', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0055', '000804', 'Pech Somanet', '72I, Street Betong, Phum Trapeang Thloeng, Sangkat Chaom Chau, Khan Pou senchey Phnom Penh.', 'ពេជ សូម៉ានេត', 'ផ្ទះលេខ 72I ផ្លូវបេតុង ភូមិត្រពាំងថ្លឹង សង្កាត់ចោមចៅ ខណ្ឌពោធិ៍សែនជ័យ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '151.2', 12, 'true', '35', NULL, '0', 0, 186.20, 'Unpaid', NULL, '2025-05-13', '2026-05-13', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0056', '000805', 'Hout Sophearin', 'Borey Penghout Beoung Snor, #658 ,Street Clasteur, Sangkat Nirouth, Khan Chba Ampov,  Phnom Penh.', 'ហួត សុភារិន', 'បុរីប៉េងហួតបឹងស្នោរ ផ្ទះលេខ៦៥៨ ផ្លូវលំ សង្កាត់និរោធ ខណ្ឌច្បារអំពៅ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '108', 12, 'false', '0', NULL, '0', 0, 108.00, 'Unpaid', NULL, '2025-05-16', '2026-05-16', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0057', '000832', 'Kim Sinat', 'Borey Phnom Penh Thmey ( Radiant Park) # G31 , St Golden Champa Phum Prokar, Sangkat Prey Sa, Khan Dangkor, Phnom Penh.', 'គីម ស៊ីណាត', 'បុរីភ្នំពេញថ្មី (សួនច្បាររស្មី) ផ្ទះលេខ G31 ផ្លូវមាសចំប៉ា ភូមិប្រការ សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '50 Mbps', '360', 12, 'false', '0', NULL, '0', 0, 360.00, 'Unpaid', NULL, '2025-05-19', '2026-05-19', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0058', '000839', 'Leng Kok', 'Borey Phnom Penh Thmey ( Radiant Park) # S05 , st sunflower Phum Prokar, Sangkat Prey Sa, Khan Dangkor, Phnom Penh.', 'ឡេង កុក', 'បុរីភ្នំពេញថ្មី (សួនរស្មី) ផ្ទះលេខ S05 ផ្លូវផ្កាឈូករ័ត្ន ភូមិប្រការ សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'false', '0', NULL, '0', 0, 216.00, 'Unpaid', NULL, '2025-05-10', '2026-05-10', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0059', '000876', 'Wang Jia', 'Borey Peng Huoth The Star Platinum Athina, #A10, Street 16, Sangkat Nirouth, Khan Chbar Ampov, Phnom Penh.', 'វ៉ាង ជា', 'បុរី ប៉េងហួត ដឹស្តា ផ្លាទីនីម អាធីណា ផ្ទះលេខ អេ១០ ផ្លូវលេខ ១៦ សង្កាត់និរោធ ខណ្ឌច្បារអំពៅ រាជធានីភ្នំពេញ', 'US IP', '10 Mbps', '360', 1, 'false', '0', NULL, '0', 0, 360.00, 'Unpaid', NULL, '2025-05-26', '2025-06-26', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0060', '000877', 'Aoeng Dalin', 'Borey Piphup Thmey Kour Srov II,House 46, Street 09B,Sangkat Preaek Kampues, Khan Dangkao, Phnom Penh', 'អ៊ឹង ដាលីន', 'បុរីពិភពថ្មីកួរស្រូវ២ ផ្ទះលេខ៤៦ ផ្លូវលេខ០៩ប៊ី សង្កាត់ព្រែកកំពឹស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'Home Save', '10 Mbps', '90', 12, 'false', '0', NULL, '0', 0, 90.00, 'Unpaid', NULL, '2025-03-07', '2026-03-07', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0061', '000897', 'Sam Choungveng', 'House No. 4, Street 161, Sangkat Orussey 2, Khan 7 Makara, Phnom Penh.', 'សំ ឈូងវេង', 'ផ្ទះលេខ៤ ផ្លូវលេខ១៦១ សង្កាត់អូរឬស្សី២ ខណ្ឌ៧មករា រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '75.6', 6, 'true', '35', NULL, '0', 0, 110.60, 'Unpaid', NULL, '2025-05-18', '2025-11-18', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0062', '000898', 'Nou Bou', 'Borey Morakot SH, House 21,22 St 8m, Sangkat Prey Sar, Khan Dangkor, Phnom Penh.', 'នូ ប៊ូ', 'បុរីមរកត SH ផ្ទះ 21,22 ផ្លូវ 8m សង្កាត់ព្រៃស ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '151.2', 12, 'false', '0', NULL, '0', 0, 151.20, 'Unpaid', NULL, '2025-03-20', '2026-03-20', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0063', '000899', 'Put Thearak', '#25E, St 136, Sangkat Phsar Thmey 3, Khan Doun Penh, Phnom Penh.', 'ពុធ ធារៈ', 'ផ្ទះលេខ 25E ផ្លូវ 136 សង្កាត់ផ្សារថ្មី 3 ខណ្ឌដូនពេញ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '216', 12, 'true', '50', NULL, '0', 0, 266.00, 'Unpaid', NULL, '2025-03-28', '2026-03-28', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0064', '000998', 'Thol Mary', 'No. B10 , St lom, Borey Try Kim, Sangkat Dangkao, Khan Dangkao, Phnom Penh', 'ថុល ម៉ារី', 'ផ្ទះលេខ B10 ផ្លូវលំ បុរីទ្រីគីម សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '151.20', 12, 'false', '0', NULL, '0', 0, 151.20, 'Unpaid', NULL, '2025-05-26', '2026-05-26', '2025-05-27 08:36:21', 0, 'Unknown', NULL, '2025-05-27 15:36:21', '2025-05-27 15:36:21'),
('INV0065', '00001', 'SAMNANG SE', 'OCIC', 'SAMNANG SE', 'ALC', 'Home Save', '10 Mbps', '100', 1, 'false', '50', NULL, '1', 1, 101.00, 'Unpaid', NULL, '2025-05-29', '2025-06-29', '2025-05-27 08:37:01', 0, 'Unknown', NULL, '2025-05-27 15:37:01', '2025-05-27 15:37:01'),
('INV0066', '000324', 'Nget Tityaridh', '#14, st 4A, Borey Piphup Thmey Chamka Doung I, Phoum Sambour, Sangkat Dang Kor, Khan Dangkor, Phnom Penh', 'ង៉ែត ទិត្យារិទ្ធ', 'ផ្ទះលេខ ១៤ ផ្លូវ ៤A បុរីពិភពថ្មីចំការដូង ភូមិសំបួរ សង្កាត់ដង្កោ ខណ្ឌដង្កោ រាជធានីភ្នំពេញ', 'FAST_HOME', '35 Mbps', '54', 6, 'false', '0', NULL, '0', 0, 54.00, 'Unpaid', NULL, '2025-06-06', '2025-12-06', '2025-05-30 01:00:01', 0, 'Unknown', NULL, '2025-05-30 08:00:01', '2025-05-30 08:00:01'),
('INV0067', '001001', 'B3-1F-24 小时早餐店', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:02', 0, 'Unknown', NULL, '2025-06-03 08:00:02', '2025-06-03 08:00:02'),
('INV0068', '001002', 'C5-B栋-1楼-红酒小炒', 'Kampot', '', 'កំពត', 'DIA', '5 Mbps', '75.00', 1, 'false', '0', NULL, '0', 0, 75.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:02', 0, 'Unknown', NULL, '2025-06-03 08:00:02', '2025-06-03 08:00:02'),
('INV0069', '001003', 'CY-B10-2F-R209', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:03', 0, 'Unknown', NULL, '2025-06-03 08:00:03', '2025-06-03 08:00:03'),
('INV0070', '001005', 'CY-B1-3F-R306', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:03', 0, 'Unknown', NULL, '2025-06-03 08:00:03', '2025-06-03 08:00:03'),
('INV0071', '001007', 'CY-B1-4F-R405', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-03', '2025-07-03', '2025-06-03 01:00:03', 0, 'Unknown', NULL, '2025-06-03 08:00:03', '2025-06-03 08:00:03'),
('INV0072', '001008', 'CY-B1-6F-R603', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:04', 0, 'Unknown', NULL, '2025-06-03 08:00:04', '2025-06-03 08:00:04'),
('INV0073', '001010', 'CY-B1-6F-R615', 'Kampot', '', 'កំពត', 'SME', '5 Mbps', '75.00', 1, 'false', '0', NULL, '0', 0, 75.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:04', 0, 'Unknown', NULL, '2025-06-03 08:00:04', '2025-06-03 08:00:04'),
('INV0074', '001013', 'CY-B1-6F-R626', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:05', 0, 'Unknown', NULL, '2025-06-03 08:00:05', '2025-06-03 08:00:05'),
('INV0075', '001014', 'CY-B1-WENWEN', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '70.00', 1, 'false', '0', NULL, '0', 0, 70.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:05', 0, 'Unknown', NULL, '2025-06-03 08:00:05', '2025-06-03 08:00:05'),
('INV0076', '001016', 'CY-B3-Gaming', 'Kampot', '', 'កំពត', 'SME', '30 Mbps', '210.00', 1, 'false', '0', NULL, '0', 0, 210.00, 'Unpaid', NULL, '2025-06-05', '2025-07-05', '2025-06-03 01:00:05', 0, 'Unknown', NULL, '2025-06-03 08:00:05', '2025-06-03 08:00:05'),
('INV0077', '001017', 'CY-B3-Gaming-2', 'Kampot', '', 'កំពត', 'DIA', '30 Mbps', '450.00', 1, 'false', '0', NULL, '0', 0, 450.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:05', 0, 'Unknown', NULL, '2025-06-03 08:00:05', '2025-06-03 08:00:05'),
('INV0078', '001018', 'CY-B3-Massage', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '70.00', 1, 'false', '0', NULL, '0', 0, 70.00, 'Unpaid', NULL, '2025-06-05', '2025-07-05', '2025-06-03 01:00:06', 0, 'Unknown', NULL, '2025-06-03 08:00:06', '2025-06-03 08:00:06'),
('INV0079', '001020', 'CY-B7-2F-R209', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-08', '2025-07-08', '2025-06-03 01:00:06', 0, 'Unknown', NULL, '2025-06-03 08:00:06', '2025-06-03 08:00:06'),
('INV0080', '001021', 'CY-B7-2F-R210', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-10', '2025-07-10', '2025-06-03 01:00:06', 0, 'Unknown', NULL, '2025-06-03 08:00:06', '2025-06-03 08:00:06'),
('INV0081', '001023', 'CY-B7-2F-R216', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:06', 0, 'Unknown', NULL, '2025-06-03 08:00:06', '2025-06-03 08:00:06'),
('INV0082', '001024', 'CY-B7-3F-309', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:06', 0, 'Unknown', NULL, '2025-06-03 08:00:06', '2025-06-03 08:00:06'),
('INV0083', '001025', 'CY-B7-4F-410', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:07', 0, 'Unknown', NULL, '2025-06-03 08:00:07', '2025-06-03 08:00:07'),
('INV0084', '001026', 'CY-B7-6F-R618', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:07', 0, 'Unknown', NULL, '2025-06-03 08:00:07', '2025-06-03 08:00:07'),
('INV0085', '001029', 'CY-B7-7F-R720', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:07', 0, 'Unknown', NULL, '2025-06-03 08:00:07', '2025-06-03 08:00:07'),
('INV0086', '001030', 'CY-B7-8F-810', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:08', 0, 'Unknown', NULL, '2025-06-03 08:00:08', '2025-06-03 08:00:08'),
('INV0087', '001031', 'CY-B7-8F-812', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:08', 0, 'Unknown', NULL, '2025-06-03 08:00:08', '2025-06-03 08:00:08'),
('INV0088', '001032', 'CY-B7-8F-817', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:08', 0, 'Unknown', NULL, '2025-06-03 08:00:08', '2025-06-03 08:00:08'),
('INV0089', '001033', 'CY-B7-8F-817-2', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:08', 0, 'Unknown', NULL, '2025-06-03 08:00:08', '2025-06-03 08:00:08'),
('INV0090', '001036', 'CY-B9-3F-320', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-05', '2025-07-05', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0091', '001037', 'CY-B9-3F-328', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0092', '001038', 'CY-B9-3F-337', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0093', '001039', 'CY-B9-3F-R309', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0094', '001041', 'CY-B9-4F-3A05', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-06', '2025-07-06', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0095', '001042', 'CY-B9-4F-3A07', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0096', '001043', 'CY-B9-4F-3A09', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0097', '001044', 'CY-B9-4F-3A11', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-08', '2025-07-08', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0098', '001045', 'CY-B9-4F-3A13', 'Kampot', '', 'កំពត', 'SME', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0099', '001046', 'CY-B9-4F-3A15', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0100', '001047', 'CY-B9-4F-3A16', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-06', '2025-07-06', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0101', '001049', 'CY-B9-4F-3A20', 'Kampot', '', 'កំពត', 'SME', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0102', '001050', 'CY-B9-4F-3A25', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0103', '001051', 'CY-B9-4F-3A27', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0104', '001052', 'CY-B9-5F-503', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-09', '2025-07-09', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0105', '001053', 'CY-B9-5F-507', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0106', '001054', 'CY-B9-5F-509', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0107', '001055', 'CY-B9-5F-512', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Paid', '2025-06-06', '2025-06-01', '2025-07-01', '2025-06-06 03:59:55', 1, 'Unknown', 'Admin', '2025-06-03 08:00:09', '2025-06-06 10:59:55'),
('INV0108', '001056', 'CY-B9-5F-513', 'Kampot', '', 'កំពត', 'DIA', '30 Mbps', '450.00', 1, 'false', '0', NULL, '0', 0, 450.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0109', '001057', 'CY-B9-5F-515', 'Kampot', '', 'កំពត', 'DIA', '30 Mbps', '450.00', 1, 'false', '0', NULL, '0', 0, 450.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0110', '001059', 'CY-B9-5F-523', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-04', '2025-07-04', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0111', '001061', 'CY-B9-5F-527', 'Kampot', '', 'កំពត', 'SME', '20 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0112', '001062', 'CY-B9-5F-529', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0113', '001063', 'CY-B9-5F-535', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0114', '001064', 'CY-B9-5F-537', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-02', '2025-07-02', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0115', '001067', 'CY-B9-6F-613', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0116', '001068', 'CY-B9-6F-619', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0117', '001069', 'CY-B9-6F-620', 'Kampot', '', 'កំពត', 'DIA', '30 Mbps', '450.00', 1, 'false', '0', NULL, '0', 0, 450.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0118', '001070', 'CY-B9-6F-622', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0119', '001071', 'CY-B9-6F-637', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:09', 0, 'Unknown', NULL, '2025-06-03 08:00:09', '2025-06-03 08:00:09'),
('INV0120', '001073', 'CY-B9-7F-721', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:10', 0, 'Unknown', NULL, '2025-06-03 08:00:10', '2025-06-03 08:00:10'),
('INV0121', '001074', 'CY-B9-7F-722', 'Kampot', '', 'កំពត', 'DIA', '30 Mbps', '450.00', 1, 'false', '0', NULL, '0', 0, 450.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:10', 0, 'Unknown', NULL, '2025-06-03 08:00:10', '2025-06-03 08:00:10'),
('INV0122', '001075', 'CY-B9-R702', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:10', 0, 'Unknown', NULL, '2025-06-03 08:00:10', '2025-06-03 08:00:10'),
('INV0123', '001076', 'CY-C5-1F-B-Chaoxian-Restaurant', 'Kampot', '', 'កំពត', 'SME', '5 Mbps', '75.00', 1, 'false', '0', NULL, '0', 0, 75.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:10', 0, 'Unknown', NULL, '2025-06-03 08:00:10', '2025-06-03 08:00:10'),
('INV0124', '001077', 'CY-C5-1F-B-Hospital-诊所', 'Kampot', '', 'កំពត', 'SME', '5 Mbps', '75.00', 1, 'false', '0', NULL, '0', 0, 75.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:10', 0, 'Unknown', NULL, '2025-06-03 08:00:10', '2025-06-03 08:00:10'),
('INV0125', '001078', 'B7-7F-R718', 'Kampot', '', 'កំពត', 'SME', '20 Mbps', '474.19', 1, 'false', '0', NULL, '0', 0, 474.19, 'Unpaid', NULL, '2025-05-14', '2025-06-14', '2025-06-03 01:00:10', 0, 'Unknown', NULL, '2025-06-03 08:00:10', '2025-06-03 08:00:10'),
('INV0126', '001079', 'CY-B9-4F-3A21', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps ', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-01', '2025-07-01', '2025-06-03 01:00:10', 0, 'Unknown', NULL, '2025-06-03 08:00:10', '2025-06-03 08:00:10'),
('INV0127', '001034', 'CY-B8B-Container-K02', 'Kampot', '', 'កំពត', 'SME', '20 Mbps', '140.00', 1, 'false', '0', NULL, '0', 0, 140.00, 'Unpaid', NULL, '2025-06-11', '2025-07-11', '2025-06-04 01:00:01', 0, 'Unknown', NULL, '2025-06-04 08:00:01', '2025-06-04 08:00:01'),
('INV0128', '001035', 'CY-B8-Hospital', 'Kampot', '', 'កំពត', 'SME', '5 Mbps', '35.00', 1, 'false', '0', NULL, '0', 0, 35.00, 'Unpaid', NULL, '2025-06-11', '2025-07-11', '2025-06-04 01:00:01', 0, 'Unknown', NULL, '2025-06-04 08:00:01', '2025-06-04 08:00:01'),
('INV0129', '001048', 'CY-B9-4F-3A18', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-11', '2025-07-11', '2025-06-04 01:00:02', 0, 'Unknown', NULL, '2025-06-04 08:00:02', '2025-06-04 08:00:02'),
('INV0130', '001022', 'CY-B7-2F-R211', 'Kampot', '', 'កំពត', 'DIA', '20 Mbps', '300.00', 1, 'false', '0', NULL, '0', 0, 300.00, 'Unpaid', NULL, '2025-06-12', '2025-07-12', '2025-06-05 01:00:02', 0, 'Unknown', NULL, '2025-06-05 08:00:02', '2025-06-05 08:00:02'),
('INV0131', '001066', 'CY-B9-6F-606', 'Kampot', '', 'កំពត', 'DIA', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-12', '2025-07-12', '2025-06-05 01:00:02', 0, 'Unknown', NULL, '2025-06-05 08:00:02', '2025-06-05 08:00:02'),
('INV0132', 'Test001', 'Vorthanak', 'Phnom Penh', 'Vorthanak', 'Phnom Penh', 'Home Save', '50 Mbps', '100', 3, 'false', '0', 1, '0.00', 1, 100.00, 'Unpaid', NULL, '2025-06-05', '2025-09-05', '2025-06-05 04:08:33', 0, 'Admin', NULL, '2025-06-05 11:08:33', '2025-06-05 11:08:33'),
('INV0133', '001015', 'CY-B3-78win', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '70.00', 1, 'false', '0', NULL, '0', 0, 70.00, 'Unpaid', NULL, '2025-06-13', '2025-07-13', '2025-06-06 01:00:01', 0, 'Unknown', NULL, '2025-06-06 08:00:01', '2025-06-06 08:00:01'),
('INV0134', '001065', 'CY-B9-5F-R519', 'Kampot', '', 'កំពត', 'SME', '10 Mbps', '150.00', 1, 'false', '0', NULL, '0', 0, 150.00, 'Unpaid', NULL, '2025-06-13', '2025-07-13', '2025-06-06 01:00:01', 0, 'Unknown', NULL, '2025-06-06 08:00:01', '2025-06-06 08:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(100, '0001_01_01_000000_create_users_table', 11),
(101, '2024_08_07_044826_create_permission_tables', 11),
(141, '2025_03_18_110258_create_customers_info_table', 12),
(142, '2025_03_21_103132_create_invoice_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 3),
(1, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 15);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'create role', 'web', '2024-08-06 18:40:07', '2024-08-06 18:40:07'),
(3, 'view role', 'web', '2024-08-06 18:40:12', '2024-08-06 18:40:12'),
(4, 'update role', 'web', '2024-08-06 18:40:23', '2024-08-06 19:51:57'),
(5, 'delete role', 'web', '2024-08-06 18:40:29', '2024-08-06 18:40:29'),
(8, 'create permission', 'web', '2024-08-07 14:03:45', '2024-08-07 14:03:45'),
(9, 'view permission', 'web', '2024-08-07 14:03:54', '2024-08-07 14:03:54'),
(10, 'update permission', 'web', '2024-08-07 14:04:02', '2024-08-07 14:04:02'),
(11, 'delete permission', 'web', '2024-08-07 14:04:08', '2024-08-07 14:04:15'),
(12, 'edit role', 'web', '2024-08-11 17:48:17', '2024-08-11 17:48:17'),
(13, 'edit permission', 'web', '2024-08-11 17:48:35', '2024-08-11 17:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `request_changes`
--

CREATE TABLE `request_changes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_type` enum('Upgrade','Downgrade','Deactivate','Reactivate','Termination','Relocation','Change Ip Address') DEFAULT NULL,
  `customer_id` varchar(100) NOT NULL,
  `old_tariff` varchar(255) DEFAULT NULL,
  `new_tariff` varchar(255) DEFAULT NULL,
  `old_internet_fee` decimal(8,2) DEFAULT NULL,
  `new_internet_fee` decimal(8,2) DEFAULT NULL,
  `old_bandwidth` varchar(100) DEFAULT NULL,
  `new_bandwidth` varchar(100) DEFAULT NULL,
  `old_address` varchar(255) DEFAULT NULL,
  `old_alt_address` varchar(255) DEFAULT NULL,
  `new_address` varchar(255) DEFAULT NULL,
  `new_alt_address` varchar(255) DEFAULT NULL,
  `old_ip_address` varchar(45) DEFAULT NULL,
  `new_ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_changes`
--

INSERT INTO `request_changes` (`id`, `request_type`, `customer_id`, `old_tariff`, `new_tariff`, `old_internet_fee`, `new_internet_fee`, `old_bandwidth`, `new_bandwidth`, `old_address`, `old_alt_address`, `new_address`, `new_alt_address`, `old_ip_address`, `new_ip_address`, `created_at`, `created_by`) VALUES
(1, 'Change Ip Address', '00001', 'Home Save', NULL, 300.00, NULL, '50 Mbps', NULL, 'Kampot', 'កំពត', NULL, NULL, '123.123.123', '321.321.321', '2025-06-03 09:35:16', 'Vorthanak'),
(2, 'Change Ip Address', '00001', 'Home Save', NULL, 300.00, NULL, '50 Mbps', NULL, 'Kampot', 'កំពត', NULL, NULL, '321.321.321', '123.123.123', '2025-06-04 07:48:23', 'Admin'),
(3, 'Deactivate', 'Test002', 'Home Save', NULL, 50.00, NULL, '30 Mbps', NULL, 'Phnom Penh', 'Phnom Penh', NULL, NULL, NULL, NULL, '2025-06-05 09:21:54', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-08-07 12:41:38', '2024-08-11 19:21:38'),
(2, 'User', 'web', '2024-08-07 12:45:52', '2025-03-10 21:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 1),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0AjBG31b2Evx4lGa2km7yzNUJDEJuo9zTdHw795T', NULL, '103.161.173.219', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7; rv:127.0) Gecko/20100101 Firefox/127.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiem9vekVVWDRybkFBOTdBTEpXaFhJVjF5NG5kZE1YcExQU3JaSTcxbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly93d3cuZmFzdG9uZWlzcC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749193969),
('44IGrmD6rwSMWrULrhWSWsOK53tgdDnpRYME5tNE', 6, '103.139.16.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZDdlMm1SZ0pScVFtWU42RURLMlZvc1ZseFBUQjF5ZWRTSk5JbGR4MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vZmFzdG9uZWlzcC5jb20vYWNjb3VudGluZy91cGNvbWluZy1zdGF0ZW1lbnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1749203432),
('5XNTyjiLiFifKemhP3D2vvtrUW4cxFTXMWtokl1C', NULL, '49.232.151.112', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM1h3VkN4RHNrMWlkOWNSZHV6UWsxU0F5NlhYQ010YktNeUxkekx0OSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly93d3cuZmFzdG9uZWlzcC5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749195237),
('bOxCpzGu0HgOe0bRK5bjxbIO1f34iWyofcD5EWKF', NULL, '167.94.138.62', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUklybHRnczZ6UWVtY29zNlpyM0NpVXV6eExXZE13QW5GT1dCOW5SViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWFpbC5mYXN0b25laXNwLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749199451),
('nKYdbWOK9dwWKiA631B9I4vyMz3Zglp3GVAtXYGl', NULL, '167.94.138.62', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3JKYk5jSmdWSEl4aU1MSTJSTE5pd1B4dUdOUDFLemxpWFNGaVpseSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vbWFpbC5mYXN0b25laXNwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749199398),
('pbyQnnfkksjwm0zzjzYkJK9FwEjryNyjn6EAVkUh', NULL, '18.195.122.215', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:84.0) Gecko/20100101 Firefox/84.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDVGUU9sNDQwajQyOUEzR2hZZXpXM1N2N2ZkU09wQWFQUzQ1YkgxaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9mYXN0b25laXNwLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749200880),
('zmS48fMo8D6HquFyyt0kRuwSHfnqKNqAU0bh7aZf', NULL, '49.232.151.112', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0dqbGtlTkRkQTVMVERhQ1ZYTDB6M1RwZnhpWnFXSmRNdko5bWpncSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly93d3cuZmFzdG9uZWlzcC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1749195230),
('ZwCc19nOzVzKNzyNKtB2G4UjNqshXaDc7ADnok2F', NULL, '18.195.122.215', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:84.0) Gecko/20100101 Firefox/84.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS29xRzZYS0FJMzJWUERWS1I1aXFhMFhpb09CalpkcFczV0ttZ3pjTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9mYXN0b25laXNwLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1749200879);

-- --------------------------------------------------------

--
-- Table structure for table `tariffs`
--

CREATE TABLE `tariffs` (
  `tariff_id` bigint(20) UNSIGNED NOT NULL,
  `tariff_name` varchar(255) NOT NULL,
  `installation_fee` decimal(8,2) DEFAULT NULL,
  `internet_fee` decimal(8,2) DEFAULT NULL,
  `dplc_fee` decimal(8,2) DEFAULT NULL,
  `iplc_fee` decimal(8,2) DEFAULT NULL,
  `bill_cycle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tariffs`
--

INSERT INTO `tariffs` (`tariff_id`, `tariff_name`, `installation_fee`, `internet_fee`, `dplc_fee`, `iplc_fee`, `bill_cycle`, `created_at`, `updated_at`) VALUES
(1, 'SSIA 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(2, 'SSIA 20Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(3, 'SSIA 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(4, 'SSIA 50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(5, 'SSIA 100Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(6, 'SME 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(7, 'SME 15Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(8, 'SME 20Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(9, 'SME 25Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(10, 'SME 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(11, 'SME 40Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(12, 'SME 50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(13, 'SME 60Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(14, 'SME 70Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(15, 'SME 80Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(16, 'SME 100Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(17, 'Fiber Entreprise 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(18, 'Fiber Entreprise 50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(19, 'Fiber Entreprise 100Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(20, 'Fiber Entreprise 200Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(21, 'Home Internet Package 5Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(22, 'Dedicated Internet Access', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(23, 'Home Internet Package 50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(24, 'Dedicated Internet Access 40Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(25, 'Dedicate Internet Access 5Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(26, 'Dedicated Internet Access 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(27, 'Dedicate Internet Access 15Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(28, 'Dedicated Internet Access 20Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(29, 'Dedicate Internet Access 50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(30, 'Dedicated Internet Access 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(31, 'Netbiz 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(32, 'Dedicated Internet Access 100Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(33, 'SSIA 15Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(34, 'SIA 15Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(35, 'SIA 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(36, 'SIA 20Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(37, 'SIA 40Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(38, 'Sharing Internet Access 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(39, 'Super Save Internet Access 20Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(40, 'Super Save Internet Access 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(41, 'Dedicated Internet Access 60Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(42, 'Business Internet Package Speed 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(43, 'DIA-Business 60Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(44, 'Hong Kong DIA Service 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(45, 'General DIA Service Speed 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(46, 'DIA-Mix China 25Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(47, 'DIA 50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(48, 'DIA 60Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(49, 'DIA 30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(50, 'DIA 80Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(51, 'DIA 20Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(52, 'SIA-40Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(53, 'SIA-30Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(54, 'Home Save-50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(55, 'Home Save-10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(56, 'Home Save-15Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(57, 'L2MPLS 1Gbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(58, 'DIA 70Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(59, 'Dedicated Internet Access 250Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(60, 'Home Save-20Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(61, 'DIA 10Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(62, 'DIA 15Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(63, 'DIA 5Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(64, 'FAST_HOME 35Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(65, 'FAST_HOME 50Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14'),
(66, 'FAST_HOME 100Mbps', NULL, NULL, NULL, NULL, '', '2025-03-11 12:04:14', '2025-03-11 12:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Laytong', 'tong@gmail.com', NULL, '$2y$12$wvTwZISuDRM.wUqPZU5yqOmQr.N9IAnJuSXbBfLJS8wTefX69R0ES', NULL, '2024-08-07 18:06:59', '2025-02-10 20:03:59'),
(4, 'Lihor', 'lihor@gmail.com', NULL, '$2y$12$6njjPx9tzs7ks22yNABXZuwGJMY8Cxyml2MkpkHLEhDWx90lOh0ce', NULL, '2024-08-07 18:12:42', '2024-08-07 18:12:42'),
(6, 'Vorthanak', 'vannakchh1@gmail.com', NULL, '$2y$12$ca8Zzx2QKcbVONnK4oVbLOYqWW06yNhIUyhqkrsNQAfS1QQPcl90.', NULL, '2024-08-07 18:20:21', '2024-08-08 13:23:43'),
(15, 'Admin', 'admin@fastone.com', NULL, '$2y$12$sLG/HsrKkEug32AdYIABKuzJd0GfGegJCyA6H6vuuifsuMQbOD7fy', '8qZHHKojerAjnGvoP6HhGwipeyV7hzub0EFNMEysWhULBKgPmSbtfuBPQNbB', '2025-05-02 03:40:45', '2025-05-26 10:00:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers_info`
--
ALTER TABLE `customers_info`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `request_changes`
--
ALTER TABLE `request_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_request_changes_customer` (`customer_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`tariff_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `request_changes`
--
ALTER TABLE `request_changes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `tariff_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers_info` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `request_changes`
--
ALTER TABLE `request_changes`
  ADD CONSTRAINT `fk_request_changes_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers_info` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
