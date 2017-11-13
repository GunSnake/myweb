<?php
/**
 * Mysqli方式的数据库连接
 * User: 95
 * Date: 2016/6/27
 * Time: 10:43
 */

namespace Model\SqlConn;

use \mysqli;

class MySQLiConn
{
    private static $conn;

    private function __construct($host, $username, $passwd, $dbname, $port)
    {
        self::$conn = new mysqli($host, $username, $passwd, $dbname, $port);

        if ( mysqli_connect_error() ) {
            die('connect error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
        }
    }

    /**
     * 单例模式
     * @return mysqli
     */
    public static function getInstance($host, $username, $passwd, $dbname, $port){
        if (null === self::$conn){
            $con = new self($host, $username, $passwd, $dbname, $port);
            self::$conn = $con->getInstance($host, $username, $passwd, $dbname, $port);
        }
         return self::$conn;
    }

    function __destruct()
    {
        self::$conn = '';
    }
}

/**
 * Class mysql测试类，检测是否连接成功
 * @package project_weibo\Project\MysqlConn
 */
/*class test
{
    public static function fetch(){
        $con = MySQLiConn::getInstance('127.0.0.1', 'root', '', 'trans', 3306);
        $res = $con->query('select * from goods');
        var_dump($res->fetch_all());
    }
}
$test = test::fetch();*/
