<?php
/**
 * Created by PhpStorm.
 * User: Mircheski
 * Date: 14.03.2015
 * Time: 22:33
 */
namespace App\Lib\Extend;

use \Illuminate\Routing\UrlGenerator;

class CustomUrlGenerator extends UrlGenerator{

    // modify the behaviour of route method by adding 'subdomain' parameter if any
    public function route($name, $parameters = array(), $absolute = true)
    {

        if ( ! is_null($route = $this->routes->getByName($name)))
        {
            // custom code
            $subdomain = \Config::get('subdomain.name');
            if($subdomain)
                $parameters['subdomain'] = $subdomain;
            // end of custom code
            return $this->toRoute($route, $parameters, $absolute);

        }

        throw new \InvalidArgumentException("Route [{$name}] not defined.");
    }

    // remove the custom added 'subdomain' parameter from the process of generating url query string
    protected function toRoute($route, $parameters, $absolute)
    {

        $parameters = $this->formatParameters($parameters);

        //custom code
        $parameters_without_subdomain = $parameters;
        unset($parameters_without_subdomain['subdomain']);
        //end of custom code

        $domain = $this->getRouteDomain($route, $parameters);

        $uri = strtr(rawurlencode($this->addQueryString($this->trimUrl(
            $root = $this->replaceRoot($route, $domain, $parameters),
            $this->replaceRouteParameters($route->uri(), $parameters_without_subdomain)
        //custom code
        ), $parameters_without_subdomain)), $this->dontEncode);
        //end of custom code

        //>> original code
        //), $parameters)), $this->dontEncode);
        //<< end of original code


        return $absolute ? $uri : '/'.ltrim(str_replace($root, '', $uri), '/');
    }
}