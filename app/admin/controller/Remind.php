<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 16:44
 */
namespace app\admin\controller;
use app\common\Common;
use think\Controller;
use think\Request;


class Remind extends Controller
{
    //自动短信提醒
    public function remindSms()
    {
        $data = db('contract')->where('sms',0)->where('status',1)->select();

        if ($data)//有效条件进入
        {
            foreach ($data as $k => $v)
            {
                $sms_date = $v['sms_time'];
                $newDate = date('Y-m-d H:i:s',strtotime("+".$v['pay']."month",$sms_date));  //计算时间的月份按照付几
                $date = strtotime($newDate);          //转回时间戳
                $unixDate = $date - 5 * 60 * 60 * 24; //减五天的时间戳
                $curTime = time();
                if ($curTime > $unixDate)//判断当前时间是否到了通知时间
                {
                    $phone = db('user')->where('uid',$v['uid'])->find()['phone'];
                    //调用短信接口 更新数据库合同已提醒状态和sms_time
                    $url = "http://yun.movek.net:83/api/sms/send.json";
                    //短信参数
                    $sms = [
                        'apikey'   => '4218ce5136404fe695b62f0c18b70130',
                        'tpl_id'   => '529',
                        'content'  => '尊敬的客户，你的房租就快到期了，如有续租近日请准备好租金到期前交付。【租房客】',
                        'mobile'   => $phone,
                    ];

                    $common = new Common();
                    $rel = $common->request_post($url,$sms); //调用短信接口
                    $relArr = json_decode($rel,true);
                    if ($relArr['code'] == 0) //结果判断
                    {
                        //更新短信发送状态
                        db('contract')->where('contid',$v['contid'])->update(['sms' => 1 ,'sms_time' => time()]);
                    }else{
                        //报错存储
                        model('smslog')->data(['uid' => $v['uid'] ,'phone' => $phone ,'msg' => $relArr['msg']])->save();
                    }
                }
            }
        }
    }
    //自动短信提醒发送状态重置
    public function reloadSms()
    {
        $data = db('contract')->where('sms',1)->where('status',1)->select();
        $curTime = time();
        foreach ($data as $k => $v)
        {
            $unixDate = $v['sms_time'] + 5 * 60 * 60 * 24; //发送短信后五天重置发送状态
            if ($curTime > $unixDate)
            {
                db('contract')->where('contid',$v['contid'])->update(['sms' => 0]); //更新状态
            }
        }
    }
    //逾期房间自动计算
    public function  autoChange(){
        $nowDate = time();
        $contract   = db('contract')->select();
        $underlying = db('underlying')->select();
        foreach ($contract as $key=>$val){
            $data[$key] = $val;
            foreach ($underlying as $ky => $vl){
                if ($contract[$key]['underid'] == $underlying[$ky]['underid']){
                    $data[$key]['child'] = $vl;
                    continue;
                }
            }
        }
        foreach ($data as $dk => $dv){
            $newDate = date('Y-m-d',strtotime("+".$dv['pay']."month",$dv['child']['overdue_time']));
            $date = strtotime($newDate);
            if ($nowDate > $date){
                db('underlying')->where('underid',$dv['underid'])->update(['status'=>'2','overdue_time'=>$nowDate]);
            }
        }
    }
    //验证码短信获取接口
    public function vercode(Request $request)
    {
        if ($request->isPost())
        {
            $phone = input('post.phone');
            $muber = mt_rand(100000,999999);
            $user = db('user')->where('phone',$phone)->find();
            if ($user)
            {
                $url = "http://yun.movek.net:83/api/sms/send.json";
                $sms = [
                    'apikey'   => '4218ce5136404fe695b62f0c18b70130',
                    'tpl_id'   => '527',
                    'content'  => '您的验证码是'.$muber.'，如非本人操作请忽略本短信。【租房客】',
                    'mobile'   => $phone,
                ];
                db('vercode')->insert(['phone' => $phone ,'vercode' => $muber]);
                $common = new Common();
                $common->request_post($url,$sms); //调用短信接口
            }
        }
    }

    //验证码验证接口
    public function verification(Request $request)
    {
        //前端post传递
        if ($request->isPost())
        {
            $vercode = input('post.vercode');
            $rel = db('vercode')->where('vercode',$vercode)->find();
            if ($rel)
            {
                db('vercode')->where('smsid',$rel['smsid'])->delete();
                return json(['data'=>'','status'=>200,'msg'=>'']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'验证码错误!']);
        }
    }

    //合同删除通知接口
    public function notice(Request $request)
    {
        if ($request->isPost())
        {
            $contid = input('post.contid');
            $data = db('contract')->where('contid',$contid)->find();
            $phone = db('user')->where('uid',$data['uid'])->find()['phone'];
            $url = "http://yun.movek.net:83/api/sms/send.json";
            $sms = [
                'apikey'   => '4218ce5136404fe695b62f0c18b70130',
                'tpl_id'   => '528',
                'content'  => '尊敬的客户，您的合同已删除，如果您已经知晓就忽略本短信，如果您未知情，请立马找房东问清楚。【租房客】',
                'mobile'   => $phone,
            ];
            $common = new Common();
            $rel = $common->request_post($url,$sms); //调用短信接口
            $relArr = json_decode($rel,true);
            if ($relArr['code'] == 0) //结果判断
            {
                return json(['data'=>'','status'=>200,'msg'=>'已短信通知租客!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
        }
    }
}