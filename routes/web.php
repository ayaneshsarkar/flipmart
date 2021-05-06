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

Route::get('/', 'PagesController@index')->name('home')->middleware('cors');
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
Route::get('/authorize-user', 'AuthController@authorizeUser');

Route::get('/orders', 'OrdersController@orders');

Route::get('/addproduct', 'ProductController@addProduct');
Route::get('/products', 'ProductController@products');
Route::get('/deleteproduct/{id}', 'ProductController@deleteProduct');
Route::get('/editproduct', 'ProductController@editProduct')->middleware('cors');
Route::post('/updateproduct', 'ProductController@updateProduct');

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


Route::resource('auth', 'AuthController');

Route::get('/install-shopify/{shop?}', 'ShopifyController@installShopify');
Route::get('/generate-token', 'ShopifyController@generateToken');

// Cart
Route::get('/cart', 'CartController@cart');
Route::post('storecart', 'CartController@storeCart');
Route::post('updatecart', 'CartController@updateCart');
Route::get('/deletecart', 'CartController@deleteCart');
Route::get('/get-cart-total', 'CartController@getCartTotal');

//Orders
Route::get('/create-order', 'OrdersController@createOrder');
Route::get('/order', 'OrdersController@order');
Route::get('/delete-order/{id}', 'OrdersController@deleteOrder');
Route::get('/close-order/{id}', 'OrdersController@closeOrder');
Route::get('/open-order/{id}', 'OrdersController@openOrder');
Route::get('/cancel-order/{id}', 'OrdersController@cancelOrder');
Route::get('/download-invoice/{id}', 'OrdersController@downloadInvoice');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', function() {
    var_dump(session('userId'));
});
