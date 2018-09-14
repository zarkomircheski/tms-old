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

/* setup multi-tenant vars */
$domain = \Config::get('system.domain');
//the ssy subdomain is the system admin area where new tenants are registered
$sysSubdomain = \Config::get('system.subdomain');

include_once "Routes/system_routes.php";
include_once "Routes/tenant_routes.php";


