<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2018/12/11
 * Time: 16:41
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Pubexpense extends Controller
{
    //显示报修信息给房东看
    public function index()
    {
        $data = db('repair')->select();
        print_r($data);
    }
    //添加报修信息
    public function repair(Request $request)
    {
        if ($request->isPost())
        {
            $house   = input('post.house'); //房名
            $name    = input('post.name');  //用户名
            $phone   = input('post.phone'); //手机
            $content = input('post.content');//报修内容
            $data = [
                ''
            ];
            db('repair')->insert();
        }
    }
}