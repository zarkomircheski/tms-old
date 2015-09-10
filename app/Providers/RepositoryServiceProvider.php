<?php
/**
 * Created by PhpStorm.
 * User: Zarko
 * Date: 07.09.2015
 * Time: 22:13
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Persistence\Interfaces\System\TenantRepoInterface', 'App\Persistence\Repositories\Eloquent\System\TenantRepo');
    }
}