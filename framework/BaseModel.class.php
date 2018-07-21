<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/7
 * Time: 下午2:20
 */

class BaseModel {

    protected $_dao;

//    protected function _initDAO(){
//        $config = array(
//            'host'=>'localhost',
//            'port'=>'8889',
//            'username'=>'root',
//            'password'=>'123456',
//            'charset'=>'utf8',
//            'dbname'=>'wdy'
//        );
//
//        $this->_dao = MySQLDB::getInstance($config);
//    }

    protected function _initDAO(){
        $config = array(
            'host'=>'localhost',
            'port'=>'8889',
            'username'=>'root',
            'password'=>'123456',
            'charset'=>'utf8',
            'dbname'=>'shop'
        );

        $this->_dao = MySQLDB::getInstance($config);
    }

    public function __construct()
    {
        $this->_initDAO();
    }
}