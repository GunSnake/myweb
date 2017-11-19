<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2017/11/19
 * Time: 19:38
 */

namespace Model;


class App
{
    protected $router = array();
    protected $responseStatus = '200 OK';
    protected $responseContentType = 'text/html';
    protected $responseBody = 'Hello World';

    public function addRouter($routerPath, $routerCallback)
    {
        $this->router[$routerPath] = $routerCallback->bindTo($this, __CLASS__);
    }

    public function dispatch($currentPath)
    {
        foreach ($this->router as $routePatch => $callBack) {
            if ($routePatch === $currentPath){
                $callBack();
            }
        }

        header('HTTP/1.1 ' . $this->responseStatus);
        header('Content-type:' . $this->responseContentType);
        header('Content-length:' . mb_strlen($this->responseBody));
    }
}