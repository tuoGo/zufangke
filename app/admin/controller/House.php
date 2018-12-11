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
use think\Db;

class House extends Controller
{
    //房源列表
    public function index()
    {
        echo 1;
        $data = Db::query('select * from zfk_house');
        dump($data);exit;

        $data  = db('house')->select();
        dump($data);exit;
        return $this->fetch('house/house_list',['data'=>$data]);
    }

    /**
     * 添加
     */
    public function add(Request $request){
        $result = input('post');
        $data = array(
            'address'   => 123,//$result['address']
            'area'      => 123,//$result['area']
            'doormodel' => 123,//$result['doormodel']
            'status'    => 123,//$result['status']
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

}