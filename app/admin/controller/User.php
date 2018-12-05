<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 16:05
 */

namespace app\admin\controller;

use app\admin\model;
use think\Controller;
use think\Request;

class User extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'name'   => '林传托',
            'phone'  => '13175001592',
            'idcard' => '330327199506021591',
        ];
        $rel = model('user')->save($data);
        print_r($rel);
    }
}