<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/11
 * Time: 10:10
 *
 * 财务报表
 */
namespace app\admin\controller;

use think\Request;
use think\Exception;
use think\Session;

class Financial extends Base
{
    /*
     * 财务报表
     */
    public function index(){
        $adid = Session::get('adid');//获取房东主键
        $data = db('financial')->where('adid',$adid)->select();

        return $this->fetch('',['data'=>$data]);

    }

    /*
     * 添加
     */
    public function add(){
        $data = array(
            'rent'         => input('post.rent'),
            'deposit'      => input('post.deposit'),
            'water'        => input('post.deposit'),
            'adid'         => Session::get('adid'),
            'amount'       => input('post.amount'),
            'electricity'  => input('post.electricity'),
            'trading_time' => time(),
        );
        try{
            db('financial')->insert($data);
            return json(['data'=>'','status'=>200,'msg'=>'财务报表添加成功!']);
        }catch (Exception $e){
            return json(['data'=>'','status'=>200,'msg'=>'系统错误,请联系我们团队!']);
        }
    }

    /*
     * 编辑
     */
    public function edit(Request $request){
        if($request->isPost()){
            $fid = input('post.fid');//主键
            $data = array(
                'rent'         => input('post.rent'),
                'deposit'      => input('post.deposit'),
                'water'        => input('post.deposit'),
                'amount'       => input('post.amount'),
                'electricity'  => input('post.electricity'),
                'trading_time' => time(),
            );
            try{
                db('financial')->where('fid',$fid)->update($data);
                return json(['data'=>'','status'=>200,'msg'=>'房源编辑成功!']);
            }catch (Exception $e){
                return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
            }
        }else{
            $fid = input('get.fid');//主键
            $data = db('financial')->where('fid','=',$fid)->find();
            return $this->fetch('',['data'=>$data]);
        }
    }

    /**
     * 删除
     */
    public function del(){
        try{
            $fid = input('post.fid');
            db('financial')->delete($fid);
            return json(['data'=>'','status'=>200,'msg'=>'删除报表成功!']);
        }catch (Exception $e){
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
        }

    }


}