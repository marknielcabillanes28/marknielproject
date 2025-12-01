-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2025 at 03:48 PM
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
-- Database: `electronics_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `mac_address` varchar(17) DEFAULT NULL,
  `action` varchar(50) NOT NULL DEFAULT 'login',
  `status` enum('active','blocked') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `name`, `ip_address`, `mac_address`, `action`, `status`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', '192.168.1.100', '00:1B:44:11:3A:B7', 'login', 'active', '2025-11-09 13:25:39', '2025-11-09 13:25:39'),
(2, 'Jane Smith', '192.168.1.101', '00:1B:44:11:3A:B8', 'logout', 'active', '2025-11-09 14:25:39', '2025-11-09 14:25:39'),
(3, 'Mike Johnson', '192.168.1.102', '00:1B:44:11:3A:B9', 'failed_login', 'blocked', '2025-11-09 14:55:39', '2025-11-09 14:55:39'),
(4, 'Sarah Wilson', '192.168.1.103', '00:1B:44:11:3A:C0', 'login', 'active', '2025-11-09 15:10:39', '2025-11-09 15:10:39'),
(5, 'Admin User', '192.168.1.1', '00:1B:44:11:3A:C1', 'admin_login', 'active', '2025-11-09 15:20:39', '2025-11-09 15:27:12'),
(6, 'chavy', '192.168.15.13', 'A7:07:D3:A5:7A:89', 'login', 'active', '2025-11-09 18:03:19', '2025-11-09 18:03:19'),
(7, 'chavy', '192.168.15.13', 'DE:61:91:98:1F:C4', 'login', 'active', '2025-11-09 18:03:34', '2025-11-09 18:03:34'),
(8, 'chavy', '192.168.15.13', 'F0:8C:32:6C:07:06', 'login', 'active', '2025-11-09 18:03:42', '2025-11-09 18:03:42'),
(9, 'chavy', '192.168.15.13', '58:23:D7:57:9C:89', 'login', 'active', '2025-11-09 18:04:13', '2025-11-09 18:04:13'),
(10, 'armando@gmail.com', '192.168.15.15', '16:5F:30:D5:A7:B2', 'failed_login', 'active', '2025-11-09 18:04:18', '2025-11-09 18:04:18'),
(11, 'chavy', '192.168.15.13', 'DE:BB:BD:C3:10:E8', 'failed_login', 'active', '2025-11-09 18:04:25', '2025-11-09 18:04:25'),
(12, 'chavy', '192.168.15.13', 'B9:1B:D2:5B:E5:1C', 'login', 'active', '2025-11-09 18:04:38', '2025-11-09 18:04:38'),
(13, 'Markniel', '192.168.15.15', '36:51:4A:A4:21:42', 'admin_login', 'active', '2025-11-09 18:04:41', '2025-11-09 18:04:41'),
(14, 'chavy', '192.168.15.15', 'B0:4F:68:75:FE:53', 'login', 'active', '2025-11-09 18:06:44', '2025-11-09 18:06:44'),
(15, 'chavy', '192.168.15.13', 'EC:6E:69:A3:2B:C0', 'failed_login', 'active', '2025-11-09 18:09:36', '2025-11-09 18:09:36'),
(16, 'chavy', '192.168.15.13', '43:6A:49:0F:36:F1', 'failed_login', 'active', '2025-11-09 18:09:42', '2025-11-09 18:09:42'),
(17, 'chavy', '192.168.15.13', '51:6A:5D:60:B7:D6', 'failed_login', 'active', '2025-11-09 18:13:21', '2025-11-09 18:13:21'),
(18, 'chavy', '192.168.15.13', '00:B1:D0:34:EA:46', 'failed_login', 'active', '2025-11-09 18:13:42', '2025-11-09 18:13:42'),
(19, 'chavy', '192.168.15.15', '1F:B0:7F:D5:05:F4', 'failed_login', 'active', '2025-11-09 18:13:58', '2025-11-09 18:13:58'),
(20, 'chavy', '192.168.15.15', 'E2:A9:98:7C:26:12', 'failed_login', 'active', '2025-11-09 18:14:24', '2025-11-09 18:14:24'),
(21, 'chavy', '192.168.15.15', '32:7C:6C:98:2B:54', 'failed_login', 'active', '2025-11-09 18:15:15', '2025-11-09 18:15:15'),
(22, 'chavy', '192.168.15.15', '84:AF:54:31:04:B4', 'failed_login', 'active', '2025-11-09 18:16:34', '2025-11-09 18:16:34'),
(23, 'chavy', '192.168.15.15', 'D0:89:66:57:76:FE', 'failed_login', 'active', '2025-11-09 18:17:59', '2025-11-09 18:17:59'),
(24, 'chavy', '192.168.15.15', '83:C4:8B:6D:D2:6D', 'failed_login', 'active', '2025-11-09 18:20:26', '2025-11-09 18:20:26'),
(25, 'chavy', '192.168.15.15', '08:3C:7C:FE:59:B2', 'failed_login', 'active', '2025-11-09 18:20:33', '2025-11-09 18:20:33'),
(26, 'chavy', '192.168.15.15', '21:97:79:8C:8E:4D', 'login', 'active', '2025-11-09 18:25:21', '2025-11-09 18:25:21'),
(27, 'chavy', '192.168.15.13', 'A9:CE:AB:04:42:BE', 'login', 'active', '2025-11-09 18:25:46', '2025-11-09 18:25:46'),
(28, 'chavy', '192.168.15.13', 'AE:7E:AC:3F:B1:64', 'logout', 'active', '2025-11-09 18:25:58', '2025-11-09 18:25:58'),
(29, 'chavy', '192.168.15.15', '4C:BC:F6:B7:03:FE', 'logout', 'active', '2025-11-09 18:33:00', '2025-11-09 18:33:00'),
(30, 'chavy', '192.168.15.15', '7B:31:8A:FA:E4:AE', 'login', 'active', '2025-11-09 18:33:10', '2025-11-09 18:33:10'),
(31, 'chavy', '192.168.15.15', 'DE:BD:12:2D:AF:48', 'login', 'active', '2025-11-09 18:44:26', '2025-11-09 18:44:26'),
(32, 'chavy', '192.168.15.15', 'B6:96:6D:2D:2D:DB', 'login', 'active', '2025-11-09 18:50:23', '2025-11-09 18:50:23'),
(33, 'chavy', '192.168.15.15', '36:F1:2F:34:46:C9', 'login', 'active', '2025-11-09 18:54:51', '2025-11-09 18:54:51'),
(34, 'shylamae@gmail.com', '192.168.15.11', '26:2B:86:7C:CE:65', 'login', 'active', '2025-11-09 19:11:12', '2025-11-09 19:11:12'),
(35, 'Markniel', '192.168.15.15', '5D:79:30:EE:D2:3D', 'failed_login', 'active', '2025-11-10 09:48:23', '2025-11-10 09:48:23'),
(36, 'Markniel', '192.168.15.15', '0E:5A:A7:36:EB:37', 'failed_login', 'active', '2025-11-10 09:48:24', '2025-11-10 09:48:24'),
(37, 'jep', '192.168.15.15', 'A2:C5:F4:01:AE:C2', 'failed_login', 'active', '2025-11-10 09:51:20', '2025-11-10 09:51:20'),
(38, 'Mark', '192.168.15.15', '8B:52:B2:2D:E2:58', 'failed_login', 'active', '2025-11-10 09:52:06', '2025-11-10 09:52:06'),
(39, 'Markniel', '192.168.15.15', 'D2:30:F3:F5:12:13', 'failed_login', 'active', '2025-11-10 09:53:04', '2025-11-10 09:53:04'),
(40, 'MarknielCabillanes', '192.168.15.15', '8C:74:50:68:A9:A6', 'admin_login', 'active', '2025-11-10 09:55:06', '2025-11-10 09:55:06'),
(41, 'Angie', '192.168.15.12', '3C:2B:80:F0:CA:C8', 'login', 'active', '2025-11-10 15:16:22', '2025-11-10 15:16:22'),
(42, 'Angie', '192.168.15.12', '9C:35:03:A4:41:36', 'logout', 'active', '2025-11-10 15:16:42', '2025-11-10 15:16:42'),
(43, 'carl', '192.168.15.16', 'BD:19:8B:C2:59:BD', 'login', 'blocked', '2025-11-10 15:17:51', '2025-11-10 16:03:55'),
(44, 'Markniel', '192.168.15.15', '57:00:3D:04:BF:EE', 'failed_login', 'active', '2025-11-10 15:28:31', '2025-11-10 15:28:31'),
(45, 'Markniel', '192.168.15.15', 'A9:38:47:3E:82:9B', 'failed_login', 'active', '2025-11-10 15:29:33', '2025-11-10 15:29:33'),
(46, 'senjo', '192.168.15.15', 'DC:A6:B9:BC:A2:F7', 'admin_login', 'active', '2025-11-10 15:30:16', '2025-11-10 15:30:16'),
(47, 'Angie', '192.168.15.12', 'DE:DD:3F:FF:75:27', 'login', 'active', '2025-11-10 15:50:13', '2025-11-10 15:50:13'),
(48, 'shylamae@gmail.com', '192.168.15.11', '7A:F0:E6:24:5A:DC', 'login', 'active', '2025-11-10 15:50:32', '2025-11-10 15:50:32'),
(49, 'butaslac', '192.168.15.17', '81:14:67:9A:AA:77', 'login', 'active', '2025-11-10 15:50:36', '2025-11-10 15:50:36'),
(50, 'butaslac', '192.168.15.17', '24:98:06:4D:EB:AF', 'logout', 'blocked', '2025-11-10 15:50:43', '2025-11-10 16:02:43'),
(51, 'Angie', '192.168.15.12', 'A1:E1:C3:3D:11:BA', 'logout', 'active', '2025-11-10 15:50:49', '2025-11-10 15:50:49'),
(52, 'Angie', '192.168.15.12', 'F7:A5:CC:76:51:52', 'login', 'active', '2025-11-10 15:51:56', '2025-11-10 15:51:56'),
(53, 'butaslac', '192.168.15.17', '72:22:A8:A7:C5:1A', 'login', 'blocked', '2025-11-10 15:52:21', '2025-11-10 16:03:30'),
(54, 'shylamae@gamail.com', '192.168.15.11', '1C:DE:02:4D:62:1B', 'failed_login', 'active', '2025-11-10 15:57:35', '2025-11-10 15:57:35'),
(55, 'shylamae@gmail.com', '192.168.15.11', '85:84:D5:25:CB:9F', 'login', 'blocked', '2025-11-10 15:57:59', '2025-11-10 16:02:18'),
(56, 'butaslac', '192.168.15.17', 'E8:A3:DB:95:56:41', 'login', 'active', '2025-11-10 16:02:05', '2025-11-10 16:02:05'),
(57, 'shylamae@gmail.com', '192.168.15.11', 'DF:DA:20:A5:1D:04', 'login', 'active', '2025-11-10 16:02:40', '2025-11-10 16:02:40'),
(58, 'butaslac', '192.168.15.17', 'A4:A2:3B:FA:1D:EE', 'login', 'active', '2025-11-10 16:04:33', '2025-11-10 16:04:33'),
(59, 'carl', '192.168.15.16', '34:8A:55:C0:7E:F6', 'failed_login', 'blocked', '2025-11-10 16:04:37', '2025-11-10 16:05:09'),
(60, 'butaslac', '192.168.15.17', '8A:0B:5A:8F:BA:01', 'login', 'active', '2025-11-10 16:04:43', '2025-11-10 16:04:43'),
(61, 'butaslac', '192.168.15.17', '29:74:DC:65:DE:2C', 'logout', 'active', '2025-11-10 16:04:46', '2025-11-10 16:04:46'),
(62, 'carl', '192.168.15.16', '88:A2:B8:9D:68:2A', 'login', 'blocked', '2025-11-10 16:04:49', '2025-11-10 16:06:18'),
(63, 'carl', '192.168.15.16', '93:24:17:54:F9:12', 'logout', 'active', '2025-11-10 16:05:20', '2025-11-10 16:05:20'),
(64, 'carl', '192.168.15.16', '8D:61:ED:58:CF:04', 'login', 'active', '2025-11-10 16:05:34', '2025-11-10 16:05:34'),
(65, 'butaslac', '192.168.15.17', '8F:F8:3F:3C:AD:D3', 'login', 'active', '2025-11-10 16:06:51', '2025-11-10 16:06:51'),
(66, 'butaslac', '192.168.15.17', 'DA:1F:38:86:BF:A0', 'logout', 'active', '2025-11-10 16:06:54', '2025-11-10 16:06:54'),
(67, 'Angie', '192.168.15.12', 'DB:4D:BE:B8:4C:6B', 'login', 'active', '2025-11-10 16:07:58', '2025-11-10 16:07:58'),
(68, 'Markniel', '::1', '38:BB:27:93:F9:E0', 'failed_login', 'active', '2025-11-29 14:09:37', '2025-11-29 14:09:37'),
(69, 'Markniel', '::1', '2E:04:02:36:F6:F8', 'failed_login', 'active', '2025-11-29 14:09:48', '2025-11-29 14:09:48'),
(70, 'Mark', '::1', '96:70:20:99:17:46', 'failed_login', 'active', '2025-11-29 14:10:51', '2025-11-29 14:10:51'),
(71, 'Markniel', '::1', '21:53:AA:8D:01:78', 'failed_login', 'active', '2025-11-29 14:12:27', '2025-11-29 14:12:27'),
(72, 'Fernando', '::1', 'FA:31:3D:85:3B:6F', 'login', 'active', '2025-11-29 14:12:50', '2025-11-29 14:12:50'),
(73, 'Fernando', '::1', '01:EF:79:9F:1A:57', 'logout', 'active', '2025-11-29 14:13:22', '2025-11-29 14:13:22'),
(74, 'MarknielCabillanes', '::1', '3A:3A:A8:EE:25:5C', 'admin_login', 'active', '2025-11-29 14:13:33', '2025-11-29 14:13:33'),
(75, 'MarknielCabillanes', '::1', 'B6:4B:78:DD:69:D3', 'logout', 'active', '2025-11-29 14:34:06', '2025-11-29 14:34:06'),
(76, 'Fernando', '::1', '89:2C:DC:B0:3C:CC', 'login', 'active', '2025-11-29 14:34:16', '2025-11-29 14:34:16'),
(77, 'Fernando', '::1', '00:A8:73:27:65:24', 'logout', 'active', '2025-11-29 14:38:28', '2025-11-29 14:38:28'),
(78, 'MarknielCabillanes', '::1', '19:EC:73:DD:05:EB', 'admin_login', 'active', '2025-11-29 14:40:42', '2025-11-29 14:40:42'),
(79, 'MarknielCabillanes', '::1', '27:E8:B0:3A:A0:42', 'logout', 'active', '2025-11-29 14:41:35', '2025-11-29 14:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `electronics`
--

CREATE TABLE `electronics` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `status` enum('Available','Out of Stock') DEFAULT 'Available',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `electronics`
--

INSERT INTO `electronics` (`id`, `name`, `brand`, `model`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(2, 'jun', 'samsung', 'v1', 0, 'Available', '2025-10-29 03:52:33', '2025-11-09 14:14:10'),
(3, 'Ref', 'samsung', 'l3210', 0, 'Available', '2025-11-09 14:17:15', '2025-11-10 15:18:09'),
(4, 'washing machine', 'panasonic', 'k112', 0, 'Available', '2025-11-10 15:30:56', '2025-11-29 14:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `ip_blocks`
--

CREATE TABLE `ip_blocks` (
  `id` int(11) UNSIGNED NOT NULL,
  `from_ip` varchar(45) NOT NULL,
  `to_ip` varchar(45) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ip_blocks`
--

INSERT INTO `ip_blocks` (`id`, `from_ip`, `to_ip`, `reason`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '192.168.1.1', '192.168.1.5', 'buang', 'active', 'Markniel', '2025-11-09 19:02:21', '2025-11-09 19:02:21'),
(2, '192.168.15.16', '192.168.15.16', '', 'active', 'senjo', '2025-11-10 16:07:12', '2025-11-10 16:07:12'),
(3, '192.168.15.17', '192.168.15.17', '', 'active', 'senjo', '2025-11-10 16:07:59', '2025-11-10 16:07:59'),
(4, '192.168.15.12', '192.168.15.12', '', 'active', 'senjo', '2025-11-10 16:08:40', '2025-11-10 16:08:40'),
(6, '192.168.15.11', '192.168.15.11', '', 'inactive', 'senjo', '2025-11-10 16:10:40', '2025-11-29 14:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `status` enum('online','maintenance') NOT NULL DEFAULT 'online'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `status`) VALUES
(1, 'online');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2024-11-09-000001', 'App\\Database\\Migrations\\CreateActivityLogsTable', 'default', 'App', 1762701928, 1),
(2, '2024-11-10-000001', 'App\\Database\\Migrations\\CreateIpBlocksTable', 'default', 'App', 1762714838, 2);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `electronic_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `electronic_id`, `quantity`, `created_at`) VALUES
(1, 8, 2, 1, '2025-11-09 14:14:10'),
(2, 16, 3, 1, '2025-11-10 15:18:09'),
(3, 19, 4, 1, '2025-11-29 14:36:01'),
(4, 19, 4, 1, '2025-11-29 14:36:05'),
(5, 19, 4, 1, '2025-11-29 14:36:35'),
(6, 19, 4, 1, '2025-11-29 14:36:37'),
(7, 19, 4, 1, '2025-11-29 14:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `maintenance_mode` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `maintenance_mode`, `updated_at`) VALUES
(1, 0, '2025-11-29 14:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(2, 'lyn', 'password', '2025-10-24 10:57:07', 'user'),
(3, 'admin', 'password', '2025-11-07 05:48:37', 'user'),
(4, 'jep', 'admin', '2025-11-07 13:11:47', 'user'),
(5, 'Mark', '123456', '2025-11-09 13:47:39', 'user'),
(7, 'Markniel', '123456', '2025-11-09 13:49:52', 'admin'),
(8, 'niel', '123456', '2025-11-09 13:54:27', 'user'),
(9, 'chavy', '$2y$10$CrcfLN/qXcuQ66gi1buh7eHKbnQh8uawXx6GtqHKu6V5zR5wvGBRC', '2025-11-09 18:03:08', 'user'),
(13, 'shylamae@gmail.com', '$2y$10$gawmTX7LNa33gk55wXFJZOojzspLR.TTEOKWAPfjLjYhf1wp.0LVS', '2025-11-09 19:10:54', 'user'),
(14, 'MarknielCabillanes', '$2y$10$cKtPm68tL4bXMfpNzj961uM/Kbdm7vtf31cIzhO9JcDkYc4yvD/tC', '2025-11-10 09:54:45', 'admin'),
(15, 'Angie', '$2y$10$UKntu2bdVpUZPU/LJUZIYuPt/R3Y.vdUZZnqkDwB3KnYPipdgq7hq', '2025-11-10 15:16:13', 'user'),
(16, 'carl', '$2y$10$GlFsN40d7ZUeXVcGsBSc3ObkaWQ0CwteQNpuudRS3dljs2mznxk7W', '2025-11-10 15:17:37', 'user'),
(17, 'senjo', '$2y$10$BzoPb1sCOAgfaxJDxQ/PWezMnQDI81Tc8OIWGtLVjsD4IrtBnHj8.', '2025-11-10 15:30:04', 'admin'),
(18, 'butaslac', '$2y$10$U28QFtSyR5B43oW/oYh7QeNBbwRruHPc8LIYRteDYJjVuhTYFoVom', '2025-11-10 15:50:28', 'user'),
(19, 'Fernando', '$2y$10$H5gJDrbJXGI93rDE23s5N.nOeWhY41ORUTIZDxy25Ros6tK9Dwa.C', '2025-11-29 14:12:43', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `status` (`status`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `electronics`
--
ALTER TABLE `electronics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_blocks`
--
ALTER TABLE `ip_blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `electronics`
--
ALTER TABLE `electronics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ip_blocks`
--
ALTER TABLE `ip_blocks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
