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

/**
 * Class PDO测试连接类
 * @package project_weibo\Project\MysqlConn
 */
/*class test
{
    public function test(){
        $con = PDOConn::getInstance('mysql:host=127.0.0.1;dbname=trans', 'root', '');
        $re = $con->prepare('select * from goods');
        $re->execute();
        var_dump($re->fetchAll(\PDO::FETCH_ASSOC));
    }
}

$re = new test();
$re->test();*/