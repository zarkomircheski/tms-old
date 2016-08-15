<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 23.03.2015
 * Time: 00:55
 */

/**
 * System routes
 *  - put only routes that belong to the system
 */
Route::group([
    'domain' => $sysSubdomain . '.' . $domain,
    'middleware' => ['subdomain', 'authorize'],
    'systemSubdomain' => $sysSubdomain,
    'namespace' => 'System',
],function() {

    Route::get('/', [
        'as' => 'home',
        'uses' => 'HomeController@index'
    ]);

    //Route::resource('tenant', 'TenantController');

    Route::get('tenants', [
        'as' => 'tenant.index',
            'uses' => 'TenantController@index',
        'role' => 'admin',
        'permissions' => '',
    ]);

    Route::get('tenant/create', [
        'as' => 'tenant.create',
        'uses' => 'TenantController@create',
        'role' => 'admin',
        'permissions' => '',
    ]);

    Route::post('tenant/store', [
        'as' => 'tenant.store',
        'uses' => 'TenantController@store',
        'role' => 'admin',
        'permissions' => '',
    ]);

    Route::get('tenant/{tenant}/edit', [
        'as' => 'tenant.edit',
        'uses' => 'TenantController@edit',
        'role' => 'admin',
        'permissions' => '',
    ]);

    Route::put('tenant/{tenant}', [
        'as' => 'tenant.update',
        'uses' => 'TenantController@update',
        'role' => 'admin',
        'permissions' => '',
    ]);

    Route::delete('tenant/{tenant}', [
        'as' => 'tenant.destroy',
        'uses' => 'TenantController@destroy',
        'role' => 'admin',
        'permissions' => '',
    ]);

});