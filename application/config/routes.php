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

// PUBLIC ROUTES (No Login Required)
$route[''] = 'home/index';
$route['index'] = 'home/index';
$route['home'] = 'home/index';
$route['pricing'] = 'home/pricing';
$route['about'] = 'home/about';
$route['contact'] = 'home/contact';
$route['faq'] = 'home/faq';

// API ROUTES (Public)
$route['api/get_available_units'] = 'api/available_units';
$route['api/total_units'] = 'api/total_units';
$route['api/in_use_units'] = 'api/in_use_units';
$route['api/check_availability'] = 'home/check_availability';
$route['api/check_availability/(:any)'] = 'home/check_availability/$1';

// AUTH ROUTES
$route['default_controller'] = 'home/index';
$route['login']   = 'auth/login';
$route['logout']  = 'auth/logout';

$route['customers'] = 'customers/index';
$route['customers/create'] = 'customers/create';
$route['customers/store'] = 'customers/store';
$route['customers/edit/(:num)'] = 'customers/edit/$1';
$route['customers/update/(:num)'] = 'customers/update/$1';
$route['customers/delete/(:num)'] = 'customers/delete/$1';

$route['consoles']               = 'consoles/index';
$route['consoles/create']        = 'consoles/create';
$route['consoles/store']         = 'consoles/store';
$route['consoles/edit/(:num)']   = 'consoles/edit/$1';
$route['consoles/update/(:num)'] = 'consoles/update/$1';
$route['consoles/delete/(:num)'] = 'consoles/delete/$1';
$route['consoles/price_history/(:num)'] = 'consoles/price_history/$1';
$route['consoles/report']        = 'consoles/report';
$route['consoles/bulk_status']   = 'consoles/bulk_status';

$route['rentals'] = 'rentals/index';
$route['rentals/create'] = 'rentals/create';
$route['rentals/store'] = 'rentals/store';
$route['rentals/initial_payment/(:num)'] = 'rentals/initial_payment/$1';
$route['rentals/process_initial_payment/(:num)'] = 'rentals/process_initial_payment/$1';
$route['rentals/finish/(:num)'] = 'rentals/finish/$1';
$route['rentals/payment_adjustment/(:num)'] = 'rentals/payment_adjustment/$1';
$route['rentals/process_payment_adjustment/(:num)'] = 'rentals/process_payment_adjustment/$1';
$route['rentals/payment/(:num)'] = 'rentals/payment/$1';
$route['rentals/process_payment/(:num)'] = 'rentals/process_payment/$1';
$route['rentals/invoice/(:num)'] = 'rentals/invoice/$1';
$route['rentals/delete/(:num)'] = 'rentals/delete/$1';
$route['rentals/start_play/(:num)'] = 'rentals/start_play/$1';
$route['rentals/collect_payment/(:num)'] = 'rentals/collect_payment/$1';
$route['rentals/process_collect_payment/(:num)'] = 'rentals/process_collect_payment/$1';

$route['debts'] = 'debts/index';
$route['debts/customer_detail/(:num)'] = 'debts/customer_detail/$1';

$route['booking'] = 'booking/index';
$route['booking/search_customer'] = 'booking/search_customer';
$route['booking/store'] = 'booking/store';
$route['booking/booking_status/(:num)'] = 'booking/booking_status/$1';
$route['booking/customer_bookings/(:any)'] = 'booking/customer_bookings/$1';
$route['booking/approve/(:num)'] = 'booking/approve/$1';
$route['booking/reject/(:num)'] = 'booking/reject/$1';
$route['booking/customer_arrived/(:num)'] = 'booking/customer_arrived/$1';

$route['users'] = 'users/index';
$route['users/create'] = 'users/create';
$route['users/store'] = 'users/store';
$route['users/edit/(:num)'] = 'users/edit/$1';
$route['users/update/(:num)'] = 'users/update/$1';
$route['users/delete/(:num)'] = 'users/delete/$1';

$route['reports'] = 'reports/index';
$route['reports/revenue'] = 'reports/revenue';
$route['reports/console_performance'] = 'reports/console_performance';
$route['reports/payment_analysis'] = 'reports/payment_analysis';
$route['reports/customer_analysis'] = 'reports/customer_analysis';
$route['reports/export_revenue_csv'] = 'reports/export_revenue_csv';
$route['reports/export_console_csv'] = 'reports/export_console_csv';
$route['reports/export_customer_csv'] = 'reports/export_customer_csv';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

