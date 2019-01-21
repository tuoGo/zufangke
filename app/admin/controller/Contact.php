<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2019/1/21
 * Time: 11:15
 */

namespace app\admin\controller;


class Contact extends Base
{
    public function index(){
        return $this->fetch('index');
    }
}