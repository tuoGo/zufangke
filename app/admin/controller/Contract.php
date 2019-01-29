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
            $count = db('contract')->count();
            $contract = db('contract')->where('adid',$adid)->order('contid asc')->paginate(15,$count);
            $pagecount = $contract->render();
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
            return $this->fetch('index',['data' => $data , 'pagecount'=>$pagecount]);
    }

    //显示合同添加页
    public function addpage()
    {
        $adid  = Session::get('adid');
        if(input('post.hid')){
            $hid = input('post.hid');
            $room = db('room')->where('hid',$hid)->select();
            return json(['data'=>$room,'status'=>200,'msg'=>'']);
        }else if (input('roomid')){
            $roomid = input('roomid');
            $underlying = db('underlying')->where('roomid',$roomid)->select();
            return json(['data'=>$underlying,'status'=>200,'msg'=>'']);
        }
        $house = db('house')->where('adid',$adid)->select();
        return $this->fetch('add',['data'=>$house]);
    }

    /*
     * 添加合同
     */
    public function add(Request $request)
    {
        if ($request->isPost())
        {
            $data = input('post.');
            $adid = Session::get('adid');
            $time = time();
            // 获取表单上传文件
            $files = request()->file('image');
            foreach($files as $file){
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move('uploads' . DS . 'infoimg');
                $path = DS . 'uploads' . DS . 'infoimg'. DS .$info->getSaveName();
                $pathNow = str_replace('\\','/',$path);
                $imgData[] = $pathNow;
            }
            $userData = [
                'adid'          => $adid,
                'rid'           => '2',
                'underid'       => $data['underid'],
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
                    'adid'              => $adid,
                    'underid'           => $data['underid'],
                    'hid'               => $data['hid'],
                    'uid'               => $uid,
                    'bet'               => $data['bet'],
                    'pay'               => $data['pay'],
                    'deposit'           => $data['deposit'],
                    'payment'           => $data['payment'],
                    'chargeday'         => '18',
                    'water'             => $data['water'],
                    'elec'              => $data['elec'],
                    'idcard_img_front'  => $imgData[0],
                    'idcard_img_behind' => $imgData[1],
                    'contract_img'      => $imgData[2],
                    'sms_time'          => $time,
                    'start_time'        => $data['start_time'],
                    'end_time'          => $data['end_time'],
                    'address'           => $data['address'],
                    'note'              => $data['note'],
                ];
                $rel = model('contract')->allowField(true)->save($contData);
                if ($rel)
                {
                    $this->success('合同添加成功！', '/contract');
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