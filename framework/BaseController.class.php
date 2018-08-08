<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/7
 * Time: 下午4:58
 */

class BaseController {


    protected function _initContentType(){

        header('Content-Type: text/html; charset=utf-8');
    }


    public function __construct()
    {
        $this->_initContentType();
    }

    /**
     * 跳转
     * @param $url 目标地址
     * @param $info 提示信息
     * @param $wait 等待时间(单位秒)
     * @return void
     */
    protected function _jump($url, $info = null, $wait = 3){
        // 判断是否为立即跳转
        if (is_null($info)){
            header("Location:".$url);
        }else{
            header("Refresh:$wait; URL=$url");
            echo $info;
        }
        // 终止脚本
        die;
    }
}