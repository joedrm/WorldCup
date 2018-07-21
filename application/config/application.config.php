<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/21
 * Time: 下午6:40
 */

return array(

    // 数据库信息组
    'db' => array(
        'host'=>'localhost',
        'port'=>'8889',
        'username'=>'root',
        'password'=>'123456',
        'charset'=>'utf8',
        'dbname'=>'shop'
    ),

    // 应用程序组
    'app' => array(
        'defualt_platform' => 'back',
    ),

    // 后台组
    'back' => array(
        'defualt_controller' => 'Manage',
        'defualt_action' => 'index',
    ),

    // 前台组
    'front' => array(

    ),
);