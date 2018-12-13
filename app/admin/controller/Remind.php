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

class Remind extends Controller
{
    public function remindSms()
    {
        $data = db('contract')->where('sms',0)->where('status',1)->select();

        if ($data)
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
                    $sms = [
                        'apikey'   => '4218ce5136404fe695b62f0c18b70130',
                        'tpl_id'   => '529',
                        'content'  => '尊敬的客户，你的房租就快到期了，如有续租请准备好租金今日即可交付。【租房客】',
                        'mobile'   => $phone,
                    ];

                    $common = new Common();
                    $rel = $common->request_post($url,$sms); //调用短信接口
                    $relArr = json_decode($rel,true);
                    if ($relArr['code'] == 0) //结果判断
                    {
                        //更新短信发送状态
                        db('contract')->where('contid',$v['contid'])->update(['sms' => 1]);
                    }else{
                        //报错存储
                        model('smslog')->data(['uid' => $v['uid'] ,'phone' => $phone ,'msg' => $relArr['msg']])->save();
                    }
                }
            }
        }
    }
}