<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 11:18
 */
namespace app\admin\controller;
use app\common\Common;
use think\Controller;

class House extends Controller {
    public function index(){
        return $this->fetch('house/house_list');
    }
}