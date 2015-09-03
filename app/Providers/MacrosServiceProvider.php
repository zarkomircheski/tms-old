<?php
/**
 * Created by PhpStorm.
 * User: Mircheski
 * Date: 07.04.2015
 * Time: 23:10
 */

namespace App\Providers;

use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Support\ServiceProvider;

class MacrosServiceProvider extends HtmlServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require base_path() . '/resources/formMacros/formMacrosHelpers.php';
        require base_path() . '/resources/formMacros/formMacros.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

    }
}