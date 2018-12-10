<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 16:02
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Housecount extends Controller
{
    /*
     * 租房成员首页
     */
    public function index()
    {
        $count = Db::query("select hid,count(hid) from zfk_user group by hid");
        return $this->fetch('index',['data',$count]);
    }

    /*
     * 租房成员详细信息显示
     */
    public function showinfo(Request $request)
    {
        if ($request->isPost())
        {
            $hid = input('post.hid');
            $data = model('user')->where('hid','=',$hid)->select();
            if($data)
            {
                foreach ($data as $v){
                    $show[] = $v->toArray();
                }
            }
            return $this->fetch('showinfo',['data',$show]);
        }
    }
}