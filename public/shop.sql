-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 02 2020 г., 18:22
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
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Артышко', 'artyshko.andrey@gmail.com', NULL, '$2y$10$oVrjeU.N7GKcXXIiCcm.He8GgX2fKR9IggrE2AAGnMQiLUzBvIz02', 'EUFza77F47bk4YLnBFVFamFaau2P2kDTnzQvvppFTpAOvdiUJx8CSAnbtfJy', '2020-02-17 03:21:56', '2020-02-17 03:21:56');

-- --------------------------------------------------------

--
-- Структура таблицы `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `admin_password_resets`
--

INSERT INTO `admin_password_resets` (`email`, `token`, `created_at`) VALUES
('artyshko.andrey@gmail.com', '$2y$10$8fUWp4q5bNMhTuApOhYK1.LPUXMLEXTi10qX974ebNBTOy80NyahC', '2020-02-17 05:32:21');

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

--
-- Дамп данных таблицы `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_sku_id`, `amount`) VALUES
(9, 108, 125, 1),
(11, 107, 123, 1),
(16, 109, 125, 12),
(17, 109, 131, 1),
(18, 109, 128, 1),
(21, 102, 131, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Худи', NULL, NULL, NULL),
(2, 'Bronze56', 1, NULL, NULL),
(3, 'Шапки', NULL, NULL, NULL),
(4, 'Носки', NULL, NULL, NULL),
(5, 'Тапки', 2, NULL, NULL),
(6, 'Adidas', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `city_expresses`
--

CREATE TABLE `city_expresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `express_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `city_expresses`
--

INSERT INTO `city_expresses` (`id`, `name`, `express_id`, `created_at`, `updated_at`) VALUES
(1, 'Москва', 1, '2020-03-01 17:00:00', NULL),
(2, 'Киев', 1, '2020-03-01 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `coupons_categories`
--

CREATE TABLE `coupons_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_id` int(10) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `coupons_categories`
--

INSERT INTO `coupons_categories` (`id`, `coupon_id`, `category_id`) VALUES
(3, 2, 2),
(4, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `coupons_products`
--

CREATE TABLE `coupons_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `coupons_products`
--

INSERT INTO `coupons_products` (`id`, `coupon_id`, `product_id`) VALUES
(2, 3, 58),
(3, 3, 59),
(4, 3, 60);

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
  `min_amount` decimal(10,0) NOT NULL,
  `max_amount` decimal(10,0) NOT NULL,
  `disabled_other_coupons` tinyint(1) NOT NULL DEFAULT '0',
  `disabled_other_sales` tinyint(1) NOT NULL DEFAULT '0',
  `not_before` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `not_after` datetime NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `coupon_codes`
--

INSERT INTO `coupon_codes` (`id`, `name`, `code`, `type`, `value`, `total`, `used`, `min_amount`, `max_amount`, `disabled_other_coupons`, `disabled_other_sales`, `not_before`, `not_after`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 'wallride', 'wallride', 'fixed', '2000.00', 60, 3, '500', '2000', 1, 1, '2020-02-23 12:22:03', '2020-02-29 00:00:00', 1, '2020-02-22 17:00:00', '2020-02-24 09:33:58'),
(2, '2020', '2020', 'percent', '50.00', 30, 0, '1000', '50000', 0, 0, '2020-02-24 16:57:41', '2020-02-29 00:00:00', 0, '2020-02-24 09:57:41', '2020-02-24 10:04:42'),
(3, 'best333', 'best333', 'fixed', '10000.00', 10, 0, '1000', '10000', 1, 1, '2020-02-24 17:04:20', '2020-02-20 00:00:00', 0, '2020-02-24 10:04:20', '2020-02-24 10:04:26');

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
-- Структура таблицы `disabled_coupons_categories`
--

CREATE TABLE `disabled_coupons_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_id` int(10) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `disabled_coupons_categories`
--

INSERT INTO `disabled_coupons_categories` (`id`, `coupon_id`, `category_id`) VALUES
(7, 3, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `disabled_coupons_products`
--

CREATE TABLE `disabled_coupons_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `disabled_coupons_products`
--

INSERT INTO `disabled_coupons_products` (`id`, `coupon_id`, `product_id`) VALUES
(2, 3, 60);

-- --------------------------------------------------------

--
-- Структура таблицы `express_companies`
--

CREATE TABLE `express_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Настраиваемая',
  `cost` decimal(10,0) DEFAULT NULL,
  `step` double(10,2) DEFAULT NULL,
  `cost_step` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `express_companies`
--

INSERT INTO `express_companies` (`id`, `name`, `enabled`, `type`, `cost`, `step`, `cost_step`, `created_at`, `updated_at`) VALUES
(1, 'EMS', 1, 'Настраиваемая', NULL, NULL, NULL, NULL, '2020-03-02 14:25:43'),
(2, 'ASE', 1, 'Настраиваемая', '1000', 1.40, '500', NULL, '2020-03-02 14:52:42'),
(3, 'Самовывоз', 1, '0 тг.', NULL, NULL, NULL, NULL, '2020-03-01 13:31:31');

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
(4, '2018_12_19_152909_create_user_addresses_table', 1),
(5, '2018_12_22_042326_create_products_table', 1),
(6, '2018_12_22_042331_create_product_skus_table', 1),
(7, '2018_12_22_065917_create_user_favorite_products_table', 1),
(8, '2018_12_22_071404_create_cart_items_table', 1),
(10, '2018_12_23_042632_create_order_items_table', 1),
(12, '2018_12_23_103753_orders_add_coupon_code_id', 1),
(13, '2020_01_28_234016_create_currencies_table', 2),
(15, '2020_02_15_154106_create_admins_table', 4),
(16, '2020_02_16_095727_admin_password_resets', 4),
(17, '2020_02_22_182652_coupons_products', 5),
(18, '2020_02_22_190314_categories', 6),
(19, '2020_02_22_190430_coupons_categories', 7),
(21, '2018_12_23_103610_create_coupon_codes_table', 8),
(22, '2020_02_23_124447_disabled_coupons_categories', 9),
(23, '2020_02_23_124857_disabled_coupons_products', 9),
(24, '2020_02_26_142913_create_express_companies_table', 10),
(25, '2020_02_26_142927_create_orders_table', 11),
(26, '2020_03_02_215746_create_city_expresses_table', 12);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `reviewed` tinyint(1) NOT NULL DEFAULT '0',
  `ship_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `ship_data` text COLLATE utf8mb4_unicode_ci,
  `id_express_company` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `no`, `user_id`, `address`, `total_amount`, `paid_at`, `payment_method`, `payment_no`, `closed`, `reviewed`, `ship_status`, `ship_data`, `id_express_company`, `created_at`, `updated_at`) VALUES
(1, '123123123', 102, '{\"address\":\"\\u0420\\u043e\\u0441\\u0441\\u0438\\u044f, \\u041a\\u0440\\u0430\\u0441\\u043d\\u043e\\u044f\\u0440\\u0441\\u043a, \\u0443\\u043b. \\u0413\\u043e\\u0440\\u044c\\u043a\\u043e\\u0433\\u043e, 24 \\u043a\\u0432 25, 660099\",\"contact_name\":\"\\u0410\\u043d\\u0434\\u0440\\u0435\\u0439 \\u0410\\u0440\\u0442\\u044b\\u0448\\u043a\\u043e \\u0410\\u043b\\u0435\\u043a\\u0441\\u0435\\u0435\\u0432\\u0438\\u0447\",\"contact_phone\":\"+79029634366\"}', '100000', '2020-02-25 00:00:00', 'card', '233144', 0, 0, 'pending', '{\"express_no\":\"123\"}', 1, '2020-02-28 17:00:00', '2020-02-29 08:59:29'),
(2, '20200226170503735991', 102, '{\"address\":\"\\u0420\\u043e\\u0441\\u0441\\u0438\\u044f, \\u041a\\u0440\\u0430\\u0441\\u043d\\u043e\\u044f\\u0440\\u0441\\u043a, \\u0443\\u043b. \\u0413\\u043e\\u0440\\u044c\\u043a\\u043e\\u0433\\u043e, 24 \\u043a\\u0432 25, 660099\",\"contact_name\":\"\\u0410\\u043d\\u0434\\u0440\\u0435\\u0439 \\u0410\\u0440\\u0442\\u044b\\u0448\\u043a\\u043e \\u0410\\u043b\\u0435\\u043a\\u0441\\u0435\\u0435\\u0432\\u0438\\u0447\",\"contact_phone\":\"+79029634366\"}', '525000', NULL, 'card', NULL, 0, 0, 'paid', NULL, 1, '2020-02-26 10:05:03', '2020-02-26 10:05:03');

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

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_sku_id`, `amount`, `price`, `rating`, `review`, `reviewed_at`) VALUES
(3, 2, 63, 133, 1, '21900.00', NULL, NULL, NULL),
(4, 2, 59, 124, 9, '55900.00', NULL, NULL, NULL);

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
(59, 'BRONZE56K HIGH PERFORMACE WINDBREAKER AIR FORCE BLUE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Windbreaker-Blue-1LOW_1800x1800.jpg', 1, 1, 5.00, 17, 0, '55900.00', '2020-01-30 02:42:36', '2020-02-20 09:28:00'),
(60, 'BRONZE56K HARD WEAR CARGO PANTS DARK NAVY', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Pants-Cargo-Blue-1LOW_1800x1800-300x300.jpg', 1, 1, 5.00, 0, 0, '49900.00', '2020-01-30 02:43:57', '2020-01-30 02:43:57'),
(61, 'POLAR PATTERNED POLO SHIRT RED', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/PATTERNED-POLO-SHIRT-RED-1.jpg', 1, 0, 5.00, 0, 0, '29900.00', '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(62, 'DIME POLO SHIRT PURPLE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/POLO_SHIRT_PURPLE_1_1400x1400-300x300.jpg', 1, 1, 5.00, 0, 0, '17940.00', '2020-01-30 02:46:56', '2020-01-30 02:46:56'),
(63, 'BRONZE56K HARDWARE TECHNOLOGY LONGSLEEVE CARDINAL', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.500 kg</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/LSTee-Bronze-Technology-Red-1LOW.jpg', 1, 1, 5.00, 0, 0, '21900.00', '2020-01-30 06:09:49', '2020-01-30 06:09:49'),
(64, 'BRONZE56K MOUNTAIN BEANIE GREEN', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.200 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Beanie-Green-1LOW_1800x1800.jpg', 1, 1, 5.00, 0, 0, '16900.00', '2020-01-30 06:10:59', '2020-01-30 06:10:59'),
(65, 'BRONSON BEARING RAW', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.110 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/BR_RAW_SingleCase_Angled.jpg', 0, 0, 5.00, 0, 0, '17900.00', '2020-01-30 06:12:32', '2020-01-30 06:12:32'),
(66, 'BRONZE56K 2020 HAT KHAKI/CHARCOAL', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.200 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Hat-2020-Khaki-Grey-1LOW_800x.jpg', 0, 1, 5.00, 0, 0, '16900.00', '2020-01-30 06:15:24', '2020-01-30 06:15:24'),
(67, 'BRONZE56K LOGO LEATHER BELT BLACK', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.800 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/Belt-Black-4LOW_1800x1800.jpg', 0, 1, 5.00, 0, 0, '24900.00', '2020-01-30 06:16:34', '2020-01-30 06:16:34'),
(68, 'BRONZE56K LOGO TENNIS LONGSLEEVE WHITE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/LSTee-TennisBall-White-1LOW_1800.jpg', 1, 1, 5.00, 0, 0, '21900.00', '2020-02-08 08:59:19', '2020-02-08 08:59:19'),
(69, 'POLAR LIGHTWEIGHT CAP-BLUE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>0.90 kg</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/LIGHTWEIGHT-CAP-BLUE-1.jpg', 1, 1, 5.00, 0, 0, '18900.00', '2020-02-08 09:00:40', '2020-02-08 09:00:40'),
(70, 'POLAR STRIPE PUFFER', '<p>SHELL: 100% NYLON TASLAN</p>\r\n\r\n<p>&ndash; WATER REPELLENT</p>\r\n\r\n<p>&ndash; DOWNPROOF</p>\r\n\r\n<p>&ndash; BREATHABLE</p>\r\n\r\n<p>&ndash; MOISTURE PERMEABLE</p>\r\n\r\n<p>LINING: 100% POLYESTER</p>\r\n\r\n<p>FILLING: 90% DOWN &ndash; 10% OTHER FEATHERS</p>\r\n\r\n<p>&ndash; 750 FILL POWER &ndash; FILL POWER MEASURES THE LOFT OF THE DOWN AND RANGES FROM 450 TO 1000 FOR CLOTHING</p>\r\n\r\n<p>YKK ZIPPERS</p>\r\n\r\n<p>CUSTOMISED ZIP PULLER</p>\r\n\r\n<p>FULL-ZIP FRONT WITH 2-WAY ZIPPER OPENING</p>\r\n\r\n<p>EMBROIDERY</p>\r\n\r\n<p>DRAWCORD HEM</p>\r\n\r\n<p>HAND WASH</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>MADE IN CHINA</p>\r\n\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>Вес</th>\r\n			<td>Н/Д</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/STRIPE-PUFFER-NAVY-1.jpg', 1, 1, 5.00, 0, 0, '107900.00', '2020-02-08 09:02:20', '2020-02-08 09:02:20'),
(71, 'SWIM SHORTS ORANGE', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<th>ес</th>\r\n			<td>0.400 kg</td>\r\n		</tr>\r\n		<tr>\r\n			<th>Размеры</th>\r\n			<td>\r\n			<p>L, M, S</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'images/p3qpmwlFTPmq2tGi8Xu2_SWIM-SHORTS-ORANGE-1_672x672.jpg', 1, 1, 5.00, 0, 0, '27900.00', '2020-02-08 09:03:32', '2020-02-08 09:03:32'),
(72, 'POLAR CORD JACKET', '<p>COLOUR: TAN</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>SHELL: 100% COTTON</p>\r\n\r\n<p>THICK CORDUROY &ndash; 8 WAVES PER INCH</p>\r\n\r\n<p>LINING: 100% POLYESTER</p>\r\n\r\n<p>THICK SHERPA FABRIC</p>\r\n\r\n<p>YKK ZIPPER &amp; BUTTONS</p>\r\n\r\n<p>CUSTOMISED ZIP PULLER</p>\r\n\r\n<p>TONAL EMBROIDERY</p>\r\n\r\n<p>WIDE FIT</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>MADE IN POLAND</p>', 'images/CORD-JACKET-TAN-2.jpg', 1, 1, 5.00, 0, 0, '79900.00', '2020-02-08 09:04:24', '2020-02-08 09:04:24'),
(73, 'POLAR WOOL CAP BLK', '<p>COLOUR: BLACK</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>80% POLYESTER &ndash; 20% POLYAMIDE</p>\r\n\r\n<p>WOOL&nbsp;FABRIC</p>\r\n\r\n<p>UNSTRUCTURED 6-PANEL CAP</p>\r\n\r\n<p>PRE-BENT&nbsp;BRIM</p>\r\n\r\n<p>EMBROIDERY ON FRONT AND BACK</p>\r\n\r\n<p>SQUARE LOW&nbsp;FIT</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>MADE IN POLAND</p>', 'images/WOOL-CAP-BLACK-1.jpg', 1, 1, 5.00, 0, 0, '19900.00', '2020-02-08 09:05:31', '2020-02-08 09:05:31');

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
(123, 'LL', 'Размер L', '55900.00', 0, 59, '2020-01-30 02:42:37', '2020-02-20 09:15:05'),
(124, 'M', 'Размер M', '55900.00', 0, 59, '2020-01-30 02:42:37', '2020-02-26 10:05:03'),
(125, 'L', 'L', '49900.00', 10, 60, '2020-01-30 02:43:57', '2020-02-11 17:08:59'),
(126, 'M', 'M', '49900.00', 5, 60, '2020-01-30 02:43:57', '2020-02-11 12:55:35'),
(127, 'S', 'S', '49900.00', 23, 60, '2020-01-30 02:43:57', '2020-01-30 02:43:57'),
(128, 'L', 'L', '29900.00', 1, 61, '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(129, 'S', 'S', '29900.00', 3, 61, '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(130, 'S', 'S', '29900.00', 2, 61, '2020-01-30 02:45:32', '2020-01-30 02:45:32'),
(131, 'L', 'L', '17940.00', 2, 62, '2020-01-30 02:46:56', '2020-02-11 17:05:09'),
(132, 'M', 'M', '17940.00', 1, 62, '2020-01-30 02:46:56', '2020-01-30 02:46:56'),
(133, 'L', 'L', '21900.00', 0, 63, '2020-01-30 06:09:49', '2020-02-26 10:05:03'),
(134, 'M', 'M', '21900.00', 2, 63, '2020-01-30 06:09:49', '2020-01-30 06:09:49'),
(135, 'S', '<table>	<tbody>		<tr>			<th>Вес</th>			<td>0.200 kg</td>		</tr>	</tbody></table>', '16900.00', 13, 64, '2020-01-30 06:10:59', '2020-01-30 06:10:59'),
(136, 'M', '<table>	<tbody>		<tr>			<th>Вес</th>			<td>0.110 kg</td>		</tr>	</tbody></table>', '17900.00', 34, 65, '2020-01-30 06:12:32', '2020-01-30 06:12:32'),
(137, 'ALL', 'Общий размер', '16900.00', 3, 66, '2020-01-30 06:15:24', '2020-01-30 06:15:24'),
(138, 'ALL', 'ALL', '24900.00', 5, 67, '2020-01-30 06:16:34', '2020-01-30 06:16:34'),
(139, 'M', 'M', '21900.00', 10, 68, '2020-02-08 08:59:19', '2020-02-12 09:10:07'),
(140, 'S', 'S', '21900.00', 3, 68, '2020-02-08 08:59:19', '2020-02-12 09:10:07'),
(141, 'ALL', 'All', '18900.00', 14, 69, '2020-02-08 09:00:40', '2020-02-08 09:00:40'),
(142, 'M', 'M', '107900.00', 3, 70, '2020-02-08 09:02:20', '2020-02-12 09:10:07'),
(143, 'L', 'L', '27900.00', 14, 71, '2020-02-08 09:03:32', '2020-02-12 09:10:07'),
(144, 'M', 'M', '27900.00', 16, 71, '2020-02-08 09:03:32', '2020-02-08 09:03:32'),
(145, 'S', 'S', '79900.00', 90, 72, '2020-02-08 09:04:24', '2020-02-08 09:04:24'),
(146, 'ALL', 'ALL', '19900.00', 18, 73, '2020-02-08 09:05:31', '2020-02-12 09:10:07');

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
(102, 'Андрей Артышко Алексеевич', 'artyshko.andrey@gmail.com', '1581049164.jpg', '2020-01-12 02:40:22', '$2y$10$eJNi1Z2UHjb96hhUqxuhWerv3jjk9Cp/YCGV7bvl4UidmP6qQXsHy', 'B1XJLLZnK2Z8duEgWNV2ULJivrChsq72ZmVecVgJYcLH08BzROBQirTjbWj5', '2020-01-12 02:39:54', '2020-02-07 04:19:26'),
(106, 'ANZHELIKA ARTYSHKO', 'lika.dudareva@gmail.com', '1581004168.jpg', NULL, '$2y$10$l5Eisw/yfNmepnwHJd7clOeVlljchofWtjWnz3ry2uXmq9zLjrKJa', NULL, '2020-02-03 08:04:08', '2020-02-03 08:04:08'),
(107, 'Роман Иминов', 'iminovarts@gmail.com', NULL, '2020-02-11 08:06:18', '$2y$10$XCMQtYi8xMArrx0SCTxrzOl55OEtCLk.opVg/sGQnu9c/DJTsIsX6', NULL, '2020-02-11 07:48:06', '2020-02-11 08:06:18'),
(108, 'Андрей Артышко', 'adad.artyshko@mail.ru', NULL, '2020-02-11 07:57:52', '$2y$10$nQpOvq/evc4nEI2jeqgGYeYHviuaAhapPO/SggFKJZeiMuG4K168u', 'kHfRnLezLkyRxqtFQyyjeC6LisWcAzesyMrgYjQPXFTTOzdSAe14y8fsuFOM', '2020-02-11 07:56:40', '2020-02-11 07:57:52'),
(109, 'Завирюха Богдан', 'bogdan@mail.ru', NULL, NULL, '$2y$10$opf8ZV2ytYVlmUbMTcJq5OVBkNLuyMnDdDU8NQZ/78zvIjqi/B7Di', NULL, '2020-02-20 09:13:50', '2020-02-20 09:13:50');

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
(194, 102, 'Россия', 'Красноярск', 'ул. Горького, 24 кв 25, 660099', '+79029634366', 1, '2020-01-14 13:06:53', '2020-02-26 09:01:31'),
(196, 108, 'Россия', 'Красноярск', 'Горького 24, 25', '89029634366', 3, '2020-02-11 08:07:09', '2020-02-11 08:07:09');

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
-- Дамп данных таблицы `user_favorite_products`
--

INSERT INTO `user_favorite_products` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 102, 60, '2020-02-10 11:41:00', '2020-02-10 11:41:00'),
(2, 102, 66, '2020-02-10 11:52:07', '2020-02-10 11:52:07'),
(3, 102, 64, '2020-02-10 12:26:02', '2020-02-10 12:26:02'),
(4, 102, 58, '2020-02-11 04:20:37', '2020-02-11 04:20:37'),
(5, 102, 62, '2020-02-11 04:49:13', '2020-02-11 04:49:13'),
(6, 107, 58, '2020-02-11 08:06:58', '2020-02-11 08:06:58'),
(7, 107, 59, '2020-02-11 08:07:43', '2020-02-11 08:07:43');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Индексы таблицы `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD KEY `admin_password_resets_email_index` (`email`);

--
-- Индексы таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_sku_id_foreign` (`product_sku_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `city_expresses`
--
ALTER TABLE `city_expresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_expresses_express_id_foreign` (`express_id`);

--
-- Индексы таблицы `coupons_categories`
--
ALTER TABLE `coupons_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_categories_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupons_categories_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `coupons_products`
--
ALTER TABLE `coupons_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_products_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupons_products_product_id_foreign` (`product_id`);

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
-- Индексы таблицы `disabled_coupons_categories`
--
ALTER TABLE `disabled_coupons_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disabled_coupons_categories_coupon_id_foreign` (`coupon_id`),
  ADD KEY `disabled_coupons_categories_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `disabled_coupons_products`
--
ALTER TABLE `disabled_coupons_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disabled_coupons_products_coupon_id_foreign` (`coupon_id`),
  ADD KEY `disabled_coupons_products_product_id_foreign` (`product_id`);

--
-- Индексы таблицы `express_companies`
--
ALTER TABLE `express_companies`
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
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_id_express_company_foreign` (`id_express_company`);

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
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `city_expresses`
--
ALTER TABLE `city_expresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `coupons_categories`
--
ALTER TABLE `coupons_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `coupons_products`
--
ALTER TABLE `coupons_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `coupon_codes`
--
ALTER TABLE `coupon_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `disabled_coupons_categories`
--
ALTER TABLE `disabled_coupons_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `disabled_coupons_products`
--
ALTER TABLE `disabled_coupons_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `express_companies`
--
ALTER TABLE `express_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT для таблицы `product_skus`
--
ALTER TABLE `product_skus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT для таблицы `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT для таблицы `user_favorite_products`
--
ALTER TABLE `user_favorite_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Ограничения внешнего ключа таблицы `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `city_expresses`
--
ALTER TABLE `city_expresses`
  ADD CONSTRAINT `city_expresses_express_id_foreign` FOREIGN KEY (`express_id`) REFERENCES `express_companies` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `coupons_categories`
--
ALTER TABLE `coupons_categories`
  ADD CONSTRAINT `coupons_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupons_categories_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupon_codes` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `coupons_products`
--
ALTER TABLE `coupons_products`
  ADD CONSTRAINT `coupons_products_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupon_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupons_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `disabled_coupons_categories`
--
ALTER TABLE `disabled_coupons_categories`
  ADD CONSTRAINT `disabled_coupons_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disabled_coupons_categories_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupon_codes` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `disabled_coupons_products`
--
ALTER TABLE `disabled_coupons_products`
  ADD CONSTRAINT `disabled_coupons_products_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupon_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disabled_coupons_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_id_express_company_foreign` FOREIGN KEY (`id_express_company`) REFERENCES `express_companies` (`id`) ON DELETE SET NULL,
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
