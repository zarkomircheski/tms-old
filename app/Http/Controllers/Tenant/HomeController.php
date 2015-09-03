<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 23.03.2015
 * Time: 00:06
 */

namespace App\Http\Controllers\Tenant;


use App\Http\Controllers\Controller;

class HomeController extends Controller{

    public function __construct() {
        parent::__construct();
    }

    function index() {
        return view('tenant.home');
    }
}