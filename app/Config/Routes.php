<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// PÚBLIQUES (sense autenticació)
$routes->get('login', 'AutenticacioController::login');
$routes->post('login', 'AutenticacioController::autenticacio');
$routes->get('logout', 'AutenticacioController::logout');

// Rutes per al procés de Login amb 2FA (Públiques, però requereixen sessió temporal)
$routes->get('2fa/verificar', 'AutenticacioController::verificar2fa');
$routes->post('2fa/validar', 'AutenticacioController::validar2fa');
$routes->get('2fa/configurar', 'AutenticacioController::configurar2fa');
$routes->post('2fa/activar', 'AutenticacioController::activar2fa');

// PRIVADES - TOTS ELS ROLS (auth)
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // INICI
    $routes->get('/', 'AlumnesController::index');
    $routes->get('alumnes', 'AlumnesController::index');
    $routes->get('alumnes/expedient/(:any)', 'AlumnesController::expedient/$1');
    $routes->get('alumnes/contacte/(:any)', 'AlumnesController::contacte/$1');
    $routes->post('alumnes/enviar_correu/(:any)', 'AlumnesController::enviar_correu/$1');
    $routes->get('alumnes/resum_matriculats', 'AlumnesController::resumMatriculats');
    $routes->get('alumnes/exportar_resum_pdf', 'AlumnesController::exportarResumPdf');
    $routes->post('alumnes/pujar-document/(:any)', 'AlumnesController::pujarDocument/$1');
    $routes->get('alumnes/eliminar-document/(:any)', 'AlumnesController::eliminarDocument/$1');
    $routes->post('alumnes/actualitzar-observacions/(:any)', 'AlumnesController::actualitzarObservacions/$1');
    $routes->post('alumnes/actualitzar-dades/(:any)', 'AlumnesController::actualitzarDadesAlumne/$1');
    $routes->post('alumnes/actualitzar-observacions-alumne/(:any)', 'AlumnesController::actualitzarObservacionsAlumne/$1');
    $routes->get('alumnes/eliminar-observacio/(:any)/(:any)', 'AlumnesController::eliminarObservacio/$1/$2');
    $routes->get('alumnes/eliminar-observacio-alumne/(:any)/(:any)', 'AlumnesController::eliminarObservacioAlumne/$1/$2');
    $routes->get('alumnes/pdf-expedient/(:any)', 'AlumnesController::pdfExpedient/$1');
    $routes->get('alumnes/pdf-matricula/(:any)', 'AlumnesController::pdfMatricula/$1');
    $routes->get('alumnes/document/(:num)', 'AlumnesController::veureDocument/$1');

    $routes->get('inici', 'IniciController::index');

    // MATRÍCULES
    $routes->get('matricules/matricula_alumne/(:any)', 'MatriculesController::matricula_alumne/$1');
    $routes->post('matricules/actualitzar/(:any)', 'MatriculesController::actualitzar/$1');
    $routes->get('matricules/validar/(:any)', 'MatriculesController::validar_matricula/$1');
    $routes->get('matricules/invalidar/(:any)', 'MatriculesController::invalidar_matricula/$1');
    $routes->get('matricules/marcar-pagat/(:any)', 'MatriculesController::marcar_pagat/$1');
    $routes->get('matricules/marcar-pendent/(:any)', 'MatriculesController::marcar_pendent/$1');
    //$routes->get('matricules/nova', 'MatriculesController::nova');

    // CERCA
    $routes->get('cerca', 'AlumnesController::cercaGlobal');

    // PERFIL
    $routes->get('perfil', 'PerfilController::index');
    $routes->post('perfil/actualitzar', 'PerfilController::actualitzar');

    // CALENDARI
    $routes->get('calendari', 'CalendariController::index');
    $routes->get('calendari/events', 'CalendariController::events');
    $routes->post('calendari/guardar', 'CalendariController::guardar');
    $routes->get('calendari/eliminar/(:num)', 'CalendariController::eliminar/$1');

});

// PRIVADES - SUPER ADMIN I ADMINISTRACIO (rolAdmin)
$routes->group('', ['filter' => ['auth', 'rolAdmin']], function ($routes) {

    // MATRÍCULA VIVA
    $routes->get('matricula-viva', 'MatriculaVivaController::index');
    $routes->post('matricula-viva/guardar', 'MatriculaVivaController::guardar');

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
    $routes->get('gestio/editar-curs/(:num)', 'GestioCursosController::editarCurs/$1');
    $routes->post('gestio/actualitzar-curs/(:num)', 'GestioCursosController::actualitzarCurs/$1');

    // SERVEIS COMPLEMENTARIS
    $routes->get('serveis/nou', 'ServeiComplementariController::nou');
    $routes->get('serveis', 'ServeiComplementariController::index');
    $routes->post('serveis/crear', 'ServeiComplementariController::crear');
    $routes->post('serveis/guardar', 'ServeiComplementariController::guardar');
    $routes->get('serveis/eliminar/(:num)', 'ServeiComplementariController::eliminar/$1');

    // BONIFICACIONS
    $routes->get('bonificacions/nou', 'BonificacionsController::nou');
    $routes->get('bonificacions', 'BonificacionsController::index');
    $routes->post('bonificacions/crear', 'BonificacionsController::crear');
    $routes->post('bonificacions/guardar', 'BonificacionsController::guardar');
    $routes->get('bonificacions/eliminar/(:num)', 'BonificacionsController::eliminar/$1');

    // USUARIS ADMINISTRATIUS
    $routes->get('usuaris', 'UsuarisController::index');
    $routes->get('usuaris/nou', 'UsuarisController::nou');
    $routes->post('usuaris/guardar', 'UsuarisController::guardar');
    $routes->get('usuaris/editar/(:any)', 'UsuarisController::editar/$1');
    $routes->post('usuaris/actualitzar/(:any)', 'UsuarisController::actualitzar/$1');
    $routes->get('usuaris/eliminar/(:any)', 'UsuarisController::eliminar/$1');

});

// PRIVADES - NOMÉS SUPER ADMIN (rolSuperAdmin)
$routes->group('', ['filter' => ['auth', 'rolSuperAdmin']], function ($routes) {

    // CONFIGURACIÓ
    $routes->get('configuracio', 'ConfiguracioController::index');
    $routes->post('configuracio/guardar', 'ConfiguracioController::guardar');

});