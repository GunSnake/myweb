<?php

/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2017/10/29
 * Time: 13:50
 */
class AutoLoad
{
    static function autoload($class){
        require S_ROOT .'/'. str_replace('\\', '/', $class).'.php';
    }
}