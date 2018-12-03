<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 11:18
 */
namespace app\admin\controller;
use app\common\Common;
class House {
    public function index(){
        $a = new Common();
        echo $a->index();
    }
}