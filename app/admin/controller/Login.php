<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2019/1/4
 * Time: 14:51
 */

namespace app\admin\controller;


use think\Controller;
use think\Exception;
use think\Session;

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
        $admin = input('post.phone');
        $pwd = input('post.pwd');
        if (empty($pwd) || empty($admin)){
            return json(['data'=>'','status'=>400,'msg'=>'请输入账户密码']);
        }
        $data = db('admin')->where('phone',$admin)->where('password',md5($pwd))->find();
        if(!empty($data)){
            Session::set('adid',$data['adid']);
            Session::set('name',$data['adname']);
            return json(['data'=>$data,'status'=> 200 , 'msg'=> '']);
        }else{
            return json(['data'=>'','status'=>400,'msg'=>'账户密码错误']);
        }

    }

    /*
     * 租客登录
     */
    public function uselogin(){
        $phone = input('post.phone');
        if (empty($phone)){
            return json(['data' => '','status' => 400, 'msg' => '请输入账号!']);
        }
        if(!is_numeric($phone)){//过滤非数字字符串
            return json(['data'=>'','status'=>400,'msg'=>'请输入正确手机号!']);
        }
        $data = db('user')->where('phone',$phone)->find();
        if (!empty($data)){
            Session::set('phone',$phone);
            Session::set('name',$data['name']);
            return json(['data'=>$data,'status'=> 200 , 'msg'=> '']);
        }else{
            return json(['data'=>'','status'=>400,'msg'=>'用户不存在!']);
        }
    }



}