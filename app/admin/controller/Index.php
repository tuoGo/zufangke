<?php
namespace app\admin\controller;

use think\Session;


class Index extends Base
{
    public function index()
    {
        $data = Session::get();
        return $this->fetch('admin/index',['data'=>$data]);
    }
}