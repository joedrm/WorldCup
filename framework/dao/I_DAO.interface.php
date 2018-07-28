<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2018/7/25
 * Time: 上午8:36
 */

interface I_DAO {

    public function getInstance($config);
    public function query($sql);
    public function getAll();
    public function getRow();
    public function getOne();
    public function escapeString();
}