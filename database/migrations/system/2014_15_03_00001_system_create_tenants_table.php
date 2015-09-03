<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 15.03.2015
 * Time: 22:05
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemCreateTenantsTable extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->unique();
            $table->string('subdomain')->unique();
            $table->string('admin_name');
            $table->string('admin_surname');
            $table->string('admin_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenants');
    }
}