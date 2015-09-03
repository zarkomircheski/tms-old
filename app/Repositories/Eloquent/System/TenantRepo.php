<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 15.03.2015
 * Time: 22:46
 */

namespace App\Repositories\System\Eloquent;

use App\Models\Eloquent\System\Tenant;
use App\Repositories\RepositoryInterfaces\TenantInterface;
use Illuminate\Database\Eloquent\Model;

class TenantRepo implements TenantInterface{

    public $model = null;

    public function __construct() {
        $this->model = new Tenant();
    }


    //default
    public function __call($method, $args) {
        return call_user_func_array([$this->model, $method], $args);
    }

}