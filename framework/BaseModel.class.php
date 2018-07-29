<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/7
 * Time: 下午2:20
 */

class BaseModel {

    protected $_dao;

    protected function _initDAO(){
        // 根据配置来选择 dao 类
        $config = $GLOBALS['config']['db'];

        switch ($GLOBALS['config']['app']['dao']){
            case 'mysql':
                $dao_class = 'MySQLDB';
                break;
            default:
                $dao_class = 'PDODB';
                break;
        }

//        var_dump($dao_class);
//        var_dump($config);
        $this->_dao = $dao_class::getInstance($config);
    }

    public function __construct()
    {
        $this->_initDAO();
    }
}