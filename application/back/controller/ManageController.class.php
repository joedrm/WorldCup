<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/17
 * Time: 下午5:27
 */

class ManageController extends PlatformController {

     public function indexAction(){
         require CURRENT_VIEW_PATH.'index.html';
     }

     public function topAction(){
         require CURRENT_VIEW_PATH.'top.html';
     }

     public function menuAction(){
        require CURRENT_VIEW_PATH.'menu.html';
     }

     public function dragAction(){
        require CURRENT_VIEW_PATH.'drag.html';
     }

     public function mainAction(){
        require CURRENT_VIEW_PATH.'main.html';
     }
}