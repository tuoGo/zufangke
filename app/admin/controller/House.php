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
        $room = db('room')->where('adid',$adid)->where('type','2')->select();
        foreach ($room as $ky => $vl) {
            $hid[$ky]    = $vl['hid'];
            $roomid[$ky] = $vl['roomid'];
        }unset($ky, $vl);//解除room循环变量
        $house = db('house')->where('hid','in',$hid)->select();
        $underlying = db('underlying')->where('roomid', 'in', $roomid)->select();
        foreach ($underlying as $kk => $vv) {
            $underid[$kk] = $vv['underid'];
        }unset($kk, $vv);//解除underlying循环变量
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
                        if ($v['status'] == 2){
                            $data[$key]['father'][$ky]['child'][$k]['vacancy'] = ($time / 60 / 60 / 24) > 0 && ($time / 60 / 60 / 24) < 1 ? 1 : floor($time / 60 / 60 / 24);
                        }else if ($time > (60 * 60 * 24 * 30) && $v['status'] == 0){
                            $data[$key]['father'][$ky]['child'][$k]['status'] = 4;
                            $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24); //空置时间
                        }else{
                            $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24) < 0 ? 1 : floor($time / 60 / 60 / 24);
                        }
                    }
                }
            }
        }
        return $this->fetch('house', ['data' => $data, 'user' => $userinfo, 'contract' => $contract]);
    }

    /**
     * 添加小区,单元
     */
    public function add(Request $request){
        if ($request->isPost()){
            $result = input('post.');
            $adid   = Session::get('adid');
            $time   = time();
            if (!empty($result['plot_name'])){
                $house = array(
                    'adid'          => $adid, //房东id
                    'address'       => $result['plot_name'],//地址
                    'create_time'   => $time,
                    'update_time'   => $time,
                );
                $hid = model('house')->insertGetId($house);
                if ($hid){
                    foreach ($result['datas'] as $key => $val){
                        $val['hid']  = $hid;
                        $val['adid'] = $adid;
                        model('room')->data($val,true)->isUpdate(false)->save();
                    }
                    return json(['data'=>'','status'=>200,'msg'=>'添加成功!']);
                }
            }else if (!empty($result['hid'])){
                foreach ($result['datas'] as $ky => $vl){
                    $vl['hid']  = $result['hid'];
                    $vl['adid'] = $adid;
                }
                model('room')->data($vl,true)->isUpdate(false)->save();
                return json(['data'=>'','status'=>200,'msg'=>'添加成功!']);
            }else if (!empty($result['roomid'])){
                //房间字段
                foreach ($result['datas'] as $k => $v){
                    $v['roomid'] = $result['roomid'];
                    $v['adid']   = $adid;
                }
            }
            return json(['data'=>'','status'=>400,'msg'=>'未知错误,联系我们!']);
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
            $adid    = Session::get('adid');
            $status  = input('post.status'); //房间的状态 0空置 1已租 2逾期 3全部
            $type    = input('post.type'); //单元/室 1整租 2合租 3全部
            $statusNow = $status;
            $typeNow = $type;
            if($type == '3'){
                $type = array('0'=>'1','1'=>'2');
            }
            $nowTime = time();
            //筛选
            if ($status == '0' || $status == '2'){
                $underlyingStr = db('underlying')->where('adid',$adid)->where('status',$status)->select();
            }elseif($status == '1'){
                $status = array('0'=>'1','1'=>'2');
                $underlyingStr = db('underlying')->where('adid',$adid)->where('status','in',$status)->select();
            }else{
                $status = array('0'=>'0','1'=>'1','2'=>'2');
                $underlyingStr = db('underlying')->where('adid',$adid)->select();
            }
            foreach ($underlyingStr as $uk => $uv){
                $roomid[$uk] = $uv['roomid'];
            }unset($uk,$uv);//解除循环变量
            $roomid = array_unique($roomid);
            $room = db('room')->where('roomid','in',$roomid)->where('type','in',$type)->select();
            foreach ($room as $rk => $rv){
                $hid[$rk] = $rv['hid'];
                $roomids[$rk] = $rv['roomid'];
            }
            $hid = array_unique($hid);
            $roomids = array_unique($roomids);
            $house = db('house')->where('hid','in',$hid)->select();
            $underlying = db('underlying')->where('roomid','in',$roomids)->where('status','in',$status)->select();
            foreach ($underlying as $undk => $undv){
                $underid[$undk] = $undv['underid'];
            }
            //数据拼接
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
                            if ($v['status'] == 2){
                                $data[$key]['father'][$ky]['child'][$k]['vacancy'] = ($time / 60 / 60 / 24) > 0 && ($time / 60 / 60 / 24) < 1 ? 1 : floor($time / 60 / 60 / 24);
                            }else if ($time > (60 * 60 * 24 * 30) && $v['status'] == 0){
                                $data[$key]['father'][$ky]['child'][$k]['status'] = 4;
                                $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24); //空置时间
                            }else{
                                $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24) < 0 ? 1 : floor($time / 60 / 60 / 24);
                            }
                        }
                    }
                }
            }
//            print_r($data);exit;
            return $this->fetch('house', ['data' => $data, 'user' => $userinfo, 'contract' => $contract , 'type' => $typeNow , 'status' => $statusNow]);
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
                            if ($v['status'] == 2){
                                $data[$key]['father'][$ky]['child'][$k]['vacancy'] = ($time / 60 / 60 / 24) > 0 && ($time / 60 / 60 / 24) < 1 ? 1 : floor($time / 60 / 60 / 24);
                            }else if ($time > (60 * 60 * 24 * 30) && $v['status'] == 0){
                                $data[$key]['father'][$ky]['child'][$k]['status'] = 4;
                                $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24); //空置时间
                            }else{
                                $data[$key]['father'][$ky]['child'][$k]['vacancy'] = floor($time / 60 / 60 / 24) < 0 ? 1 : floor($time / 60 / 60 / 24);
                            }
                        }
                    }
                }
            }
            if ($data == ''){
                $data = '0';
            }
            return $this->fetch('house', ['data' => $data, 'user' => $userinfo, 'contract' => $contract]);
        }
    }
}
