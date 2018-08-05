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

        // 校验验证码
        $t_captcha = new Captcha();
        if (! $t_captcha->checkCaptcha($_POST['captcha'])){
            $this->_jump('index.php?p=back&c=Admin&a=login', '验证码错误');
        }

        // 获得表单数据
        $admin_name = $_POST["username"];
        $admin_pwd = $_POST["password"];

        //echo '<br/>name='.$admin_name.'pwd='.$admin_pwd;
        //echo 'aaaaaaaa';

        // 从数据库中验证管理员信息是否合法
        $m_admin = Factory::M('AdminModel');
        $admin_info = $m_admin->check($admin_name, $admin_pwd);
        if ($admin_info){
            // 验证通过
//            echo '<br/>合法，跳转到后台首页';

            // 利用 session 设置登录标识，
            //session_start();
            new SessionDB();

            //$_SESSION['is_login'] = 'yes';
            $_SESSION['admin'] = $admin_info; // 登录标识，管理员信息

            $this->_jump('index.php?p=back&c=Manage&a=index');
        }else{
//            echo '<br/>非法，登录失败，跳转到后台登录页面index.php?p=back&c=Admin&c=login';
            $this->_jump('index.php?p=back&c=Admin&a=login', '管理员信息非法');
        }
    }

    // 生成登录页面的验证码
    public function captchaAction(){

        $t_captcha = new Captcha();
        $t_captcha->generate();
    }

    /**
     * 退出登录
     */
    public function logoutAction(){

        unset($_SESSION['admin']);
        $this->_jump('index.php?p=back&c=Admin&a=login');
    }
}