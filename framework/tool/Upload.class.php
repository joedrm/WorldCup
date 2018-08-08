<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/8/8
 * Time: 上午6:21
 */

class Upload{

    private $_max_size;
    private $_type_map;
    private $_allow_ext_list;
    private $_allow_mime_list;
    private $_upload_path;
    private $_prefix;

    private $_error; // 记录错误消息
    public function getError(){
        return $this->_error;
    }

    public function __construct()
    {
        $this->_max_size = 1024*1024;
        $this->_type_map = array(
            '.png' => array('image/png', 'image/x-png'),
            '.jpg' => array('image/jpeg', 'image/pjpeg'),
            '.jpeg' => array('image/jpeg', 'image/pjpeg'),
            '.gif' => array('image/gif'),
        );
        $this->_allow_ext_list = array('.png', '.jpg');

        # mime type 元素
        $allow_mine_list = array();
        foreach ($this->_allow_ext_list as $value){
            // 得到每个后缀名
            $allow_mine_list = array_merge($allow_mine_list, $this->_type_map[$value]);
        }
        // 去重
        $this->_allow_mime_list = array_unique($allow_mine_list);

        $this->_upload_path = './';

        $this->_prefix = 'wdy_';
    }

    public function __set($name, $value) // 属性重载
    {
        // TODO: Implement __set() method.
        $allow_set_list = array('_upload_path', '_prefix', '_allow_ext_list', '_max_size');
        if (substr($name, 0, 1) !== '_'){
            $name = '_'.$name;
        }
        $this->$name = $value;
    }

    /**
     * 上传单个文件
     */
    public function uploadOne($tmp_file){

        # 是否存在错误
        if ($tmp_file['error'] != 0){
            $this->_error = '文件上传错误';
            echo $tmp_file['error'];
            return false;
        }

        # 尺寸限定
        if ($tmp_file['size'] > $this->_max_size){
            echo '文件过大';
            return false;
        }

        # 类型
        $ext = strtolower(strrchr($tmp_file['name'], '.'));

        if (!in_array($ext, $this->_allow_ext_list)){
            $this->_error = '类型不合适';
            return false;
        }

        if (!in_array($tmp_file['type'], $this->_allow_mime_list)){
            $this->_error = '类型不合法';
            return false;
        }

        // PHP 自己获取文件的 mime ，进行检测
        $finfo = new finfo(FILEINFO_MIME_TYPE);//获得一个可以检测文件mime类型的对象
        $mime_type = $finfo->file($tmp_file['tmp_name']);

        if (!in_array($mime_type, $this->_allow_mime_list)){
            $this->_error = '类型不合法';
            return false;
        }

        # 移动
        // 创建子目录
        $subdir = date('YmdH').'/';
        if (! is_dir($this->_upload_path.$subdir)){ // 检测是否存在
            // 不存在，就创建
            mkdir($this->_upload_path.$subdir);
        }

        $upload_fila_name = uniqid($this->_prefix, true).$ext;
        if (move_uploaded_file($tmp_file['tmp_name'], $this->_upload_path.$subdir.$upload_fila_name)){
            // 移动成功, 返回文件名
            return $subdir.$upload_fila_name;
        }else{
            $this->_error = '移动失败';
            return false;
        }
    }
}
