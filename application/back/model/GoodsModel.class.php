<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/8/5
 * Time: 下午5:10
 */

class GoodsModel extends BaseModel{

    /**
     * @param $data 商品关联数据
     * @return bool
     */
    public function inserGoods($data){
        // 先数据校验

        $data['create_admin_id'] = $_SESSION['admin']['admin_id'];
        //$sql = "insert into `goods` values (null , '{$data['goods_name']}', )";
        $sql = sprintf("insert into `goods` values (null , '%s', '%s', '', '', '', '', '%s', '%s', '%s', '%s', '%s');",
            $data['goods_name'],
            $data['shop_price'],
            $data['goods_desc'],
            $data['goods_number'],
            $data['is_on_sale'],
            $data['goods_promote'],
            $data['create_admin_id']);

//        var_dump($data);

        return $this->_dao->query($sql);
    }
}