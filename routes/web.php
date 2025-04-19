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

Route::get('/', 'Auth\UserAuthController@viewLogin');

Route::get('/login', 'Auth\UserAuthController@viewLogin');

/**
 * @description login for users
 */
Route::post('/login', 'Auth\UserAuthController@login');

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/home', 'Auth\UserAuthController@home');
    Route::get('/logout', 'Auth\UserAuthController@logout');
});

Route::group(['middleware' => 'auth', 'prefix' => 'customer'], function()
{

    Route::get('/coupons', 'CouponController@allByCustomer');

    /**
     * @description routes for establishments
     */
    Route::group(['prefix' => 'establishments'], function()
    {
        Route::get('/', 'EstablishmentController@allByCustomer');
        Route::post('/', 'EstablishmentController@store');
    });

});

Route::get('/coupons', 'CouponController@all');

Route::get('/countries', 'CountryController@all');
Route::get('/countries/{id}/provinces', 'CountryController@provinces');
Route::get('/provinces/{id}/cities', 'ProvinceController@cities');
