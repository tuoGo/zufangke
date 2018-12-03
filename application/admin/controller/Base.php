<?php
namespace app\admin\controller;
use Think\Controller;

class BaseController extends Controller{

    function _initialize(){
        $adname = cookie('adname');
        $adid   = cookie('adid');

        if (!isset($adid) && !isset($adname)){
            header('location:'.U('Log/index'));
            die;
        }
        // 登录用户进行再次验证
        $where = array(
            'adname' => passport_decrypt($adname,C('PASSWORD_KEY')),
            'adid'	 => passport_decrypt($adid,C('PASSWORD_KEY')),
        );
        $admin = D('Admin');
        $adminArr = $admin->where($where)->find();
        if(empty($adminArr)){
            // 判断是否为合法数据
            header('location:'.U('Home/Index/index'));
            die;
        }
        // 对角色进行管理
        // 得到对应的角色以及权限
        $role = D('role');
        $roleArr = $role->find($adminArr['rid']);
        if(empty($roleArr)){
            // 若没有对应的权限则为非法用户
            header('location:'.U('Home/Index/index'));
            die;
        }
        $power = D('Power');
        $powerid = explode('|', $roleArr['powerid']);

        $where['powerid'] = ':powerid';
        foreach ($powerid as $k => $v) {
            $powerTotalArr[] = $power->field('controller,action')->where($where)->bind(':powerid',$v['powerid'])->find();
        }

        // 做两层判断
        // 对路径进行判断
        $controller = strtolower(CONTROLLER_NAME);
        $action = strtolower(ACTION_NAME);
        $flag = false;
        foreach ($powerTotalArr as $k => $v) {
            if(strtolower($v['controller']) == $controller && strtolower($v['action']) == $action){
                $flag = true;
            }
        }
        if(!$flag) exit('您没有权限');

        // 重组控制器和方法
        foreach ($powerTotalArr as $k => $v) {
            if(!in_array($v['controller'],$powerTotalArrStr)) $powerTotalArrStr[] = strtolower($v['controller']);
            $powerTotalArrStr[] = strtolower($v['controller']).'/'.strtolower($v['action']);
        }

        $this->assign('powerTotalArrStr',$powerTotalArrStr);
    }
}
