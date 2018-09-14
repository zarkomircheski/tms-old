<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 13.09.2018
 * Time: 21:14
 */

namespace App\Persistence\ORM\Eloquent\Tenant;

use Illuminate\Database\Eloquent\Model;


class Vehicle extends Model
{
    protected $fillable = ['company_name', 'subdomain', 'admin_name', 'admin_surname', 'admin_email'];

}