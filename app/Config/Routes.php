<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// INICI
$routes->get('/', 'AlumnesController::index');
$routes->get('alumnes', 'AlumnesController::index');

$routes->get('alumnes/expedient/(:num)', 'AlumnesController::expedient/$1');
$routes->get('alumnes/contacte/(:num)', 'AlumnesController::contacte/$1');

$routes->get('inici', 'IniciController::index');

// MATRÍCULES
$routes->get('matricules/torn1', 'MatriculesController::torn1');
$routes->get('matricules/torn2', 'MatriculesController::torn2');
$routes->get('matricules/torn3', 'MatriculesController::torn3');
//$routes->get('matricules/nova', 'MatriculesController::nova');
$routes->get('alumnes/resum_matriculats', 'AlumnesController::resumMatriculats');

// MATRÍCULA VIVA
$routes->get('matricula-viva', 'MatriculaVivaController::index');
$routes->post('matricula-viva/guardar', 'MatriculaVivaController::guardar');


//CERCA
$routes->get('cerca', 'AlumnesController::cercaGlobal');

//LOGIN

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');


$routes->get('expedients', 'ExpedientsController::index');
/* ALUMNES / EXPEDIENTS

$routes->get('alumnes', 'AlumnesController::index');
$routes->get('alumnes/expedient/(:num)', 'AlumnesController::expedient/$1');
$routes->get('alumnes/contacte', 'AlumnesController::contacte');



// PAGAMENTS --> DE MOMENT NO
$routes->get('pagaments/pagats', 'PagamentsController::pagats');
$routes->get('pagaments/no-pagats', 'PagamentsController::noPagats');
$routes->get('pagaments/bonificats', 'PagamentsController::bonificats');
$routes->get('pagaments/resum', 'PagamentsController::resum');

// GESTIÓ DE CURSOS
$routes->get('gestio/eso', 'GestioCursosController::eso');
$routes->get('gestio/batxillerat', 'GestioCursosController::batxillerat');
$routes->get('gestio/fp-gm', 'GestioCursosController::fpGrauMitja');
$routes->get('gestio/fp-gs', 'GestioCursosController::fpGrauSuperior');
$routes->get('gestio/fp-basica', 'GestioCursosController::fpBasica');
$routes->get('gestio/pfi', 'GestioCursosController::pfi');

// USUARIS ADMINISTRATIUS
$routes->get('usuaris', 'UsuarisController::index');

// CONFIGURACIÓ
$routes->get('configuracio', 'ConfiguracioController::index');*/
