<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
Route::get('/about', 'PagesController@about')->name('about');
Route::get('/contact', 'PagesController@contact')->name('contact');

Route::get("shop/{slug}", "ShopsController@product");

Route::get('/shop', 'ShopsController@shop')->name('shop');


Route::get('/signup', 'AuthController@signup');
Route::get('/register', 'AuthController@signup');
Route::get('/signin', 'AuthController@signin');
Route::get('/login', 'AuthController@signin');
Route::get('/verify/{hashParam}', 'AuthController@verify');
Route::get('/admin', 'ProductController@admin');
Route::get('/logout', 'PagesController@index');

Route::get('/orders', function() {
  $data['title'] = 'Orders';
  return view('admin.orders')->with($data);
});

Route::get('/addproduct', 'ProductController@addProduct');
Route::get('/addcategory', 'ProductController@addCategory');

Route::post('storemessage', 'PagesController@storeMessage')->name('contact.message');

Route::post('register', 'AuthController@register')->name('auth.register');
Route::post('login', 'AuthController@login')->name('auth.login');
Route::post('logout', 'AuthController@logout')->name('auth.logout');

Route::post('storecategory', 'ProductController@storeCategory')->name('product.storecategory');
Route::post('storeproduct', 'ProductController@storeProduct')->name('product.storeproduct');

Route::post('cart', 'ShopsController@storeCart')->name('cart');


Route::resource('auth', 'AuthController');
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
