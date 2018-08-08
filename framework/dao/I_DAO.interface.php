<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/25
 * Time: 上午8:36
 */

interface I_DAO {

    public static function getInstance($config);
    public function query($sql);
    public function getAll($sql);
    public function getRow($sql);
    public function getOne($sql);
    public function escapeString($data);
}