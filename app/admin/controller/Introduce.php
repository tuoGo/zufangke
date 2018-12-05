<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 10:48
 */

namespace app\admin\controller;

use think\Controller;

class Introduce extends Controller
{
    public function index(){
        return $this->fetch('admin/introduce');
    }
}