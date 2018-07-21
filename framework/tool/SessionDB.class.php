<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/21
 * Time: 下午5:19
 */

class SessionDB {

    private $_dao;

    public function __construct() {
        //设置session处理器
        ini_set('session.save_handler', 'user');
        session_set_save_handler(
            array($this, 'userSessionBegin'),
            array($this, 'userSessionEnd'),
            array($this, 'userSessionRead'),
            array($this, 'userSessionWrite'),
            array($this, 'userSessionDelete'),
            array($this, 'userSessionGC')
        );

        //开启
        session_start();
    }

    function userSessionBegin() {
        //初始化DAO
        $config = array(
            'host'=>'localhost',
            'port'=>'8889',
            'username'=>'root',
            'password'=>'123456',
            'charset'=>'utf8',
            'dbname'=>'shop'
        );

        $this->_dao = MySQLDB::getInstance($config);
//        $config = $GLOBALS['config']['db'];
//        $this->_dao = MySQLDB::getInstance($config);
    }
    function userSessionEnd() {
        return true;
    }
    /**
     * 读操作
     * 执行时机：	session机制开启程中执行
     * 工作：		从当前session数据区读取内容
     * @param $sess_id string
     * @return string
     */
    function userSessionRead($sess_id) {
        //查询
        $sql = "SELECT session_content FROM `session` WHERE session_id='$sess_id'";
        return (string) $this->_dao->getOne($sql);
    }


    /**
     * 写操作
     * 执行时机：	脚本周期结束时，PHP在整理收尾时
     * 工作：		将当前脚本处理好的session数据，持久化存储到数据库中！
     * @param $sess_id string
     * @param $sess_content string 序列化好的session内容字符串
     * @return bool
     */
    function userSessionWrite($sess_id, $sess_content) {
        // 完成写
        $sql = "REPLACE INTO `session` VALUES ('$sess_id', '$sess_content', unix_timestamp())";
        return $this->_dao->query($sql);
    }


    /**
     * 删除操作
     * 执行时机：	调用了session_destroy()销毁session过程中被调用
     * 工作：		删除当前session的数据区（记录）
     * @param $sess_id string
     * @return bool
     */
    function userSessionDelete($sess_id) {
        //删除
        $sql = "DELETE FROM `session` WHERE session_id='$sess_id'";
        return $this->_dao->query($sql);
    }


    /**
     * 垃圾回收操作
     * 执行时机：	开启session机制时，有概率的执行
     * 工作：		删除那些过期的session数据区
     * @param $max_lifetime
     * @return bool
     */
    function userSessionGC($max_lifetime) {
        //删除
        $sql = "DELETE FROM `session` WHERE last_time<unix_timestamp()-$max_lifetime";
        return $this->_dao->query($sql);
    }
}