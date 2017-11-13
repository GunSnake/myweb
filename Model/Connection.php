<?php
/**
 * 连接和处理数据库中数据类
 * User: 95
 * Date: 2016/6/8 0008
 * Time: 14:37
 */

namespace Model;

require_once __DIR__ . '/SqlConn/PDOConn.php';
require_once __DIR__ . '/SqlConn/MySQLiConn.php';

use Model\SqlConn\PDOConn;
use Model\SqlConn\MySQLiConn;

class Connection
{
    private static $Instance;
    private $conn;//数据库连接
    private $sql;//查询语句
    /**
     * 创建数据库连接
     * Connection constructor.
     */
    public function __construct()
    {
        $dbinfo = require('../Config/db_config.php');
        /*switch ($db){
            case 'mysql' : $this->db = $dbinfo['mysqlDb'];break;
            case 'pdo'   : $this->db = $dbinfo['pdoDb'];break;
            default      : $this->db = $dbinfo['mysqlDb'];break;
        }*/
        $nowdb = $dbinfo['mysqlDb'];
        $this->conn = MySQLiConn::getInstance($nowdb['host'], $nowdb['user'], $nowdb['password'], $nowdb['dbname'], $nowdb['port']);
        $this->conn->set_charset('utf8');
    }

    public static function getInstance(){
        if (!self::$Instance){
            self::$Instance = new self();
        }
        return self::$Instance;
    }
    /**
     *  查询所有的数据库数据
     * @param $sql 查询语句
     * @param $param 参数
     * @return array  数组
     * @throws \Exception
     */
    public function &query_all($sql,$param = array()){
        $this->sql = self::make_sql($sql,$param);
        $res = $this->conn->query($this->sql);
        if (!$res) return null;
        $num = $res->num_rows;
        for ($i=0;$i<$num;$i++){
            $re[] = $res->fetch_assoc();
        }
        return $re;
    }

    public function &query($sql){
        $res = $this->conn->query($sql);
        return $res;
    }
    /**
     * 取出数据库中某一条语句的值
     * @param $sql  查询语句
     * @param array $param 参数
     * @return array
     * @throws \Exception
     */
    public function &query_one($sql,$param = array()){
        $this->sql = self::make_sql($sql,$param);
        $res = $this->conn->query($this->sql);
        if (!$res) return null;
        $ret = $res->fetch_assoc();
        return $ret;
    }

    /**
     * 取出数据库中某一项的值
     * @param $sql 查询语句
     * @param array $param 参数
     * @return null
     */
    public function &query_value($sql,$param = array()){
        $res = $this->query_one($sql, $param);
        if (!$res) return null;
        $ret = end($res);
        return $ret;
    }

    /**
     * 用户的插入数据库操作
     * @param $table 插入的表格
     * @param $param 插入的项
     * @param $value 插入的数据
     * @return bool|\mysqli_result
     * @throws \Exception
     */
    public function &insert_into($table, $param, $value){
        if (!$table || !$param || !$value) throw new \Exception('语句不正确，请重新检查');
        $param_str = '(`'.implode('`,`', $param).'`)';
        foreach ($value as $k => $v){
            if(is_array($v)){
                $value_arr[] = '('.'\''.implode("','", $v).'\''.')';
            }else{
                $value_arr[] = '('.'\''.implode("','", $value).'\''.')';
                break;
            }
        }
        $value_str = implode(',', $value_arr);
        $sql = 'INSERT INTO '.$table.' '.$param_str.' VALUES '.$value_str;
        $res = $this->conn->query($sql);
        if (!$res) throw new \Exception('插入失败');
        $num = $this->conn->affected_rows;
        return $num;
    }

    /**
     * 把用户输入的查询语句组装成实际的查询语句
     * @param $sql  语句本体
     * @param $array 输入的参数
     * @return mixed
     * @throws \Exception
     */
    private function make_sql($sql,$array){
        if (!$sql) throw new \Exception('请输入查询语句！');
        $param_num = substr_count($sql, '?');
        if (($param_num !== count($array)) && $array) throw new \Exception('语句不正确，请重新检查');
        $this->sql = $sql;
        if ($array != []){
            for ($i=0;$i<$param_num;$i++){
                $this->sql = self::str_replace_once('?',mysqli_real_escape_string($this->conn,$array[$i]),$sql);
            }
        }
        return $this->sql;
    }

    /**
     * 把问号参数替换成实际参数
     * @param $needle
     * @param $repalce
     * @param $haystack
     * @return mixed
     */
    private function str_replace_once($needle, $repalce,$haystack){
        $pos = strpos($haystack,$needle);
        if (!$pos) return $haystack;
        return substr_replace($haystack,$repalce,$pos,strlen($needle));
    }

    public function __destruct()
    {
        $this->conn = '';
    }
}

/*$db = new Connection();
var_dump($db->query_all('select * from user where id = ?',[3]));
var_dump($db->query_one('select * from user'));*/


