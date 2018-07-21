<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/8
 * Time: 上午11:22
 */


class AdminModel extends BaseModel{

    /**
     * 验证管理员是否合法
     * @param $admin_name
     * @param $admin_pwd
     *
     * @return bool
     */
    public function check($admin_name, $admin_pwd){

        //echo '<br/>name='.$admin_name;

        $sql = "SELECT * FROM `wdy_admin` WHERE admin_name='$admin_name' and admin_pwd=md5('$admin_pwd')";
        $row = $this->_dao->getRow($sql);

        return (bool)$row;
    }

}