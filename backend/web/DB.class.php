<?php

/**
 *  专门用来执行sql完成数据库的操作
 */
class DB
{
    /**
     * 1. 因为操作数据时需要
     *   地址(主机), 端口,用户名,密码,数据库,编码
     *  外部特征. 所以需要将这些信息定义为成员变量
     */
    private $host; //连接数据库的地址
    private $port; //连接数据库的端口
    private $user; //用户名
    private $password; //密码
    private $dbname; //连接的数据库
    private $charset; //设置编码

    private $link; //数据库连接资源,为了让当前类中的所有方法都可以访问到.

    private static $instance;  //保存创建好的DB对象

    public static function getInstance($config){
        if(!self::$instance instanceof self){
            self::$instance = new self($config); //调用当前构造函数
        }
        return self::$instance;
    }


    private function __construct($config)
    {
        //给每个成员变量设置默认值,可以简化用户传入参数
        $this->host = isset($config['host']) ? $config['host'] : '127.0.0.1';
        $this->port = isset($config['port']) ? $config['port'] : '3306';
        $this->user = isset($config['user']) ? $config['user'] : 'root';
        $this->password = $config['password'];
        $this->dbname = $config['dbname'];
        $this->charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        //立马先连接上数据库并且再设置编码
        $this->connect();
        $this->setCharset();//设置编码
    }

    /**
     * 2.该类型的所有对象都应该具体
     *               连接
     *               设置编码
     *               执行查询的sql
     */

    /**
     * 连接数据库
     */
    private function connect()
    {
        $this->link = @mysqli_connect($this->host, $this->user, $this->password, $this->dbname, $this->port);
        if ($this->link === false) {
            echo '连接数据库失败<br/>';
            echo '错误信息为:' . mysqli_connect_error() . '<br/>';
            exit;
        }
    }

    /**
     * 设置编码
     */
    private function setCharset()
    {
        $sql = "set names " . $this->charset;
        $result = mysqli_query($this->link, $sql);
        if ($result === false) {  //执行失败
            echo '设置编码失败<br/>';
            echo '错误信息:' . mysqli_error($this->link) . '<br/>';
            exit;
        }
    }


    /**
     * 执行查询类的sql语句得到查询结果.
     * @param $sql
     */
    public function query($sql)
    {
        $result = mysqli_query($this->link, $sql);
        if ($result === false) {  //执行失败
            echo '查询失败<br/>';
            echo 'SQL:'.$sql.'<br/>';
            echo '错误信息:' . mysqli_error($this->link) . '<br/>';
            exit;
        } else {
            return $result;
        }
    }

    /**
     * 执行查询的sql语句,得到所有的多行返回结果
     * @param $sql
     */
    public function fetchAll($sql)
    {  //select * from 表
        $result = $this->query($sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {  //取出多行数据
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * 执行查询的sql语句,得到一行的返回结果
     * @param $sql
     */
    public function fetchRow($sql)
    {   //select * from 表 limit 1
        $result = $this->query($sql);
        $row = mysqli_fetch_assoc($result); //得到查询结果中的一行数据
        return $row;
    }

    /**
     * 获取一个sql的唯一执行结果
     * @param $sql
     */
    public function fetchColumn($sql){
        //>>1.执行sql语句,得到执行结果
            $result = $this->query($sql); //因为该方法就是用来执行sql,得到执行结果
        //>>2.从执行结果中得到唯一的数据
            $row = mysqli_fetch_row($result); //因为需要从结果中得到值,只关心结果不关心键.
            if($row===null){  //因为$sql可能查询出数据,所以需要判断是否为空
                return null;
            }else{
                return $row[0]; //因为需要得到第一行的第一列数据
            }
    }


    /**
     * 用来执行修改类的sql语句
     * @param $sql
     */
    public function execute($sql){
        $result = mysqli_query($this->link, $sql);
        if ($result === false) {  //执行失败
            echo '执行失败<br/>';
            echo 'SQL:'.$sql.'<br/>';
            echo '错误信息:' . mysqli_error($this->link) . '<br/>';
            exit;
        } else {
            return $result;
        }
    }


    private function __clone()
    {
    }

    public function __destruct()
    {
        //当对象从内存中销毁时,关闭数据库连接资源
//        mysqli_close($this->link);
    }

    /**
     * 得到最后生成id
     * @return int|string
     */
    public function last_insert_id(){
        return mysqli_insert_id($this->link);
    }

}