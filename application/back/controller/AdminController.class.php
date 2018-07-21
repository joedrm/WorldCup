<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/8
 * Time: 上午9:48
 */

class AdminController extends BaseController{

    /**
     * 登录表单动作
     */
    public function loginAction(){

        require CURRENT_VIEW_PATH.'login.html';
    }

    /**
     * 验证管理员是否合法
     */
    public function checkAction(){

        // 获得表单数据
        $admin_name = $_POST["username"];
        $admin_pwd = $_POST["password"];

        //echo '<br/>name='.$admin_name.'pwd='.$admin_pwd;
        //echo 'aaaaaaaa';

        // 从数据库中验证管理员信息是否合法
        $m_admin = Factory::M('AdminModel');
        if ($m_admin->check($admin_name, $admin_pwd)){
            // 验证通过
            //echo '<br/>合法，跳转到后台首页';

            // 利用 session 设置登录标识，
            session_start();
            $_SESSION['is_login'] = 'yes';

            $this->_jump('index.php?p=back&c=Manage&a=index');
        }else{
            //echo '<br/>非法，登录失败，跳转到后台登录页面index.php?p=back&c=Admin&c=login';
            $this->_jump('index.php?p=back&c=Admin&a=login', '管理员信息非法');
        }
    }
}