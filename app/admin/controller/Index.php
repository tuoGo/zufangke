<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
//        echo 1;exit;
        return $this->fetch('admin/index');
    }
}