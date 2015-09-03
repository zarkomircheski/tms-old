<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 15.03.2015
 * Time: 22:46
 */

namespace App\Models\Eloquent\System;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model{

    protected $fillable = ['company_name', 'subdomain', 'admin_name', 'admin_surname', 'admin_email'];

}