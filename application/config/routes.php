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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/* Authentication Secion Routing */
$route['admin']               = 'authentication/index';
$route['authenticate']        = 'authentication/authenticate';
$route['logout']              = 'authentication/logout';


$route['cities']              = 'widgets/cities';



// General Routing 
$route['(:any)']                 = '$1/index';
$route['(:any)/checkDup']        = '$1/checkDuplicate';
$route['(:any)/changestatus']    = '$1/changeStatus';
$route['(:any)/add']             = '$1/add';
$route['(:any)/gallery/(:any)']  = '$1/gallery/$2';
$route['(:any)/addGalleryImage/(:any)']  = '$1/addGalleryImage/$2';
$route['(:any)/update/(:any)']   = '$1/update/$2';

$route['(:any)/managepost']      = '$1/managePostData';

$route['(:any)/delete']          = '$1/delete';
$route['(:any)/trash']           = '$1/trash';
$route['(:any)/restore']         = '$1/restore';
$route['(:any)/multiplerestore'] = '$1/multipleRestore';
$route['(:any)/multipledelete']  = '$1/multipleDelete';
$route['(:any)/exportPDF']       = '$1/exportPDF';
$route['(:any)/exportCSV']       = '$1/exportCSV';
$route['(:any)/importCSV']       = '$1/importCSV';
