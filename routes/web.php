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
    return redirect('/home');
});



Route::get('/home', 'HomeController@index')->name('home');
Route::get('/product/{id}', 'ProductController@details')->name('productdetails');
Route::get('cart', 'ProductController@cart')->name('cart');
Route::get('add-to-cart/{id}', 'ProductController@addToCart');
Route::patch('update-cart', 'ProductController@update');
Route::post('add-to-cart-quantity', 'ProductController@addToCartQuantity');
Route::post('add-to-wishlist', 'ProductController@addToWishList');
Route::delete('remove-from-cart', 'ProductController@remove');
Route::get('/result', 'searchController@searchProducts');
Route::get('/products/{gfather}/{father}/{son}', 'ProductController@groupSon');
Route::get('/products/{gfather}/{father}/{son}/{brand}', 'ProductController@groupByBand');
Route::get('/products/{gfather}','ProductController@groupGfa');

Route::group([
    'middleware' => ['auth']
], function() {

    Route::get('purchase', 'PurchaseControler@purchase');
    Route::post('add-info-user', 'PurchaseControler@addInfoUser')->name('saveinfo');
    Route::get('confirm', 'PurchaseControler@confirm');
    Route::get('methods', 'PurchaseControler@methods');
    Route::post('generateimg', 'PurchaseControler@generateimg')->name('generateimg');
    Route::get('thanks', 'ProductController@thanks');

    //------- my addresses -------------------------------------------
    Route::resource('addresses', AddressController::class);
    Route::get('addresses/default/{id}', 'AddressController@default');

    //------- my methods ---------------------------------------------
    Route::resource('secure/methods', CreditcardController::class);
});

Auth::routes();