<?php
/**
 * Created by PhpStorm.
 * User: Mircheski
 * Date: 09.04.2015
 * Time: 21:58
 */



if(! function_exists('formError')) {

    function formError($field = false)
    {
        $errors = Session::get('errors', new Illuminate\Support\MessageBag);
        if($errors->has($field))
            return implode(',',$errors->get($field));

    }

}



