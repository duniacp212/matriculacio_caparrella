<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

$routes = Services::routes();

/*
|--------------------------------------------------------------------------
| Setup
|--------------------------------------------------------------------------
*/

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('signin');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // IMPORTANT: millor desactivat per seguretat

/*
|--------------------------------------------------------------------------
| Rutes públiques
|--------------------------------------------------------------------------
*/

$routes->get('/', 'Auth::signin');

/*
|--------------------------------------------------------------------------
| Grup AUTH
|--------------------------------------------------------------------------
*/

$routes->group('auth', function($routes) {

    // Registre
    $routes->get('signin', 'Auth::signin');
    $routes->post('register', 'Auth::register');

    // Login
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::doLogin');

    // Logout
    $routes->get('logout', 'Auth::logout');
});

/*
|--------------------------------------------------------------------------
| Grup FORMS
|--------------------------------------------------------------------------
*/

$routes->group('forms', function($routes) {

    // Dades Personals
    $routes->get('dadesPersonals', 'Forms::dadesPersonals');
    $routes->post('saveDadesPersonals', 'Forms::saveDadesPersonals');

    // Dades Tutors
    $routes->get('dadesTutors', 'Forms::dadesTutors');
    $routes->post('saveDadesTutors', 'Forms::saveDadesTutors');

    // Dades Cicle
    $routes->get('dadesCicle', 'Forms::dadesCicle');
    $routes->post('saveDadesCicle', 'Forms::saveDadesCicle');

    // Documentació
    $routes->get('documentacio', 'Forms::documentacio');
    $routes->post('saveDocumentacio', 'Forms::saveDocumentacio');

    // Confirmació
    $routes->get('confirmacio', 'Forms::confirmacio');
});
