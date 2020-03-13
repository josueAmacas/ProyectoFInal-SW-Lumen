<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It is a breeze. Simply tell Lumen the URIs it should respond to
  | and give it the Closure to call when that URI is requested.
  |
 */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'personas'], function ($router) {
    $router->get('/listaPersonas', "PersonaController@listaUsuarios");
    $router->get('/getPersona/{cedula}', "PersonaController@getPersona");
    $router->post('/crearPersona', "PersonaController@crearPersona");
    $router->get('/listaDocentes', "PersonaController@listaDocentes");
    $router->get('/getDocente/{cedula}', "PersonaController@getDocente");
    $router->post('/modificarPersona/{cedula}', "PersonaController@modificarPersona");
    $router->get('/listarTramitesEstudiante/{cedula}', "PersonaController@getTramiteEstudiante");
    $router->get('/listarTramites', "PersonaController@getTramites");
    $router->get('/getTramite/{id}', "PersonaController@getTramiteCodigo");
});

$router->group(['prefix' => 'usuarios'], function($router) {
    $router->post('/ingresar', 'LoginController@login');
});



