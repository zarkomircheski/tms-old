<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Response;

class Authorize
{

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorized = false;
        $user = $this->auth->user();
        $route = $request->route();

        if($user && $route) {

            $actions = $route->getAction();
            $role = array_get($actions, 'role');
            $permissions = explode('|',array_get($actions, 'permissions') );
            if($role || count($permissions) ) {
                if($user->is($role))
                    $authorized = true;

                if($user->has($permissions) )
                    $authorized = true;
            }
        }

        if(! $authorized) {
            //die('not authorized');
        }
//dd($request);
        return $next($request);
    }
}
