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

/*
 * 
 * RUTAS DE PRUEBA
 * 
 */
 
/*
Route::get('/', function () {
    return view('welcome');
});


Route::get('/tktexto', function () {
    return '<H2>TKT</H2>';
});

Route::get('/post', 'App\Http\Controllers\PsicoltktController@testPost');
Route::get('/event', 'App\Http\Controllers\PsicoltktController@testEvent');

 */

// Cargando Clases

use App\Http\Middleware\ApiAuthMiddleware;


/*
 * 
 * RUTAS DEL API
 * 

 
Route::get('/usuario/pruebas', 'App\Http\Controllers\UserController@pruebas');
Route::get('/categoria/pruebas', 'App\Http\Controllers\CategoryController@pruebas');
Route::get('/evento/pruebas', 'App\Http\Controllers\EventController@pruebas');

 */

/*
 * 
 * RUTAS DEL CONTROLADOR DE USUARIO
 * 
 */

Route::post('/api/register', 'App\Http\Controllers\UserController@register');
Route::post('/api/login', 'App\Http\Controllers\UserController@login');
Route::put('/api/update', 'App\Http\Controllers\UserController@update');
Route::post('/api/upload', 'App\Http\Controllers\UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/api/detail/{id}', 'App\Http\Controllers\UserController@detail');