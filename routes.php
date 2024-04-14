<?php

$router->get('/', 'HomeController@index');
$router->post('/listings', 'ListingsController@store', ['error']);
$router->post('/listings/delete', 'ListingsController@destroy');

$router->get('/auth/register', 'UserController@create', ['guest']);
$router->get('/auth/login', 'UserController@login', ['guest']);

$router->post('auth/register', 'UserController@store', ['guest']);
$router->post('auth/login', 'UserController@authenticate', ['guest']);


$router->post('auth/logout', 'UserController@logout', ['auth']);
