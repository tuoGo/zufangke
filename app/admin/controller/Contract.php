<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 14:36
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class Contract extends Base
{
    /*
     * 显示合同列表
     */
    public function index()
    {
            $adid = Session::get('adid');
            $contract = db('contract')->where('adid',$adid)->select();
            foreach ($contract as $key => $val){
                $uid[$key]     = $val['uid'];
                $underid[$key] = $val['underid'];
            }unset($key,$val);
            $userinfo   = db('user')->where('uid','in',$uid)->select();
            foreach ($contract as $contk => $contv){
                $data[$contk] = $contv;
                foreach ($userinfo as $userk => $userv){
                    if ($contract[$contk]['uid'] == $userinfo[$userk]['uid']){
                        $data[$contk]['user'] = $userv;
                        $data[$contk]['start_time'] = date('Y年m月d日',$data[$contk]['start_time']);
                        $data[$contk]['end_time'] = date('Y年m月d日',$data[$contk]['end_time']);
                        continue;
                    }
                }
            }
            return $this->fetch('index',['data' => $data]);
    }

    //显示合同添加页
    public function addpage()
    {
        return $this->fetch();
    }

    /*
     * 添加合同
     */
    public function add(Request $request)
    {
        if ($request->isPost())
        {
            $data = input('post.');
            $time = time();
            $userData = [
                'adid'          => $data['adid'],
                'hid'           => $data['hid'],
                'name'          => $data['name'],
                'phone'         => $data['phone'],
                'idcard'        => $data['idcard'],
                'create_time'   => $time,
                'update_time'   => $time,
            ];
            $uid = model('user')->insertGetId($userData);
            if ($uid)
            {
                $contData = [
                    'adid'              => $data['adid'],
                    'hid'               => $data['hid'],
                    'uid'               => $uid,
                    'bet'               => $data['bet'],
                    'pay'               => $data['pay'],
                    'deposit'           => $data['deposit'],
                    'payment'           => $data['payment'],
                    'chargeday'         => $data['chargeday'],
                    'water'             => $data['water'],
                    'elec'              => $data['elec'],
                    'idcard_img_front'  => $data['idcard_img_front'],
                    'idcard_img_behind' => $data['idcard_img_behind'],
                    'contract_img'      => $data['contract_img'],
                    'sms_time'  => $time,
                ];
                $rel = model('contract')->allowField(true)->save($contData);
                if ($rel)
                {
                    return json(['data'=>'','status'=>200,'msg'=>'合同添加成功!']);
                }
            }
            return json(['data'=>'','status'=>400,'msg'=>'合同添加失败!']);
        }
    }

    //显示合同删除页
    public function delpage()
    {
        return $this->fetch();
    }

    /*
     * 软删除合同
     */
    public function del(Request $request)
    {
        if ($request->isPost())
        {
            $contid = input('post.contid');
            $rel = db('contract')->where('contid',$contid)->update(['status' => 0]);
            if ($rel)
            {
                return json(['data'=>'','status'=>200,'msg'=>'合同已软删除!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'合同删除失败或不存在此合同!']);
        }
    }
    public function checkIn(){
//        return $this->fetch();
    }
}