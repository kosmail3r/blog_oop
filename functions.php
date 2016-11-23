<?php
/**
 * Created by PhpStorm.
 * User: weagl
 * Date: 22.11.2016
 * Time: 22:53
 */

function __autoload($name)
{
    $dir = 'classes/';
    $file = $name . '.php';
    if (is_file($dir . $file)) {
        include_once($dir . $file);
    }
}