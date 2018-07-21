<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/6/19
 * Time: 上午8:43
 * 将数据库优化为单利类
 */

class MySQLDB{

    public $host;
    public $port;
    public $username;
    public $password;
    public $charset;
    public $dbname;

    // 连接结果
    private static $link;

    private $resource;

    // 构造函数
    private function __construct($config)
    {
        $this->host = isset($config['host']) ? $config['host'] : 'localhost';
        $this->port = isset($config['port']) ? $config['port'] : '3306';
        $this->username = isset($config['username']) ? $config['username'] : 'root';
        $this->password = isset($config['password']) ? $config['password'] : '';
        $this->charset = isset($config['charset']) ? $config['charset'] : 'utf8';
        $this->dbname = isset($config['dbname']) ? $config['dbname'] : '';

        // 连接数据库
        $this->connect();

        // 设置连接编码
        $this->setCharset($this->charset);

        // 选择数据库
        $this->selectedDB($this->dbname);
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance($config){
        if (!isset(self::$link)){
            self::$link = new self($config);
        }
        return self::$link;
    }

    public function connect(){
        $this->resource = mysql_connect("$this->host:$this->port", "$this->username", "$this->password") or die("连接数据库失败！");
    }

    // 优化：目的是出错打印都在query里面处理
    public function setCharset($charset){
        //mysql_set_charset("$this->charset", $this->resource);
        $this->query("set names $charset;");
    }

    public function selectedDB($dbname){
        //mysql_select_db("$this->dbname", $this->resource);
        $this->query("use $dbname;");
    }

    /*执行sql语句*/
    public function query($sql){
        if (!$result = mysql_query($sql, $this->resource)) {

            header('Content-Type: text/html; charset=utf-8');

            echo "<br/>执行失败。";
            echo "<br/>失败的sql语句为：".$sql;
            echo "<br/>出错信息：".mysqli_error();
            echo "<br/>错误代码：".mysqli_errno();
            die();
        }
        return $result;
    }

    /*返回二维数组*/
    public function getAll($sql){
        $result = $this->query($sql);
        $arr = array();
        while ($rec = mysql_fetch_assoc($result)){ // 返回下标为字段名的数组
            $arr[] = $rec; // 添加到 arr 数组中，变为二维数组
        }
        return $arr;
    }

    /*返回一行数据*/
    public function getRow($sql){

        //echo '<br/>sql='.$sql;

        $result = $this->query($sql);
        if ($rec = mysql_fetch_assoc($result)){ // 返回下标为字段名的数组
            return $rec;
        }
        return false;
    }

    /*返回一个数据*/
    public function getOne($sql){
        $result = $this->query($sql);
        $rec = mysql_fetch_row($result); // 返回下标为数字的数组，且下标为：0、1、2、3...
        if ($rec === false){
            return false;
        }
        return $rec[0];
    }

    // 反序列化是会调用
    public function __wakeup()
    {
        // 连接数据库
        $this->connect();

        // 设置连接编码
        $this->setCharset($this->charset);

        // 选择数据库
        $this->selectedDB($this->dbname);
    }

    // 序列化式会调用
    public function __sleep()
    {
        echo "序列化";
        mysql_close($this->resource);
        // 如果定义了__sleep方法，必须返回数组，才能进行序列化
        return array('host', 'port', 'username', 'password', 'charset', 'dbname');
    }
}


