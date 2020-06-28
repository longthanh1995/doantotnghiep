-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jun 22, 2020 at 04:04 PM
-- Server version: 5.7.29
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `subject_id` int(11) NOT NULL DEFAULT '0',
  `action` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `object_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `object_id` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rescheduled_user_id` int(11) DEFAULT NULL,
  `rescheduled_from_id` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `doctor_timetable_id` int(11) DEFAULT NULL,
  `appointment_status_id` int(10) UNSIGNED DEFAULT NULL,
  `appointment_type_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_condition_id` int(10) UNSIGNED DEFAULT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` mediumtext COLLATE utf8_unicode_ci,
  `booking_reason` varchar(800) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_patient_id` int(11) DEFAULT NULL,
  `book_source` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `verify_attempted` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `note` longtext COLLATE utf8_unicode_ci,
  `is_finished_summary` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `reason_id` int(11) DEFAULT NULL,
  `extra_note` text COLLATE utf8_unicode_ci,
  `has_patient_arrived` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `referred_doctor_id` int(11) DEFAULT NULL,
  `referred_clinic_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_fees`
--

CREATE TABLE `appointment_fees` (
  `appointment_id` int(11) NOT NULL,
  `booking_fee` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `tax_amount` decimal(13,4) DEFAULT NULL,
  `currency_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(13,4) DEFAULT NULL,
  `fee_currency` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fail_message` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `tax_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GST',
  `has_tax` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `surcharge` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_files`
--

CREATE TABLE `appointment_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `appointment_id` int(11) NOT NULL,
  `file_id` char(26) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_health_summaries`
--

CREATE TABLE `appointment_health_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) NOT NULL DEFAULT '0',
  `summary` longtext COLLATE utf8_unicode_ci,
  `note` longtext COLLATE utf8_unicode_ci,
  `plan` longtext COLLATE utf8_unicode_ci,
  `visit_doctor_if` longtext COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_reasons`
--

CREATE TABLE `appointment_reasons` (
  `id` int(10) UNSIGNED NOT NULL,
  `reason` text COLLATE utf8_unicode_ci,
  `appointment_type_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appointment_reasons`
--

INSERT INTO `appointment_reasons` (`id`, `reason`, `appointment_type_id`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'General Consultation', 1, NULL, '2020-01-01 03:34:28', '2020-01-01 03:34:28'),
(2, 'General Checking', 1, NULL, '2020-01-01 03:34:40', '2020-01-01 03:34:40'),
(3, 'Total Body Testing', 1, NULL, '2020-01-01 03:34:55', '2020-01-01 03:34:55'),
(4, 'Chronic Disease follow up', 2, NULL, '2020-01-01 03:35:15', '2020-01-01 03:35:15'),
(5, 'Vaccin Injections', 7, NULL, '2020-01-01 03:35:29', '2020-01-01 03:35:29'),
(6, 'Review of Chronic Condition', 22, NULL, '2020-01-04 14:47:37', '2020-01-04 14:47:37'),
(7, 'Acute Problem', 22, NULL, '2020-01-04 14:47:57', '2020-01-04 14:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_statuses`
--

CREATE TABLE `appointment_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appointment_statuses`
--

INSERT INTO `appointment_statuses` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Verifying', NULL, '2020-01-12 08:27:32', '2020-01-12 08:27:32'),
(2, 'Confirmed', NULL, '2020-01-12 08:27:32', '2020-01-12 08:27:32'),
(3, 'Visited', NULL, '2020-01-12 08:27:32', '2020-01-12 08:27:32'),
(4, 'Cancelled', NULL, '2020-01-12 08:27:32', '2020-01-12 08:27:32'),
(5, 'No-show', NULL, '2020-01-12 08:27:32', '2020-01-12 08:27:32'),
(6, 'Verification Failed', NULL, '2020-01-12 08:27:32', '2020-01-12 08:27:32'),
(7, 'Late', NULL, '2020-01-12 08:27:32', '2020-01-12 08:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_types`
--

CREATE TABLE `appointment_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `category` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'general',
  `is_free_diabetes_test` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appointment_types`
--

INSERT INTO `appointment_types` (`id`, `name`, `clinic_id`, `is_active`, `category`, `is_free_diabetes_test`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'General Consultation ', NULL, 1, 'general', 0, NULL, '2020-01-17 15:12:00', '2020-01-23 12:30:33'),
(2, 'Chronic Disease follow up', NULL, 1, 'general', 0, NULL, '2020-01-17 15:12:00', '2020-01-20 10:46:09'),
(3, 'General Consultation follow up', NULL, 1, 'general', 0, NULL, '2020-01-17 15:12:00', '2020-01-20 10:46:14'),
(4, 'General Health Screening', NULL, 1, 'general', 0, NULL, '2020-01-17 15:12:00', '2020-01-20 10:46:20'),
(5, 'Review of Health Screening', NULL, 0, 'general', 0, NULL, '2020-01-17 15:12:01', '2020-01-17 15:12:01'),
(6, 'Repeat Health Screening ', NULL, 0, 'general', 0, NULL, '2020-01-17 15:12:01', '2020-01-17 15:12:01'),
(7, 'Vaccination', NULL, 1, 'general', 0, NULL, '2020-01-17 15:12:00', '2020-01-20 10:52:51'),
(8, 'Accidents / Injuries Consultation', NULL, 0, 'general', 0, NULL, '2020-01-17 15:12:00', '2020-01-17 15:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `fingerprint` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `last4` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` point DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `clinic_type_id` int(10) UNSIGNED DEFAULT NULL,
  `phone_country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time_zone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_profile_id` int(10) UNSIGNED DEFAULT NULL,
  `working_week_days` json DEFAULT NULL,
  `enable_queue_feature` tinyint(3) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`id`, `name`, `address`, `zip`, `city`, `location`, `email`, `password`, `country_id`, `clinic_type_id`, `phone_country_code`, `phone_number`, `profile_image_id`, `time_zone`, `tax_profile_id`, `working_week_days`, `enable_queue_feature`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Healthmark Family Medicine Clinic (Choa Chu Kang)', 'Blk 601 Choa Chu Kang Street 62 #01-09 Singapore 680601', '680601', 'Singapore', 0x000000000101000000e0c28190acef5940af38e686f059f63f, 'tysiaw@gmail.com', '123', 192, 1, '+65', '67672281', 'ciq5opeuypg7xcyit8d4t89jcc', 'Asia/Singapore', 1, '[1, 2, 3, 4, 5, 6, 7]', 1, NULL, '2016-05-10 00:00:00', '2020-05-05 04:44:54'),
(37, 'Trinity Medical Centre', '28 College St', '5015', 'Port Adelaide ', 0x00000000010100000091d618744250614007280d350a6d41c0, 'michaelsiaw@hotmail.com', NULL, 13, 1, '+61', '82492000', 'E8iBPc3FcxfWMjJsBJTylACEo4', 'Australia/Adelaide', 7, '[1, 2, 3, 4, 5, 6, 7]', 0, NULL, '2016-11-27 12:43:27', '2019-06-06 10:12:58'),
(43, 'Homecare Singapore', 'Blk 601 Choa Chu Kang Street 62 #01-09 Singapore 680601', '100000', 'Singapore', 0x000000000101000000e0c28190acef5940af38e686f059f63f, 'support@manadr.com', NULL, 192, 3, '+65', '67672281', NULL, 'Asia/Singapore', 14, '[1, 2, 3, 4, 5, 6, 7]', 0, NULL, '2017-03-28 11:21:14', '2020-04-14 08:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `clinic_types`
--

CREATE TABLE `clinic_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clinic_types`
--

INSERT INTO `clinic_types` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'clinic', NULL, NULL, NULL),
(2, 'dental', NULL, NULL, NULL),
(3, 'house_call', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `iso` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso3` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nice_name` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_region` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_code` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_currency_amount` int(10) UNSIGNED DEFAULT NULL,
  `is_support_twilo_alp` tinyint(3) UNSIGNED DEFAULT NULL,
  `ordering` int(10) UNSIGNED DEFAULT NULL,
  `first_id_letters` json DEFAULT NULL,
  `is_frequently_selected` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doctor_title_id` int(10) UNSIGNED DEFAULT NULL,
  `profile_image_id` char(26) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medical_school_id` int(10) UNSIGNED DEFAULT NULL,
  `phone_country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `office_hours` longtext COLLATE utf8_unicode_ci,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` datetime NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `invited_by_doctor_id` int(11) DEFAULT NULL,
  `verification_status` tinyint(3) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `email`, `name`, `doctor_title_id`, `profile_image_id`, `medical_school_id`, `phone_country_code`, `phone_number`, `office_hours`, `website`, `country_id`, `gender`, `remember_token`, `date_of_birth`, `address`, `user_id`, `invited_by_doctor_id`, `verification_status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(187, 'ryan.nguyen@manadr.com', 'Dr Ryan Nguyen (Staging)', 1, '2BBBzMqr1Capfj7w1aoOob3b12', NULL, '+84', '967470983', '8A.M to 19:30P.M', 'https://manadr.com', 192, 'male', NULL, '1995-10-16 00:00:00', 'ha noi, viet nam', 964, NULL, 2, NULL, '2019-10-23 08:45:47', '2020-05-25 06:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_booking_fees`
--

CREATE TABLE `doctor_booking_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `fee_currency` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee_amount` decimal(13,4) DEFAULT NULL,
  `appointment_type_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_clinics`
--

CREATE TABLE `doctor_clinics` (
  `id` int(10) UNSIGNED NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `primary` tinyint(3) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_clinics`
--

INSERT INTO `doctor_clinics` (`id`, `doctor_id`, `clinic_id`, `primary`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 187, 1, NULL, NULL, '2020-05-18 09:05:23', '2020-05-18 09:05:23'),
(2, 187, 37, NULL, NULL, '2020-05-18 09:05:23', '2020-05-18 09:05:23');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_medical_schools`
--

CREATE TABLE `doctor_medical_schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medical_school_id` int(10) UNSIGNED DEFAULT NULL,
  `date_of_graduation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_qualifications`
--

CREATE TABLE `doctor_qualifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `issuer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issued_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `doctor_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_settings`
--

CREATE TABLE `doctor_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_settings`
--

INSERT INTO `doctor_settings` (`id`, `doctor_id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 187, 'timezone', 'Asia/Singapore', '2020-03-06 10:33:15', '2020-03-06 10:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_timetables`
--

CREATE TABLE `doctor_timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `available` tinyint(3) UNSIGNED DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `clinic_id` int(11) DEFAULT NULL,
  `is_booked` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `appointment_type_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_timetable_configs`
--

CREATE TABLE `doctor_timetable_configs` (
  `doctor_id` int(10) UNSIGNED NOT NULL,
  `appointment_type_id` int(11) NOT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_titles`
--

CREATE TABLE `doctor_titles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `title_image_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctor_titles`
--

INSERT INTO `doctor_titles` (`id`, `title`, `title_image_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Doctor', 'khundg7cp3g37ytbndceqzpfny', NULL, NULL, NULL),
(2, 'Dentist', 'qeu3yhj7i3rgjbqt98sypcimxo', NULL, NULL, NULL),
(3, 'Specialist', 'cpd6kb453jrgj8wrmtcor9gt7a', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `media_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `width` int(10) UNSIGNED DEFAULT NULL,
  `height` int(10) UNSIGNED DEFAULT NULL,
  `size` int(10) UNSIGNED DEFAULT NULL,
  `extension` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `container` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `original_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_schools`
--

CREATE TABLE `medical_schools` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medical_schools`
--

INSERT INTO `medical_schools` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'National University Of Singapore', NULL, '2016-06-22 11:17:38', '2016-06-22 11:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2020_05_21_092250_create_doctors_table', 1),
('2020_05_21_093537_create_doctor_medical_schools_table', 1),
('2020_05_21_093858_create_doctor_qualifications_table', 1),
('2020_05_21_094146_create_doctor_settings_table', 1),
('2020_05_21_094534_create_doctor_titles_table', 1),
('2020_05_21_094840_create_medical_schools_table', 1),
('2020_05_21_094949_create_otp_passwords_table', 1),
('2020_05_21_095358_create_relationships_table', 1),
('2020_05_21_095510_create_reminder_jobs_table', 1),
('2020_05_25_154357_create_activities_table', 1),
('2020_05_26_011019_create_countries__table', 1),
('2020_05_26_013421_create_clinic_types__table', 1),
('2020_05_26_015957_create_patients__table', 1),
('2020_05_26_121807_create_user_relatives_table', 1),
('2020_05_26_123641_create_tax_profiles_table', 1),
('2020_05_26_124415_create_images_table', 1),
('2020_05_26_134559_create_doctor_clinics_table', 1),
('2020_05_26_135106_create_clinics_table', 1),
('2020_05_26_140216_create_cards_table', 1),
('2020_05_26_141254_create_appointments_table', 1),
('2020_05_26_143446_create_appointment_fees_table', 1),
('2020_05_26_144748_create_appointment_files_table', 1),
('2020_05_26_145036_create_appointment_health_summaries_table', 1),
('2020_05_26_145548_create_appointment_reasons_table', 1),
('2020_05_26_145734_create_appointment_statuses_table', 1),
('2020_05_26_145855_create_appointment_types_table', 1),
('2020_05_26_150645_create_doctor_booking_fees_table', 1),
('2020_05_26_151050_create_doctor_timetable_configs_table', 1),
('2020_05_26_161003_create_doctor_timetables_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `otp_passwords`
--

CREATE TABLE `otp_passwords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `secret_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `table_type` int(10) UNSIGNED DEFAULT NULL,
  `otp_token` char(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otp_token_used` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `call_token` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_attempts` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_country_id` int(10) UNSIGNED NOT NULL,
  `profile_image_id` char(26) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_locked` tinyint(3) UNSIGNED DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medical_record_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `race` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_arrival` date DEFAULT NULL,
  `contact_number` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_port_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_free_text` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `guardian_patient_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `alias` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resident_country_id` int(10) UNSIGNED DEFAULT NULL,
  `id_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deceased` tinyint(4) NOT NULL DEFAULT '0',
  `verified` tinyint(4) NOT NULL DEFAULT '0',
  `imported_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imported_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imported_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_imported_record` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `medical_condition` longtext COLLATE utf8_unicode_ci,
  `drug_allergy` longtext COLLATE utf8_unicode_ci,
  `stripe_customer_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_already_appointment` tinyint(4) NOT NULL DEFAULT '0',
  `address_block` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apartment_number` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `gender`, `date_of_birth`, `email`, `phone_number`, `phone_country_code`, `address_street`, `address_city`, `address_zip`, `issue_country_id`, `profile_image_id`, `is_locked`, `address`, `medical_record_number`, `race`, `date_of_arrival`, `contact_number`, `pass_port_number`, `country_free_text`, `user_id`, `guardian_patient_id`, `created_by`, `alias`, `resident_country_id`, `id_number`, `deceased`, `verified`, `imported_phone`, `imported_name`, `imported_email`, `is_imported_record`, `medical_condition`, `drug_allergy`, `stripe_customer_id`, `has_already_appointment`, `address_block`, `apartment_number`, `deleted_at`, `created_at`, `updated_at`) VALUES
(680, 'Ryan', 'Nguyen (Staging)', 'Male', '1995-10-16', 'longnguyenvan995@gmail.com', '9369258147', '+65', NULL, NULL, '', 232, 'c88ckuwjot8nicqm1mzo5c3p4c', NULL, 'My Address jjjdjjid', '', '', NULL, '', '', '', 1260, NULL, 1260, '', 192, 'N1245', 0, 0, '', '', '', 0, '', '', 'cus_HEqYymjMZrbOG5', 1, '', '', NULL, '2020-04-25 09:05:41', '2020-06-18 03:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `relationships`
--

CREATE TABLE `relationships` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `relationships`
--

INSERT INTO `relationships` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Me', NULL, NULL, NULL),
(2, 'Son', NULL, NULL, NULL),
(3, 'Daughter', NULL, NULL, NULL),
(4, 'Mother', NULL, NULL, NULL),
(5, 'Father', NULL, NULL, NULL),
(6, 'Brother', NULL, NULL, NULL),
(7, 'Sister', NULL, NULL, NULL),
(8, 'Grandfather', NULL, NULL, NULL),
(9, 'Grandmother', NULL, NULL, NULL),
(10, 'Friend', NULL, NULL, NULL),
(11, 'Wife', NULL, NULL, NULL),
(12, 'Husband', NULL, NULL, NULL),
(13, 'Boyfriend', NULL, NULL, NULL),
(14, 'Girlfriend', NULL, NULL, NULL),
(15, 'Cousin', NULL, NULL, NULL),
(16, 'Aunt', NULL, NULL, NULL),
(17, 'Uncle', NULL, NULL, NULL),
(18, 'Other', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reminder_jobs`
--

CREATE TABLE `reminder_jobs` (
  `id` varchar(26) COLLATE utf8_unicode_ci NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `schedule_for` int(11) NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_profiles`
--

CREATE TABLE `tax_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(4,2) NOT NULL,
  `tax_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GST',
  `is_active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tax_profiles`
--

INSERT INTO `tax_profiles` (`id`, `deleted_at`, `code`, `name`, `percent`, `tax_type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Registration Number 01', 'Entity Name 001', '7.00', 'GST', 1, '2017-12-19 14:57:19', '2019-10-30 10:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_image_id` char(26) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_country_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `national_id_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `account_id` int(11) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `accepted_policy` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone_number`, `email`, `first_name`, `last_name`, `profile_image_id`, `phone_country_code`, `gender`, `address_street`, `address_city`, `address_zip`, `date_of_birth`, `country_id`, `national_id_number`, `account_type`, `account_id`, `password`, `remember_token`, `status`, `accepted_policy`, `deleted_at`, `created_at`, `updated_at`) VALUES
(964, '967470983', 'ryan.nguyen@manadr.com', NULL, NULL, NULL, '+84', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 187, '$2y$10$MjwGn4Oa5b0O00m6S2B7fuljWI50CC9K/LMQ03duUOPPx/xlwdE8O', '1hIzxToz2tW51eEjcWrFt9foivnIfmF8mUMHZuGpEZjtmtDg8IdOf14qEurF', 1, 0, NULL, '2019-10-23 08:45:47', '2020-06-13 09:01:55'),
(1260, '9369258147', 'longnguyenvan995@gmail.com', NULL, NULL, NULL, '+65', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 680, '', '', 1, 1, NULL, '2020-04-25 09:04:48', '2020-06-18 03:21:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_relatives`
--

CREATE TABLE `user_relatives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `relationship_id` int(10) UNSIGNED DEFAULT NULL,
  `user_patient_id` int(11) DEFAULT NULL,
  `is_guardian` tinyint(3) UNSIGNED DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `id_number` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `issue_country_id` int(10) UNSIGNED DEFAULT NULL,
  `profile_image_id` char(26) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resident_country_id` int(10) UNSIGNED DEFAULT NULL,
  `address_zip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_block` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apartment_number` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medical_condition` longtext COLLATE utf8_unicode_ci,
  `drug_allergy` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_relatives`
--

INSERT INTO `user_relatives` (`id`, `user_id`, `patient_id`, `relationship_id`, `user_patient_id`, `is_guardian`, `description`, `first_name`, `last_name`, `email`, `address`, `gender`, `date_of_birth`, `id_number`, `issue_country_id`, `profile_image_id`, `resident_country_id`, `address_zip`, `address_block`, `apartment_number`, `medical_condition`, `drug_allergy`, `created_at`, `updated_at`) VALUES
(631, 1260, 680, 1, 680, NULL, '', 'Ryan', 'Nguyen (Staging)', 'longnguyenvan995@gmail.com', 'My Address jjjdjjid', 'Other', '1995-10-16 16:05:28', 'N1245', 232, 'c88ckuwjot8nicqm1mzo5c3p4c', 192, '', '', '', '', '', '2020-04-25 09:05:41', '2020-06-18 03:21:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_fees`
--
ALTER TABLE `appointment_fees`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `appointment_files`
--
ALTER TABLE `appointment_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_health_summaries`
--
ALTER TABLE `appointment_health_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_reasons`
--
ALTER TABLE `appointment_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_statuses`
--
ALTER TABLE `appointment_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_types`
--
ALTER TABLE `appointment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinic_types`
--
ALTER TABLE `clinic_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_booking_fees`
--
ALTER TABLE `doctor_booking_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_clinics`
--
ALTER TABLE `doctor_clinics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_medical_schools`
--
ALTER TABLE `doctor_medical_schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_qualifications`
--
ALTER TABLE `doctor_qualifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_settings`
--
ALTER TABLE `doctor_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_timetables`
--
ALTER TABLE `doctor_timetables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_timetable_configs`
--
ALTER TABLE `doctor_timetable_configs`
  ADD PRIMARY KEY (`doctor_id`,`appointment_type_id`);

--
-- Indexes for table `doctor_titles`
--
ALTER TABLE `doctor_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_schools`
--
ALTER TABLE `medical_schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_passwords`
--
ALTER TABLE `otp_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relationships`
--
ALTER TABLE `relationships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminder_jobs`
--
ALTER TABLE `reminder_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_profiles`
--
ALTER TABLE `tax_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_relatives`
--
ALTER TABLE `user_relatives`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_files`
--
ALTER TABLE `appointment_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_health_summaries`
--
ALTER TABLE `appointment_health_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_reasons`
--
ALTER TABLE `appointment_reasons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appointment_statuses`
--
ALTER TABLE `appointment_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appointment_types`
--
ALTER TABLE `appointment_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `clinic_types`
--
ALTER TABLE `clinic_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `doctor_booking_fees`
--
ALTER TABLE `doctor_booking_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_clinics`
--
ALTER TABLE `doctor_clinics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor_medical_schools`
--
ALTER TABLE `doctor_medical_schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_qualifications`
--
ALTER TABLE `doctor_qualifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_settings`
--
ALTER TABLE `doctor_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctor_timetables`
--
ALTER TABLE `doctor_timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_titles`
--
ALTER TABLE `doctor_titles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medical_schools`
--
ALTER TABLE `medical_schools`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `otp_passwords`
--
ALTER TABLE `otp_passwords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=681;

--
-- AUTO_INCREMENT for table `relationships`
--
ALTER TABLE `relationships`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tax_profiles`
--
ALTER TABLE `tax_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1261;

--
-- AUTO_INCREMENT for table `user_relatives`
--
ALTER TABLE `user_relatives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=632;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
