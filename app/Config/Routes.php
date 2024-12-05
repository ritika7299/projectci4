<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;


/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');    //home page routes
/************************************************************************************************************************************/
$routes->get('/', 'Admin::index');                                      //view page of login
$routes->get('admin/register_view', 'Admin::register_view');            //view page of registration
$routes->post('admin/registerSubmit', 'Admin::registerSubmit');
$routes->post('admin/login', 'Admin::login');                           //login action  
$routes->get('admin/logout', 'Admin::logout');                          // Logout action
$routes->get('admin/dashboard', 'Admin::dashboard');                    //dashboard page 
$routes->post('admin/saveDetails', 'Admin::saveDetails');               //save programme form details
$routes->get('admin/delete/(:num)', 'Admin::delete/$1');                //delete programme from details
// $routes->post('admin/updateDetails', 'Admin::updateDetails');           //update programme from details
// $routes->get('admin/getRecordDetails/(:num)', 'Admin::getRecordDetails/$prog_id');         //getDetails from DB

// $routes->post('admin/getRecordDetails', 'Admin::getRecordDetails'); // For fetching details
$routes->post('admin/get-data-for-update/(:num)', 'Admin::updateRecord/$1');        // For updating details




