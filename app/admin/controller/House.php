<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 11:18
 */
namespace app\admin\controller;

use app\common\Common;
use think\Exception;
use think\Request;
use think\Session;

class House extends Base
{
    //房源列表
    public function index()
    {
        $nowTime = time();//当前时间
        $adid = Session::get('adid');
        $region = db('house')->where('adid',$adid)->select();//查询个人下的房源小区
        foreach ($region as $ky => &$vl){ //一层循环
            $region[$ky]['father'] = db('room')->where('hid',$vl['hid'])->select(); //查询单元/室
            foreach ($region[$ky]['father'] as $key => &$val){ //二层循环
                $region[$ky]['father'][$key]['child'] = db('underlying')->where('roomid',$val['roomid'])->select(); //查询房间
                foreach ($region[$ky]['father'][$key]['child'] as $k => $v){ //三层循环
                    $userinfo = db('user')->where('underid',$v['underid'])->where('status','1')->find(); //查询合同签署者信息
                    $contract = db('contract')->where('underid',$v['underid'])->find(); //每个房间的合同查询
                    $time = $nowTime - $v['update_time'];//时间差
                    $region[$ky]['father'][$key]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24); //逾期时间值
                    $region[$ky]['father'][$key]['child'][$k]['user'] = $userinfo; //用户信息
                    $region[$ky]['father'][$key]['child'][$k]['contract'] = $contract;  //合同信息
                    $region[$ky]['father'][$key]['child'][$k]['contract']['start_time'] = date('Y.m.d',$region[$ky]['father'][$key]['child'][$k]['contract']['start_time']);
                    $region[$ky]['father'][$key]['child'][$k]['contract']['end_time']   = date('Y.m.d',$region[$ky]['father'][$key]['child'][$k]['contract']['end_time']);
                    if ($v['status'] == 0 && $time >= (60 * 60 * 24 * 30)){
                        $region[$ky]['father'][$key]['child'][$k]['status'] = 4; //着火房的状态标记
                    }
                }
                unset($k,$v);
            }
            unset($key,$val);
        }
        unset($ky,$vl);
        return $this->fetch('house_list',['data'=>$region]);
    }
    /**
     * 添加页展示
     */
    public function addpage()
    {
        return $this->fetch();
    }

    /**
     * 添加小区,单元
     */
    public function add(Request $request){
        if ($request->isPost()){
            $result = input('post.');
            $time   = time();
            if (!empty($result['address'])){
                $house = array(
                    'adid'          => Session::get('adid'), //房东id
                    'address'       => $result['address'],//地址
                    'create_time'   => $time,
                    'update_time'   => $time,
                );
                $hid = model('house')->insertGetId($house);
                if ($hid){
                    $room = array(
                        'hid'   => $hid,
                        'room'  => $result['room'],
                        'type'  => $result['type'],
                    );
                    model('room')->allowField(true)->save($room);
                    return json(['data'=>'','status'=>200,'msg'=>'添加成功!']);
                }
            }else if (!empty($result['hid'])){
                $data = array(
                    'hid'       => $result['hid'],
                    'room'      => $result['room'],
                    'type'      => $result['type'],
                );
                model('room')->allowField(true)->save($data);
                return json(['data'=>'','status'=>200,'msg'=>'添加成功!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'未知错误,联系我们!']);
        }
    }
    /**
     * 添加房间
     */
    public function addRoom(Request $request){
        if ($request->isPost()){
            $result = input('post.');
            $data = array(
                'adid'      => $result['adid'], //房东id
                'address'   => $result['address'],//地址
                'status'    => $result['status'],//房源状态
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

    public function editpage()
    {
        return $this->fetch();
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

    public function delpage()
    {
        return $this->fetch();
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
    /**
     * 整租房or合租房or全部显示
     */
    public function leaseType(Request $request)
    {
        if ($request->isPost())
        {
            $adid   = input('post.adid');
            $type   = input('post.type');
            $status = input('post.status');
            if (empty($type) && empty($status)) {

                $data = db('house')->where('adid',$adid)->select();

                return json(['data'=>$data,'status'=>200,'msg'=>'']);

            }else if (empty($type) && !empty($status)) {

                $data = db('house')->where('adid',$adid)->where('status',$status)->select();

                return json(['data'=>$data,'status'=>200,'msg'=>'']);

            }else if (!empty($type) && empty($status)){

                $data = db('house')->where('adid',$adid)->where('lease_type',$type)->select();

                return json(['data'=>$data,'status'=>200,'msg'=>'']);

            }else if (!empty($type) && !empty($status)){

                $where = array(
                    'adid'          => ['=',$adid],
                    'lease_type'    => ['=',$type],
                    'status'        => ['=',$status],
                );

                $data = db('house')->where($where)->select();

                return json(['data'=>$data,'status'=>200,'msg'=>'']);

            }

        }

    }

}
