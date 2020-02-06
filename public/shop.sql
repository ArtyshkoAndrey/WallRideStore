-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 06 2020 г., 19:13
-- Версия сервера: 5.7.25-log
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Главная', 'fa-bar-chart', '/', NULL, NULL, '2020-01-13 03:57:39'),
(2, 0, 6, 'Администрирование', 'fa-tasks', NULL, NULL, NULL, '2020-01-13 03:59:12'),
(3, 2, 7, 'Список администраторов', 'fa-users', 'auth/users', NULL, NULL, '2020-01-13 03:59:45'),
(4, 2, 8, 'Роли', 'fa-user', 'auth/roles', NULL, NULL, '2020-01-13 03:59:56'),
(5, 2, 9, 'Разрешения', 'fa-ban', 'auth/permissions', NULL, NULL, '2020-01-13 04:00:15'),
(6, 2, 10, 'Меню', 'fa-bars', 'auth/menu', NULL, NULL, '2020-01-13 04:00:24'),
(7, 2, 11, 'Логи', 'fa-history', 'auth/logs', NULL, NULL, '2020-01-13 04:00:34'),
(8, 0, 2, 'Покупатели', 'fa-users', '/users', NULL, '2018-12-23 02:59:18', '2020-01-13 03:58:17'),
(9, 0, 3, 'Товары', 'fa-cubes', '/products', NULL, '2018-12-23 02:59:29', '2020-01-13 03:58:29'),
(10, 0, 4, 'Заказы', 'fa-dollar', '/orders', NULL, '2018-12-23 02:59:38', '2020-01-13 04:42:05'),
(11, 0, 5, 'Купоны', 'fa-tags', '/coupon_codes', NULL, '2018-12-23 02:59:52', '2020-01-13 03:58:50');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_operation_log`
--

CREATE TABLE `admin_operation_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_operation_log`
--

INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
(226, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:48:39', '2020-01-14 07:48:39'),
(227, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:48:44', '2020-01-14 07:48:44'),
(228, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\",\"_export_\":\"all\"}', '2020-01-14 07:48:58', '2020-01-14 07:48:58'),
(229, 1, 'admin/products/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:58:29', '2020-01-14 07:58:29'),
(230, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:58:33', '2020-01-14 07:58:33'),
(231, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:58:34', '2020-01-14 07:58:34'),
(232, 1, 'admin/orders/103', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:58:38', '2020-01-14 07:58:38'),
(233, 1, 'admin/orders/103/ship', 'POST', '127.0.0.1', '{\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\",\"express_company\":\"12312\",\"express_no\":\"14315345345\"}', '2020-01-14 07:58:45', '2020-01-14 07:58:45'),
(234, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 07:58:46', '2020-01-14 07:58:46'),
(235, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:59:03', '2020-01-14 07:59:03'),
(236, 1, 'admin/orders/103', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:59:09', '2020-01-14 07:59:09'),
(237, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:59:13', '2020-01-14 07:59:13'),
(238, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 07:59:14', '2020-01-14 07:59:14'),
(239, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 08:03:04', '2020-01-14 08:03:04'),
(240, 1, 'admin/orders/103', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 08:03:07', '2020-01-14 08:03:07'),
(241, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:04:08', '2020-01-14 08:04:08'),
(242, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:04:51', '2020-01-14 08:04:51'),
(243, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:05:11', '2020-01-14 08:05:11'),
(244, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:05:15', '2020-01-14 08:05:15'),
(245, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:05:24', '2020-01-14 08:05:24'),
(246, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:05:28', '2020-01-14 08:05:28'),
(247, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:05:37', '2020-01-14 08:05:37'),
(248, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:05:56', '2020-01-14 08:05:56'),
(249, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:06:21', '2020-01-14 08:06:21'),
(250, 1, 'admin/orders/103', 'GET', '127.0.0.1', '[]', '2020-01-14 08:06:29', '2020-01-14 08:06:29'),
(251, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 08:06:33', '2020-01-14 08:06:33'),
(252, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:10:53', '2020-01-14 08:10:53'),
(253, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:13:18', '2020-01-14 08:13:18'),
(254, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:14:30', '2020-01-14 08:14:30'),
(255, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:14:49', '2020-01-14 08:14:49'),
(256, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:15:02', '2020-01-14 08:15:02'),
(257, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:15:38', '2020-01-14 08:15:38'),
(258, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:15:48', '2020-01-14 08:15:48'),
(259, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:15:59', '2020-01-14 08:15:59'),
(260, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:16:43', '2020-01-14 08:16:43'),
(261, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:17:12', '2020-01-14 08:17:12'),
(262, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:17:26', '2020-01-14 08:17:26'),
(263, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:21:16', '2020-01-14 08:21:16'),
(264, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:22:49', '2020-01-14 08:22:49'),
(265, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:23:29', '2020-01-14 08:23:29'),
(266, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 08:23:36', '2020-01-14 08:23:36'),
(267, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 08:24:16', '2020-01-14 08:24:16'),
(268, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 08:24:18', '2020-01-14 08:24:18'),
(269, 1, 'admin/products', 'GET', '127.0.0.1', '[]', '2020-01-14 08:24:59', '2020-01-14 08:24:59'),
(270, 1, 'admin/products', 'GET', '127.0.0.1', '[]', '2020-01-14 08:25:37', '2020-01-14 08:25:37'),
(271, 1, 'admin/products', 'GET', '127.0.0.1', '[]', '2020-01-14 08:25:56', '2020-01-14 08:25:56'),
(272, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 08:26:03', '2020-01-14 08:26:03'),
(273, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 08:29:51', '2020-01-14 08:29:51'),
(274, 1, 'admin/coupon_codes/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 08:29:56', '2020-01-14 08:29:56'),
(275, 1, 'admin/coupon_codes/create', 'GET', '127.0.0.1', '[]', '2020-01-14 08:36:24', '2020-01-14 08:36:24'),
(276, 1, 'admin/coupon_codes', 'POST', '127.0.0.1', '{\"name\":\"2020 \\u043d\\u0433 \\u0442\\u043e\\u043f\\u0447\\u0438\\u043a\",\"code\":\"2020\",\"type\":\"fixed\",\"value\":\"20\",\"total\":\"20\",\"min_amount\":\"1\",\"not_before\":\"2020-01-13 00:00:00\",\"not_after\":\"2020-02-01 00:00:00\",\"enabled\":\"1\",\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\"}', '2020-01-14 08:37:24', '2020-01-14 08:37:24'),
(277, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 08:37:24', '2020-01-14 08:37:24'),
(278, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:16:26', '2020-01-14 09:16:26'),
(279, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:17:58', '2020-01-14 09:17:58'),
(280, 1, 'admin/coupon_codes/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:18:01', '2020-01-14 09:18:01'),
(281, 1, 'admin/coupon_codes/1', 'PUT', '127.0.0.1', '{\"name\":\"2020 \\u043d\\u0433 \\u0442\\u043e\\u043f\\u0447\\u0438\\u043a\",\"code\":\"2020\",\"type\":\"fixed\",\"value\":\"20.00\",\"total\":\"20\",\"min_amount\":\"1.00\",\"not_before\":\"2020-01-13 00:00:00\",\"not_after\":\"2020-02-01 00:00:00\",\"enabled\":\"1\",\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\",\"_method\":\"PUT\",\"_previous_\":\"http:\\/\\/myshop\\/admin\\/coupon_codes\"}', '2020-01-14 09:18:09', '2020-01-14 09:18:09'),
(282, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:18:10', '2020-01-14 09:18:10'),
(283, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:19:57', '2020-01-14 09:19:57'),
(284, 1, 'admin/coupon_codes/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:20:04', '2020-01-14 09:20:04'),
(285, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:20:17', '2020-01-14 09:20:17'),
(286, 1, 'admin/coupon_codes/1/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:20:20', '2020-01-14 09:20:20'),
(287, 1, 'admin/coupon_codes/1/edit', 'GET', '127.0.0.1', '[]', '2020-01-14 09:20:23', '2020-01-14 09:20:23'),
(288, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:20:25', '2020-01-14 09:20:25'),
(289, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:20:54', '2020-01-14 09:20:54'),
(290, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:21:34', '2020-01-14 09:21:34'),
(291, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:22:06', '2020-01-14 09:22:06'),
(292, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:22:11', '2020-01-14 09:22:11'),
(293, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:22:24', '2020-01-14 09:22:24'),
(294, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:22:25', '2020-01-14 09:22:25'),
(295, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:23:09', '2020-01-14 09:23:09'),
(296, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 09:23:15', '2020-01-14 09:23:15'),
(297, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:23:21', '2020-01-14 09:23:21'),
(298, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:23:22', '2020-01-14 09:23:22'),
(299, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:23:23', '2020-01-14 09:23:23'),
(300, 1, 'admin/orders', 'GET', '127.0.0.1', '[]', '2020-01-14 09:25:57', '2020-01-14 09:25:57'),
(301, 1, 'admin/orders/103', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:26:01', '2020-01-14 09:26:01'),
(302, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:26:03', '2020-01-14 09:26:03'),
(303, 1, 'admin/orders/104', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:26:05', '2020-01-14 09:26:05'),
(304, 1, 'admin/orders/104/ship', 'POST', '127.0.0.1', '{\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\",\"express_company\":\"test\",\"express_no\":\"1333\"}', '2020-01-14 09:26:56', '2020-01-14 09:26:56'),
(305, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 09:26:56', '2020-01-14 09:26:56'),
(306, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 09:27:39', '2020-01-14 09:27:39'),
(307, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:27:48', '2020-01-14 09:27:48'),
(308, 1, 'admin/orders/104', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:27:51', '2020-01-14 09:27:51'),
(309, 1, 'admin/orders/104/refund', 'POST', '127.0.0.1', '{\"agree\":true,\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\"}', '2020-01-14 09:27:58', '2020-01-14 09:27:58'),
(310, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 09:28:03', '2020-01-14 09:28:03'),
(311, 1, 'admin/orders/104/refund', 'POST', '127.0.0.1', '{\"agree\":true,\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\"}', '2020-01-14 09:28:23', '2020-01-14 09:28:23'),
(312, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 09:28:43', '2020-01-14 09:28:43'),
(313, 1, 'admin/orders/104/refund', 'POST', '127.0.0.1', '{\"agree\":true,\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\"}', '2020-01-14 09:28:48', '2020-01-14 09:28:48'),
(314, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 09:28:51', '2020-01-14 09:28:51'),
(315, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:28:55', '2020-01-14 09:28:55'),
(316, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:29:19', '2020-01-14 09:29:19'),
(317, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:29:20', '2020-01-14 09:29:20'),
(318, 1, 'admin/orders/104', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 09:29:23', '2020-01-14 09:29:23'),
(319, 1, 'admin/orders/104/refund', 'POST', '127.0.0.1', '{\"agree\":false,\"reason\":\"\\u041d\\u0435\\u0442\",\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\"}', '2020-01-14 09:29:30', '2020-01-14 09:29:30'),
(320, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 09:29:32', '2020-01-14 09:29:32'),
(321, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 13:19:52', '2020-01-14 13:19:52'),
(322, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:21:40', '2020-01-14 13:21:40'),
(323, 1, 'admin/coupon_codes/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:21:43', '2020-01-14 13:21:43'),
(324, 1, 'admin/coupon_codes', 'POST', '127.0.0.1', '{\"name\":\"\\u0422\\u0435\\u0441\\u0442\",\"code\":\"test\",\"type\":\"percent\",\"value\":\"90\",\"total\":\"1000\",\"min_amount\":\"5\",\"not_before\":\"2020-01-13 00:00:00\",\"not_after\":\"2020-01-31 00:00:00\",\"enabled\":\"1\",\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\",\"_previous_\":\"http:\\/\\/myshop\\/admin\\/coupon_codes\"}', '2020-01-14 13:22:19', '2020-01-14 13:22:19'),
(325, 1, 'admin/coupon_codes', 'GET', '127.0.0.1', '[]', '2020-01-14 13:22:20', '2020-01-14 13:22:20'),
(326, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:23:45', '2020-01-14 13:23:45'),
(327, 1, 'admin/orders', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:23:47', '2020-01-14 13:23:47'),
(328, 1, 'admin/orders/107', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:24:09', '2020-01-14 13:24:09'),
(329, 1, 'admin/orders/107/ship', 'POST', '127.0.0.1', '{\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\",\"express_company\":\"\\u041f\\u043e\\u0447\\u0442\\u0430 \\u0420\\u043e\\u0441\\u0441\\u0438\\u0438\",\"express_no\":\"202010102020\"}', '2020-01-14 13:24:37', '2020-01-14 13:24:37'),
(330, 1, 'admin/orders/107', 'GET', '127.0.0.1', '[]', '2020-01-14 13:24:37', '2020-01-14 13:24:37'),
(331, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:26:26', '2020-01-14 13:26:26'),
(332, 1, 'admin/products/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:26:30', '2020-01-14 13:26:30'),
(333, 1, 'admin/products', 'POST', '127.0.0.1', '{\"title\":\"\\u0421\\u043e\\u0431\\u0430\\u043a\\u0438\",\"description\":\"<p><strong>Lorem ipsum<\\/strong>&nbsp;&mdash; \\u043a\\u043b\\u0430\\u0441\\u0441\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0439 \\u0442\\u0435\\u043a\\u0441\\u0442-&laquo;\\u0440\\u044b\\u0431\\u0430&raquo; (\\u0443\\u0441\\u043b\\u043e\\u0432\\u043d\\u044b\\u0439, \\u0437\\u0430\\u0447\\u0430\\u0441\\u0442\\u0443\\u044e \\u0431\\u0435\\u0441\\u0441\\u043c\\u044b\\u0441\\u043b\\u0435\\u043d\\u043d\\u044b\\u0439 \\u0442\\u0435\\u043a\\u0441\\u0442-\\u0437\\u0430\\u043f\\u043e\\u043b\\u043d\\u0438\\u0442\\u0435\\u043b\\u044c, \\u0432\\u0441\\u0442\\u0430\\u0432\\u043b\\u044f\\u0435\\u043c\\u044b\\u0439 \\u0432 \\u043c\\u0430\\u043a\\u0435\\u0442 \\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u0446\\u044b). \\u042f\\u0432\\u043b\\u044f\\u0435\\u0442\\u0441\\u044f \\u0438\\u0441\\u043a\\u0430\\u0436\\u0451\\u043d\\u043d\\u044b\\u043c \\u043e\\u0442\\u0440\\u044b\\u0432\\u043a\\u043e\\u043c \\u0438\\u0437 \\u0444\\u0438\\u043b\\u043e\\u0441\\u043e\\u0444\\u0441\\u043a\\u043e\\u0433\\u043e&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/%D0%A2%D1%80%D0%B0%D0%BA%D1%82%D0%B0%D1%82_(%D0%BB%D0%B8%D1%82%D0%B5%D1%80%D0%B0%D1%82%D1%83%D1%80%D0%B0)\\\">\\u0442\\u0440\\u0430\\u043a\\u0442\\u0430\\u0442\\u0430<\\/a>&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/%D0%9C%D0%B0%D1%80%D0%BA_%D0%A2%D1%83%D0%BB%D0%BB%D0%B8%D0%B9_%D0%A6%D0%B8%D1%86%D0%B5%D1%80%D0%BE%D0%BD\\\">\\u041c\\u0430\\u0440\\u043a\\u0430 \\u0422\\u0443\\u043b\\u043b\\u0438\\u044f \\u0426\\u0438\\u0446\\u0435\\u0440\\u043e\\u043d\\u0430<\\/a>&nbsp;&laquo;\\u041e \\u043f\\u0440\\u0435\\u0434\\u0435\\u043b\\u0430\\u0445 \\u0434\\u043e\\u0431\\u0440\\u0430 \\u0438 \\u0437\\u043b\\u0430&raquo;, \\u043d\\u0430\\u043f\\u0438\\u0441\\u0430\\u043d\\u043d\\u043e\\u0433\\u043e \\u0432&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/45_%D0%B3%D0%BE%D0%B4_%D0%B4%D0%BE_%D0%BD._%D1%8D.\\\">45 \\u0433\\u043e\\u0434\\u0443 \\u0434\\u043e&nbsp;\\u043d.&nbsp;\\u044d.<\\/a>&nbsp;\\u043d\\u0430&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/%D0%9B%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B8%D0%B9_%D1%8F%D0%B7%D1%8B%D0%BA\\\">\\u043b\\u0430\\u0442\\u0438\\u043d\\u0441\\u043a\\u043e\\u043c \\u044f\\u0437\\u044b\\u043a\\u0435<\\/a>, \\u043e\\u0431\\u043d\\u0430\\u0440\\u0443\\u0436\\u0435\\u043d\\u0438\\u0435 \\u0441\\u0445\\u043e\\u0434\\u0441\\u0442\\u0432\\u0430 \\u0430\\u0442\\u0440\\u0438\\u0431\\u0443\\u0442\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u0420\\u0438\\u0447\\u0430\\u0440\\u0434\\u0443 \\u041c\\u0430\\u043a\\u041a\\u043b\\u0438\\u043d\\u0442\\u043e\\u043a\\u0443<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/Lorem_ipsum#cite_note-1\\\">[1]<\\/a>. \\u0420\\u0430\\u0441\\u043f\\u0440\\u043e\\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u043b\\u0441\\u044f \\u0432&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/1970-%D0%B5_%D0%B3%D0%BE%D0%B4%D1%8B\\\">1970-\\u0445 \\u0433\\u043e\\u0434\\u0430\\u0445<\\/a>&nbsp;\\u0438\\u0437-\\u0437\\u0430 \\u0442\\u0440\\u0430\\u0444\\u0430\\u0440\\u0435\\u0442\\u043e\\u0432 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0438&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/w\\/index.php?title=Letraset&amp;action=edit&amp;redlink=1\\\">Letraset<\\/a>, a \\u0437\\u0430\\u0442\\u0435\\u043c&nbsp;&mdash; \\u0438\\u0437-\\u0437\\u0430 \\u0442\\u043e\\u0433\\u043e, \\u0447\\u0442\\u043e \\u0441\\u043b\\u0443\\u0436\\u0438\\u043b \\u0441\\u0435\\u043c\\u043f\\u043b\\u043e\\u043c \\u0432 \\u043f\\u0440\\u043e\\u0433\\u0440\\u0430\\u043c\\u043c\\u0435&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/PageMaker\\\">PageMaker<\\/a>. \\u0418\\u0441\\u043f\\u043e\\u0440\\u0447\\u0435\\u043d\\u043d\\u044b\\u0439 \\u0442\\u0435\\u043a\\u0441\\u0442, \\u0432\\u0435\\u0440\\u043e\\u044f\\u0442\\u043d\\u043e, \\u043f\\u0440\\u043e\\u0438\\u0441\\u0445\\u043e\\u0434\\u0438\\u0442 \\u043e\\u0442 \\u0435\\u0433\\u043e \\u0438\\u0437\\u0434\\u0430\\u043d\\u0438\\u044f \\u0432&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/Loeb_Classical_Library\\\">Loeb Classical Library<\\/a>&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/1914_%D0%B3%D0%BE%D0%B4\\\">1914 \\u0433\\u043e\\u0434\\u0430<\\/a>, \\u0432 \\u043a\\u043e\\u0442\\u043e\\u0440\\u043e\\u043c \\u0441\\u043b\\u043e\\u0432\\u043e&nbsp;<em>dolorem<\\/em>&nbsp;\\u0440\\u0430\\u0437\\u0431\\u0438\\u0442\\u043e \\u043f\\u0435\\u0440\\u0435\\u043d\\u043e\\u0441\\u043e\\u043c \\u0442\\u0430\\u043a, \\u0447\\u0442\\u043e \\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u0446\\u0430 36 \\u043d\\u0430\\u0447\\u0438\\u043d\\u0430\\u0435\\u0442\\u0441\\u044f \\u0441&nbsp;<em>lorem ipsum&hellip;<\\/em>&nbsp;(<em>do-<\\/em>&nbsp;\\u043e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u043d\\u0430 \\u043f\\u0440\\u0435\\u0434\\u044b\\u0434\\u0443\\u0449\\u0435\\u0439)<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/Lorem_ipsum#cite_note-2\\\">[2]<\\/a>.<\\/p>\\r\\n\\r\\n<p>&nbsp;<\\/p>\\r\\n\\r\\n<blockquote>\\r\\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n<\\/blockquote>\\r\\n\\r\\n<p>\\u0412 \\u043e\\u0440\\u0438\\u0433\\u0438\\u043d\\u0430\\u043b\\u0435 \\u0430\\u0431\\u0437\\u0430\\u0446 \\u0432\\u044b\\u0433\\u043b\\u044f\\u0434\\u0438\\u0442 \\u0442\\u0430\\u043a:<\\/p>\\r\\n\\r\\n<blockquote>\\r\\n<p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do<strong>lorem ipsum<\\/strong>, quia&nbsp;<strong>dolor sit, amet, consectetur, adipisci<\\/strong>&nbsp;v<strong>elit, sed<\\/strong>&nbsp;quia non numquam&nbsp;<strong>eius mod<\\/strong>i&nbsp;<strong>tempor<\\/strong>a&nbsp;<strong>incidunt, ut labore et dolore magna<\\/strong>m&nbsp;<strong>aliqua<\\/strong>m quaerat voluptatem.&nbsp;<strong>Ut enim ad minim<\\/strong>a&nbsp;<strong>veniam, quis nostru<\\/strong>m&nbsp;<strong>exercitation<\\/strong>em&nbsp;<strong>ullam co<\\/strong>rporis suscipit<strong>&nbsp;labori<\\/strong>o<strong>s<\\/strong>am,&nbsp;<strong>nisi ut aliquid ex ea commod<\\/strong>i&nbsp;<strong>consequat<\\/strong>ur?&nbsp;<strong>Quis aute<\\/strong>m vel eum&nbsp;<strong>iure reprehenderit,<\\/strong>&nbsp;qui&nbsp;<strong>in<\\/strong>&nbsp;ea&nbsp;<strong>voluptate velit esse<\\/strong>, quam nihil molestiae&nbsp;<strong>c<\\/strong>onsequatur, vel&nbsp;<strong>illum<\\/strong>, qui&nbsp;<strong>dolore<\\/strong>m&nbsp;<strong>eu<\\/strong>m&nbsp;<strong>fugiat<\\/strong>, quo voluptas&nbsp;<strong>nulla pariatur<\\/strong>? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&nbsp;<strong>exceptur<\\/strong>i&nbsp;<strong>sint, obcaecat<\\/strong>i&nbsp;<strong>cupiditat<\\/strong>e&nbsp;<strong>non pro<\\/strong>v<strong>ident<\\/strong>, similique&nbsp;<strong>sunt in culpa<\\/strong>,&nbsp;<strong>qui officia deserunt mollit<\\/strong>ia&nbsp;<strong>anim<\\/strong>i,&nbsp;<strong>id est laborum<\\/strong>&nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.<\\/p>\\r\\n<\\/blockquote>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":null,\"description\":null,\"price\":null,\"stock\":null,\"id\":null,\"_remove_\":\"1\"}},\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\",\"_previous_\":\"http:\\/\\/myshop\\/admin\\/products\"}', '2020-01-14 13:27:40', '2020-01-14 13:27:40'),
(334, 1, 'admin/products/create', 'GET', '127.0.0.1', '[]', '2020-01-14 13:27:41', '2020-01-14 13:27:41'),
(335, 1, 'admin/users', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:27:47', '2020-01-14 13:27:47'),
(336, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:27:47', '2020-01-14 13:27:47'),
(337, 1, 'admin/products/create', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-14 13:27:50', '2020-01-14 13:27:50'),
(338, 1, 'admin/products', 'POST', '127.0.0.1', '{\"title\":\"\\u0421\\u0430\\u043c\\u043e\\u0435\\u0434\",\"description\":\"<p><strong>Lorem ipsum<\\/strong>&nbsp;&mdash; \\u043a\\u043b\\u0430\\u0441\\u0441\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0439 \\u0442\\u0435\\u043a\\u0441\\u0442-&laquo;\\u0440\\u044b\\u0431\\u0430&raquo; (\\u0443\\u0441\\u043b\\u043e\\u0432\\u043d\\u044b\\u0439, \\u0437\\u0430\\u0447\\u0430\\u0441\\u0442\\u0443\\u044e \\u0431\\u0435\\u0441\\u0441\\u043c\\u044b\\u0441\\u043b\\u0435\\u043d\\u043d\\u044b\\u0439 \\u0442\\u0435\\u043a\\u0441\\u0442-\\u0437\\u0430\\u043f\\u043e\\u043b\\u043d\\u0438\\u0442\\u0435\\u043b\\u044c, \\u0432\\u0441\\u0442\\u0430\\u0432\\u043b\\u044f\\u0435\\u043c\\u044b\\u0439 \\u0432 \\u043c\\u0430\\u043a\\u0435\\u0442 \\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u0446\\u044b). \\u042f\\u0432\\u043b\\u044f\\u0435\\u0442\\u0441\\u044f \\u0438\\u0441\\u043a\\u0430\\u0436\\u0451\\u043d\\u043d\\u044b\\u043c \\u043e\\u0442\\u0440\\u044b\\u0432\\u043a\\u043e\\u043c \\u0438\\u0437 \\u0444\\u0438\\u043b\\u043e\\u0441\\u043e\\u0444\\u0441\\u043a\\u043e\\u0433\\u043e&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/%D0%A2%D1%80%D0%B0%D0%BA%D1%82%D0%B0%D1%82_(%D0%BB%D0%B8%D1%82%D0%B5%D1%80%D0%B0%D1%82%D1%83%D1%80%D0%B0)\\\">\\u0442\\u0440\\u0430\\u043a\\u0442\\u0430\\u0442\\u0430<\\/a>&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/%D0%9C%D0%B0%D1%80%D0%BA_%D0%A2%D1%83%D0%BB%D0%BB%D0%B8%D0%B9_%D0%A6%D0%B8%D1%86%D0%B5%D1%80%D0%BE%D0%BD\\\">\\u041c\\u0430\\u0440\\u043a\\u0430 \\u0422\\u0443\\u043b\\u043b\\u0438\\u044f \\u0426\\u0438\\u0446\\u0435\\u0440\\u043e\\u043d\\u0430<\\/a>&nbsp;&laquo;\\u041e \\u043f\\u0440\\u0435\\u0434\\u0435\\u043b\\u0430\\u0445 \\u0434\\u043e\\u0431\\u0440\\u0430 \\u0438 \\u0437\\u043b\\u0430&raquo;, \\u043d\\u0430\\u043f\\u0438\\u0441\\u0430\\u043d\\u043d\\u043e\\u0433\\u043e \\u0432&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/45_%D0%B3%D0%BE%D0%B4_%D0%B4%D0%BE_%D0%BD._%D1%8D.\\\">45 \\u0433\\u043e\\u0434\\u0443 \\u0434\\u043e&nbsp;\\u043d.&nbsp;\\u044d.<\\/a>&nbsp;\\u043d\\u0430&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/%D0%9B%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B8%D0%B9_%D1%8F%D0%B7%D1%8B%D0%BA\\\">\\u043b\\u0430\\u0442\\u0438\\u043d\\u0441\\u043a\\u043e\\u043c \\u044f\\u0437\\u044b\\u043a\\u0435<\\/a>, \\u043e\\u0431\\u043d\\u0430\\u0440\\u0443\\u0436\\u0435\\u043d\\u0438\\u0435 \\u0441\\u0445\\u043e\\u0434\\u0441\\u0442\\u0432\\u0430 \\u0430\\u0442\\u0440\\u0438\\u0431\\u0443\\u0442\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u0420\\u0438\\u0447\\u0430\\u0440\\u0434\\u0443 \\u041c\\u0430\\u043a\\u041a\\u043b\\u0438\\u043d\\u0442\\u043e\\u043a\\u0443<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/Lorem_ipsum#cite_note-1\\\">[1]<\\/a>. \\u0420\\u0430\\u0441\\u043f\\u0440\\u043e\\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u043b\\u0441\\u044f \\u0432&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/1970-%D0%B5_%D0%B3%D0%BE%D0%B4%D1%8B\\\">1970-\\u0445 \\u0433\\u043e\\u0434\\u0430\\u0445<\\/a>&nbsp;\\u0438\\u0437-\\u0437\\u0430 \\u0442\\u0440\\u0430\\u0444\\u0430\\u0440\\u0435\\u0442\\u043e\\u0432 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0438&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/w\\/index.php?title=Letraset&amp;action=edit&amp;redlink=1\\\">Letraset<\\/a>, a \\u0437\\u0430\\u0442\\u0435\\u043c&nbsp;&mdash; \\u0438\\u0437-\\u0437\\u0430 \\u0442\\u043e\\u0433\\u043e, \\u0447\\u0442\\u043e \\u0441\\u043b\\u0443\\u0436\\u0438\\u043b \\u0441\\u0435\\u043c\\u043f\\u043b\\u043e\\u043c \\u0432 \\u043f\\u0440\\u043e\\u0433\\u0440\\u0430\\u043c\\u043c\\u0435&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/PageMaker\\\">PageMaker<\\/a>. \\u0418\\u0441\\u043f\\u043e\\u0440\\u0447\\u0435\\u043d\\u043d\\u044b\\u0439 \\u0442\\u0435\\u043a\\u0441\\u0442, \\u0432\\u0435\\u0440\\u043e\\u044f\\u0442\\u043d\\u043e, \\u043f\\u0440\\u043e\\u0438\\u0441\\u0445\\u043e\\u0434\\u0438\\u0442 \\u043e\\u0442 \\u0435\\u0433\\u043e \\u0438\\u0437\\u0434\\u0430\\u043d\\u0438\\u044f \\u0432&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/Loeb_Classical_Library\\\">Loeb Classical Library<\\/a>&nbsp;<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/1914_%D0%B3%D0%BE%D0%B4\\\">1914 \\u0433\\u043e\\u0434\\u0430<\\/a>, \\u0432 \\u043a\\u043e\\u0442\\u043e\\u0440\\u043e\\u043c \\u0441\\u043b\\u043e\\u0432\\u043e&nbsp;<em>dolorem<\\/em>&nbsp;\\u0440\\u0430\\u0437\\u0431\\u0438\\u0442\\u043e \\u043f\\u0435\\u0440\\u0435\\u043d\\u043e\\u0441\\u043e\\u043c \\u0442\\u0430\\u043a, \\u0447\\u0442\\u043e \\u0441\\u0442\\u0440\\u0430\\u043d\\u0438\\u0446\\u0430 36 \\u043d\\u0430\\u0447\\u0438\\u043d\\u0430\\u0435\\u0442\\u0441\\u044f \\u0441&nbsp;<em>lorem ipsum&hellip;<\\/em>&nbsp;(<em>do-<\\/em>&nbsp;\\u043e\\u0441\\u0442\\u0430\\u043b\\u043e\\u0441\\u044c \\u043d\\u0430 \\u043f\\u0440\\u0435\\u0434\\u044b\\u0434\\u0443\\u0449\\u0435\\u0439)<a href=\\\"https:\\/\\/ru.wikipedia.org\\/wiki\\/Lorem_ipsum#cite_note-2\\\">[2]<\\/a>.<\\/p>\\r\\n\\r\\n<p>&nbsp;<\\/p>\\r\\n\\r\\n<blockquote>\\r\\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<\\/p>\\r\\n<\\/blockquote>\\r\\n\\r\\n<p>\\u0412 \\u043e\\u0440\\u0438\\u0433\\u0438\\u043d\\u0430\\u043b\\u0435 \\u0430\\u0431\\u0437\\u0430\\u0446 \\u0432\\u044b\\u0433\\u043b\\u044f\\u0434\\u0438\\u0442 \\u0442\\u0430\\u043a:<\\/p>\\r\\n\\r\\n<blockquote>\\r\\n<p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt, explicabo. Nemo enim ipsam voluptatem, quia voluptas sit, aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos, qui ratione voluptatem sequi nesciunt, neque porro quisquam est, qui do<strong>lorem ipsum<\\/strong>, quia&nbsp;<strong>dolor sit, amet, consectetur, adipisci<\\/strong>&nbsp;v<strong>elit, sed<\\/strong>&nbsp;quia non numquam&nbsp;<strong>eius mod<\\/strong>i&nbsp;<strong>tempor<\\/strong>a&nbsp;<strong>incidunt, ut labore et dolore magna<\\/strong>m&nbsp;<strong>aliqua<\\/strong>m quaerat voluptatem.&nbsp;<strong>Ut enim ad minim<\\/strong>a&nbsp;<strong>veniam, quis nostru<\\/strong>m&nbsp;<strong>exercitation<\\/strong>em&nbsp;<strong>ullam co<\\/strong>rporis suscipit<strong>&nbsp;labori<\\/strong>o<strong>s<\\/strong>am,&nbsp;<strong>nisi ut aliquid ex ea commod<\\/strong>i&nbsp;<strong>consequat<\\/strong>ur?&nbsp;<strong>Quis aute<\\/strong>m vel eum&nbsp;<strong>iure reprehenderit,<\\/strong>&nbsp;qui&nbsp;<strong>in<\\/strong>&nbsp;ea&nbsp;<strong>voluptate velit esse<\\/strong>, quam nihil molestiae&nbsp;<strong>c<\\/strong>onsequatur, vel&nbsp;<strong>illum<\\/strong>, qui&nbsp;<strong>dolore<\\/strong>m&nbsp;<strong>eu<\\/strong>m&nbsp;<strong>fugiat<\\/strong>, quo voluptas&nbsp;<strong>nulla pariatur<\\/strong>? At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum deleniti atque corrupti, quos dolores et quas molestias&nbsp;<strong>exceptur<\\/strong>i&nbsp;<strong>sint, obcaecat<\\/strong>i&nbsp;<strong>cupiditat<\\/strong>e&nbsp;<strong>non pro<\\/strong>v<strong>ident<\\/strong>, similique&nbsp;<strong>sunt in culpa<\\/strong>,&nbsp;<strong>qui officia deserunt mollit<\\/strong>ia&nbsp;<strong>anim<\\/strong>i,&nbsp;<strong>id est laborum<\\/strong>&nbsp;et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.<\\/p>\\r\\n<\\/blockquote>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"Test\",\"description\":\"test1\",\"price\":\"1000\",\"stock\":\"3\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"yDAxfkuJPJJzRC1vuH2bwBEyWTNHfA1oDDkibEl0\",\"_previous_\":\"http:\\/\\/myshop\\/admin\\/products\"}', '2020-01-14 13:28:22', '2020-01-14 13:28:22'),
(339, 1, 'admin/products', 'GET', '127.0.0.1', '[]', '2020-01-14 13:28:23', '2020-01-14 13:28:23'),
(340, 1, 'admin/orders/104', 'GET', '127.0.0.1', '[]', '2020-01-14 13:45:39', '2020-01-14 13:45:39'),
(341, 1, 'admin/products', 'GET', '127.0.0.1', '[]', '2020-01-14 13:45:39', '2020-01-14 13:45:39'),
(342, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-01-16 10:10:52', '2020-01-16 10:10:52'),
(343, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-16 10:10:56', '2020-01-16 10:10:56'),
(344, 1, 'admin/products', 'GET', '127.0.0.1', '[]', '2020-01-16 10:11:20', '2020-01-16 10:11:20'),
(345, 1, 'admin/products/32/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-16 10:11:24', '2020-01-16 10:11:24'),
(346, 1, 'admin/products/32', 'PUT', '127.0.0.1', '{\"key\":null,\"image\":\"_file_del_\",\"_file_del_\":null,\"_token\":\"dmgLZGle7JGmlmD7xjGchPjRn9I6ooJg0ucO4cTr\",\"_method\":\"PUT\"}', '2020-01-16 10:11:26', '2020-01-16 10:11:26'),
(347, 1, 'admin/products/32', 'PUT', '127.0.0.1', '{\"key\":null,\"image\":\"_file_del_\",\"_file_del_\":null,\"_token\":\"dmgLZGle7JGmlmD7xjGchPjRn9I6ooJg0ucO4cTr\",\"_method\":\"PUT\"}', '2020-01-16 10:11:47', '2020-01-16 10:11:47'),
(348, 1, 'admin/products/32', 'PUT', '127.0.0.1', '{\"key\":null,\"image\":\"_file_del_\",\"_file_del_\":null,\"_token\":\"dmgLZGle7JGmlmD7xjGchPjRn9I6ooJg0ucO4cTr\",\"_method\":\"PUT\"}', '2020-01-16 10:11:47', '2020-01-16 10:11:47'),
(349, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-01-30 01:30:59', '2020-01-30 01:30:59'),
(350, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 01:31:12', '2020-01-30 01:31:12'),
(351, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 01:31:42', '2020-01-30 01:31:42'),
(352, 1, 'admin/products/31/edit', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 01:32:17', '2020-01-30 01:32:17'),
(353, 1, 'admin/products', 'GET', '127.0.0.1', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 01:32:32', '2020-01-30 01:32:32'),
(354, 1, 'admin', 'GET', '127.0.0.1', '[]', '2020-01-30 01:33:45', '2020-01-30 01:33:45'),
(355, 1, 'admin', 'GET', '31.173.240.152', '[]', '2020-01-30 01:37:17', '2020-01-30 01:37:17'),
(356, 1, 'admin/products', 'GET', '31.173.240.152', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 01:37:26', '2020-01-30 01:37:26'),
(357, 1, 'admin/products/create', 'GET', '31.173.240.152', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 01:37:31', '2020-01-30 01:37:31'),
(358, 1, 'admin/products', 'POST', '31.173.240.152', '{\"title\":\"BRONZE56K HIGH PERFORMANCE WINDBREAKER ORANGE\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.500 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440\\u044b<\\/th>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t<p>M<\\/p>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"0\",\"skus\":{\"new_1\":{\"title\":\"M\",\"description\":\"\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440 \\u041c\",\"price\":\"55900\",\"stock\":\"0\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"vxFJ0UE5J0MnEATv3sonQhlvIXL0e47En2PThe6A\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 01:54:54', '2020-01-30 01:54:54'),
(359, 1, 'admin/products', 'GET', '31.173.240.152', '[]', '2020-01-30 01:54:55', '2020-01-30 01:54:55'),
(360, 1, 'admin', 'GET', '31.173.240.152', '[]', '2020-01-30 02:40:36', '2020-01-30 02:40:36'),
(361, 1, 'admin/products', 'GET', '31.173.240.152', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 02:40:43', '2020-01-30 02:40:43'),
(362, 1, 'admin/products/create', 'GET', '31.173.240.152', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 02:41:09', '2020-01-30 02:41:09'),
(363, 1, 'admin/products', 'POST', '31.173.240.152', '{\"title\":\"BRONZE56K HIGH PERFORMACE WINDBREAKER AIR FORCE BLUE\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>\\u041d\\/\\u0414<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440\\u044b<\\/th>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t<p>L, M<\\/p>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"L\",\"description\":\"\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440 L\",\"price\":\"55900\",\"stock\":\"2\",\"id\":null,\"_remove_\":\"0\"},\"new_2\":{\"title\":\"M\",\"description\":\"\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440 M\",\"price\":\"55900\",\"stock\":\"24\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"UrUBpvqPOpGDotDBLpacQcCIG3y43BVanQ3weaJ0\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 02:42:36', '2020-01-30 02:42:36'),
(364, 1, 'admin/products', 'GET', '31.173.240.152', '[]', '2020-01-30 02:42:37', '2020-01-30 02:42:37'),
(365, 1, 'admin/products/create', 'GET', '31.173.240.152', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 02:42:42', '2020-01-30 02:42:42'),
(366, 1, 'admin/products', 'POST', '31.173.240.152', '{\"title\":\"BRONZE56K HARD WEAR CARGO PANTS DARK NAVY\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>\\u041d\\/\\u0414<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440\\u044b<\\/th>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t<p>L, M, S<\\/p>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"L\",\"description\":\"L\",\"price\":\"49900\",\"stock\":\"10\",\"id\":null,\"_remove_\":\"0\"},\"new_2\":{\"title\":\"M\",\"description\":\"M\",\"price\":\"49900\",\"stock\":\"5\",\"id\":null,\"_remove_\":\"0\"},\"new_3\":{\"title\":\"S\",\"description\":\"S\",\"price\":\"49900\",\"stock\":\"23\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"UrUBpvqPOpGDotDBLpacQcCIG3y43BVanQ3weaJ0\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 02:43:57', '2020-01-30 02:43:57'),
(367, 1, 'admin/products', 'GET', '31.173.240.152', '[]', '2020-01-30 02:43:58', '2020-01-30 02:43:58'),
(368, 1, 'admin/products/create', 'GET', '31.173.240.152', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 02:44:01', '2020-01-30 02:44:01'),
(369, 1, 'admin/products', 'POST', '31.173.240.152', '{\"title\":\"POLAR PATTERNED POLO SHIRT RED\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>\\u041d\\/\\u0414<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440\\u044b<\\/th>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t<p>L, M, S<\\/p>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"L\",\"description\":\"L\",\"price\":\"29900\",\"stock\":\"1\",\"id\":null,\"_remove_\":\"0\"},\"new_2\":{\"title\":\"S\",\"description\":\"S\",\"price\":\"29900\",\"stock\":\"3\",\"id\":null,\"_remove_\":\"0\"},\"new_3\":{\"title\":\"S\",\"description\":\"S\",\"price\":\"29900\",\"stock\":\"2\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"UrUBpvqPOpGDotDBLpacQcCIG3y43BVanQ3weaJ0\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(370, 1, 'admin/products', 'GET', '31.173.240.152', '[]', '2020-01-30 02:45:33', '2020-01-30 02:45:33'),
(371, 1, 'admin/products/create', 'GET', '31.173.240.152', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 02:45:59', '2020-01-30 02:45:59'),
(372, 1, 'admin/products', 'POST', '31.173.240.152', '{\"title\":\"DIME POLO SHIRT PURPLE\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>\\u041d\\/\\u0414<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440\\u044b<\\/th>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t<p>L, M<\\/p>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"L\",\"description\":\"L\",\"price\":\"17940\",\"stock\":\"2\",\"id\":null,\"_remove_\":\"0\"},\"new_2\":{\"title\":\"M\",\"description\":\"M\",\"price\":\"17940\",\"stock\":\"1\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"UrUBpvqPOpGDotDBLpacQcCIG3y43BVanQ3weaJ0\"}', '2020-01-30 02:46:55', '2020-01-30 02:46:55'),
(373, 1, 'admin/products', 'GET', '31.173.240.152', '[]', '2020-01-30 02:46:56', '2020-01-30 02:46:56'),
(374, 1, 'admin', 'GET', '95.188.80.41', '[]', '2020-01-30 06:07:11', '2020-01-30 06:07:11'),
(375, 1, 'admin/products', 'GET', '95.188.80.41', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 06:07:25', '2020-01-30 06:07:25'),
(376, 1, 'admin/products/create', 'GET', '95.188.80.41', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 06:07:43', '2020-01-30 06:07:43'),
(377, 1, 'admin/products/create', 'GET', '95.188.80.41', '[]', '2020-01-30 06:07:55', '2020-01-30 06:07:55'),
(378, 1, 'admin/products', 'POST', '95.188.80.41', '{\"title\":\"BRONZE56K HARDWARE TECHNOLOGY LONGSLEEVE CARDINAL\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.500 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0420\\u0430\\u0437\\u043c\\u0435\\u0440\\u044b<\\/th>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t<p>L, M, S<\\/p>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"L\",\"description\":\"L\",\"price\":\"21900\",\"stock\":\"1\",\"id\":null,\"_remove_\":\"0\"},\"new_2\":{\"title\":\"M\",\"description\":\"M\",\"price\":\"21900\",\"stock\":\"2\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"wmoMHJCdO1okp4Btoy4qUuInCm0x0OkNMAqvzJIv\"}', '2020-01-30 06:09:49', '2020-01-30 06:09:49'),
(379, 1, 'admin/products', 'GET', '95.188.80.41', '[]', '2020-01-30 06:09:49', '2020-01-30 06:09:49'),
(380, 1, 'admin/products/create', 'GET', '95.188.80.41', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 06:09:54', '2020-01-30 06:09:54'),
(381, 1, 'admin/products', 'POST', '95.188.80.41', '{\"title\":\"BRONZE56K MOUNTAIN BEANIE GREEN\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.200 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":null,\"description\":null,\"price\":null,\"stock\":null,\"id\":null,\"_remove_\":\"1\"}},\"_token\":\"wmoMHJCdO1okp4Btoy4qUuInCm0x0OkNMAqvzJIv\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 06:10:21', '2020-01-30 06:10:21'),
(382, 1, 'admin/products/create', 'GET', '95.188.80.41', '[]', '2020-01-30 06:10:21', '2020-01-30 06:10:21'),
(383, 1, 'admin/products', 'POST', '95.188.80.41', '{\"title\":\"BRONZE56K MOUNTAIN BEANIE GREEN\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.200 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"BRONZE56K MOUNTAIN BEANIE GREEN\",\"description\":\"<table>\\t<tbody>\\t\\t<tr>\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\t\\t\\t<td>0.200 kg<\\/td>\\t\\t<\\/tr>\\t<\\/tbody><\\/table>\",\"price\":\"16900\",\"stock\":\"13\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"wmoMHJCdO1okp4Btoy4qUuInCm0x0OkNMAqvzJIv\"}', '2020-01-30 06:10:59', '2020-01-30 06:10:59'),
(384, 1, 'admin/products', 'GET', '95.188.80.41', '[]', '2020-01-30 06:10:59', '2020-01-30 06:10:59'),
(385, 1, 'admin/products/create', 'GET', '95.188.80.41', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 06:11:03', '2020-01-30 06:11:03'),
(386, 1, 'admin/products', 'POST', '95.188.80.41', '{\"title\":\"BRONSON BEARING RAW\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.110 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"BRONSON BEARING RAW\",\"description\":null,\"price\":\"17900\",\"stock\":\"34\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"wmoMHJCdO1okp4Btoy4qUuInCm0x0OkNMAqvzJIv\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 06:12:22', '2020-01-30 06:12:22'),
(387, 1, 'admin/products/create', 'GET', '95.188.80.41', '[]', '2020-01-30 06:12:23', '2020-01-30 06:12:23'),
(388, 1, 'admin/products', 'POST', '95.188.80.41', '{\"title\":\"BRONSON BEARING RAW\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.110 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"1\",\"skus\":{\"new_1\":{\"title\":\"BRONSON BEARING RAW\",\"description\":\"<table>\\t<tbody>\\t\\t<tr>\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\t\\t\\t<td>0.110 kg<\\/td>\\t\\t<\\/tr>\\t<\\/tbody><\\/table>\",\"price\":\"17900\",\"stock\":\"34\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"wmoMHJCdO1okp4Btoy4qUuInCm0x0OkNMAqvzJIv\"}', '2020-01-30 06:12:32', '2020-01-30 06:12:32'),
(389, 1, 'admin/products', 'GET', '95.188.80.41', '[]', '2020-01-30 06:12:33', '2020-01-30 06:12:33'),
(390, 1, 'admin/products/create', 'GET', '95.188.80.41', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 06:14:18', '2020-01-30 06:14:18'),
(391, 1, 'admin/products', 'POST', '95.188.80.41', '{\"title\":\"BRONZE56K 2020 HAT KHAKI\\/CHARCOAL\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.200 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"0\",\"skus\":{\"new_1\":{\"title\":\"ALL\",\"description\":\"\\u041e\\u0431\\u0449\\u0438\\u0439 \\u0440\\u0430\\u0437\\u043c\\u0435\\u0440\",\"price\":\"16900\",\"stock\":\"3\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"wmoMHJCdO1okp4Btoy4qUuInCm0x0OkNMAqvzJIv\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 06:15:24', '2020-01-30 06:15:24'),
(392, 1, 'admin/products', 'GET', '95.188.80.41', '[]', '2020-01-30 06:15:24', '2020-01-30 06:15:24'),
(393, 1, 'admin/products/create', 'GET', '95.188.80.41', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 06:15:51', '2020-01-30 06:15:51'),
(394, 1, 'admin/products', 'POST', '95.188.80.41', '{\"title\":\"BRONZE56K LOGO LEATHER BELT BLACK\",\"description\":\"<table>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>\\u0412\\u0435\\u0441<\\/th>\\r\\n\\t\\t\\t<td>0.800 kg<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"on_sale\":\"0\",\"skus\":{\"new_1\":{\"title\":\"ALL\",\"description\":\"ALL\",\"price\":\"24900\",\"stock\":\"5\",\"id\":null,\"_remove_\":\"0\"}},\"_token\":\"wmoMHJCdO1okp4Btoy4qUuInCm0x0OkNMAqvzJIv\",\"_previous_\":\"http:\\/\\/95.188.80.41\\/admin\\/products\"}', '2020-01-30 06:16:34', '2020-01-30 06:16:34'),
(395, 1, 'admin/products', 'GET', '95.188.80.41', '[]', '2020-01-30 06:16:34', '2020-01-30 06:16:34'),
(396, 1, 'admin', 'GET', '95.188.80.41', '{\"_pjax\":\"#pjax-container\"}', '2020-01-30 06:22:27', '2020-01-30 06:22:27');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`) VALUES
(1, 'All permission', '*', '', '*', NULL, NULL),
(2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL),
(3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL),
(4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL),
(5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL),
(6, 'Управление пользователями', 'users', '', '/users*', '2018-12-23 03:00:19', '2020-01-13 04:02:09'),
(7, 'Управление товарами', 'products', '', '/products*', '2018-12-23 03:00:28', '2020-01-13 04:02:37'),
(8, 'Управление заказами', 'orders', '', '/orders*', '2018-12-23 03:00:38', '2020-01-13 04:02:57'),
(9, 'Управление купонами', 'coupon_codes', '', '/coupon_codes*', '2018-12-23 03:00:47', '2020-01-13 04:03:11');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', '2018-12-23 02:58:08', '2018-12-23 02:58:08'),
(2, 'Операции', 'operator', '2018-12-23 03:01:07', '2020-01-13 04:01:41');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_role_menu`
--

CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_role_menu`
--

INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `admin_role_permissions`
--

CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_role_permissions`
--

INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 2, NULL, NULL),
(2, 3, NULL, NULL),
(2, 4, NULL, NULL),
(2, 5, NULL, NULL),
(2, 6, NULL, NULL),
(2, 7, NULL, NULL),
(2, 8, NULL, NULL),
(2, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `admin_role_users`
--

CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_role_users`
--

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Fulliton', '$2y$10$eJNi1Z2UHjb96hhUqxuhWerv3jjk9Cp/YCGV7bvl4UidmP6qQXsHy', 'Andrey', 'images/VfBD3UtAXTw.jpg', '6RaASNFCnaLcGpF7L8w8ZKePa6WfnMuG1LD87cr5eDJzpdvZnSlWKMv96AnQ', NULL, '2020-01-13 03:53:49');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_user_permissions`
--

CREATE TABLE `admin_user_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_user_permissions`
--

INSERT INTO `admin_user_permissions` (`id`, `user_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_sku_id` int(10) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `coupon_codes`
--

CREATE TABLE `coupon_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `total` int(10) UNSIGNED NOT NULL,
  `used` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `min_amount` decimal(10,2) NOT NULL,
  `not_before` datetime DEFAULT NULL,
  `not_after` datetime DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `coupon_codes`
--

INSERT INTO `coupon_codes` (`id`, `name`, `code`, `type`, `value`, `total`, `used`, `min_amount`, `not_before`, `not_after`, `enabled`, `created_at`, `updated_at`) VALUES
(1, '2020 нг топчик', '2020', 'fixed', '20.00', 20, 0, '1.00', '2020-01-13 00:00:00', '2020-02-01 00:00:00', 1, '2020-01-14 08:37:24', '2020-01-14 08:37:54'),
(2, 'Тест', 'test', 'percent', '90.00', 1000, 0, '5.00', '2020-01-13 00:00:00', '2020-01-31 00:00:00', 1, '2020-01-14 13:22:19', '2020-01-14 13:22:35');

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ratio` float NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `ratio`, `symbol`, `created_at`, `updated_at`) VALUES
(1, 'Тенге', 1, 'тг.', NULL, NULL),
(2, 'Российский рубль', 0.1638, 'р.', NULL, NULL),
(3, 'Американский доллар', 0.0026, '$', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_04_173148_create_admin_tables', 1),
(4, '2018_12_19_152909_create_user_addresses_table', 1),
(5, '2018_12_22_042326_create_products_table', 1),
(6, '2018_12_22_042331_create_product_skus_table', 1),
(7, '2018_12_22_065917_create_user_favorite_products_table', 1),
(8, '2018_12_22_071404_create_cart_items_table', 1),
(9, '2018_12_23_042627_create_orders_table', 1),
(10, '2018_12_23_042632_create_order_items_table', 1),
(11, '2018_12_23_103610_create_coupon_codes_table', 1),
(12, '2018_12_23_103753_orders_add_coupon_code_id', 1),
(13, '2020_01_28_234016_create_currencies_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `paid_at` datetime DEFAULT NULL,
  `coupon_code_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refund_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `refund_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `reviewed` tinyint(1) NOT NULL DEFAULT '0',
  `ship_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `ship_data` text COLLATE utf8mb4_unicode_ci,
  `extra` text COLLATE utf8mb4_unicode_ci,
  `express_company` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `no`, `user_id`, `address`, `total_amount`, `remark`, `paid_at`, `coupon_code_id`, `payment_method`, `payment_no`, `refund_status`, `refund_no`, `closed`, `reviewed`, `ship_status`, `ship_data`, `extra`, `express_company`, `created_at`, `updated_at`) VALUES
(103, '20200113161202060627', 102, '{\"address\":\"\\u5929\\u6d25\\u5e02\\u5e02\\u8f96\\u533a\\u7ea2\\u6865\\u533a\\u0413\\u043e\\u0440\\u044c\\u043a\\u043e\\u0433\\u043e 24, 25\",\"zip\":660099,\"contact_name\":\"\\u0410\\u043d\\u0434\\u0440\\u0435\\u0439 \\u0410\\u0440\\u0442\\u044b\\u0448\\u043a\\u043e\",\"contact_phone\":\"89029634366\"}', '22.00', '123123', '2020-01-13 00:00:00', NULL, 'card', NULL, 'pending', NULL, 1, 1, 'received', '{\"express_company\":\"12312\",\"express_no\":\"14315345345\", }', NULL, 'ems', '2020-01-13 09:12:02', '2020-01-14 08:00:11'),
(104, '20200114153754612193', 102, '{\"address\":\"\\u5929\\u6d25\\u5e02\\u5e02\\u8f96\\u533a\\u7ea2\\u6865\\u533a\\u0413\\u043e\\u0440\\u044c\\u043a\\u043e\\u0433\\u043e 24, 25\",\"zip\":660099,\"contact_name\":\"\\u0410\\u043d\\u0434\\u0440\\u0435\\u0439 \\u0410\\u0440\\u0442\\u044b\\u0448\\u043a\\u043e\",\"contact_phone\":\"89029634366\"}', '980.00', NULL, '2020-01-14 15:52:29', 1, 'card', '11233', 'pending', NULL, 1, 1, 'received', '{\"express_company\":\"test\",\"express_no\":\"1333\"}', '{\"refund_reason\":\"\\u041d\\u0435 \\u0442\\u043e\\u0442 \\u0440\\u0430\\u0437\\u043c\\u0435\\u0440\",\"refund_disagree_reason\":\"\\u041d\\u0435\\u0442\"}', 'ase', '2020-01-14 08:37:54', '2020-01-14 13:26:02'),
(105, '20200114182503983585', 102, '{\"address\":\"\\u5929\\u6d25\\u5e02\\u5e02\\u8f96\\u533a\\u7ea2\\u6865\\u533a\\u0413\\u043e\\u0440\\u044c\\u043a\\u043e\\u0433\\u043e 24, 25\",\"zip\":660099,\"contact_name\":\"\\u0410\\u043d\\u0434\\u0440\\u0435\\u0439 \\u0410\\u0440\\u0442\\u044b\\u0448\\u043a\\u043e\",\"contact_phone\":\"89029634366\"}', '1022.00', 'цукцук', NULL, NULL, 'card', NULL, 'pending', NULL, 1, 0, 'pending', NULL, NULL, 'ase', '2020-01-14 11:25:03', '2020-01-14 11:25:03'),
(106, '20200114200852301319', 102, '{\"address\":\"\\u0420\\u043e\\u0441\\u0441\\u0438\\u044f, \\u041a\\u0440\\u0430\\u0441\\u043d\\u043e\\u044f\\u0440\\u0441\\u043a, \\u0413\\u043e\\u0440\\u044c\\u043a\\u043e\\u0433\\u043e 24, 25\",\"zip\":660099,\"contact_name\":\"\\u0410\\u043d\\u0434\\u0440\\u0435\\u0439\",\"contact_phone\":\"89029634366\"}', '11.00', 'Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.', NULL, NULL, 'card', NULL, 'pending', NULL, 0, 0, 'delivered', NULL, NULL, 'ase', '2020-01-14 13:08:52', '2020-01-14 13:08:52'),
(107, '20200114202235030508', 102, '{\"address\":\"\\u0420\\u043e\\u0441\\u0441\\u0438\\u044f, \\u041a\\u0440\\u0430\\u0441\\u043d\\u043e\\u044f\\u0440\\u0441\\u043a, \\u0413\\u043e\\u0440\\u044c\\u043a\\u043e\\u0433\\u043e 24, 25\",\"zip\":660099,\"contact_name\":\"\\u0410\\u043d\\u0434\\u0440\\u0435\\u0439\",\"contact_phone\":\"89029634366\"}', '2.20', 'Тест', '2020-01-14 00:00:00', 2, 'cash', NULL, 'pending', NULL, 0, 0, 'received', '{\"express_company\":\"\\u041f\\u043e\\u0447\\u0442\\u0430 \\u0420\\u043e\\u0441\\u0441\\u0438\\u0438\",\"express_no\":\"202010102020\"}', NULL, 'pickup', '2020-01-14 13:22:35', '2020-01-14 13:29:15');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_sku_id` int(10) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` int(10) UNSIGNED DEFAULT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `reviewed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('adad.artyshko@mail.ru', '$2y$10$I0qrmje9ssvO4JH/YOkKROteu.76LOy.n/xVsM8.u5bnMDxKrbUAm', '2020-01-27 17:52:06');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `on_sale` tinyint(1) NOT NULL DEFAULT '1',
  `on_new` tinyint(1) NOT NULL DEFAULT '1',
  `rating` double(8,2) NOT NULL DEFAULT '5.00',
  `sold_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `review_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `image`, `on_sale`, `on_new`, `rating`, `sold_count`, `review_count`, `price`, `created_at`, `updated_at`) VALUES
(58, 'BRONZE56K HIGH PERFORMANCE WINDBREAKER ORANGE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.500 kg</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>M</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Windbreaker-Orange-1LOW_1800x180.jpg', 0, 1, 5.00, 0, 0, '55900.00', '2020-01-30 01:54:55', '2020-01-30 01:54:55'),
(59, 'BRONZE56K HIGH PERFORMACE WINDBREAKER AIR FORCE BLUE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Windbreaker-Blue-1LOW_1800x1800.jpg', 1, 1, 5.00, 0, 0, '55900.00', '2020-01-30 02:42:36', '2020-01-30 02:42:36'),
(60, 'BRONZE56K HARD WEAR CARGO PANTS DARK NAVY', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Pants-Cargo-Blue-1LOW_1800x1800-300x300.jpg', 1, 1, 5.00, 0, 0, '49900.00', '2020-01-30 02:43:57', '2020-01-30 02:43:57'),
(61, 'POLAR PATTERNED POLO SHIRT RED', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/PATTERNED-POLO-SHIRT-RED-1.jpg', 1, 0, 5.00, 0, 0, '29900.00', '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(62, 'DIME POLO SHIRT PURPLE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/POLO_SHIRT_PURPLE_1_1400x1400-300x300.jpg', 1, 1, 5.00, 0, 0, '17940.00', '2020-01-30 02:46:56', '2020-01-30 02:46:56'),
(63, 'BRONZE56K HARDWARE TECHNOLOGY LONGSLEEVE CARDINAL', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.500 kg</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/LSTee-Bronze-Technology-Red-1LOW.jpg', 1, 1, 5.00, 0, 0, '21900.00', '2020-01-30 06:09:49', '2020-01-30 06:09:49'),
(64, 'BRONZE56K MOUNTAIN BEANIE GREEN', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.200 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Beanie-Green-1LOW_1800x1800.jpg', 1, 1, 5.00, 0, 0, '16900.00', '2020-01-30 06:10:59', '2020-01-30 06:10:59'),
(65, 'BRONSON BEARING RAW', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.110 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/BR_RAW_SingleCase_Angled.jpg', 0, 0, 5.00, 0, 0, '17900.00', '2020-01-30 06:12:32', '2020-01-30 06:12:32'),
(66, 'BRONZE56K 2020 HAT KHAKI/CHARCOAL', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.200 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Hat-2020-Khaki-Grey-1LOW_800x.jpg', 0, 1, 5.00, 0, 0, '16900.00', '2020-01-30 06:15:24', '2020-01-30 06:15:24'),
(67, 'BRONZE56K LOGO LEATHER BELT BLACK', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.800 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Belt-Black-4LOW_1800x1800.jpg', 0, 1, 5.00, 0, 0, '24900.00', '2020-01-30 06:16:34', '2020-01-30 06:16:34');

-- --------------------------------------------------------

--
-- Структура таблицы `product_skus`
--

CREATE TABLE `product_skus` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_skus`
--

INSERT INTO `product_skus` (`id`, `title`, `description`, `price`, `stock`, `product_id`, `created_at`, `updated_at`) VALUES
(122, 'M', 'Размер М', '55900.00', 0, 58, '2020-01-30 01:54:55', '2020-01-30 01:54:55'),
(123, 'L', 'Размер L', '55900.00', 2, 59, '2020-01-30 02:42:37', '2020-01-30 02:42:37'),
(124, 'M', 'Размер M', '55900.00', 24, 59, '2020-01-30 02:42:37', '2020-01-30 02:42:37'),
(125, 'L', 'L', '49900.00', 10, 60, '2020-01-30 02:43:57', '2020-01-30 02:43:57'),
(126, 'M', 'M', '49900.00', 5, 60, '2020-01-30 02:43:57', '2020-01-30 02:43:57'),
(127, 'S', 'S', '49900.00', 23, 60, '2020-01-30 02:43:57', '2020-01-30 02:43:57'),
(128, 'L', 'L', '29900.00', 1, 61, '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(129, 'S', 'S', '29900.00', 3, 61, '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(130, 'S', 'S', '29900.00', 2, 61, '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(131, 'L', 'L', '17940.00', 2, 62, '2020-01-30 02:46:56', '2020-01-30 02:46:56'),
(132, 'M', 'M', '17940.00', 1, 62, '2020-01-30 02:46:56', '2020-01-30 02:46:56'),
(133, 'L', 'L', '21900.00', 1, 63, '2020-01-30 06:09:49', '2020-01-30 06:09:49'),
(134, 'M', 'M', '21900.00', 2, 63, '2020-01-30 06:09:49', '2020-01-30 06:09:49'),
(135, 'BRONZE56K MOUNTAIN BEANIE GREEN', '<table>	<tbody>		<tr>			<th>Вес</th>			<td>0.200 kg</td>		</tr>	</tbody></table>', '16900.00', 13, 64, '2020-01-30 06:10:59', '2020-01-30 06:10:59'),
(136, 'BRONSON BEARING RAW', '<table>	<tbody>		<tr>			<th>Вес</th>			<td>0.110 kg</td>		</tr>	</tbody></table>', '17900.00', 34, 65, '2020-01-30 06:12:32', '2020-01-30 06:12:32'),
(137, 'ALL', 'Общий размер', '16900.00', 3, 66, '2020-01-30 06:15:24', '2020-01-30 06:15:24'),
(138, 'ALL', 'ALL', '24900.00', 5, 67, '2020-01-30 06:16:34', '2020-01-30 06:16:34');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(102, 'Андрей Артышко Алексеевич', 'artyshko.andrey@gmail.com', '1581004168.jpg', '2020-01-12 02:40:22', '$2y$10$eJNi1Z2UHjb96hhUqxuhWerv3jjk9Cp/YCGV7bvl4UidmP6qQXsHy', 'eqBEzveWfkjhhqCiOvTYhnrGlwc85nKxbtDn3JoRBJLs3AIIU7av20qoY7sG', '2020-01-12 02:39:54', '2020-01-29 14:19:56'),
(105, 'Анжелика Дударева', 'adad.artyshko@mail.ru', '1581004168.jpg', '2020-02-05 17:00:00', '$2y$10$9NYA6fq/qW5iskFhARS5I.de0FUbgEIA.FmWu3w.yW3nSl9L/zWv6', 'F4M3XgZ0pkdJt9VUxJf3BYDznecz5wWiuWOAEsKi5Ail5TuvaoMPEw5i2vBD', '2020-01-27 15:36:48', '2020-02-06 15:49:28'),
(106, 'ANZHELIKA ARTYSHKO', 'lika.dudareva@gmail.com', '1581004168.jpg', NULL, '$2y$10$l5Eisw/yfNmepnwHJd7clOeVlljchofWtjWnz3ry2uXmq9zLjrKJa', NULL, '2020-02-03 08:04:08', '2020-02-03 08:04:08');

-- --------------------------------------------------------

--
-- Структура таблицы `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `country`, `city`, `street`, `contact_phone`, `currency_id`, `created_at`, `updated_at`) VALUES
(194, 102, 'Россия', 'Красноярск', 'ул. Горького, 24 кв 25, 660099', '+79029634366', 3, '2020-01-14 13:06:53', '2020-02-04 09:36:43'),
(195, 105, 'Россия', 'Красноярск', 'ул. Горького, 24 кв. 25, 660099', '+79029634366', 1, '2020-01-29 05:30:38', '2020-02-06 13:21:52');

-- --------------------------------------------------------

--
-- Структура таблицы `user_favorite_products`
--

CREATE TABLE `user_favorite_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `admin_operation_log`
--
ALTER TABLE `admin_operation_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_operation_log_user_id_index` (`user_id`);

--
-- Индексы таблицы `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_permissions_name_unique` (`name`);

--
-- Индексы таблицы `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_roles_name_unique` (`name`);

--
-- Индексы таблицы `admin_role_menu`
--
ALTER TABLE `admin_role_menu`
  ADD KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`);

--
-- Индексы таблицы `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`);

--
-- Индексы таблицы `admin_role_users`
--
ALTER TABLE `admin_role_users`
  ADD KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`);

--
-- Индексы таблицы `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_username_unique` (`username`);

--
-- Индексы таблицы `admin_user_permissions`
--
ALTER TABLE `admin_user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`);

--
-- Индексы таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_sku_id_foreign` (`product_sku_id`);

--
-- Индексы таблицы `coupon_codes`
--
ALTER TABLE `coupon_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_codes_code_unique` (`code`);

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_no_unique` (`no`),
  ADD UNIQUE KEY `orders_refund_no_unique` (`refund_no`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_coupon_code_id_foreign` (`coupon_code_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_product_sku_id_foreign` (`product_sku_id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_skus`
--
ALTER TABLE `product_skus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_skus_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`),
  ADD KEY `currency_id` (`currency_id`);

--
-- Индексы таблицы `user_favorite_products`
--
ALTER TABLE `user_favorite_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_favorite_products_user_id_foreign` (`user_id`),
  ADD KEY `user_favorite_products_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `admin_operation_log`
--
ALTER TABLE `admin_operation_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=397;

--
-- AUTO_INCREMENT для таблицы `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `admin_user_permissions`
--
ALTER TABLE `admin_user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `coupon_codes`
--
ALTER TABLE `coupon_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT для таблицы `product_skus`
--
ALTER TABLE `product_skus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT для таблицы `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT для таблицы `user_favorite_products`
--
ALTER TABLE `user_favorite_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_sku_id_foreign` FOREIGN KEY (`product_sku_id`) REFERENCES `product_skus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_coupon_code_id_foreign` FOREIGN KEY (`coupon_code_id`) REFERENCES `coupon_codes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_sku_id_foreign` FOREIGN KEY (`product_sku_id`) REFERENCES `product_skus` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_skus`
--
ALTER TABLE `product_skus`
  ADD CONSTRAINT `product_skus_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_favorite_products`
--
ALTER TABLE `user_favorite_products`
  ADD CONSTRAINT `user_favorite_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_favorite_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
