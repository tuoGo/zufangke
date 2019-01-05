<?php
namespace app\admin\controller;

use think\Session;

class Index extends Base
{
    public function index()
    {
        $data = [
            'name'  => Session::get('name'),
            'phone' => Session::get('phone'),
        ];
        $this->assign('data',$data);
        return $this->fetch('admin/index');
    }
}