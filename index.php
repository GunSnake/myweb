<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2017/10/23
 * Time: 21:30
 */

require 'config.php';
include_once S_ROOT.'/Model/AutoLoad.php';
spl_autoload_register("\\Model\\AutoLoad::autoload");

$app = new \Model\App();
$app->addRouter('/user/namer', function(){
    $this->responseContentType = 'application/json;charset=utf8';
    $this->responseBody = '{"name": "testBindTo"}';
});
$app->dispatch('user/namer');

