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
$routes->get('/sign-up', 'SignupController::index');
$routes->get('/login', 'LoginController::index');
$routes->get('/services', 'ServicesController::index');
$routes->get('/shipping', 'ShippingController::index');
$routes->get('/signup', 'SignupController::index');
$routes->post('/signup/insert', 'SignupController::insert');
$routes->get('/terms-condition', 'TermsconditionController::index');
$routes->get('/testimonials', 'TestimonialsController::index');
$routes->get('/scheduling', 'SchedulingController::index');
$routes->get('/scheduling/account-information/(:any)', 'SchedulingController::accountInformation/$1');
$routes->get('/scheduling/service-information/(:any)', 'SchedulingController::serviceInformation/$1');
$routes->get('/scheduling/choose-schedule/(:any)', 'SchedulingController::chooseSchedule/$1');
$routes->post('/scheduling/getSizes', 'SchedulingController::getSizes');
$routes->post('/scheduling/insertAdditionalBoxTotalAmount', 'SchedulingController::insertAdditionalBoxTotalAmount');
$routes->get('/scheduling/getBookingItems', 'SchedulingController::getBookingItems');
$routes->get('/scheduling/getTotalAmount', 'SchedulingController::getTotalAmount');
$routes->post('/scheduling/deleteBookingItem', 'SchedulingController::deleteBookingItem');
$routes->post('/scheduling/insertBookingItem', 'SchedulingController::insertBookingItem');
$routes->post('/scheduling/updateServiceOption', 'SchedulingController::updateServiceOption');
$routes->get('/scheduling/checkServiceOptions', 'SchedulingController::checkServiceOptions');
$routes->get('/scheduling/getStudyAbroadAdditionalStoragePrice', 'SchedulingController::getStudyAbroadAdditionalStoragePrice');
$routes->post('/scheduling/finalizeSchedule', 'SchedulingController::finalizeSchedule');
$routes->post('/scheduling/insertSummerSchoolDeliveryFee', 'SchedulingController::insertSummerSchoolDeliveryFee');
$routes->get('/services/summerStorageSession', 'ServicesController::summerStorageSession');
$routes->get('/services/summerAdvantageSession', 'ServicesController::summerAdvantageSession');
$routes->get('/pay', 'PayController::index');
$routes->get('/drop-off/(:segment)', 'DropOffController::index/$1');
$routes->post('/dropoff/update', 'DropOffController::update');
$routes->post('/pay/sendPayment', 'PayController::sendPayment');
$routes->post('/pay/processPayment', 'PayController::processPayment');
$routes->get('/pay/removeServiceSession', 'PayController::removeServiceSession');
$routes->get('/logout', 'LogoutController::index');
$routes->post('/loginfunc', 'LoginController::loginfunc');

//Admin Routes
$routes->get('/admin/login', 'admin\LoginController::index');
$routes->get('/admin/drop-off', 'admin\DropOffController::index');
$routes->get('/admin/calendar-schedules', 'admin\CalendarSchedulesController::index');
$routes->get('/admin/calendarschedules/Lists', 'admin\CalendarSchedulesController::Lists');
$routes->get('/admin/logout', 'admin\LogoutController::index');
$routes->post('/admin/loginfunc', 'admin\LoginController::loginfunc');
$routes->get('/admin', 'admin\BookingsController::index');
$routes->get('/admin/bookings', 'admin\BookingsController::index');
$routes->post('/admin/bookings/getData', 'admin\BookingsController::getData');
$routes->delete('/admin/bookings/delete/(:num)', 'admin\BookingsController::delete/$1');
$routes->delete('/admin/dropoff/delete/(:num)', 'admin\DropOffController::delete/$1');
$routes->get('/admin/bookings/updateStatus/(:num)', 'admin\BookingsController::updateStatus/$1');
$routes->get('/admin/bookings/generatePdf/(:num)', 'admin\BookingsController::generatePdf/$1');
$routes->get('/admin/dropoff/generatePdf/(:num)', 'admin\DropOffController::generatePdf/$1');
$routes->get('/admin/bookings/bookingDetails', 'admin\BookingsController::bookingDetails');
$routes->get('/admin/bookings/exportToCsv', 'admin\BookingsController::exportToCsv');
$routes->get('/admin/bookings/exportToExcel', 'admin\BookingsController::exportToExcel');
$routes->post('/admin/bookings/updateTotalAmount', 'admin\BookingsController::updateTotalAmount');
$routes->post('/admin/bookings/updateDynamicTotalAmount', 'admin\BookingsController::updateDynamicTotalAmount');
$routes->post('bookings/reSchedule/(:segment)/(:segment)', 'admin\BookingsController::reSchedule/$1/$2');
$routes->post('bookings/dropOff/(:segment)/(:segment)', 'admin\BookingsController::dropOff/$1/$2');
$routes->get('/admin/booking-details/(:num)', 'admin\BookingDetailsController::index/$1');
$routes->post('/admin/bookingdetails/updatePickUpDate', 'admin\BookingDetailsController::updatePickUpDate');
$routes->post('/admin/bookingdetails/updatePickUpTime', 'admin\BookingDetailsController::updatePickUpTime');
$routes->post('/admin/bookingdetails/updateRowInWarehouse', 'admin\BookingDetailsController::updateRowInWarehouse');
$routes->post('/admin/bookingdetails/deleteBookingItem', 'admin\BookingDetailsController::deleteBookingItem');
$routes->get('/admin/bookingdetails/getSizes', 'admin\BookingDetailsController::getSizes');
$routes->get('/admin/bookingdetails/sizeAmount', 'admin\BookingDetailsController::sizeAmount');
$routes->post('/admin/bookingdetails/insertBookingDetails', 'admin\BookingDetailsController::insertBookingDetails');
$routes->post('/admin/bookingdetails/finalTotalAmount', 'admin\BookingDetailsController::finalTotalAmount');
$routes->post('/admin/bookingdetails/updateBookingItemDetails', 'admin\BookingDetailsController::updateBookingItemDetails');
$routes->post('/admin/bookingdetails/updateAdminNotes', 'admin\BookingDetailsController::updateAdminNotes');
$routes->get('/bookingdetails/test', 'admin\BookingDetailsController::test');

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