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


Route::get('foo', function () {
    return 'Hello World';
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin_template');
});

Route::get('/admin2', function () {
    return view('index2');
});

Route::get('/login', function () {
    return view('layouts.frontLayout.login');
});