<?php
/**
 * pdo方式的数据库连接
 * User: 95
 * Date: 2016/6/27
 * Time: 10:46
 */

namespace Model\SqlConn;

use \PDO;
class PDOConn
{
    private static $conn;
    private function __construct($dsn, $username, $passwd)
    {
        try{
            self::$conn = new \PDO($dsn, $username, $passwd);
        }catch (\PDOException $e){
            echo 'this error is ' . $e;
        }
        return self::$conn;
    }

    public static function getInstance($dsn, $username, $passwd){
        if (null === self::$conn){
            $con = new self($dsn, $username, $passwd);
            self::$conn = $con->getInstance($dsn, $username, $passwd);
        }
        return self::$conn;
    }
}

