-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2021 at 04:36 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messenger`
--

-- --------------------------------------------------------

--
-- Table structure for table `authentication`
--

CREATE TABLE `authentication` (
  `auth_id` int(11) NOT NULL,
  `auth_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_verified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authentication`
--

INSERT INTO `authentication` (`auth_id`, `auth_email`, `password`, `created_at`, `is_verified`) VALUES
(23, 'M0JrWmp2VmUvdVBCVmR1ckFJa1lPczJ5RVJ2YmxHVm5veWV1SnZhSUZmWT0=', '$2y$10$73V4TeW9dZWWnw3UTxdB4eJUjQs0fE5B8g1ojKsHa5coLhZwU4y4W', '2021-03-11 16:39:44', 1),
(24, 'T3FMRlZKUVRHdzFpOWcwNDZWdDNIVEF0NmFmTmZoMjM5RGd4U1dzbmd4OD0=', '$2y$10$meHdCfpvEclrTpaykf5tuOd4QnJhsv2uqf74GBkHUlV9uvfIMz7Si', '2021-03-11 16:41:25', 1),
(25, 'SldRdXcwdDFEL2pkN05kQnNjYlNYTlV5M2tWL09rclNNL0U3WXY3b1hjZz0=', '$2y$10$cY.pPl6FlJc29jF8sntUXes5KrrOc0jXxXX9zE1QxqLogDLVQlfY2', '2021-03-11 17:07:10', 1),
(26, 'aG15STdTeVZYS0RaelRwcUliR1l5dz09', '$2y$10$FhUm4jDRLt687JeJQyRrwOZKszNiV2IIjQOer7eMFIOeW/sVIJ6Ne', '2021-03-13 19:59:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `details_id` int(11) NOT NULL,
  `auth_id` varchar(255) NOT NULL,
  `auth_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `mobile_num` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `personality` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`details_id`, `auth_id`, `auth_name`, `full_name`, `gender`, `mobile_num`, `birthday`, `address`, `personality`, `profile_pic`, `status`) VALUES
(23, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'NkdlRFpQTGdObmpqUVVKQ1dJZDhnUT09', 'Shankar Lamichhane', NULL, NULL, NULL, NULL, NULL, '/assets/images/avtar/d5e9bf516621466af429.JPG', NULL),
(24, '4d134bc072212ace2df385dae143139da74ec0ef', 'MnJqSWJ1RVNWS2ZBTnBKKzZXNmFvUT09', 'Agya Pathak', NULL, NULL, NULL, NULL, NULL, '/assets/images/avtar/f397c37f2c749c802e6b.JPG', NULL),
(25, 'f6e1126cedebf23e1463aee73f9df08783640400', 'QjVibUNmc3pUUElKeU5lcHNZMm1SUT09', 'Sudip Bhandari', NULL, NULL, NULL, NULL, NULL, '/assets/images/avtar/c01eb85e1c744368e2c3.jpg', NULL),
(26, '887309d048beef83ad3eabf2a79a64a389ab1c9f', 'N25uQytxSDZOOStZS2RMM21QQit4UT09', 'Kedar Subedi', NULL, NULL, NULL, NULL, NULL, '/assets/images/avtar/avatar.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `sent_by` varchar(255) NOT NULL,
  `sent_to` varchar(255) NOT NULL,
  `message` longtext DEFAULT NULL,
  `sticker` varchar(255) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `status` int(2) DEFAULT 0,
  `time` time DEFAULT current_timestamp(),
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `sent_by`, `sent_to`, `message`, `sticker`, `media`, `status`, `time`, `date`) VALUES
(278, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', '4d134bc072212ace2df385dae143139da74ec0ef', 'ZTBuSGxneWp5Wnl5QUJYZnZ4WDh3UT09', NULL, '', 0, '16:56:24', '2021-03-11'),
(279, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'f6e1126cedebf23e1463aee73f9df08783640400', 'YVpOM3NpNFRGdHBiMS92K1BvRGRwdz09', NULL, '', 0, '18:33:20', '2021-03-11'),
(280, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'f6e1126cedebf23e1463aee73f9df08783640400', 'YWhBK2ROTlVQUlBVdkE5bHZLbkR0QT09', NULL, '', 0, '18:33:31', '2021-03-11'),
(281, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'f6e1126cedebf23e1463aee73f9df08783640400', 'L2hwL1JkTldDbFBVWC90VWw2VVZ1a1pHUDlYVGFhTlRCamRDcGxtU1libTZNWlA3bkFtYUEyNFJCajBxYnIweDFRZ2kzWXhnbXJjYUR4WGUvOXAvUkJaY1RVZ0NmREc5blNDNW12ZVJ1RHVXZW5mMmxmRkhMamV6TExqQWdwOTdnVmR2OXVpUk9CbmJUYWswRUVnRFk3ZUdlckFCRHJFRnI2ckxvWVk5RlpRTEN3N0ZXUThLT2cvUGFnbUpxNnNNMURqaWVESm1kcndUZXlmQlg4Yml5SDhFZmVkTmxJZjRYd1VxcGZRNmhBaDhVMUIzcWh5cVdKQitNNUVNOHlrMlFhSnFSbnpzNW5BQThmUC9pWGM1aUo0SHBwQ096djFSR2JJS0tJNTdtTk9hYmc3QzlPbjg1YWJzazZ5OW9nakNOU1NEUS9COGVNM1JwVFIyUko1SFA0M3oxcE5oeFhlckdKT01ULzJzaDk4RmJPbWtlUCtUQ2NSN28rTXRQOCs3My9BLzVsYU9ia3VUK2xXRXlwSkNJQ2RJMExpY05oQUlFekhuenpLdUluTFY3VHduT2lKckp5ZmRrSElBV1d3ZXlCaFhhZTBoN0hJaG0wUVd1MmNvMllLVE1TVi92SFNIV29SRXNZR3ZPTGE3UzRwZUxnRXlCSkZqVnBiYTNFTDZZcEZiUkFpY1JYY1BudmlSMGkvVEdVRjFSNWIwMVl2K2dZT3BvMGIyZGJraTFqK0pXM2h3WlBGUWJFRG9HWXEvV01UTTFPTzBHbjV0cEFETzYyY3ZxWEZEZkxPTUsydWhFSFZwbVRUWWo4bTFJWlY5WWdGdnkrUTNhMnNkR3dpS08zeXhGTHkxbUY1bEtxZXp1UlhmZkxzeldaNXNuUldvUmMrR2h4cGVQclNRQWdUamMrVkN6L1Fha2Jjdjc2Nkh1dUZkaXB2NTNaWmxIbzBmNlUydHBYMFBYMUNHOC8vOUZBdEFJYldIWjhySnVyNUI2cFZpWEQraXhlMjhlUEIreGRrdGFSVU0wWkVNR3pYWURTRE52Wjhqc0RBdFUrR1hNVlhqTXNXUTVTQVUyQ1lKeDQ5RW5JYTZQWHRQUWJzQ2lJVWUzekoraVFVaGJpU3d4bmswS1QrbnFvYk41bisrQnRTYjhiUkYzVjNFc3gybnVtKyt2dkV1MzRrcllkUXpUdVp0eXNONkZ3cXRsSW9QenJvZVZidENCZTBzOHdMdTR0VllPS0lQeC9CS0NTVHNOWktBTkNFTnN0YkFUMzBPLzdnNVcvM1JJb002VnBWdmlRRVFtdi92RkV2Z2l5ZTJiZzBqNGJUQXZOQ0dBRXBQaGp2MnJ1OFE5czJseVkxWlltQnNQRnNBRlVsSERseWdpVEhPQXRJdnhyZ3o5N21LUXMzSUJkdGNiMnlmWVU4eGFpVmx1cUptVHJCZEpIR3c2M0lYSGxSU2tXU1Y4Y0ZKUkxNN1dWNkxLcWorQmRGdTg0djYrZGxBRG9xY2pHUWNNTTNTNStiV0ovd29iNUMzZzB6TklXYS9MVGRrZlppb2tMais5K2JOVmREYWV2dkQxOThZQnFaZEt6SDZzNEtEb01URzlBNWFPaFRGUEN2cWVZZ3MxV0FaT2psUXRGai92R3JYc2xXTVN3M3ZsNjBSVlIvTHBSeTJaZ1dhTTFpRThxcHd0bmNPYkI2ZUJYSnFLTXQzelYxaDVrTjR0MkZPb0VReFJsajE0QnBUSklrYytvbllldE1xWmNoUGRMbklTdU5sT2pobWJpRUxrRVM1VENtVU9tRlFNOG0xV2p3S2FzdFJxaFNJK2RVZ2MzdlBrWHRqTUYxTmw4QnlwYlZxYkc5Q3VJdm9XVDJqMDZFMTM2YU1jUzFTQVZ4VUY5MGUzZ09DZHRzZmhXM1o3ejI4cE9wOTNnU2xNTTNYbldCL05Wa0JPM1NvcnFFWmZOaXBSZFhyWWxWak45cGE0Ri9YMUpXYk5NbGFtWnBOUExKM0J1KytxT0liZ0NsOTYvcjhLc2hocTZ6RUZ4ekE4b2NwQjlZYWdocjByTXpGRUhTbG5JRlNCbWM3NHl2VWRlSEszOVVmTGFZNTFnSkc0OEtsQ2dIbVhkNDFUUHc5SVBORWpWWGFQQ0s5eVEweGY2b0hrT0hOSzZpMTM2eWdleExtYTRUUGJ0bGxlTWJtQ3EyL0hUbXJHVUl5T3c4ZUlobk4=', NULL, '', 0, '18:33:56', '2021-03-11'),
(282, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'f6e1126cedebf23e1463aee73f9df08783640400', 'ZTFqREQyYUk0U0VZUnRwMkN4K25lZWFqSndKWDdrNXFQdTB4bUU4aW1IVlRrM1Q3RDAwbnBOdGFFTGNiVHNnU1prTWgwWDhTdE5MMlpEWmo5ZE5tb1N0OFFWSjVkcW1VK1FRTHJ1WmM0RTVhdDRkZ3c1NWVxS1pGWHVhcDY1eFI=', NULL, '', 0, '18:34:38', '2021-03-11'),
(283, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', '4d134bc072212ace2df385dae143139da74ec0ef', 'Z21iK1A2TGhhUC9KaUNCeFBMdG1TQT09', NULL, '', 0, '19:57:40', '2021-03-13'),
(284, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', '4d134bc072212ace2df385dae143139da74ec0ef', 'Ukh4dTE1eTBOYXM5anVJUzgrWi9Xdz09', NULL, '', 0, '19:58:04', '2021-03-13'),
(285, '4d134bc072212ace2df385dae143139da74ec0ef', 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'cmludEhOZHdBQXhGb3BBYk5qLzc0dz09', NULL, '', 0, '19:58:13', '2021-03-13'),
(286, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', '4d134bc072212ace2df385dae143139da74ec0ef', 'TW5ZWGlmY1JZTnJKSUVCTEl0b1BCbDZ2ZDhGVno0QnZtYkZjZERJMlhRQT0=', NULL, 'IMG_0831 - Copy.JPG', 0, '19:58:24', '2021-03-13'),
(287, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', '887309d048beef83ad3eabf2a79a64a389ab1c9f', 'RzdvU2tJMFhjdHhDQ2xhOEtjNjFoQT09', NULL, '', 0, '20:00:46', '2021-03-13'),
(288, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', 'f6e1126cedebf23e1463aee73f9df08783640400', 'YzZPRjA0Z2syOXh6b1NacUJCNW1wQT09', NULL, '', 0, '20:01:05', '2021-03-13'),
(289, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', '887309d048beef83ad3eabf2a79a64a389ab1c9f', 'M1BJcjFhaUl6U2JhQlNBNXplT2ZGZz09', NULL, '', 0, '20:02:45', '2021-03-13'),
(290, 'd435a6cdd786300dff204ee7c2ef942d3e9034e2', '887309d048beef83ad3eabf2a79a64a389ab1c9f', 'TVB5aFVQZ1Z0OURjSTdDYTB1RGNkUT09', NULL, '', 0, '20:04:44', '2021-03-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authentication`
--
ALTER TABLE `authentication`
  ADD PRIMARY KEY (`auth_id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authentication`
--
ALTER TABLE `authentication`
  MODIFY `auth_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
