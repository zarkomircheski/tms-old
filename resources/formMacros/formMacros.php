<?php
/**
 * Created by PhpStorm.
 * User: Mircheski
 * Date: 07.04.2015
 * Time: 22:56
 */


Form::macro('m_input', function($type, $name, $value = null, $options = array(), $extras = array()) {

    //errors
    $notifyClass = "";
    $notifyIcon = "";
    $required = "";
    if(array_has($extras,'error') && $extras['error']!= "") {
        $notifyClass = "has-error";
        $notifyIcon = '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ';
        $extras['help'] = $extras['error'];
    }

    if(in_array('required', $options) ) {
        $required = ' <span class="glyphicon glyphicon-asterisk" style="font-size:9px;top:-3px" aria-hidden="true"></span>';
    }

    //macro options
    $class = "form-control";

    //concat options with macro options
    $options['class'] = $class . " " . array_get($options, 'class');

    //build element
    $element = Form::input($type, $name, $value, $options);

    $wrapper =
    "<div class=\"form-group $notifyClass\">" .
        "<label class=\"control-label\" for=\"$name\">" . array_get($extras, 'label') . $required . "</label>" .
            $element .
        "<p class=\"help-block\">" . $notifyIcon . array_get($extras, 'help') . "</p>" .
    "</div>";

    return $wrapper;
});

Form::macro('m_submit', function($value = null, $options = array(), $extra = array() ) {

    //macro options
    $class = "btn btn-default";

    //concat options with macro options
    $options['class'] = $class . " " . array_get($options, 'class');

    //build element
    $element = Form::submit($value, $options);

    return $element;
});

Form::macro('m_button', function($value = null, $options = array(), $extras = array() ) {

    //macro options
    $class = "btn btn-default";

    //concat options with macro options
    $options['class'] = $class . " " . array_get($options, 'class');

    //build element
    $element = Form::button($value, $options);

    return $element;
});


