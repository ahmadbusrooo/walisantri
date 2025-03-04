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
|	https://codeigniter.com/user_guide/general/routing.html
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

$route['manage/auth'] = 'auth/auth_set/login';
$route['manage/([a-zA-Z_-]+)'] = '$1/$1_set';
$route['manage/auth/(:any)'] = 'auth/auth_set/$1';
$route['manage/([a-zA-Z_-]+)/(:any)'] = '$1/$1_set/$2';
$route['manage/(:any)/edit/(:num)'] = "$1/$1_set/add/$2";
$route['manage/(:any)/(:any)/edit/(:num)'] = "$1/$1_set/add_$2/$3";
$route['manage/(:any)/(:any)/(:num)/(:num)'] = "$1/$1_set/$2/$3/$4";
$route['manage/(:any)/(:any)/(:num)/(:num)/(:num)'] = "$1/$1_set/$2/$3/$4/$5";
$route['manage/(:any)/(:any)/(:num)/(:num)/(:num)/(:num)'] = "$1/$1_set/$2/$3/$4/$5/$6";
$route['manage/(:any)/(:any)/(:num)'] = "$1/$1_set/$2/$3";
$route['manage/(:any)/(:any)/(:any)'] = "$1/$1_set/$3_$2";
$route['manage'] = "dashboard/Dashboard_set";

$route['student/auth'] = 'student/auth_student/login';
$route['student/([a-zA-Z_-]+)'] = '$1/$1_student';
$route['student/auth/(:any)'] = 'student/auth_student/$1';
$route['student/([a-zA-Z_-]+)/(:any)'] = '$1/$1_student/$2';
$route['student/(:any)/edit/(:num)'] = "$1/$1_student/add/$2";
$route['student/(:any)/(:any)/edit/(:num)'] = "$1/$1_student/add_$2/$3";
$route['student/(:any)/(:any)/(:num)/(:num)'] = "$1/$1_student/$2/$3/$4";
$route['student/(:any)/(:any)/(:num)/(:num)/(:num)'] = "$1/$1_student/$2/$3/$4/$5";
$route['student/(:any)/(:any)/(:num)'] = "$1/$1_student/$2/$3";
$route['student/(:any)/(:any)/(:any)'] = "$1/$1_student/$3_$2";
$route['student'] = "dashboard/Dashboard_student";
$route['manage/student/report'] = 'student_set/report';


$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['manage/izin_pulang'] = 'izin_pulang/Izin_pulang_set/index';


$route['manage/payout/multiple_pay'] = 'payout_set/multiple_pay';
$route['manage/payout/send_reminder'] = 'payout/payout_set/send_reminder';
$route['payout/payout/search_santri'] = 'payout/payout_set/search_santri';
$route['manage/pelanggaran'] = 'pelanggaran/Pelanggaran_set';
$route['manage/pelanggaran/add'] = 'pelanggaran/Pelanggaran_set/add';
$route['manage/pelanggaran/view/(:num)'] = 'pelanggaran/Pelanggaran_set/view/$1';
$route['manage/pelanggaran'] = 'pelanggaran/Pelanggaran_set';
$route['manage/pelanggaran/add'] = 'pelanggaran/Pelanggaran_set/add';
$route['manage/pelanggaran/edit/(:num)'] = 'pelanggaran/pelanggaran_set/edit/$1';
$route['manage/pelanggaran/delete/(:num)'] = 'pelanggaran/Pelanggaran_set/delete/$1';


$route['pelanggaran_student'] = 'pelanggaran/pelanggaran_student';
$route['health_student'] = 'health/health_student/index';
$route['nadzhaman_student'] = 'nadzhaman/nadzhaman_student/index';
$route['api/auth/login'] = 'auth_student/login';
$route['api/auth/logout'] = 'auth_student/logout';
$route['default_controller'] = 'auth_student';
$route['api/dashboard'] = 'dashboard_student/get_dashboard_data';
$route['api/pelanggaran_student'] = 'pelanggaran_student/get_pelanggaran';
$route['api/payout_student'] = 'payout_student/get_payout_data';
$route['api/health_student'] = 'health_student/get_health_data';
$route['api/nadzhaman_student'] = 'nadzhaman_student/get_nadzhaman_data';

//Routing Data Ustadz
$route['manage/ustadz'] = 'ustadz/Ustadz/index';
$route['manage/ustadz/form/(:num)'] = 'ustadz/Ustadz/form/$1';
$route['manage/ustadz/delete/(:num)'] = 'ustadz/Ustadz/delete/$1';
$route['manage/ustadz/save'] = 'ustadz/Ustadz/save';


// Routing for Flutter Integration API
$route['api/login'] = 'flutter_integration/login'; // API login
$route['api/logout'] = 'flutter_integration/logout'; // API logout
$route['api/profile'] = 'flutter_integration/get_profile'; // Get profile details
$route['api/profile/edit'] = 'flutter_integration/edit_profile';
$route['api/data_siswa'] = 'flutter_integration/fetch_student_data';
$route['api/profile/change-password'] = 'flutter_integration/change_password'; // Change password
$route['api/dashboard'] = 'flutter_integration/dashboard'; // Get dashboard data
$route['api/pelanggaran'] = 'flutter_integration/get_pelanggaran'; // Get pelanggaran data
$route['api/health'] = 'flutter_integration/get_health_data'; // Get health data
$route['api/nadzhaman'] = 'flutter_integration/get_nadzhaman_data'; // Get nadzhaman data
$route['api/payout'] = 'flutter_integration/get_payout_data'; // Get payout data
$route['api/create_transaction'] = 'flutter_integration/create_transaction'; 
$route['api/payment_history'] = 'flutter_integration/get_payment_history'; // API untuk mendapatkan riwayat pembayaran santri



$route['manage/payment/delete_payment_bulan/(:num)/(:num)'] = 'payment_set/delete_payment_bulan/$1/$2';
$route['nadzhaman/manage_kitab_class'] = 'nadzhaman/manage_kitab_class';
$route['nadzhaman/filter_nadzhaman'] = 'nadzhaman/filter_nadzhaman';
$route['KitabDikelas_model'] = 'KitabDikelas_model';

$route['komplek/kamar/(:num)'] = 'komplek/kamar_by_komplek/$1';
$route['komplek/kamar/add/(:num)'] = 'komplek/add_kamar/$1';
$route['komplek/kamar/add_glob/(:num)'] = 'komplek/add_kamar_glob/$1';
$route['komplek/kamar/edit/(:num)'] = 'komplek/edit_kamar/$1';
$route['komplek/kamar/delete/(:num)'] = 'komplek/delete_kamar/$1';