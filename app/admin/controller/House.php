<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 11:18
 */
namespace app\admin\controller;

use think\Controller;
use think\Exception;
use think\Request;

class House extends Controller
{
    //房源列表
    public function index()
    {
        $data  = db('house')->select();
        return $this->fetch('house_list',['data'=>$data]);
    }

    /**
     * 添加
     */
    public function add(Request $request){
        $result = input('post');
        $data = array(
            'address'   => $result['address'],//$result['address']
            'area'      => $result['area'],//$result['area']
            'doormodel' => $result['doormodel'],//$result['doormodel']
            'status'    => $result['status'],//$result['status']
        );

        try{
            //数据库存储操作
            model('house')->save($data);
            return json(['data'=>'','status'=>200,'msg'=>'用户编辑成功!']);
        }catch (Exception $e){
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
        }
    }

    /**
     * 编辑
     */
    public function edit(Request $request){
        if($request->isPost()){
            $hid = input('post.hid');//主键
            $result = input('post');//数据
            $data = array(
                'address'   => $result['address'],
                'area'      => $result['area'],
                'doormodel' => $result['doormodel'],
                'status'    => $result['status']
            );
            try{
                model('house')->allowField(true)->save($data,['hid' => $hid]);
                return json(['data'=>'','status'=>200,'msg'=>'用户编辑成功!']);
            }catch (Exception $e){
                return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
            }
        }else{
            $hid = input('get.hid');//主键
            $data = db('house')->where('hid','=',$hid)->select()[0];
            return $this->fetch('admin/index');
        }
    }

    /**
     * 删除
     */
    public function del(){
        try{
            $hid = input('get.hid');
            db('house')->delete($hid);
            return json(['data'=>'','status'=>200,'msg'=>'删除用户成功!']);
        }catch (Exception $e){
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
        }

    }

}