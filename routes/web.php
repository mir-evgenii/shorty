<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/add', function () {
    return 'New gen short url';
});

Route::post('/{short_url}', function () {
    return 'New custom short url';
});

Route::get('/{short_url}', function () {
    return 'Reconnect long url';
});

Route::get('/{short_url}/s', function () {
    return 'Reconnect long url with button';
});
