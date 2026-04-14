<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// PÚBLIQUES (sense autenticació)
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');

// PRIVADES (amb autenticació)
$routes->group('', ['filter' => 'auth'], function($routes) {

    // INICI
    $routes->get('/', 'AlumnesController::index');
    $routes->get('alumnes', 'AlumnesController::index');
    $routes->get('alumnes/expedient/(:num)', 'AlumnesController::expedient/$1');
    $routes->get('alumnes/contacte/(:num)', 'AlumnesController::contacte/$1');
    $routes->post('alumnes/enviar_correu/(:num)', 'AlumnesController::enviar_correu/$1');
    $routes->get('alumnes/resum_matriculats', 'AlumnesController::resumMatriculats');
    $routes->get('alumnes/exportar_resum_pdf', 'AlumnesController::exportarResumPdf');

    $routes->get('inici', 'IniciController::index');

    // MATRÍCULES
    $routes->get('matricules/matricula_alumne/(:num)', 'MatriculesController::matricula_alumne/$1');
    //$routes->get('matricules/nova', 'MatriculesController::nova');
    $routes->get('matricula-viva', 'MatriculaVivaController::index');
    $routes->post('matricula-viva/guardar', 'MatriculaVivaController::guardar');

    // CERCA
    $routes->get('cerca', 'AlumnesController::cercaGlobal');

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
    */

    // GESTIÓ DE CURSOS
    $routes->get('gestio/eso', 'GestioCursosController::eso');
    $routes->get('gestio/batxillerat', 'GestioCursosController::batxillerat');
    $routes->get('gestio/fp-gm', 'GestioCursosController::fpGrauMitja');
    $routes->get('gestio/fp-gs', 'GestioCursosController::fpGrauSuperior');
    $routes->get('gestio/fp-basica', 'GestioCursosController::fpBasica');
    $routes->get('gestio/pfi', 'GestioCursosController::pfi');
    $routes->post('gestio/processar', 'GestioCursosController::processarAccio');
    $routes->get('gestio/nou-curs', 'GestioCursosController::nouCurs');
    $routes->get('gestio/nou-curs/(:segment)', 'GestioCursosController::nouCurs/$1');
    $routes->post('gestio/guardar-curs', 'GestioCursosController::guardarCurs');

    // USUARIS ADMINISTRATIUS
    $routes->get('usuaris', 'UsuarisController::index');
    $routes->get('usuaris/nou', 'UsuarisController::nou');
    $routes->post('usuaris/guardar', 'UsuarisController::guardar');
    $routes->get('usuaris/editar/(:num)', 'UsuarisController::editar/$1');
    $routes->post('usuaris/actualitzar/(:num)', 'UsuarisController::actualitzar/$1');
    $routes->get('usuaris/eliminar/(:num)', 'UsuarisController::eliminar/$1');

    // CONFIGURACIÓ
    $routes->get('configuracio', 'ConfiguracioController::index');
    $routes->post('configuracio/guardar', 'ConfiguracioController::guardar');

});