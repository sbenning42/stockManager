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

Route::post('/register', 'UsersController@store');
Route::post('/login', 'AuthController@login');

Route::group(['prefix' => 'heroes', 'middleware' => 'jwt.auth'], function () {
    Route::get('/', 'HeroesController@index');
    Route::post('/', 'HeroesController@store');
    Route::get('/{id}', 'HeroesController@show');
    Route::patch('/{id}', 'HeroesController@patch');
    Route::delete('/{id}', 'HeroesController@delete');
});

Route::get('/roles', 'RolesController@index');
Route::get('/roles/{id}', 'RolesController@show');
Route::get('/accounts', 'AccountsController@index');
Route::get('/accounts/{id}', 'AccountsController@show');
Route::get('/countries', 'CountriesController@index');
Route::get('/countries/{id}', 'CountriesController@show');
Route::get('/file_types', 'FileTypesController@index');
Route::get('/file_types/{id}', 'FileTypesController@show');
Route::get('/global-model-states', 'UserGlobalModelStatesController@index');
Route::get('/global-model-states/{id}', 'UserGlobalModelStatesController@show');

Route::group(['prefix' => 'self'], function () {
    
    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::get('/', 'AuthController@self');

    });

});

Route::group(['prefix' => 'users'], function () {
    // Route::post('/', 'UsersController@store');
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/', 'UsersController@index');
        Route::get('/{id}', 'UsersController@show');
        // Route::put('/{id}', 'UsersController@update');
        // Route::delete('/{id}', 'UsersController@delete');
        Route::get('/{id}/role', 'UserRoleController@show');
        // Route::put('/{id}/role', 'UserRoleController@update');
        Route::get('/{id}/account', 'UserAccountController@show');
        // Route::put('/{id}/account', 'UserAccountController@update');
        Route::get('/{id}/global-model', 'UserGlobalModelController@show');
        Route::patch('/{id}/global-model', 'UserGlobalModelController@update');
        Route::get('/{id}/global-model/state', 'UserGlobalModelStateController@show');
        // Route::put('/{id}/global-model/state', 'UserGlobalModelStateController@update');
        Route::get('/{id}/global-model/address', 'UserGlobalModelAddressController@show');
        Route::put('/{id}/global-model/address', 'UserGlobalModelAddressController@update');
        Route::get('/{id}/global-model/addresses', 'UserGlobalModelAddressesController@index');
        Route::post('/{id}/global-model/addresses', 'UserGlobalModelAddressesController@store');
        // Route::get('/{id}/global-model/addresses/{address_id}', 'UserGlobalModelAddressesController@show');
        Route::patch('/{id}/global-model/addresses/{address_id}', 'UserGlobalModelAddressesController@patch');
        Route::delete('/{id}/global-model/addresses/{address_id}', 'UserGlobalModelAddressesController@delete');
    });
});