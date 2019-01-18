<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 11:18
 */
namespace app\admin\controller;

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
        $nowTime = time();
        $house = db('house')->where('adid', $adid)->select();
        foreach ($house as $k => $v) {
            $hid[$k] = $v['hid'];
        }
        unset($k, $v);//解除house循环变量
        $room = db('room')->where('hid', 'in', $hid)->select();
        foreach ($room as $ky => $vl) {
            $roomid[$ky] = $vl['roomid'];
        }
        unset($ky, $vl);//解除room循环变量
        $underlying = db('underlying')->where('roomid', 'in', $roomid)->select();
        foreach ($underlying as $kk => $vv) {
            $underid[$kk] = $vv['underid'];
        }
        unset($kk, $vv);//解除underlying循环变量
        $userinfo = db('user')->where('underid', 'in', $underid)->where('status', '1')->select(); //合同签署者
        $contract = db('contract')->where('underid', 'in', $underid)->select(); //合同信息
        foreach ($contract as $c => $cc) {
            $contract[$c]['start_time'] = date('Y.m.d', $cc['start_time']);
            $contract[$c]['end_time'] = date('Y.m.d', $cc['end_time']);
        }
        foreach ($house as $key => $val) {
            $data[$key] = $val;
            foreach ($room as $ky => $vl) {
                if ($house[$key]['hid'] == $room[$ky]['hid']) {
                    $data[$key]['father'][$ky] = $vl;
                }
                foreach ($underlying as $k => $v) {
                    if ($data[$key]['father'][$ky]['roomid'] == $v['roomid']) {
                        $data[$key]['father'][$ky]['child'][$k] = $v;
                        $time = $nowTime - $v['update_time'];//时间差
                        $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24); //逾期时间值
                    }
                }
            }
        }
        return $this->fetch('house', ['data' => $data, 'user' => $userinfo, 'contract' => $contract]);
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
        if ($request->isPost()) {
            $adid = Session::get('adid');
            $type = input('post.type');  //房间状态
            $status = input('post.status'); //房间是整租或合租
            $nowTime = time();
            $house = db('house')->where('adid', $adid)->select();
            foreach ($house as $k => $v) {
                $hid[$k] = $v['hid'];
            }
            unset($k, $v);//解除house循环变量
            $room = db('room')->where('hid', 'in', $hid)->where('type',$status)->select();
            foreach ($room as $ky => $vl) {
                $roomid[$ky] = $vl['roomid'];
            }
            unset($ky, $vl);//解除room循环变量
            $underlying = db('underlying')->where('roomid', 'in', $roomid)->where('status',$type)->select();
            foreach ($underlying as $kk => $vv) {
                $underid[$kk] = $vv['underid'];
            }
            unset($kk, $vv);//解除underlying循环变量
            $userinfo = db('user')->where('underid', 'in', $underid)->where('status', '1')->select(); //合同签署者
            $contract = db('contract')->where('underid', 'in', $underid)->select(); //合同信息
            foreach ($contract as $c => $cc) {
                $contract[$c]['start_time'] = date('Y.m.d', $cc['start_time']);
                $contract[$c]['end_time'] = date('Y.m.d', $cc['end_time']);
            }
            foreach ($house as $key => $val) {
                $data[$key] = $val;
                foreach ($room as $ky => $vl) {
                    if ($house[$key]['hid'] == $room[$ky]['hid']) {
                        $data[$key]['father'][$ky] = $vl;
                    }
                    foreach ($underlying as $k => $v) {
                        if ($data[$key]['father'][$ky]['roomid'] == $v['roomid']) {
                            $data[$key]['father'][$ky]['child'][$k] = $v;
                            $time = $nowTime - $v['update_time'];//时间差
                            $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24); //逾期时间值
                        }
                    }
                }
            }
            return $this->fetch('house', ['data' => $data, 'user' => $userinfo, 'contract' => $contract]);
        }
    }
    /**
     * 搜索
     */
    public function search(Request $request){
        if ($request->isPost()){
            $adid    = Session::get('adid');
            $text    = input('post.text');
            $nowTime = time();
            $house   = db('house')->where('adid', $adid)->where('address','like','%'.$text.'%')->select();
            foreach ($house as $k => $v) {
                $hid[$k] = $v['hid'];
            }
            unset($k, $v);//解除house循环变量
            $room = db('room')->where('hid', 'in', $hid)->select();
            foreach ($room as $ky => $vl) {
                $roomid[$ky] = $vl['roomid'];
            }
            unset($ky, $vl);//解除room循环变量
            $underlying = db('underlying')->where('roomid', 'in', $roomid)->select();
            foreach ($underlying as $kk => $vv) {
                $underid[$kk] = $vv['underid'];
            }
            unset($kk, $vv);//解除underlying循环变量
            $userinfo = db('user')->where('underid', 'in', $underid)->where('status', '1')->select(); //合同签署者
            $contract = db('contract')->where('underid', 'in', $underid)->select(); //合同信息
            foreach ($contract as $c => $cc) {
                $contract[$c]['start_time'] = date('Y.m.d', $cc['start_time']);
                $contract[$c]['end_time'] = date('Y.m.d', $cc['end_time']);
            }
            foreach ($house as $key => $val) {
                $data[$key] = $val;
                foreach ($room as $ky => $vl) {
                    if ($house[$key]['hid'] == $room[$ky]['hid']) {
                        $data[$key]['father'][$ky] = $vl;
                    }
                    foreach ($underlying as $k => $v) {
                        if ($data[$key]['father'][$ky]['roomid'] == $v['roomid']) {
                            $data[$key]['father'][$ky]['child'][$k] = $v;
                            $time = $nowTime - $v['update_time'];//时间差
                            $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24); //逾期时间值
                        }
                    }
                }
            }
            return $this->fetch('house', ['data' => $data, 'user' => $userinfo, 'contract' => $contract]);
        }
    }
}
