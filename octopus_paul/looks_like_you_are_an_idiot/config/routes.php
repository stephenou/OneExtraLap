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
| 	example.com/class/method/id/
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
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "home/main//1";
$route['scaffolding_trigger'] = "";
$route['about'] = "oel/index/about";
$route['faq'] = "oel/index/faq";
$route['tour'] = "oel/tour/";
$route['business'] = "oel/business/";
$route['admin'] = "admin/index/";
$route['ajax/([a-zA-Z0-9]+)'] = "ajax/$1/";
$route['reset'] = "account/reset_password/";
$route['reset/([0-9]+)'] = "account/reset_password/$1";
$route['preview/([0-9]+)'] = "account/signup/preview/$1///";
$route['refer/([a-zA-Z0-9]+)'] = "account/signup/refer/$1///";
$route['signup'] = "account/signup/////";
$route['signup/(:any)'] = "account/signup/$1////";
$route['signup/(:any)/(:any)'] = "account/signup/$1/$2///";
$route['signup/(:any)/(:any)/(:any)'] = "account/signup/$1/$2/$3//";
$route['signup/(:any)/(:any)/(:any)/(:any)'] = "account/signup/$1/$2/$3/$4/";
$route['signup/(:any)/(:any)/(:any)/(:any)/(:any)'] = "account/signup/$1/$2/$3/$4/$5";
$route['login'] = "account/login/////";
$route['login/(:any)'] = "account/login/$1////";
$route['login/(:any)/(:any)'] = "account/login/$1/$2///";
$route['login/(:any)/(:any)/(:any)'] = "account/login/$1/$2/$3//";
$route['login/(:any)/(:any)/(:any)/(:any)'] = "account/login/$1/$2/$3/$4/";
$route['login/(:any)/(:any)/(:any)/(:any)/(:any)'] = "account/login/$1/$2/$3/$4/$5";
$route['logout'] = "account/logout/////";
$route['logout/(:any)'] = "account/logout/$1////";
$route['logout/(:any)/(:any)'] = "account/logout/$1/$2///";
$route['logout/(:any)/(:any)/(:any)'] = "account/logout/$1/$2/$3//";
$route['logout/(:any)/(:any)/(:any)/(:any)'] = "account/logout/$1/$2/$3/$4/";
$route['logout/(:any)/(:any)/(:any)/(:any)/(:any)'] = "account/logout/$1/$2/$3/$4/$5";
$route['settings'] = "account/settings/";
$route['settings/([a-zA-Z0-9]+)'] = "account/settings/$1";
$route['people'] = "search/people/leaderboard//1";
$route['people/([a-zA-Z0-9]+)/page/([0-9]+)'] = "search/people/$1/$2";
$route['people/([a-zA-Z0-9]+)'] = "search/people/$1/1";
$route['tags'] = "search/tags//1";
$route['tags/page/([0-9]+)'] = "search/tags//$1";
$route['tags/(:any)/page/([0-9]+)'] = "search/tags/$1/$2";
$route['tags/(:any)'] = "search/tags/$1/1";
$route['badges'] = "search/badges//1";
$route['badges/page/([0-9]+)'] = "search/badges//$1";
$route['badges/(:any)/page/([0-9]+)'] = "search/badges/$1/$2";
$route['badges/(:any)'] = "search/badges/$1/1";
$route['quizzes'] = "search/quizzes/popular//1";
$route['quizzes/random/(:any)'] = "search/quizzes/random/$1";
$route['quizzes/([a-zA-Z0-9]+)'] = "search/quizzes/$1/1";
$route['quizzes/([a-zA-Z0-9]+)/page/([0-9]+)'] = "search/quizzes/$1/$2";
$route['search'] = "search/index/quiz//1";
$route['search/(:any)/(:any)/page/([0-9]+)'] = "search/index/$1/$2/$3";
$route['search/(:any)/(:any)'] = "search/index/$1/$2/1";
$route['search/(:any)'] = "search/index/$1//1";
$route['test'] = "test/index";
$route['connect'] = "account/twitter/connect";
$route['disconnect'] = "account/twitter/disconnect";
$route['notwitter'] = "account/twitter/notwitter";
$route['create'] = "create/index/";
$route['create/(:any)'] = "create/index/$1";
$route['everything'] = "home/main/everything/1";
$route['everything/page/([0-9]+)'] = "home/main/everything/$1";
$route['page/(:num)'] = "home/main//$1";
$route['([0-9]+)/grade'] = "quiz/index/$1/grade";
$route['([0-9]+)/edit'] = "quiz/index/$1/edit";
$route['([a-zA-Z0-9]+)/([a-zA-Z]+)'] = "home/user/$1/$2/1";
$route['([a-zA-Z0-9]+)/page'] = "home/user/$1//1";
$route['([a-zA-Z0-9]+)/page/([0-9]+)'] = "home/user/$1//$2";
$route['([a-zA-Z0-9]+)/([a-zA-Z]+)/page'] = "home/user/$1/$2/1";
$route['([a-zA-Z0-9]+)/([a-zA-Z]+)/page/([0-9]+)'] = "home/user/$1/$2/$3";
$route['([0-9]+)'] = "quiz/index/$1/";
$route['([a-zA-Z0-9]+)'] = "home/user/$1//1";
$route['(:any)'] = "home/user/$1//1";


/* End of file routes.php */
/* Location: ./system/application/config/routes.php */