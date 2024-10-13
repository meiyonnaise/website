<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->post('/login/check_login', 'Login::check_login');
$routes->get('login/logout', 'Login::logout');

$routes->get('show/forgot_password', 'Users::showForgotPasswordForm');
$routes->post('reset_password', 'Users::resetPasswordEmail');
$routes->match(['get', 'post'],'reset_password/(:segment)', 'Users::resetPassword');

$routes->get('/register', 'Registration::index');
$routes->post('/register/form', 'Registration::register');
$routes->get('/register/verify_email', 'Registration::verifyEmail');
$routes->post('/register/verify_email/code', 'Users::updateEmailVerified');

$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/dashboard/enrol', 'Users::enrolInCourse');
$routes->get('/profile', 'Users::index');
$routes->post('/profile/update', 'Users::updateUserInfo');
$routes->post('/profile/imageUpload', 'Users::uploadProfilePicture');


$routes->post('/upload/upload_file', 'Upload::upload_file');
$routes->get('/upload', 'Upload::index');

$routes->get('course/(:segment)', 'Course::index');
$routes->get('course/(:segment)/showCreatePostForm', 'Course::showCreatePostForm');
$routes->post('course/(:segment)/processCreatePost', 'Course::processCreatePostForm');
$routes->post('course/(:segment)/addToFavourites', 'Users::addToFavourites');
$routes->get('course/(:segment)/posts', 'Course::getPostsAsJson');
$routes->get('course/(:segment)/posts/(:num)', 'Course::showSpecificPost');
$routes->post('course/(:segment)/postsIncr/(:num)', 'Course::incrementViewsByAjax');
$routes->get('course/(:segment)/comments', 'Course::getCommentsAsJson');
$routes->get('course/(:segment)/posts/(:num)/getForm', 'Course::showForm'); //:num is the postID
$routes->post('course/(:segment)/posts/(:num)/addComment', 'Course::addComment');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
