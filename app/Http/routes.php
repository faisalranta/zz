<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', function () {
    return view('auth.login');
});




Route::get('/d', 'HomeController@index');
Route::get('/f', 'FinanceController@toDayActivity');

Route::get('/f/ccoa', 'FinanceController@ccoa');

Route::get('/p', 'PurchaseController@toDayActivity');
Route::get('/s', 'SalesController@toDayActivity');
Route::get('/i', 'InventoryController@toDayActivity');
Route::get('/r', 'ReportsController@toDayActivity');