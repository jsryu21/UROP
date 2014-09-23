<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'pages';
$route['friends/(:any)'] = 'pages/friends/$1';
$route['user/(:any)'] = 'pages/user/$1';
$route['detail/(:any)'] = 'pages/detail/$1';
$route['check/(:any)'] = 'pages/check/$1';
$route['check_submit'] = 'pages/check_submit';
$route['agree/(:any)/(:any)'] = 'pages/agree/$1/$2';
$route['disagree/(:any)/(:any)'] = 'pages/disagree/$1/$2';
$route['logout'] = 'pages/logout';
$route['news'] = 'news';
$route['news/(:any)'] = 'news/index/$1';
$route['news/create_temp_small_cluster'] = 'news/create_temp_small_cluster';
$route['news/create_medium_category_num_rows'] = 'news/create_medium_category_num_rows';

/* End of file routes.php */
/* Location: ./application/config/routes.php */