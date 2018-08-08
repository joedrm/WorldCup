<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/7
 * Time: 下午2:31
 */


/**
项目中的工厂类
 */
class Factory {

    /**
     * 生成模型的单例对象
     *
     * @param $model_name string
     * @return object
     */
    public static function M($model_name){

        // 存储已经实例化好的模型对象的列表，下标模型名，值模型对象
        static $model_list = array();

        // 判断当前模型是否已经实例化
        if (!isset($model_list[$model_name])){

            // 可变标志符，可变类
            $model_list[$model_name] = new $model_name;
        }
        return $model_list[$model_name];
    }
}