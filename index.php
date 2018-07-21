<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/7
 * Time: 下午4:14
 *
 * 前端控制器（请求分发器）
 */



/**
 * 自动加载类文件函数
 */
function userAutoload($class_name){

    //echo '<br/>class_name = '.$class_name;

    // 先处理确定的（框架中的核心类）
    $framework_class_list = array(
        // 类名 => '类文件地址'
        'BaseController' => FRAMEWORK_PATH.'BaseController.class.php',
        'BaseModel' => FRAMEWORK_PATH.'BaseModel.class.php',
        'Factory' => FRAMEWORK_PATH.'Factory.class.php',
        'MySQLDB' => FRAMEWORK_PATH.'MySQLDB.class.php'
    );

    // 判断是否为核心类，是核心类就直接加载
    if (isset($framework_class_list[$class_name])){
        // 是核心类
        require $framework_class_list[$class_name];
    }

    // 判断是否为可增加类（控制器类、模型类）
    // 控制器类，截取后10个字符，匹配控制器
    elseif (substr($class_name, -10) == 'Controller'){
        // 控制器类，当前平台下controller目录
        require CURRENT_CONTROLLER_PATH.$class_name.'.class.php';
    }

    // 模型类，截取后5个字符，匹配model
    elseif (substr($class_name, -5) == 'Model'){
        // 模型类，当前平台下model目录
        require CURRENT_MODEL_PATH.$class_name.'.class.php';
    }
}
spl_autoload_register("userAutoload");


/**
 * 定义目录常量
 */
define('ROOT_PATH', getcwd().'/'); // getcwd()获得当前目录
define('APPLICATION_PATH', ROOT_PATH.'application/');
define('FRAMEWORK_PATH', ROOT_PATH.'framework/');


/**
 * 确定分发参数
 */

// 平台
$defualt_platform = 'test';
define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : $defualt_platform);


// 当前平台相关的路径常量
define('CURRENT_CONTROLLER_PATH', APPLICATION_PATH.PLATFORM.'/controller/');
define('CURRENT_MODEL_PATH', APPLICATION_PATH.PLATFORM.'/model/');
define('CURRENT_VIEW_PATH', APPLICATION_PATH.PLATFORM.'/view/');


// 控制器类
$defualt_controller = 'Match';
//$c = isset($_GET['c']) ? $_GET['c'] : $defualt_controller;
define('CONTROLLER', isset($_GET['c']) ? $_GET['c'] : $defualt_controller);

// 动作
$defualt_action = 'list';
//$a = isset($_GET['a']) ? $_GET['a'] : $defualt_action;
define('ACTION', isset($_GET['a']) ? $_GET['a'] : $defualt_action);

$controller_name = CONTROLLER.'Controller';

// 实例化控制
$controller = new $controller_name();

$action_name = ACTION.'Action';

// 执行 Action
$controller->$action_name();