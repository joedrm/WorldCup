<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/8/5
 * Time: 下午5:10
 */

class GoodsModel extends BaseModel{

    protected $_logic_table = 'goods';


    /**
     * @param $data 商品关联数据
     * @return bool
     */
    public function inserGoods($data){

        $data['create_admin_id'] = $_SESSION['admin']['admin_id'];

        // 保证数据转义
        $escape_data = $this->escapteStringAll($data);

        //$sql = "insert into `goods` values (null , '{$data['goods_name']}', )";
        $sql = sprintf("insert into $this->_table values (null , %s, %s, '', '', '', '', %s, %s, %s, %s, %s);",
            $escape_data['goods_name'],
            $escape_data['shop_price'],
            $escape_data['goods_desc'],
            $escape_data['goods_number'],
            $escape_data['is_on_sale'],
            $escape_data['goods_promote'],
            $escape_data['create_admin_id']);

//        var_dump($data);
//        die($sql);

        return $this->_dao->query($sql);
    }
}