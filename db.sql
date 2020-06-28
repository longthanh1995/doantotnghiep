-- clinics --
INSERT INTO `clinics` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `address`, `zip`, `city`, `location`, `email`, `password`, `country_id`, `clinic_type_id`, `phone_country_code`, `phone_number`, `profile_image_id`, `time_zone`, `tax_profile_id`, `working_week_days`, `enable_queue_feature`) VALUES
(1, '2016-05-10 00:00:00', '2020-05-05 04:44:54', NULL, 'Healthmark Family Medicine Clinic (Choa Chu Kang)', 'Blk 601 Choa Chu Kang Street 62 #01-09 Singapore 680601', '680601', 'Singapore', 0x000000000101000000e0c28190acef5940af38e686f059f63f, 'tysiaw@gmail.com', '123', 192, 1, '+65', '67672281', 'ciq5opeuypg7xcyit8d4t89jcc', 'Asia/Singapore', 1, '[1, 2, 3, 4, 5, 6, 7]', 1),
(37, '2016-11-27 12:43:27', '2019-06-06 10:12:58', NULL, 'Trinity Medical Centre', '28 College St', '5015', 'Port Adelaide ', 0x00000000010100000091d618744250614007280d350a6d41c0, 'michaelsiaw@hotmail.com', NULL, 13, 1, '+61', '82492000', 'E8iBPc3FcxfWMjJsBJTylACEo4', 'Australia/Adelaide', 7, '[1, 2, 3, 4, 5, 6, 7]', 0),
(43, '2017-03-28 11:21:14', '2020-04-14 08:38:38', NULL, 'Homecare Singapore', 'Blk 601 Choa Chu Kang Street 62 #01-09 Singapore 680601', '100000', 'Singapore', 0x000000000101000000e0c28190acef5940af38e686f059f63f, 'support@manadr.com', NULL, 192, 3, '+65', '67672281', NULL, 'Asia/Singapore', 14, '[1, 2, 3, 4, 5, 6, 7]', 0);

-- appointment_types --
INSERT INTO `appointment_types` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`, `clinic_id`, `is_active`, `category`, `is_free_diabetes_test`) VALUES
(1, '2020-01-17 15:12:00', '2020-01-23 12:30:33', NULL, 'General Consultation ', NULL, 1, 'general', 0),
(2, '2020-01-17 15:12:00', '2020-01-20 10:46:09', NULL, 'Chronic Disease follow up', NULL, 1, 'general', 0),
(3, '2020-01-17 15:12:00', '2020-01-20 10:46:14', NULL, 'General Consultation follow up', NULL, 1, 'general', 0),
(4, '2020-01-17 15:12:00', '2020-01-20 10:46:20', NULL, 'General Health Screening', NULL, 1, 'general', 0),
(5, '2020-01-17 15:12:01', '2020-01-17 15:12:01', NULL, 'Review of Health Screening', NULL, 0, 'general', 0),
(6, '2020-01-17 15:12:01', '2020-01-17 15:12:01', NULL, 'Repeat Health Screening ', NULL, 0, 'general', 0),
(7, '2020-01-17 15:12:00', '2020-01-20 10:52:51', NULL, 'Vaccination', NULL, 1, 'general', 0),
(8, '2020-01-17 15:12:00', '2020-01-17 15:12:00', NULL, 'Accidents / Injuries Consultation', NULL, 0, 'general', 0);

-- appointment_statuses --
INSERT INTO `appointment_statuses` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`) VALUES
(1, '2020-01-12 08:27:32', '2020-01-12 08:27:32', NULL, 'Verifying'),
(2, '2020-01-12 08:27:32', '2020-01-12 08:27:32', NULL, 'Confirmed'),
(3, '2020-01-12 08:27:32', '2020-01-12 08:27:32', NULL, 'Visited'),
(4, '2020-01-12 08:27:32', '2020-01-12 08:27:32', NULL, 'Cancelled'),
(5, '2020-01-12 08:27:32', '2020-01-12 08:27:32', NULL, 'No-show'),
(6, '2020-01-12 08:27:32', '2020-01-12 08:27:32', NULL, 'Verification Failed'),
(7, '2020-01-12 08:27:32', '2020-01-12 08:27:32', NULL, 'Late');

-- appointment_reasons --
INSERT INTO `appointment_reasons` (`id`, `created_at`, `updated_at`, `reason`, `appointment_type_id`, `parent_id`) VALUES
(1, '2020-01-01 03:34:28', '2020-01-01 03:34:28', 'General Consultation', 1, NULL),
(2, '2020-01-01 03:34:40', '2020-01-01 03:34:40', 'General Checking', 1, NULL),
(3, '2020-01-01 03:34:55', '2020-01-01 03:34:55', 'Total Body Testing', 1, NULL),
(4, '2020-01-01 03:35:15', '2020-01-01 03:35:15', 'Chronic Disease follow up', 2, NULL),
(5, '2020-01-01 03:35:29', '2020-01-01 03:35:29', 'Vaccin Injections', 7, NULL),
(6, '2020-01-04 14:47:37', '2020-01-04 14:47:37', 'Review of Chronic Condition', 22, NULL),
(7, '2020-01-04 14:47:57', '2020-01-04 14:47:57', 'Acute Problem', 22, NULL);

-- clinic_types --
INSERT INTO `clinic_types` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`) VALUES
(1, NULL, NULL, NULL, 'clinic'),
(2, NULL, NULL, NULL, 'dental'),
(3, NULL, NULL, NULL, 'house_call');

-- doctor_titles --
INSERT INTO `doctor_titles` (`id`, `created_at`, `updated_at`, `deleted_at`, `title`, `title_image_id`) VALUES
(1, NULL, NULL, NULL, 'Doctor', 'khundg7cp3g37ytbndceqzpfny'),
(2, NULL, NULL, NULL, 'Dentist', 'qeu3yhj7i3rgjbqt98sypcimxo'),
(3, NULL, NULL, NULL, 'Specialist', 'cpd6kb453jrgj8wrmtcor9gt7a');

-- medical_schools --
INSERT INTO `medical_schools` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'National University Of Singapore', '2016-06-22 11:17:38', '2016-06-22 11:17:38', NULL);
-- relationships --
INSERT INTO `relationships` (`id`, `created_at`, `updated_at`, `deleted_at`, `name`) VALUES
(1, NULL, NULL, NULL, 'Me'),
(2, NULL, NULL, NULL, 'Son'),
(3, NULL, NULL, NULL, 'Daughter'),
(4, NULL, NULL, NULL, 'Mother'),
(5, NULL, NULL, NULL, 'Father'),
(6, NULL, NULL, NULL, 'Brother'),
(7, NULL, NULL, NULL, 'Sister'),
(8, NULL, NULL, NULL, 'Grandfather'),
(9, NULL, NULL, NULL, 'Grandmother'),
(10, NULL, NULL, NULL, 'Friend'),
(11, NULL, NULL, NULL, 'Wife'),
(12, NULL, NULL, NULL, 'Husband'),
(13, NULL, NULL, NULL, 'Boyfriend'),
(14, NULL, NULL, NULL, 'Girlfriend'),
(15, NULL, NULL, NULL, 'Cousin'),
(16, NULL, NULL, NULL, 'Aunt'),
(17, NULL, NULL, NULL, 'Uncle'),
(18, NULL, NULL, NULL, 'Other');
-- tax_profiles --
INSERT INTO `tax_profiles` (`id`, `created_at`, `updated_at`, `deleted_at`, `code`, `name`, `percent`, `tax_type`, `is_active`) VALUES
(1, '2017-12-19 14:57:19', '2019-10-30 10:24:21', NULL, 'Registration Number 01', 'Entity Name 001', '7.00', 'GST', 1);



-- doctors --
INSERT INTO `doctors` (`id`, `created_at`, `updated_at`, `deleted_at`, `email`, `name`, `doctor_title_id`, `profile_image_id`, `medical_school_id`, `phone_country_code`, `phone_number`, `office_hours`, `website`, `country_id`, `gender`, `remember_token`, `date_of_birth`, `address`, `user_id`, `invited_by_doctor_id`, `verification_status`) VALUES
(187, '2019-10-23 08:45:47', '2020-05-25 06:29:09', NULL, 'ryan.nguyen@manadr.com', 'Dr Ryan Nguyen (Staging)', 1, '2BBBzMqr1Capfj7w1aoOob3b12', NULL, '+84', '967470983', '8A.M to 19:30P.M', 'https://manadr.com', 192, 'male', NULL, '1995-10-16 00:00:00', 'ha noi, viet nam', 964, NULL, 2);

-- doctor_clinics --
INSERT INTO `doctor_clinics` (`id`, `created_at`, `updated_at`, `deleted_at`, `doctor_id`, `clinic_id`, `primary`) VALUES
(1, '2020-05-18 09:05:23', '2020-05-18 09:05:23', NULL, 187, 1, NULL),
(2, '2020-05-18 09:05:23', '2020-05-18 09:05:23', NULL, 187, 37, NULL);

-- doctor_settings --
INSERT INTO `doctor_settings` (`id`, `created_at`, `updated_at`, `doctor_id`, `name`, `value`) VALUES
(1, '2020-03-06 10:33:15', '2020-03-06 10:33:15', 187, 'timezone', 'Asia/Singapore');

-- patients --
INSERT INTO `patients` (`id`, `created_at`, `updated_at`, `deleted_at`, `first_name`, `last_name`, `gender`, `date_of_birth`, `email`, `phone_number`, `phone_country_code`, `address_street`, `address_city`, `issue_country_id`, `address_zip`, `profile_image_id`, `is_locked`, `address`, `medical_record_number`, `race`, `date_of_arrival`, `contact_number`, `pass_port_number`, `country_free_text`, `user_id`, `guardian_patient_id`, `created_by`, `alias`, `resident_country_id`, `id_number`, `deceased`, `verified`, `imported_phone`, `imported_name`, `imported_email`, `is_imported_record`, `medical_condition`, `drug_allergy`, `stripe_customer_id`, `has_already_appointment`, `address_block`, `apartment_number`) VALUES
(680, '2020-04-25 09:05:41', '2020-06-18 03:21:49', NULL, 'Ryan', 'Nguyen (Staging)', 'Male', '1995-10-16 16:05:28', 'longnguyenvan995@gmail.com', '9369258147', '+65', NULL, NULL, 232, '', 'c88ckuwjot8nicqm1mzo5c3p4c', NULL, 'My Address jjjdjjid', '', '', NULL, '', '', '', 1260, NULL, 1260, '', 192, 'N1245', 0, 0, '', '', '', 0, '', '', 'cus_HEqYymjMZrbOG5', 1, '', '');


-- user_relatives -- 
INSERT INTO `user_relatives` (`id`, `user_id`, `patient_id`, `relationship_id`, `created_at`, `updated_at`, `user_patient_id`, `is_guardian`, `description`, `first_name`, `last_name`, `email`, `address`, `gender`, `date_of_birth`, `id_number`, `issue_country_id`, `profile_image_id`, `resident_country_id`, `address_zip`, `address_block`, `apartment_number`, `medical_condition`, `drug_allergy`) VALUES
(631, 1260, 680, 1, '2020-04-25 09:05:41', '2020-06-18 03:21:49', 680, NULL, '', 'Ryan', 'Nguyen (Staging)', 'longnguyenvan995@gmail.com', 'My Address jjjdjjid', 'Other', '1995-10-16 16:05:28', 'N1245', 232, 'c88ckuwjot8nicqm1mzo5c3p4c', 192, '', '', '', '', '');

-- users --
INSERT INTO `users` (`id`, `created_at`, `updated_at`, `deleted_at`, `phone_number`, `email`, `first_name`, `last_name`, `profile_image_id`, `phone_country_code`, `gender`, `address_street`, `address_city`, `address_zip`, `date_of_birth`, `country_id`, `national_id_number`, `account_type`, `account_id`, `password`, `remember_token`, `status`, `accepted_policy`) VALUES
(964, '2019-10-23 08:45:47', '2020-06-13 09:01:55', NULL, '967470983', 'ryan.nguyen@manadr.com', NULL, NULL, NULL, '+84', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 187, '$2y$10$MjwGn4Oa5b0O00m6S2B7fuljWI50CC9K/LMQ03duUOPPx/xlwdE8O', '1hIzxToz2tW51eEjcWrFt9foivnIfmF8mUMHZuGpEZjtmtDg8IdOf14qEurF', 1, 0),
(1260, '2020-04-25 09:04:48', '2020-06-18 03:21:49', NULL, '9369258147', NULL, NULL, NULL, NULL, '+65', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 680, '', '', 1, 1);






