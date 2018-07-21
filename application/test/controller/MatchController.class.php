<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/7
 * Time: 下午4:13
 */


class MatchController extends BaseController{

    public function listAction(){

        $m_match = Factory::M('MatchModel');
        $match_list = $m_match->getList();

        echo '<br/>';

        //require './application/test/view/match_list_view.html';
        require CURRENT_VIEW_PATH.'match_list_view.html';
    }

    public function removeAction(){

        echo "执行了删除操作";
    }
}