<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 15:25
 */

namespace app\admin\controller;


use think\Controller;
use think\Cookie;
use think\Request;
use think\Db;
class Adinfo extends Controller
{

    /*
     * 退出
     */
    public function cancellation(){
        if(!empty(cookie('adid')) || !empty(cookie('adname')) || !empty(cookie('phone'))){
            Cookie::delete('adid');
            Cookie::delete('adname');
            Cookie::delete('phone');
        }
        return $this->fetch('Log/index');//跳转登录页
    }

    /*
     * 房东登录
     */
    public function login(){
        $admin = input('post.admin');
        $pwd = input('post.pwd');
        if (empty($pwd) && empty($admin)){
            return json(['data'=>'','status'=>400,'msg'=>'请输入账户密码']);
        }
        $where = array(
            'adname' => ['=',$admin],
            'password' => ['=',md5($pwd)],
        );
        $data = db('admin')->where($where)->find();
        if(!empty($data)){
            Cookie::set('adid',$data['adid'],3600);
            Cookie::set('adname',$data['adname'],3600);
            return $this->fetch('admin/index');//跳转首页
        }else{
            return json(['data'=>'','status'=>400,'msg'=>'账户密码错误']);
        }

    }

    /*
    * 超级管理员用户
    */
    public function index(Request $request)
    {
        //判断有post传递走编辑
        if ($request->isPost())
        {
            $adid = input('post.adid');
            $adminInfo = input('post.');
            $data = [
                'adname' => $adminInfo['adname'],
                'phone'  => $adminInfo['phone'],
            ];
            try{
            //数据库更新操作
                model('admin')->allowField(true)->save($data,['adid' => $adid]);

                return json(['data'=>'','status'=>200,'msg'=>'用户编辑成功!']);

            }catch (Exception $e){

                return json(['data' => '', 'status' => 400, 'msg' => '系统错误,请联系我们团队!']);

            }
        }
        $info = Db::table('zfk_admin')->field('adname,phone')->select();
        $info = $info[0];
        return $this->fetch('index',['data' => $info]);
    }
}
