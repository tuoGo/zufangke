<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 16:05
 */

namespace app\admin\controller;

use think\Controller;
use think\Exception;
use think\Request;
use think\Db;

class User extends Base
{

    /*
     * 用户列表
     */
    public function index()
    {
        $data = Db::table('zfk_user')->select();
        return $this->fetch('index',['data' => $data]);
    }
    /*
     * 添加用户
     */
    public function add(Request $request)
    {
        //判断是否post
        if($request->isPost())
        {
            $userInfo = input('post.');
            $data = [
                'adid'   => $userInfo['adid'],
                'name'   => $userInfo['name'],
                'phone'  => $userInfo['phone'],
                'idcard' => $userInfo['idcard'],
            ];
            try{
                //搜索用户身份证是否已经存在
                $userRel = model('user')->where('idcard',$userInfo['idcard'])->select();
                if ($userRel){
                    return json(['data'=>'','status'=>400,'msg'=>'此用户已存在!']);
                }
                //数据库存储操作
                model('user')->allowField(true)->save($data);

                return json(['data'=>'','status'=>200,'msg'=>'用户添加成功!']);

            }catch (Exception $e){

                return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
            }

        }
    }
    /*
     * 编辑用户
     */
    public function edit(Request $request)
    {
        //判断是否post
        if ($request->isPost())
        {
            //接收主键uid
            $uid = input('post.uid');
            $userInfo = input('post.');
            $data = [
                'name'   => $userInfo['name'],
                'phone'  => $userInfo['phone'],
                'idcard' => $userInfo['idcard'],
            ];
            try{
                //数据库更新操作
                model('user')->allowField(true)->save($data,['uid' => $uid]);

                return json(['data'=>'','status'=>200,'msg'=>'用户编辑成功!']);

            }catch (Exception $e) {

                return json(['data' => '', 'status' => 400, 'msg' => '系统错误,请联系我们团队!']);

            }
        }
    }
    /*
     * 删除用户
     */
    public function del(Request $request)
    {
        if ($request->isPost())
        {
            //接收主键uid
            $uid = input('post.uid');
            try{
                //数据库删除操作
                $rel = model('user')->where('uid',$uid)->delete();
                if (empty($rel))
                {
                    return json(['data'=>'','status'=>400,'msg'=>'请不要重复删除!']);
                }
                return json(['data'=>'','status'=>200,'msg'=>'用户删除成功!']);

            }catch (Exception $e){

                return json(['data' => '', 'status' => 400, 'msg' => '系统错误,请联系我们团队!']);

            }
        }
    }
}