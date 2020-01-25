<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




//list users
Route::get('topUsers','UserController@index');

//list single user
Route::get('user/{id}','UserController@show');

//create new user
Route::post('register','UserController@store');

//update user
Route::put('user','UserController@update');

//Delete user
Route::delete('user/{id}','UserController@destroy');

//check referrral 
Route::post('check-reward','UserController@checkReferralCode');

//Display services
Route::get('GetAllServices','ServicesController@index');

//go to selected service
// Route::get('selectedService/{id}','ServicesController@redeemService');



//list all the products
Route::get('store','MarketController@index');

//Single product
Route::post('product','MarketController@show');

//check redempation of service
Route::post('redeemService','ServicesController@checkRedemption');

//create searvice purchase
Route::post('createService','ServicePurchaseController@create');

Route::post('checkServicePurchased','ServicePurchaseController@checkServicePurchase');

//get one Service
Route::post('getSingleService','ServicesController@redeemService');

//create user purchase
Route::post('purchase','UserPurchaseController@create');

//product process controller
Route::post('buyProduct','ProductPurchaseController@create');