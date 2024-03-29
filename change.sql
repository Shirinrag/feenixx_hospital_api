ALTER TABLE `tbl_patients` CHANGE `address1` `address1` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `tbl_cities` ADD INDEX(`id`);
ALTER TABLE `tbl_cities` ADD INDEX(`city`, `state_id`);
ALTER TABLE `tbl_designation` ADD INDEX(`id`, `designation_name`);
ALTER TABLE `tbl_doctor` ADD INDEX(`last_name`, `email`, `contact_no`, `fk_gender_id`, `fk_designation_id`);
ALTER TABLE `tbl_gender` ADD INDEX(`id`, `gender`);
ALTER TABLE `tbl_marital_status` ADD INDEX(`id`, `marital_status`);
ALTER TABLE `tbl_patients` ADD INDEX(`id`, `first_name`, `last_name`, `email`, `contact_no`, `dob`, `fk_gender_id`, `fk_marital_status_id`);
ALTER TABLE `tbl_states` ADD INDEX(`id`, `name`, `country_id`);
ALTER TABLE `tbl_users` ADD INDEX(`id`, `fk_id`, `first_name`, `last_name`, `email`, `contact_no`, `fk_user_type`);
ALTER TABLE `tbl_user_type` ADD INDEX(`id`, `user_type`);
ALTER TABLE `tbl_ward` ADD INDEX(`id`, `wards`);
ALTER TABLE `tbl_patients` ADD `fk_blood_group_id` INT NULL DEFAULT NULL AFTER `fk_marital_status_id`;
ALTER TABLE `tbl_patients` ADD `status` INT NOT NULL DEFAULT '1' AFTER `emergency_contact_phone`, ADD `del_status` INT NOT NULL DEFAULT '1' AFTER `status`;
ALTER TABLE `tbl_patients` ADD `patient_id` VARCHAR(100) NULL DEFAULT NULL AFTER `id`;
-- 08/05/2023
ALTER TABLE `tbl_appointment` ADD INDEX(`id`,`fk_doctor_id`, `fk_patient_id`, `appointment_date`, `appointment_time`, `appointment_type`);
ALTER TABLE `tbl_appointment_type` ADD INDEX(`id`, `type`);
ALTER TABLE `tbl_patient_medical_documents` ADD INDEX(`id`, `fk_patient_id`);
ALTER TABLE `tbl_patient_medical_documents` ADD `fk_appointment_id` INT NULL DEFAULT NULL AFTER `fk_patient_id`;
ALTER TABLE `tbl_payment` ADD INDEX(`id`, `fk_patient_id`, `fk_appointment_id`, `payment_type`, `online_amount`, `cash_amount`, `mediclaim_amount`, `discount_amount`, `total_amount`);

INSERT INTO `tbl_user_type` (`id`, `user_type`, `status`, `del_status`, `created_at`, `updated_at`) VALUES (NULL, 'Pharmacists', '1', '1', current_timestamp(), current_timestamp()), (NULL, 'Receptionists', '1', '1', current_timestamp(), current_timestamp());
ALTER TABLE `tbl_appointment` ADD `admission_type` VARCHAR(100) NULL DEFAULT NULL AFTER `appointment_time`;
ALTER TABLE `tbl_staff` ADD INDEX(`id`, `first_name`, `last_name`, `email`, `contact_no`, `fk_gender_id`, `dob`, `fk_state_id`, `fk_city_id`, `pincode`);
ALTER TABLE `tbl_advance_amount` ADD `advance_invoice` LONGTEXT NULL DEFAULT NULL AFTER `fk_payment_type`;


ALTER TABLE `tbl_payment_history` ADD `invoice_no` VARCHAR(100) NULL DEFAULT NULL AFTER `date`, ADD `invoice_pdf` LONGTEXT NULL DEFAULT NULL AFTER `invoice_no`;
ALTER TABLE `tbl_appointment` ADD `discharge_summary` LONGTEXT NULL DEFAULT NULL AFTER `description`, ADD `discharge_summary_pdf` LONGTEXT NULL DEFAULT NULL AFTER `discharge_summary`;


ALTER TABLE `tbl_appointment` ADD `discount_amount` DOUBLE NULL DEFAULT NULL AFTER `fk_admission_sub_type_id`;
ALTER TABLE `tbl_payment` CHANGE `deposite_amount` `grand_total` DOUBLE NULL DEFAULT NULL;
