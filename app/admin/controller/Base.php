<?php
namespace app\admin\controller;
use think\Controller;

class Base extends Controller{

    function _initialize(){
        $adname = cookie('adname');
        $adid   = cookie('adid');

        if (!isset($adid) && !isset($adname)){
            header('location: http://'.$_SERVER['HTTP_HOST'].'Log/index');
            die;
        }
        // 登录用户进行再次验证
        $where = array(
            'adname' => ['=',$adname],
            'adid' => ['=',$adid],
        );
        $adminArr = db('admin')->where($where)->select()[0];
        if(empty($adminArr)){
            // 判断是否为合法数据
            header('location: http://'.$_SERVER['HTTP_HOST'].'index');
            die;
        }
        // 对角色进行管理
        // 得到对应的角色以及权限
        $roleArr = db('role')->where('roleid','=',$adminArr['rid'])->select()[0];
        if(empty($roleArr)){
            // 若没有对应的权限则为非法用户
            header('location: http://'.$_SERVER['HTTP_HOST'].'index');
            die;
        }

        $powerid = explode('|', $roleArr['powerid']);

        foreach ($powerid as $k => $v) {
            $powerTotalArr[] = db('power')->field('controller,action')->where('powerid','=',$v)->select()[0];
        }

        // 对路径进行判断
        $action = strtolower($_SERVER['REDIRECT_URL']);
        $flag = false;
        foreach ($powerTotalArr as $k => $v) {
            $url = strtolower('/'.$v['controller'].'/'.$v['action']);
            if($url == $action){
                $flag = true;
            }
        }
        if(!$flag){
            return json(['data'=>'','status'=>400,'msg'=>'您没有权限']);
        }

        // 重组控制器和方法
//        foreach ($powerTotalArr as $k => $v) {
//            if(!in_array($v['controller'],$powerTotalArrStr)) $powerTotalArrStr[] = strtolower($v['controller']);
//            $powerTotalArrStr[] = strtolower($v['controller']).'/'.strtolower($v['action']);
//        }
//        $this->assign('powerTotalArrStr',$powerTotalArrStr);
    }
}
