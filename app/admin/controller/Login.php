<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2019/1/4
 * Time: 14:51
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch('login');
    }

    /*
     * 全部退出
     */
    public function out(){
        Session::delete('adid');
        Session::delete('adname');
        Session::delete('phone');
        return $this->fetch('Log/index');//跳转登录页
    }

    /*
     * 房东登录
     */
    public function adlogin(){
        $admin = input('post.admin');
        $pwd = input('post.pwd');
        if (empty($pwd) || empty($admin)){
            return json(['data'=>'','status'=>400,'msg'=>'请输入账户密码']);
        }
        $where = array(
            'adname' => ['=',$admin],
            'password' => ['=',md5($pwd)],
        );
        $data = db('admin')->where($where)->find();
        if(!empty($data)){
            Session::set('adid',$data['adid']);
            Session::set('adname',$data['adname']);
            return $this->fetch('admin/index');//跳转首页
        }else{
            return json(['data'=>'','status'=>400,'msg'=>'账户密码错误']);
        }

    }

    /*
     * 租客登录
     */
    public function uselogin(Request $request){
        $phone = input('post.phone');
        if(!is_numeric($phone)){//过滤非数字字符串
            return json(['data'=>'','status'=>400,'msg'=>'用户不存在!']);
        }
        $data = db('user')->where('phone',$phone)->find();
        if (!empty($data)){
            Session::set('phone',$phone);
            return $this->fetch('admin/index');//跳转首页
        }else{
            return json(['data'=>'','status'=>400,'msg'=>'用户不存在!']);
        }
    }



}