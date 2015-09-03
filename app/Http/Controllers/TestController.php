<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 14.03.2015
 * Time: 01:13
 */

namespace App\Http\Controllers;


class TestController extends Controller{

    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        echo "subdomain name is - " . $this->subdomain;
        return \View::make('dashboard');
    }

    public function test(){
        dd('ok');
    }
}