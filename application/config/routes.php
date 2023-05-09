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
// ============================ Doctor Details=================================
$route['add-doctor'] = 'superadmin_api/add_doctor';
$route['display-all-doctor-details'] = 'superadmin_api/display_all_doctor_details';
$route['get-all-doctor-on-id'] = 'superadmin_api/get_all_doctor_on_id';
$route['update-doctor'] = 'superadmin_api/update_doctor';
$route['update-doctor-status'] = 'superadmin_api/update_doctor_status';
$route['delete-doctor'] = 'superadmin_api/delete_doctor';
// =========================== Patient Details=================================
$route['add-patient'] = 'superadmin_api/add_patient';
$route['display-all-patient-details'] = 'superadmin_api/display_all_patient_details';
$route['get-all-patient-on-id'] = 'superadmin_api/get_all_patient_on_id';
$route['update-patient'] = 'superadmin_api/update_patient';
$route['delete-patient'] = 'superadmin_api/delete_patient';
// ============================= Appointment Details=========================
$route['get-appointment-data'] = 'common_api/get_appointment_data';
$route['get-patient-details-on-patient-id'] = 'doctor_api/get_patient_details_on_patient_id';

$route['save-appointment-details'] = 'doctor_api/save_appointment_details';
$route['get-all-appointment-details'] = 'doctor_api/get_all_appointment_details';


