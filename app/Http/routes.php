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

$domain = "tms.ngrok.com";
$domain = "1_tms";
$sysSubdomain = \Config::get('system.subdomain');

include_once "Routes/system_routes.php";
include_once "Routes/tenant_routes.php";


