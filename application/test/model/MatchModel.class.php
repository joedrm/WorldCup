<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/7
 * Time: 下午2:23
 */



class MatchModel extends BaseModel {

    /**
     * 获取所有比赛列表
     */
    public function getList(){
        $sql = "SELECT t1.t_name as t1_name, m.t1_score, m.t2_score, t2.t_name as t2_name, m.m_time FROM `match` as m left join team as t1 on t1.t_id=m.t1_id left join team as t2 on t2.t_id=m.t2_id;";
        return $this->_dao->getAll($sql);
    }


    /**
     * 删除某场比赛
     */
    public function removeMatch( $m_id ){
        $sql = "delete from `match` where m_id=$m_id";
        return $this->_dao->query($sql);
    }

    public function removeTeam($t_id){
        return $this->_dao->query("delete from `team` where t_id= $t_id");
    }
}