<?php

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

Route::resource('/', 'BlogController');
Route::get('/generic.html', function () {
    return view('generic');
});
Route::get('/elements.html', function () {
    return view('elements');
});
