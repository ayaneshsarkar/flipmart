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

Route::get('/', 'PagesController@index')->name('home');
Route::get('/about', 'PagesController@about')->name('about');
Route::get('/contact', 'PagesController@contact')->name('contact');

Route::get("shop/{slug}", "ShopsController@product");

Route::get('/shop', 'ShopsController@shop')->name('shop');
Route::get('/cart', 'PagesController@cart')->name('cart');


Route::get('/signup', 'AuthController@signup');
Route::get('/register', 'AuthController@signup');
Route::get('/signin', 'AuthController@signin');
Route::get('/login', 'AuthController@signin');
Route::get('/verify/{hashParam}', 'AuthController@verify');
Route::get('/admin', 'ProductController@admin');
Route::get('/logout', 'PagesController@index');

Route::get('/orders', 'ProductController@orders');

Route::get('/addproduct', 'ProductController@addProduct');
Route::get('/addcategory', 'ProductController@addCategory');
Route::get('/viewbrands', 'ProductController@viewBrands');
Route::get('/deletebrand/{id}', 'ProductController@deleteBrand');
Route::get('/editbrand', 'ProductController@editBrand')->name('editbrand');
Route::post('updatebrand', 'ProductController@updateBrand')->name('updatebrand');

Route::post('storemessage', 'PagesController@storeMessage')->name('contact.message');

Route::post('register', 'AuthController@register')->name('auth.register');
Route::post('login', 'AuthController@login')->name('auth.login');
Route::post('logout', 'AuthController@logout')->name('auth.logout');

Route::post('storecategory', 'ProductController@storeCategory')->name('product.storecategory');
Route::post('storeproduct', 'ProductController@storeProduct')->name('product.storeproduct');

Route::post('cart', 'ShopsController@storeCart')->name('cart');
Route::post('mycart', 'ShopsController@storeSingleCart')->name('mycart');
Route::post('cartdelete', 'ShopsController@deleteCart')->name('cartdelete');
Route::post('cartupdate', 'ShopsController@updateCart')->name('cartupdate');

Route::post('ordercreate', 'OrdersController@createOrder')->name('ordercreate');


Route::resource('auth', 'AuthController');

Route::get('/install-shopify/{shop?}', 'ShopifyController@installShopify');
Route::get('/generate-token', 'ShopifyController@generateToken');
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
