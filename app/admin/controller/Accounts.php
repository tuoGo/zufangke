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
        $uid     = Session::get('uid');
        if (!empty($adid)){
            $fcount  = db('financial')->where('adid',$adid)->count();
            $list    = db('financial')->where('adid',$adid)->order('end_time desc')->paginate(14,$fcount);
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
                $flist[$fk]['start_time'] = date('Y年m月d日',$flist[$fk]['start_time']);
                $flist[$fk]['end_time'] = date('Y年m月d日',$flist[$fk]['end_time']);
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
            return $this->fetch('index',['data'=>$data,'list'=>$flist,'page'=>$page,'user'=>'fangdong']);
        }else if (!empty($uid)){
            $fcount  = db('financial')->where('uid',$uid)->count();
            $list    = db('financial')->where('uid',$uid)->where('status != 2')->order('end_time desc')->paginate(14,$fcount);
            $page    = $list->render();
            $adid    = db('user')->where('uid',$uid)->find()['adid'];
            $admin  = db('admin')->field('adname,phone')->where('adid',$adid)->find();
            foreach ($list as $uk => $uv){
                $flist[$uk] = $uv;
                $flist[$uk]['user'] = $admin;
                $flist[$uk]['start_time'] = date('Y年m月d日',$flist[$uk]['start_time']);
                $flist[$uk]['end_time'] = date('Y年m月d日',$flist[$uk]['end_time']);
            }
            return $this->fetch('index',['list'=>$flist,'page'=>$page,'user'=>'zuke']);
        }
    }
    /*
     * 向租客发起支付单
     */
    public function init(Request $request){
        if ($request->isPost()){
            $data = input('post.');
            $contract = db('contract')->where('contid',$data['contid'])->find();
            $rent  = db('financial')->field('rent')->where('fid',$data['fid'])->find()['rent'];
            $water = $data['water'] * $contract['water'];
            $elec  = $data['elec'] * $contract['elec'];
            $costs = $water + $elec;
            $sum   = $rent + $costs;
            $rel   = db('financial')->where('fid',$data['fid'])->update(['water'=>$data['water'],'elec'=>$data['elec'],'additional_costs'=>$costs,'amount'=>$sum,'status'=>3]);
            if ($rel){
                return json(['data'=>'','status'=>200,'msg'=>'已向租客发起支付!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'发起订单失败!']);
        }
    }
}