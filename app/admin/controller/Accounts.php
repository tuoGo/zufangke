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
        return $this->fetch('index',['data'=>$data,'list'=>$flist,'page'=>$page]);
    }
    /*
     * 向租客发起支付单
     */
    public function init(){
        $data = input('post.');
        print_r($data);exit;
    }
}