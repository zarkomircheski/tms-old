<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 23.03.2015
 * Time: 00:59
 */

/**
 * Tenant routes
 *  - put only routes that belong to tenant
 */
Route::group([
    'domain' => '{subdomain}.' . $domain ,
    'middleware' => 'subdomain',
    'namespace' => 'Tenant',
], function() {

    Route::get('/', [
        'as' => 'home',
        'uses' => 'HomeController@index'
    ]);

    Route::resource('vehicle', 'VehicleController');
    Route::get('vehicles', 'VehicleController@index')->name('vehicles'); //override route for plural name

    Route::resource('trailer', 'trailerController');
    Route::get('trailers', 'TrailerController@index')->name('trailers'); //override route for plural name


});