<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

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

Route::post('/add', [UrlController::class, 'add']);

Route::post('/{short_url}', [UrlController::class, 'addCustom']);

Route::get('/{short_url}', [UrlController::class, 'redirect']);

Route::get('/{short_url}/s', [UrlController::class, 'saveRedirect']);
