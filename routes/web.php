<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', 'PagesController@index')->name('home');
Route::get('/signup', 'AuthController@signup');
Route::get('/register', 'AuthController@signup');
Route::get('/signin', 'AuthController@signin');
Route::get('/login', 'AuthController@signin');
Route::get('/verify/{hashParam}', 'AuthController@verify');
Route::get('/admin', function() {
  $data['title'] = 'Admin';
  return view('admin.dashboard')->with($data);
});

Route::post('register', 'AuthController@register')->name('auth.register');
Route::post('login', 'AuthController@login')->name('auth.login');


Route::resource('auth', 'AuthController');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
