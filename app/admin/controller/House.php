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
    public function index(Request $request)
    {
        if ($request->isPost()){
            $adid = input('post.adid');
            $data = db('house')->where('adid',$adid)->select();
            $nowTime = time();//当前时间
            foreach ($data as $k => $v){
                $difference = $nowTime-$v['update_time'];//时间差
                if($v['status'] == 2 && $difference >= (60*60*24*30)){
                    $v['status'] = 4;//当同时满足两种条件时,标注为着火房(4代表着火房)
                }
                $data[$k] = $v;
            }
            return $this->fetch('house_list',['data'=>$data]);
        }

    }

    /**
     * 添加
     */
    public function add(Request $request){
        if ($request->isPost()){
            $result = input('post.');
            $data = array(
                'adid'      => $result['adid'],
                'address'   => $result['address'],//$result['address']
                'area'      => $result['area'],//$result['area']
                'doormodel' => $result['doormodel'],//$result['doormodel']
                'status'    => $result['status'],//$result['status']
            );
            try{
                //数据库存储操作
                model('house')->save($data);
                return json(['data'=>'','status'=>200,'msg'=>'房源编辑成功!']);
            }catch (Exception $e){
                return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
            }
        }
    }

    /**
     * 编辑
     */
    public function edit(Request $request){
        if($request->isPost()){
            $hid = input('post.hid');//主键
            $result = input('post.');//数据
            $data = array(
                'address'   => $result['address'],
                'area'      => $result['area'],
                'doormodel' => $result['doormodel'],
                'status'    => $result['status']
            );
            try{
                model('house')->allowField(true)->save($data,['hid' => $hid]);
                return json(['data'=>'','status'=>200,'msg'=>'房源编辑成功!']);
            }catch (Exception $e){
                return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
            }
        }else{
            $hid = input('get.hid');//主键
            $data = db('house')->where('hid','=',$hid)->select()[0];
            return $this->fetch('admin/index',['data'=>$data]);
        }
    }

    /**
     * 删除
     */
    public function del(){
        try{
            $hid = input('post.hid');
            db('house')->delete($hid);
            return json(['data'=>'','status'=>200,'msg'=>'删除房源成功!']);
        }catch (Exception $e){
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
        }

    }

}