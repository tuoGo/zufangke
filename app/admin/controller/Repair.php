<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2018/12/11
 * Time: 16:41
 */

namespace app\admin\controller;

use app\common\Common;
use think\Controller;
use think\Request;

class Repair extends Controller
{
    //显示报修信息给房东看
    public function index()
    {
        $repair = db('repair')->select();
        foreach ($repair as $k => $v)
        {
            $user  = db('user')->where('uid',$v['uid'])->find();
            $house = db('house')->where('hid',$v['hid'])->find();
            $info  = [
                'repid'     => $v['repid'],
                'address'   => $house['address'],
                'name'      => $user['name'],               //---------数据拼接展示
                'phone'     => $user['phone'],
                'content'   => $v['content'],
            ];
            $data[] = $info;
        }
        return $this->fetch('index',['data' => $data]);
    }
    //完成报修处理
    public function complete(Request $request)
    {
        if ($request->isPost())
        {
            $repid = input('post.preid');
            $rel = db('repair')->where('repid',$repid)->update(['status' => 1]);
            if ($rel)
            {
                return json(['data'=>'','status'=>200,'msg'=>'完成处理!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,稍后再试!']);
        }
    }
    //添加报修信息
    public function add(Request $request)
    {
        if ($request->isPost())
        {
            $hid     = input('post.hid');//房源id
            $uid     = input('post.uid');//用户id
            $content = input('post.content');//报修内容
            $data = [
                'hid'       => $hid,
                'uid'       => $uid,
                'content'   => $content,
            ];
            $rel = model('repair')->save($data);
            if ($rel)
            {
                $phone = db('admin')->find()['phone'];
                $url = "http://yun.movek.net:83/api/sms/send.json";
                $sms = [
                    'apikey'   => '4218ce5136404fe695b62f0c18b70130',
                    'tpl_id'   => '593',
                    'content'  => '您有新的报修信息，请尽快登录后台查看，如果无法立即处理避免租客焦急等待产生负面情绪着想，请致电告知租客何时处理。【租房客】',
                    'mobile'   => $phone,
                ];
                $common = new Common();
                $rel = $common->request_post($url,$sms); //调用短信接口
                $relArr = json_decode($rel,true);
                if ($relArr['code'] == 0) //结果判断
                {
                    return json(['data'=>'','status'=>200,'msg'=>'您的情况已通知房东!']);
                }
                return json(['data'=>'','status'=>400,'msg'=>$relArr['msg']]);
            }
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,稍后再试!']);
        }
    }
    //编辑报修内容
    public function edit(Request $request)
    {
        if ($request->isPost())
        {
            $repid   = input('post.repid');
            $content = input('post.content');
            $rel = db('repair')->where('repid',$repid)->update(['content' => $content]);
            if ($rel)
            {
                return json(['data'=>'','status'=>200,'msg'=>'报修内容已修改!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,稍后再试!']);
        }
    }

    //取消报修
    public function del(Request $request)
    {
        if ($request->isPost())
        {
            $repid = input('post.repid');
            $rel = db('repair')->where('repid',$repid)->delete();
            if ($rel)
            {
                return json(['data'=>'','status'=>200,'msg'=>'报修已取消!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,稍后再试!']);
        }
    }
}