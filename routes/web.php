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

// Route::get('/', function () {
//     return redirect('/home');
// });

// Route::get('/', function () {
//     return redirect('/giveaway/registry');
// });

Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/product/{id}', 'ProductController@details')->name('productdetails');
Route::get('cart', 'ProductController@cart')->name('cart');
Route::get('add-to-cart/{id}', 'ProductController@addToCart');
Route::patch('update-cart', 'ProductController@update');
Route::post('add-to-cart-quantity', 'ProductController@addToCartQuantity');

Route::delete('remove-from-cart', 'ProductController@remove');
Route::get('/result', 'searchController@searchProducts');
Route::get('/result/brand/{brand}/{searching}', 'searchController@searchProductsByBrand');
Route::get('/products/{gfather}/{father}/{son}', 'ProductController@groupSon');
Route::get('/products/{gfather}/{father}/{son}/{brand}', 'ProductController@groupByBand');
Route::get('/products/{gfather}','ProductController@groupGfa');
Route::get('/categories/{category}/{id}', 'ProductController@groupCategory');
Route::get('/category/{category}/{id}/{subcategory}/{subid}', 'ProductController@groupSubCategory');

// order price low to price, price to low
Route::get('/products/filter/{price}/{gfather}/{father}/{son}', 'ProductController@groupPrice');
Route::get('/products/filter/{price}/{gfather}/{father}/{son}/{brand}', 'ProductController@groupByBandPrice');
Route::get('/categories/filter/{price}/{category}/{id}', 'ProductController@groupCategory');
Route::get('/category/filter/{price}/{category}/{id}/{subcategory}/{subid}', 'ProductController@groupSubCategory');

// Landing page
Route::get('/giveaway/registry', 'GiveawayController@index');
Route::post('/giveaway/registry', 'GiveawayController@savingData');

// get Confirm from zonaPagos
Route::get('/secure/methods/zp/response', 'ConfirmController@ConfirmTrans');

// get Confirm from pay-u
Route::get('/secure/methods/payu/response', 'ConfirmController@ConfirmTransPayU');

// back to commerce from zonaPagos
Route::get('/secure/methods/zp/back', 'ConfirmController@BackToCommerce');

// back to commerce from pay-U
Route::get('/secure/methods/payu/back', 'ConfirmController@BackToCommercePayU');

// Download PDF
Route::get('/legality/payment-result/download-pdf/{response}', 'PdfController@downloadResponseTrans');
Route::get('/legality/payment-result/downloadPayU-pdf/{response}', 'PdfController@downloadResponsePayU');

//politica de privacidad y tratamiento de datos
Route::get('/terms/privacy-policy-and-data-processing', function () {
    return view('terms.privacy');
});

// Política de Términos de Servicio, Política de Reembolsos y Devoluciones
Route::get('/terms/service-policy-refound-and-return-policy',function () {
    return view('terms.refound');
});

// Preguntas frecuentes
Route::get('/terms/faq', function (){
    return view('terms.faq');
});

//notify products
Route::post('/secure/notify/info', 'NotifyController@NotifyProduct');

Route::group([
    'middleware' => ['auth']
], function() {

    Route::get('purchase', 'PurchaseControler@verifyAddress');
    Route::post('add-info-user', 'PurchaseControler@addInfoUser')->name('saveinfo');
    Route::get('confirm', 'PurchaseControler@confirm');
    Route::get('methods', 'PurchaseControler@methods');
    Route::post('generateimg', 'PurchaseControler@generateimg')->name('generateimg');
    Route::get('thanks', 'ProductController@thanks');

    //------- my addresses -------------------------------------------
    Route::resource('addresses', AddressController::class);
    Route::get('addresses/default/{id}', 'AddressController@default');
    Route::post('addresses/list', 'AddressController@addressList');
    Route::post('addresses/listchange', 'AddressController@addressChange');
    Route::get('/secure/delivery/address/verify', 'PurchaseControler@verifyAddress');

    //------- new address from cart -------------------------------------------
    Route::get('addresses/new/{value}', 'AddressController@create');
    
    // E-mail verification after registration.
    Route::post('/secure/verify/email', 'MemberController@verifyEmail');
    Route::get('/register/auth/email/verify', 'MemberController@sendEmailVerication');
    
    //------- Regions ------------------------------------------------
    Route::post('/region/dpt', 'regionController@dpt');
    Route::post('/region/city', 'regionController@city');

    //------- my methods ---------------------------------------------
    Route::resource('secure/methods', CreditCardController::class);
    Route::get('secure/methods/default/{id}', 'CreditCardController@default');
    Route::post('secure/methods/list', 'CreditCardController@creditCardList');
    Route::post('secure/methods/listchange', 'CreditCardController@creditCardChange');

    //------- Payment process ----------------------------------------
    //Route::post('secure/methods/paynow', 'PaymentController@paymentProcess');
    Route::post('secure/method/payment/now', 'PaymentController@paymentProcess')->name('paymentnow');

    //------- Send Email to friend -----------------------------------
    Route::post('send-email-friend', 'SendingEmailController@sendToFriend'); 

    //------- Wish list ----------------------------------------------
    Route::post('add-to-wishlist', 'ProductController@addToWishList');

    //------- Voucher verification -----------------------------------
    Route::post('secure/methods/verify/voucher', 'VoucherController@voucherVerify');

    //------- My orders ----------------------------------------------
    Route::get('/secure/orders/info', 'ProfileController@myOrders');

});

Auth::routes();

Route::get('resize','ProductController@resize');