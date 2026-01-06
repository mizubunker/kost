<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // GET

    $routes->get('vote', 'VoteController::index');
    $routes->get('detail', 'KostController::index');
    $routes->get('terbaik', 'KostController::saw');
    $routes->get('terbaik/(:segment)', 'KostController::saw/$1');
    
    // POST

    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->post('vote', 'VoteController::create');
    
    // vote(idKost) - tambah vote
    // comment(message) - komentar soal kost
    // addKost(data) - nambah data kost baru
    
    
    // DELETE
    
    // deleteKost(idKost) - hapus kost yang sudah ada
    // vote(idKost) - unvote
    
    // PUT
    
    // editKost(id, data) - edit kost berdasarkan id
});