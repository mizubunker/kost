<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // GET

    $routes()->get('vote', 'VoteController::index');
    
    // terbaik() - semua terbaik dari SAW
    // terbaik(harga) - filter Harga
    // terbaik(jarak) - filter Jarak
    // terbaik(fasilitas) - filter Fasilitas
    // terbaik(keamanan) - filter Keamanan
    // vote(idKost) - ambil jumlah vote
    // detail(idKost) - ambil data kost-an
    
    // POST

    $routes()->post('register', 'AuthController::register');
    $routes()->post('login', 'AuthController::login');
    $routes()->post('vote', 'VoteController::create');
    
    // vote(idKost) - tambah vote
    // comment(message) - komentar soal kost
    // addKost(data) - nambah data kost baru
    
    
    // DELETE
    
    // deleteKost(idKost) - hapus kost yang sudah ada
    // vote(idKost) - unvote
    
    // PUT
    
    // editKost(id, data) - edit kost berdasarkan id
});