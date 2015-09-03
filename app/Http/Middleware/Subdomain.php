<?php
/**
 * Created by PhpStorm.
 * User: Mircheski
 * Date: 14.03.2015
 * Time: 20:54
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Config;
use DB;
use App;
use App\Models\Eloquent\System\Tenant;

class Subdomain implements Middleware{

    public function handle($request, Closure $next)
    {
        //set subdomain details
        $subdomain = $request->route('subdomain');
        $actions = $request->route()->getAction();
        $systemSubdomain = isset($actions['systemSubdomain']) ? $actions['systemSubdomain'] : null;
        $subdomain = $subdomain ?: $systemSubdomain;

        if(! $subdomain) {
            //prevent request or redirect if no subdomain in route
            App::abort(404);
        }

        //setup subdomain so we can use it when needed
        Config::set('subdomain.name', $subdomain);

        //setup client database
        $this->_switch_client_db($subdomain);

        return $next($request);
    }

    protected function _switch_client_db($subdomain) {

        if( $subdomain == Config::get('system.subdomain')) {
            // change db connection here

            return true;
        }

        // Get the tenant, abort if null
        $tenant = Tenant::whereSubdomain("{$subdomain}")->first();

        if ($tenant == null) { App::abort(404); }

        // Check that the db exists, abort if not

        $dbname = $subdomain;
        $res = DB::select("show databases like '{$dbname}'");

        if (count($res) == 0) { App::abort(404); }

        // Set the tenant DB name and fire it up as the new default DB connection

        Config::set('database.connections.mysql_tenant.database',$dbname);

        DB::setDefaultConnection('mysql_tenant');

    }

}