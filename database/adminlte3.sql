-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 06, 2024 at 01:25 AM
-- Server version: 5.7.33
-- PHP Version: 8.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adminlte3`
--

-- --------------------------------------------------------

--
-- Table structure for table `log_activities`
--

CREATE TABLE `log_activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_activities`
--

INSERT INTO `log_activities` (`id`, `user_id`, `path`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 0, '/login', 'Login : administrator', '2024-01-01 10:01:59', '2024-01-01 10:01:59'),
(2, 0, '/login', 'Login : administrator', '2024-01-01 15:14:54', '2024-01-01 15:14:54'),
(3, 0, '/logout', 'Logout : administrator', '2024-01-01 17:06:59', '2024-01-01 17:06:59'),
(4, 0, '/login', 'Login : administrator', '2024-01-01 17:24:21', '2024-01-01 17:24:21'),
(5, 0, 'users/edit', 'Update user information :  (0)', '2024-01-01 17:27:30', '2024-01-01 17:27:30'),
(6, 0, 'users/edit', 'Update user information :  (0)', '2024-01-01 17:40:05', '2024-01-01 17:40:05'),
(7, 0, '/login', 'Login : administrator@hpcs.my', '2024-01-04 15:55:18', '2024-01-04 15:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `ref_identification_types`
--

CREATE TABLE `ref_identification_types` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_identification_types`
--

INSERT INTO `ref_identification_types` (`id`, `name`, `status_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'New I/C Number', 1, '2023-08-27 19:42:07', 0, NULL, NULL),
(2, 'Passport', 1, '2023-08-27 19:42:07', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ref_status`
--

CREATE TABLE `ref_status` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_status`
--

INSERT INTO `ref_status` (`id`, `name`, `color`) VALUES
(0, 'Deleted', '#000000'),
(1, 'Active', '#008000'),
(2, 'Not Active', '#800000');

-- --------------------------------------------------------

--
-- Table structure for table `sys_error_logs`
--

CREATE TABLE `sys_error_logs` (
  `id` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `log` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sys_menu_1childs`
--

CREATE TABLE `sys_menu_1childs` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parameter` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_menu_1childs`
--

INSERT INTO `sys_menu_1childs` (`id`, `parent_id`, `sort`, `title`, `icon`, `url`, `parameter`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Customize Theme', 'fa-solid fa-angle-right fa-2xs', 'setting/edit', NULL, 1, '2024-01-01 10:35:36', '2024-01-01 10:35:36'),
(2, 1, 2, 'Users', 'fa-solid fa-angle-right fa-2xs', 'users/index', NULL, 1, '2024-01-01 10:31:36', '2024-01-01 10:31:36'),
(3, 1, 3, 'Roles', 'fa-solid fa-angle-right fa-2xs', 'roles/index', NULL, 1, '2024-01-01 10:32:13', '2024-01-01 10:32:13'),
(4, 1, 4, 'Permissions', 'fa-solid fa-angle-right fa-2xs', 'permissions/index', NULL, 1, '2024-01-01 10:32:59', '2024-01-01 10:32:59'),
(5, 1, 5, 'Menu', 'fa-solid fa-angle-right fa-2xs', 'menu/index', NULL, 1, '2024-01-01 10:33:36', '2024-01-01 10:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `sys_menu_2childs`
--

CREATE TABLE `sys_menu_2childs` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child1_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parameter` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sys_menu_parents`
--

CREATE TABLE `sys_menu_parents` (
  `id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parameter` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_menu_parents`
--

INSERT INTO `sys_menu_parents` (`id`, `sort`, `title`, `icon`, `url`, `parameter`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 10, 'RBAC', 'fa-solid fa-screwdriver-wrench fa-lg', '#', NULL, 1, '2024-01-01 10:30:31', '2024-01-01 10:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `sys_menu_roles`
--

CREATE TABLE `sys_menu_roles` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_parent_id` int(11) NOT NULL,
  `menu_1child_id` int(11) DEFAULT NULL,
  `menu_2child_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_menu_roles`
--

INSERT INTO `sys_menu_roles` (`id`, `role_id`, `menu_parent_id`, `menu_1child_id`, `menu_2child_id`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 1, '2024-01-01 10:30:31', '2024-01-01 10:30:31'),
(2, 1, 1, 1, NULL, 1, '2024-01-01 10:31:13', '2024-01-01 10:31:13'),
(3, 1, 1, 2, NULL, 1, '2024-01-01 10:31:36', '2024-01-01 10:31:36'),
(4, 1, 1, 3, NULL, 1, '2024-01-01 10:32:13', '2024-01-01 10:32:13'),
(5, 1, 1, 4, NULL, 1, '2024-01-01 10:32:59', '2024-01-01 10:32:59'),
(6, 1, 1, 5, NULL, 1, '2024-01-01 10:33:36', '2024-01-01 10:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `sys_notifications`
--

CREATE TABLE `sys_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `descriptions` varchar(255) NOT NULL,
  `url_redirect` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sys_permissions`
--

CREATE TABLE `sys_permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `method` varchar(100) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_permissions`
--

INSERT INTO `sys_permissions` (`id`, `name`, `method`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'Permissions - *', NULL, 1, '2024-01-01 10:27:57', '2024-01-01 10:27:57'),
(2, 'Roles - *', NULL, 1, '2024-01-01 10:28:12', '2024-01-01 10:28:12'),
(3, 'User - *', NULL, 1, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(4, 'Menu - *', NULL, 1, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(5, 'Home', NULL, 1, '2024-01-01 10:34:22', '2024-01-01 10:34:22'),
(6, 'Setting System', NULL, 1, '2024-01-01 10:34:51', '2024-01-01 10:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `sys_permission_routes`
--

CREATE TABLE `sys_permission_routes` (
  `id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_permission_routes`
--

INSERT INTO `sys_permission_routes` (`id`, `permission_id`, `route_id`, `created_at`, `updated_at`) VALUES
(1, 1, 17, '2024-01-01 10:27:57', '2024-01-01 10:27:57'),
(2, 1, 18, '2024-01-01 10:27:57', '2024-01-01 10:27:57'),
(3, 1, 19, '2024-01-01 10:27:58', '2024-01-01 10:27:58'),
(4, 1, 20, '2024-01-01 10:27:58', '2024-01-01 10:27:58'),
(5, 1, 21, '2024-01-01 10:27:58', '2024-01-01 10:27:58'),
(6, 1, 22, '2024-01-01 10:27:58', '2024-01-01 10:27:58'),
(7, 2, 23, '2024-01-01 10:28:12', '2024-01-01 10:28:12'),
(8, 2, 24, '2024-01-01 10:28:12', '2024-01-01 10:28:12'),
(9, 2, 25, '2024-01-01 10:28:12', '2024-01-01 10:28:12'),
(10, 2, 26, '2024-01-01 10:28:12', '2024-01-01 10:28:12'),
(11, 2, 27, '2024-01-01 10:28:12', '2024-01-01 10:28:12'),
(12, 2, 28, '2024-01-01 10:28:12', '2024-01-01 10:28:12'),
(13, 3, 39, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(14, 3, 40, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(15, 3, 41, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(16, 3, 42, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(17, 3, 43, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(18, 3, 44, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(19, 3, 45, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(20, 3, 46, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(21, 3, 47, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(22, 3, 48, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(23, 3, 49, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(24, 3, 50, '2024-01-01 10:28:40', '2024-01-01 10:28:40'),
(25, 4, 29, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(26, 4, 30, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(27, 4, 31, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(28, 4, 32, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(29, 4, 33, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(30, 4, 34, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(31, 4, 35, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(32, 4, 36, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(33, 4, 37, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(34, 4, 38, '2024-01-01 10:28:53', '2024-01-01 10:28:53'),
(35, 5, 5, '2024-01-01 10:34:22', '2024-01-01 10:34:22'),
(36, 6, 13, '2024-01-01 10:34:51', '2024-01-01 10:34:51'),
(37, 6, 14, '2024-01-01 10:34:51', '2024-01-01 10:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `sys_roles`
--

CREATE TABLE `sys_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_roles`
--

INSERT INTO `sys_roles` (`id`, `name`, `level`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, 1, '2023-07-10 07:49:32', '2024-01-01 10:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `sys_role_permissions`
--

CREATE TABLE `sys_role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_role_permissions`
--

INSERT INTO `sys_role_permissions` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, '2024-01-01 10:29:20', '2024-01-01 10:29:20'),
(2, 1, 1, '2024-01-01 10:29:20', '2024-01-01 10:29:20'),
(3, 1, 2, '2024-01-01 10:29:20', '2024-01-01 10:29:20'),
(4, 1, 3, '2024-01-01 10:29:20', '2024-01-01 10:29:20'),
(5, 1, 5, '2024-01-01 10:35:02', '2024-01-01 10:35:02'),
(6, 1, 6, '2024-01-01 10:35:02', '2024-01-01 10:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `sys_role_users`
--

CREATE TABLE `sys_role_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_role_users`
--

INSERT INTO `sys_role_users` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(0, 0, 1, '2023-08-11 09:37:16', '2024-01-01 17:40:05');

-- --------------------------------------------------------

--
-- Table structure for table `sys_routes`
--

CREATE TABLE `sys_routes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_routes`
--

INSERT INTO `sys_routes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'sanctum.csrf-cookie', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(2, 'ignition.healthCheck', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(3, 'ignition.executeSolution', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(4, 'ignition.updateConfig', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(5, '/', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(6, 'login', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(7, 'logout', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(8, 'forgot-password', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(9, 'register-account', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(10, 'register-store', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(11, '/verification', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(12, 'changeLang', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(13, 'setting/edit', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(14, 'setting/update', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(15, 'error/log', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(16, 'error/store', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(17, 'permissions/index', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(18, 'permissions/create', '2024-01-01 10:27:46', '2024-01-01 10:27:46'),
(19, 'permissions/store', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(20, 'permissions/edit', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(21, 'permissions/update', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(22, 'permissions/delete', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(23, 'roles/index', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(24, 'roles/create', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(25, 'roles/store', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(26, 'roles/edit', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(27, 'roles/update', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(28, 'roles/delete', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(29, 'menu/index', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(30, 'menu/create', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(31, 'menu/store', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(32, 'menu/edit-parent', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(33, 'menu/edit-child1', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(34, 'menu/edit-child2', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(35, 'menu/update', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(36, 'menu/delete-parent', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(37, 'menu/delete-child1', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(38, 'menu/delete-child2', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(39, 'users/index', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(40, 'users/create', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(41, 'users/store', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(42, 'users/edit', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(43, 'users/update', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(44, 'users/view', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(45, 'users/delete', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(46, 'users/read-notification', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(47, 'users/list-notification', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(48, 'users/list', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(49, 'user/complete-details', '2024-01-01 10:27:47', '2024-01-01 10:27:47'),
(50, 'users/complete-update', '2024-01-01 10:27:47', '2024-01-01 10:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `sys_settings`
--

CREATE TABLE `sys_settings` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `title_favicon` varchar(50) NOT NULL,
  `favicon_path` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `logo_login_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_settings`
--

INSERT INTO `sys_settings` (`id`, `title`, `title_favicon`, `favicon_path`, `logo_path`, `logo_login_path`, `created_at`, `updated_at`) VALUES
(1, 'AdminLTE 3', 'AdminLTE 3', 'images\\favicon\\favicon.ico', 'images\\logo\\logo.png', 'images\\logo\\logo.png', '2023-07-19 09:39:23', '2023-08-31 11:22:21');

-- --------------------------------------------------------

--
-- Table structure for table `usr_users`
--

CREATE TABLE `usr_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `email_verified` int(11) DEFAULT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_login` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `login_last` datetime DEFAULT NULL,
  `login_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usr_users`
--

INSERT INTO `usr_users` (`id`, `username`, `email`, `password`, `role_id`, `status_id`, `email_verified`, `token`, `first_login`, `created_at`, `created_by`, `updated_at`, `updated_by`, `login_last`, `login_at`) VALUES
(0, 'administrator', 'administrator@hpcs.my', '$2y$10$XR91RvGoFbNvNUQDLA.FIe7EBxeVsq/LUvQ5rn8DVB.QgqmR6ttC6', 1, 1, 1, NULL, 1, '2023-06-27 14:33:15', 0, '2024-01-04 07:55:18', 0, '2024-01-04 15:55:18', '2024-01-04 15:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `usr_user_profiles`
--

CREATE TABLE `usr_user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `identification_type_id` int(11) DEFAULT NULL,
  `identification_card` varchar(20) DEFAULT NULL,
  `phone_home` varchar(20) DEFAULT NULL,
  `phone_mobile` varchar(20) DEFAULT NULL,
  `path_avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usr_user_profiles`
--

INSERT INTO `usr_user_profiles` (`id`, `user_id`, `name`, `identification_type_id`, `identification_card`, `phone_home`, `phone_mobile`, `path_avatar`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(0, 0, 'ADMIN HPCS', 1, '000000000000', NULL, '60123456789', NULL, NULL, NULL, '2024-01-01 17:40:05', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_activities`
--
ALTER TABLE `log_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_identification_types`
--
ALTER TABLE `ref_identification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_status`
--
ALTER TABLE `ref_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_error_logs`
--
ALTER TABLE `sys_error_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_menu_1childs`
--
ALTER TABLE `sys_menu_1childs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sys_menu_1childs_status_id` (`status_id`);

--
-- Indexes for table `sys_menu_2childs`
--
ALTER TABLE `sys_menu_2childs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_menu_parents`
--
ALTER TABLE `sys_menu_parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_menu_roles`
--
ALTER TABLE `sys_menu_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_notifications`
--
ALTER TABLE `sys_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_permissions`
--
ALTER TABLE `sys_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sys_permissions_name_unique` (`name`),
  ADD KEY `fk_sys_permisstions_status_id` (`status_id`);

--
-- Indexes for table `sys_permission_routes`
--
ALTER TABLE `sys_permission_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_roles`
--
ALTER TABLE `sys_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sys_roles_name_unique` (`name`) USING BTREE,
  ADD KEY `fk_sys_roles_status_id` (`status_id`);

--
-- Indexes for table `sys_role_permissions`
--
ALTER TABLE `sys_role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sys_role_permissions_role_id` (`role_id`),
  ADD KEY `fk_sys_role_permissions_permission_id` (`permission_id`);

--
-- Indexes for table `sys_role_users`
--
ALTER TABLE `sys_role_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sys_role_users_role_id` (`role_id`),
  ADD KEY `fk_sys_role_users_user_id` (`user_id`);

--
-- Indexes for table `sys_routes`
--
ALTER TABLE `sys_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_settings`
--
ALTER TABLE `sys_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usr_users`
--
ALTER TABLE `usr_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`) USING BTREE,
  ADD UNIQUE KEY `email_unique` (`email`) USING BTREE,
  ADD KEY `fk_usr_users_status_id` (`status_id`),
  ADD KEY `fk_usr_users_role_id` (`role_id`);

--
-- Indexes for table `usr_user_profiles`
--
ALTER TABLE `usr_user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_profiles_user_id_UNIQUE` (`user_id`) USING BTREE,
  ADD UNIQUE KEY `user_profiles_name_UNIQUE` (`name`) USING BTREE,
  ADD UNIQUE KEY `user_profiles_identification_card_UNIQUE` (`identification_card`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ref_identification_types`
--
ALTER TABLE `ref_identification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ref_status`
--
ALTER TABLE `ref_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sys_error_logs`
--
ALTER TABLE `sys_error_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_menu_1childs`
--
ALTER TABLE `sys_menu_1childs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sys_menu_2childs`
--
ALTER TABLE `sys_menu_2childs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_menu_parents`
--
ALTER TABLE `sys_menu_parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sys_menu_roles`
--
ALTER TABLE `sys_menu_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sys_notifications`
--
ALTER TABLE `sys_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_permissions`
--
ALTER TABLE `sys_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sys_permission_routes`
--
ALTER TABLE `sys_permission_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `sys_roles`
--
ALTER TABLE `sys_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sys_role_permissions`
--
ALTER TABLE `sys_role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sys_role_users`
--
ALTER TABLE `sys_role_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sys_routes`
--
ALTER TABLE `sys_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `sys_settings`
--
ALTER TABLE `sys_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usr_users`
--
ALTER TABLE `usr_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usr_user_profiles`
--
ALTER TABLE `usr_user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sys_menu_1childs`
--
ALTER TABLE `sys_menu_1childs`
  ADD CONSTRAINT `fk_sys_menu_1childs_status_id` FOREIGN KEY (`status_id`) REFERENCES `ref_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sys_permissions`
--
ALTER TABLE `sys_permissions`
  ADD CONSTRAINT `fk_sys_permisstions_status_id` FOREIGN KEY (`status_id`) REFERENCES `ref_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sys_roles`
--
ALTER TABLE `sys_roles`
  ADD CONSTRAINT `fk_sys_roles_status_id` FOREIGN KEY (`status_id`) REFERENCES `ref_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sys_role_permissions`
--
ALTER TABLE `sys_role_permissions`
  ADD CONSTRAINT `fk_sys_role_permissions_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sys_permissions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sys_role_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `sys_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sys_role_users`
--
ALTER TABLE `sys_role_users`
  ADD CONSTRAINT `fk_sys_role_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `sys_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sys_role_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usr_users`
--
ALTER TABLE `usr_users`
  ADD CONSTRAINT `fk_usr_users_role_id` FOREIGN KEY (`role_id`) REFERENCES `sys_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usr_users_status_id` FOREIGN KEY (`status_id`) REFERENCES `ref_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usr_user_profiles`
--
ALTER TABLE `usr_user_profiles`
  ADD CONSTRAINT `fk_usr_user_profiles_user_id` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
