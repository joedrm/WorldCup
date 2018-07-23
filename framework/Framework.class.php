<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/21
 * Time: 下午6:19
 */

/**
 * 框架初始化功能类
 */
class Framework{

    /**
     * 入口
     */
    public static function run (){

        //声明路径常量
        static::_initPathConst();
        // 初始化配置
        static::_initConfig();
        //确定分发参数
        static::_initDispatchParam();
        // 当前平台相关的路径常量
        static::_initPlatformPathConst();
        // 注册自动加载
        static::_initAutoload();
        // 请求分发
        static::_dispatch();
    }

    /**
     * 声明路径常量
     */
    private static function _initPathConst(){
        // 定义基础目录常量
        define('ROOT_PATH', getcwd().'/'); // getcwd()获得当前目录
        define('APPLICATION_PATH', ROOT_PATH.'application/');
        define('CONFIG_PATH', APPLICATION_PATH . 'config/');
        define('FRAMEWORK_PATH', ROOT_PATH.'framework/');
        define('TOOL_PATH', FRAMEWORK_PATH.'tool/');
    }

    /**
     * 初始化配置
     */
    private static function _initConfig(){
        // 存储于全局变量，可以在整个项目中都是用该配置数据
        $GLOBALS['config'] = require CONFIG_PATH.'application.config.php';
    }

    /**
     * 初始化分发参数
     */
    private static function _initDispatchParam(){
        // 平台
        $defualt_platform = $GLOBALS['config']['app']['defualt_platform'];
        define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : $defualt_platform);

        // 控制器类
        $defualt_controller = $GLOBALS['config'][PLATFORM]['defualt_controller'];
        define('CONTROLLER', isset($_GET['c']) ? $_GET['c'] : $defualt_controller);

        // 动作
        $defualt_action = $GLOBALS['config'][PLATFORM]['defualt_action'];
        define('ACTION', isset($_GET['a']) ? $_GET['a'] : $defualt_action);
    }

    /**
     * 声明当前平台的路径常量
     */
    private static function _initPlatformPathConst(){
        // 当前平台相关的路径常量
        define('CURRENT_CONTROLLER_PATH', APPLICATION_PATH.PLATFORM.'/controller/');
        define('CURRENT_MODEL_PATH', APPLICATION_PATH.PLATFORM.'/model/');
        define('CURRENT_VIEW_PATH', APPLICATION_PATH.PLATFORM.'/view/');
    }

    /**
     * 自动加载类文件函数
     */
    public static function userAutoload($class_name){

        //echo '<br/>class_name = '.$class_name;

        // 先处理确定的（框架中的核心类）
        $framework_class_list = array(
            // 类名 => '类文件地址'
            'BaseController' => FRAMEWORK_PATH.'BaseController.class.php',
            'BaseModel' => FRAMEWORK_PATH.'BaseModel.class.php',
            'Factory' => FRAMEWORK_PATH.'Factory.class.php',
            'MySQLDB' => FRAMEWORK_PATH.'MySQLDB.class.php',
            'SessionDB' => TOOL_PATH.'SessionDB.class.php', // session工具类自动加载
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

    /**
     * 注册自动加载
     */
    public static function _initAutoload(){
        spl_autoload_register(array(__CLASS__, 'userAutoload'));
    }

    /**
     * 分发请求
     */
    /**
     * 分发请求
     */
    private static function _dispatch() {
        //实例化控制器类,并调用动作方法
        $controller_name = CONTROLLER . 'Controller';
        //实例化
        $controller = new $controller_name();//可变类
        //调用方法（action动作）
        //拼凑当前的方法动作名字符串
        $action_name = ACTION . 'Action';
        $controller->$action_name();//可变方法
    }

}