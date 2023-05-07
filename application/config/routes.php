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
$route['register'] = 'common/register_data';
$route['login-data'] = 'common/login_data';
$route['get-all-common-details'] = 'common/get_all_common_details';
$route['get-city-data-on-state-id'] = 'common/get_city_data_on_state_id';
// ============================ Doctor Details===========================================
$route['add-doctor'] = 'superadmin/add_doctor';
$route['display-all-doctor-details'] = 'superadmin/display_all_doctor_details';
$route['get-all-doctor-on-id'] = 'superadmin/get_all_doctor_on_id';
$route['update-doctor'] = 'superadmin/update_doctor';
$route['update-doctor-status'] = 'superadmin/update_doctor_status';
$route['delete-doctor'] = 'superadmin/delete_doctor';
// =========================== Patient Details=============================================
$route['add-patient'] = 'superadmin/add_patient';
$route['display-all-patient-details'] = 'superadmin/display_all_patient_details';
$route['get-all-patient-on-id'] = 'superadmin/get_all_patient_on_id';