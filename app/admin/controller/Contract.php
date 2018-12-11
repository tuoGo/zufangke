<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 14:36
 */

namespace app\admin\controller;
use app\admin\model;
use think\Controller;
use think\Request;

class Contract extends Controller
{
    /*
     * 显示合同列表
     */
    public function index()
    {
        $data = db('contract')->select();
        return $this->fetch('index',['data' => $data]);
    }

    /*
     * 添加合同
     */
    public function add(Request $request)
    {
        if ($request->isPost())
        {
            $data = input('post.');
            $contData = [
                'uid'       => $data['uid'],
                'hid'       => $data['hid'],
                'bet'       => $data['bet'],
                'pay'       => $data['pay'],
                'deposit'   => $data['deposit'],
                'payment'   => $data['payment'],
                'chargeday' => $data['chargeday'],
                'water'     => $data['water'],
                'elec'      => $data['elec'],
            ];
            $rel = model('contract')->allowField(true)->save($contData);
            if ($rel)
            {
                return json(['data'=>'','status'=>200,'msg'=>'合同添加成功!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'合同添加失败!']);
        }
    }

    /*
     * 删除合同
     */
    public function del(Request $request)
    {
        if ($request->isPost())
        {
            $contid = input('post.contid');
            $rel = model('contract')->where('contid','=',$contid)->save(['status' => 0]);
            if ($rel)
            {
                return json(['data'=>'','status'=>200,'msg'=>'合同删除成功!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'合同删除失败或不存在此合同!']);
        }
    }
}