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

class Accounts extends Base
{
    /*
     * 财务报表
     */
    public function index(){
        $adid    = Session::get('adid');//获取房东主键
        $fcount  = db('financial')->where('adid',$adid)->count();
        $list    = db('financial')->where('adid',$adid)->order('fid asc')->paginate(14,$fcount);
        $page    = $list->render();
        $count   = db('underlying')->where('adid',$adid)->count();
        $signing = db('underlying')->where('adid',$adid)->where('status != 0')->count();
        $total   = db('financial')->where('adid',$adid)->sum('amount');
        $delivery= db('financial')->where('adid',$adid)->sum('rent');
        $costs   = db('financial')->where('adid',$adid)->sum('additional_costs');
        foreach ($list as $key => $value){
            $uid[$key] = $value['uid'];
        }
        $user = db('user')->where('uid','in',$uid)->select();
        foreach ($list as $fk => $fv){
            $flist[$fk] = $fv;
            foreach ($user as $uk => $uv){
                if ($flist[$fk]['uid'] == $uv['uid']){
                    $flist[$fk]['user'] = $uv;
                    continue;
                }
            }
        }
        $data = array(
            'count'    => $count,   //房源总计
            'signing'  => $signing, //已签约房源
            'total'    => $total,   //总金额
            'delivery' => $delivery,//租金收入
            'costs'    => $costs,   //水电收入
        );
        return $this->fetch('index',['data'=>$data,'list'=>$flist,'page'=>$page]);
    }

    /*
     * 添加
     */
    public function add(){
        $data = array(
            'rent'         => input('post.rent'),//租金
            'deposit'      => input('post.deposit'),//押金
            'water'        => input('post.deposit'),//水费
            'adid'         => Session::get('adid'),//房东主键
            'amount'       => input('post.amount'),//总金额
            'electricity'  => input('post.electricity'),//电费
            'trading_time' => time(),//交易时间
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
                'rent'         => input('post.rent'),//租金
                'deposit'      => input('post.deposit'),//押金
                'water'        => input('post.deposit'),//水费
                'amount'       => input('post.amount'),//总金额
                'electricity'  => input('post.electricity'),//电费
                'trading_time' => time(),//交易时间
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