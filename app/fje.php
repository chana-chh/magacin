<?php

function dd($var, $print = true, $backtrace = false)
{
    echo '<h3 style="color:#900">VARIABLE</h1>';
    echo '<pre style="background-color:#fdd; color:#000; padding:1rem;">';

    if ($print) {
        print_r($var);
    } else {
        var_dump($var);
    }

    echo '</pre>';

    if (gettype($var) === 'object') {
        echo '<h3 style="color:#090">OBJECT: ' . get_class($var) . '</h1>';
        echo '<pre style="background-color:#dfd; color:#000; padding:1rem;">';
        print_r(get_class_methods($var));
        echo '</pre>';
    }

    if ($backtrace) {
        echo '<h3 style="color:#009">BACKTRACE</h1>';
        echo '<pre style="background-color:#ddf; color:#000; padding:1rem;">';
        print_r(debug_backtrace());
        echo '</pre>';
    }

    die();
}
function d($var, $print = true, $backtrace = false)
{
    echo '<h3 style="color:#900">VARIABLE</h1>';
    echo '<pre style="background-color:#fdd; color:#000; padding:1rem;">';

    if ($print) {
        print_r($var);
    } else {
        var_dump($var);
    }

    echo '</pre>';

    if (gettype($var) === 'object') {
        echo '<h3 style="color:#090">OBJECT: ' . get_class($var) . '</h1>';
        echo '<pre style="background-color:#dfd; color:#000; padding:1rem;">';
        print_r(get_class_methods($var));
        echo '</pre>';
    }

    if ($backtrace) {
        echo '<h3 style="color:#009">BACKTRACE</h1>';
        echo '<pre style="background-color:#ddf; color:#000; padding:1rem;">';
        print_r(debug_backtrace());
        echo '</pre>';
    }
}
