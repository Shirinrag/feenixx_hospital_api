<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['register'] = 'common_api/register_data';
$route['login-data'] = 'common_api/login_data';
$route['get-all-common-details'] = 'common_api/get_all_common_details';
$route['get-city-data-on-state-id'] = 'common_api/get_city_data_on_state_id';
// ===========================Superadmin Dashboard===============================
$route['superadmin-dashboard'] = 'superadmin_api/superadmin_dashboard_count_data';
// ============================ Doctor Details=================================
$route['add-doctor'] = 'superadmin_api/add_doctor';
$route['display-all-doctor-details'] = 'superadmin_api/display_all_doctor_details';
$route['get-all-doctor-on-id'] = 'superadmin_api/get_all_doctor_on_id';
$route['update-doctor'] = 'superadmin_api/update_doctor';
$route['update-doctor-status'] = 'superadmin_api/update_doctor_status';
$route['delete-doctor'] = 'superadmin_api/delete_doctor';
// =========================== Patient Details========================
$route['add-patient'] = 'superadmin_api/add_patient';
$route['display-all-patient-details'] = 'superadmin_api/display_all_patient_details';
$route['get-all-patient-on-id'] = 'superadmin_api/get_all_patient_on_id';
$route['update-patient'] = 'superadmin_api/update_patient';
$route['delete-patient'] = 'superadmin_api/delete_patient';
// ==================== ADD Diseases===================================
$route['add-diseases'] = 'superadmin_api/add_diseases';
$route['display-all-diesases-details'] = 'superadmin_api/display_all_diesases_details';
$route['update-diseases'] = 'superadmin_api/update_diseases';
$route['delete-diseases'] = 'superadmin_api/delete_diseases';
$route['update-diseases-status'] = 'superadmin_api/update_diseases_status';
// =================== Staff Details ==============================
$route['add-staff'] = 'superadmin_api/add_staff';
$route['display-all-staff-details'] = 'superadmin_api/display_all_staff_details';
$route['get-all-staff-on-id'] = 'superadmin_api/get_all_staff_on_id';
$route['update-staff'] = 'superadmin_api/update_staff';
$route['delete-staff'] = 'superadmin_api/delete_staff';
// ===================== Super admin Appoitment Details==============
$route['superadmin-get-all-appointment-details'] = 'superadmin_api/get_all_appointment_details';
$route['s-get-all-appointment-report-details']='superadmin_api/s_get_all_appointment_report_details';
// ============================== Location ===========================

$route['save-location'] = 'superadmin_api/save_location';
$route['display-all-location-details'] = 'superadmin_api/display_all_location_details';
$route['update-location'] = 'superadmin_api/update_location';
$route['delete-location'] = 'superadmin_api/delete_location';
$route['get-sub-type-data-on-appoitment-id'] = 'common_api/get_sub_type_data_on_appoitment_id';
// ============================= Doctor Appointment Details================
$route['get-appointment-data'] = 'common_api/get_appointment_data';
$route['get-patient-details-on-patient-id'] = 'reciption_api/get_patient_details_on_patient_id';
$route['save-appointment-details'] = 'reciption_api/save_appointment_details';
$route['get-all-appointment-details-on-doctor-id'] = 'doctor_api/get_all_appointment_details_on_doctor_id';
$route['dr-update-appointment'] = 'doctor_api/dr_update_appointment';
// ===========================Doctor Dashboard===============================
$route['doctor-dashboard'] = 'doctor_api/dashboard_count_data';
$route['get-user-type-on-id'] = 'common_api/get_user_type_on_id';

// ==================== ADD Charges===================================
$route['add-charges'] = 'superadmin_api/add_charges';
$route['display-all-charges-details'] = 'superadmin_api/display_all_charges_details';
$route['update-charges'] = 'superadmin_api/update_charges';
$route['delete-charges'] = 'superadmin_api/delete_charges';
$route['update-charges-status'] = 'superadmin_api/update_charges_status';

// ================ Receiption Appointment Details=====================
$route['get-all-appointment-details'] = 'reciption_api/get_all_appointment_details';
$route['add-appointment-payment-details'] = 'reciption_api/add_appointment_payment_details';
$route['reschedule-appointment-details'] = 'reciption_api/reschedule_appointment_details';
$route['get-payment-data-on-appointment-id'] = 'reciption_api/get_payment_data_on_appointment_id';
$route['update-payment-details'] = 'reciption_api/update_payment_details';
$route['add-appointment-advance-payment-details'] = 'reciption_api/add_appointment_advance_payment_details';
$route['add-appointment-charges-details']= 'reciption_api/add_appointment_charges_details';
$route['update-discharge-date'] = 'reciption_api/update_discharge_date';
$route['update-discharge-time'] = 'reciption_api/update_discharge_time';
$route['update-discharge-summary'] = 'reciption_api/update_discharge_summary';
$route['add-surgery-details'] = 'reciption_api/add_surgery_details';
$route['get-patient-name-on-patient-id'] = 'reciption_api/get_patient_name_on_patient_id';
$route['get-doctor-details'] = 'common_api/get_doctor_details';


