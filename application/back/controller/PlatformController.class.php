<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/28
 * Time: 上午10:26
 */

class PlatformController extends BaseController {

    public function __construct()
    {
        parent::__construct();
        $this->_initSession();
        $this->_checkLogin();
    }

    protected function _initSession() {
        new SessionDB();
    }

    protected function _checkLogin(){

        new SessionDB();

        //验证是否具有登录标志
        //列出不需要登录验证的动作列表
        $no_list = array(
            'Admin' => array('login', 'check', 'captcha'),
            //控制器名 => 当前控制器不需要验证的动作名列表数组
        );
        if(isset($no_list[CONTROLLER]) && in_array(ACTION, $no_list[CONTROLLER])) {
            //不需要验证，是特例
            return ;
        }

//        if (!isset($_SESSION['is_login'])){
//            // 没有
//            $this->_jump('index.php?p=back&c=Admin&a=login');
//        }

        if (!isset($_SESSION['admin'])){
            // 没有
            $this->_jump('index.php?p=back&c=Admin&a=login');
        }
    }
}