<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['api/v1/login']['post'] = 'AuthController/login';

$route['api/v1/users']['get'] = 'UserController/index';
$route['api/v1/users/(:num)']['get'] = 'UserController/show/$1';
$route['api/v1/users']['post'] = 'UserController/store';
$route['api/v1/users/(:num)']['put'] = 'UserController/update/$1';
$route['api/v1/users/(:num)']['delete'] = 'UserController/delete/$1';

$route['404_override'] = $route['404_override'] = 'Error404/index';
$route['translate_uri_dashes'] = FALSE;
