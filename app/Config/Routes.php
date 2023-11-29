<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/about', 'AboutController::index');
$routes->get('/contact', 'ContactController::index');
$routes->post('/contact/sendMessage', 'ContactController::sendMessage');
$routes->get('/faqs', 'FAQController::index');
$routes->get('/login', 'LoginController::index');
$routes->get('/services', 'ServicesController::index');
$routes->get('/shipping', 'ShippingController::index');
$routes->get('/signup', 'SignupController::index');
$routes->get('/terms-condition', 'TermsconditionController::index');
$routes->get('/testimonials', 'TestimonialsController::index');
$routes->get('/scheduling', 'SchedulingController::index');
$routes->get('/scheduling/intro', 'SchedulingController::intro');
$routes->get('/scheduling/account-information', 'SchedulingController::accountInformation');
$routes->get('/scheduling/service-information', 'SchedulingController::serviceInformation');

//Admin Routes
$routes->get('/admin/login', 'admin\LoginController::index');
$routes->get('/admin/logout', 'admin\LogoutController::index');
$routes->post('/admin/loginfunc', 'admin\LoginController::loginfunc');
$routes->get('/admin', 'admin\DashboardController::index');
$routes->get('/admin/dashboard', 'admin\DashboardController::index');
//Users
$routes->get('/admin/add-user', 'admin\AdduserController::index');
$routes->post('/admin/adduser/insert', 'admin\AdduserController::insert');
$routes->get('/admin/user-masterlist', 'admin\UsermasterlistController::index');
$routes->delete('/admin/usermasterlist/delete/(:num)', 'admin\UsermasterlistController::delete/$1');
$routes->get('/admin/edit-user/(:num)', 'admin\EdituserController::index/$1');
$routes->post('/admin/edituser/update', 'admin\EdituserController::update');
//Dorms
$routes->get('/admin/add-dorm', 'admin\AdddormController::index');
$routes->post('/admin/adddorm/insert', 'admin\AdddormController::insert');
$routes->get('/admin/dorm-masterlist', 'admin\DormmasterlistController::index');
$routes->delete('/admin/dormmasterlist/delete/(:num)', 'admin\dormmasterlistController::delete/$1');
$routes->get('/admin/edit-dorm/(:num)', 'admin\EditdormController::index/$1');
$routes->post('/admin/editdorm/update', 'admin\EditdormController::update');
//Items & Sizes
$routes->get('/admin/add-item', 'admin\AdditemController::index');
$routes->post('/admin/additem/insert', 'admin\AdditemController::insert');
$routes->get('/admin/item-masterlist', 'admin\ItemmasterlistController::index');
$routes->delete('/admin/itemmasterlist/delete/(:num)', 'admin\itemmasterlistController::delete/$1');
$routes->get('/admin/edit-item/(:num)', 'admin\EdititemController::index/$1');
$routes->post('/admin/edititem/update', 'admin\EdititemController::update');