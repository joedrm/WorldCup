<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/17
 * Time: 下午5:27
 */

class ManageController extends BaseController {

     public function indexAction(){
         // 验证是否有登录标识
         session_start();
         if (!isset($_SESSION['is_login'])){
            // 没有
             $this->_jump('index.php?p=back&c=Admin&a=login');
         }else{
             echo '你好，这里是后台首页';
         }
     }
}