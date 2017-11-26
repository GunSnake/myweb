<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2017/11/26
 * Time: 20:47
 */

namespace Model;


class Token
{
    private $secret = 'my_web';
    private $token = '';

    public function __construct()
    {
        $this->createToken();
    }

    /**
     * 获取token
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 创建token
     */
    private function createToken()
    {
        $this->makeToken();
    }

    /**
     *生成token
     */
    private function makeToken()
    {
        $str = rand(1000,9999);
        $str2 = dechex($_SERVER['REQUEST_TIME']-$str);
        $this->token = $str.substr(md5($str.$this->secret), 0,10).$str2;
    }

    /**
     * 验证Token
     * @param $str token字符串
     * @param int $delay 延迟
     * @return bool
     */
    public function verifyToken($str, $delay = 300)
    {
        $re = substr($str, 0 , 4);
        $middle = substr($str, 0 ,14);
        $re2 = substr($str, 14, 8);
        return ($middle == $re.substr(md5($re.$this->secret),0,10))
            &&($_SERVER['REQUEST_TIME'] - hexdec($re2) - $re<$delay);
    }
}