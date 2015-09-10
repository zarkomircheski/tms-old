<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 07.09.2015
 * Time: 21:22
 */

namespace App\Persistence\Repositories\Eloquent\System;


use App\Persistence\Interfaces\System\TenantRepoInterface;
use App\Persistence\ORM\Eloquent\System\Tenant;
use App\Persistence\Repositories\Eloquent\BaseRepo;


class TenantRepo extends BaseRepo implements TenantRepoInterface {

    function __construct()
    {
        $this->model = new Tenant();
    }

//    //default
//    public function __call($method, $args) {
//        return call_user_func_array([$this->model, $method], $args);
//    }
}