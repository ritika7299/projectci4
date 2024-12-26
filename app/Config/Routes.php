<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;


/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');    //home page routes
/************************************************************************************************************************************/

$routes->get('/', 'Admin::index');                                                          //view page of login
$routes->get('admin/register', 'Admin::register');                                          //view page of registration
$routes->post('admin/registerSubmit', 'Admin::registerSubmit');                             // registration details submit
$routes->post('admin/login', 'Admin::login');                                               //login action  
$routes->get('admin/logout', 'Admin::logout');                                              // Logout action
$routes->get('admin/dashboard', 'Admin::dashboard');                                        //dashboard page 
$routes->post('admin/saveDetails', 'Admin::saveDetails');                                   //save programme form details
$routes->get('admin/delete/(:num)', 'Admin::delete/$1');                                    // delete details 
$routes->get('admin/get-data-for-update', 'Admin::getRecord');                              // For fetching details
$routes->post('admin/updateDetails', 'Admin::updateDetails');                               // For updating details
$routes->get('admin/get-data-for-program', 'Admin::getProgramRecord');                      // For fetching pdf details
$routes->post('admin/updateProgramRecord', 'Admin::updateProgramRecord');                   // For updating program pdf 
$routes->post('admin/updateAttendanceRecord', 'Admin::updateAttendanceRecord');             // For updating attendance pdf
$routes->get('admin/history-program-pdf', 'Admin::get_program_history');                //view history log for program pdf
$routes->get('admin/history-attendance-pdf', 'Admin::get_attendance_history');          //view history log for attendance pdf

