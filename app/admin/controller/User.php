<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 16:05
 */

namespace app\admin\controller;

use think\Controller;
use think\Exception;
use think\Request;
use think\Db;
use think\Session;

class User extends Base
{

    /*
     * 用户列表
     */
    public function index()
    {
//        $siteurl = 'https://www.zufangk.cn/login';
//        $userid = 10000;
//
//        $url = $siteurl.'?id='.$userid;
//
//        $img = $this->qrcode($url);
//        print_r($img);exit;
        return $this->fetch('index');
    }
    /*
     * 修改密码
     */
    public function psw(Request $request){
        if ($request->isPost()){
            $adid = Session::get('adid');
            $password = input('post.');
            $psw = db('admin')->where('adid',$adid)->find();
            if (md5($password['old']) == $psw['password']){
                if ($password['new'] != $password['repeat']){
                    if($password['new'] != $password['old']){
                        db('admin')->where('adid',$adid)->update(['password'=>md5($password['new'])]);
                        Session::clear();
                        return json(['data'=>'','status'=>200,'msg'=>'密码修改成功!']);
                    }
                    return json(['data'=>'','status'=>400,'msg'=>'新密码不可跟旧密码相同!']);
                }
                return json(['data'=>'','status'=>400,'msg'=>'两次密码输入不一致!']);
            }
            return json(['data'=>'','status'=>400,'msg'=>'密码错误!']);
        }
    }
    /*
     * 收款二维码上传
     */
    public function payImg(){
        $adid = Session::get('adid');
        // 获取表单上传文件
        $files = request()->file('image');
        if (empty($files)){
            return json(['data'=>'','status'=>400,'msg'=>'请上传收款码!']);
        }
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move('uploads' . DS . 'payimg');
            $path = DS . 'uploads' . DS . 'payimg'. DS .$info->getSaveName();
            $pathNow = str_replace('\\','/',$path);
            $imgData[] = $pathNow;
        }
        $update = db('admin')->where('adid',$adid)->update(['wechat_img'=>$imgData[0],'alipay_img'=>$imgData[1]]);
        if ($update){
            return json(['data'=>'','status'=>200,'msg'=>'上传成功!']);
        }
    }
    /*
     * 生成二维码
     * */
    function qrcode($url,$level=3,$size=4){
        vendor('phpqrcode.phpqrcode');
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        //生成二维码图片
        //echo $_SERVER['REQUEST_URI'];
        $object = new \QRcode();
        $date = date('Y-m-d');
        $path = "Uploads/qrcode/".$date.'/';
        if (!file_exists($path)) {
            mkdir ("$path", 0777, true);
        }
        $name = time().'_'.mt_rand();
        //生成的文件名
        $fileName = $path.$name.'.png';
        $res = $object->png($url, $fileName, $errorCorrectionLevel, $matrixPointSize, 2);
        return $fileName;
    }
    /*
     * 添加用户
     */
    public function add(Request $request)
    {
        //判断是否post
        if($request->isPost())
        {
            $userInfo = input('post.');
            $data = [
                'adid'   => $userInfo['adid'],
                'name'   => $userInfo['name'],
                'phone'  => $userInfo['phone'],
                'idcard' => $userInfo['idcard'],
            ];
            try{
                //搜索用户身份证是否已经存在
                $userRel = model('user')->where('idcard',$userInfo['idcard'])->select();
                if ($userRel){
                    return json(['data'=>'','status'=>400,'msg'=>'此用户已存在!']);
                }
                //数据库存储操作
                model('user')->allowField(true)->save($data);

                return json(['data'=>'','status'=>200,'msg'=>'用户添加成功!']);

            }catch (Exception $e){

                return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
            }

        }
    }
    /*
     * 编辑用户
     */
    public function edit(Request $request)
    {
        //判断是否post
        if ($request->isPost())
        {
            //接收主键uid
            $uid = input('post.uid');
            $userInfo = input('post.');
            $data = [
                'name'   => $userInfo['name'],
                'phone'  => $userInfo['phone'],
                'idcard' => $userInfo['idcard'],
            ];
            try{
                //数据库更新操作
                model('user')->allowField(true)->save($data,['uid' => $uid]);

                return json(['data'=>'','status'=>200,'msg'=>'用户编辑成功!']);

            }catch (Exception $e) {

                return json(['data' => '', 'status' => 400, 'msg' => '系统错误,请联系我们团队!']);

            }
        }
    }
    /*
     * 删除用户
     */
    public function del(Request $request)
    {
        if ($request->isPost())
        {
            //接收主键uid
            $uid = input('post.uid');
            try{
                //数据库删除操作
                $rel = model('user')->where('uid',$uid)->delete();
                if (empty($rel))
                {
                    return json(['data'=>'','status'=>400,'msg'=>'请不要重复删除!']);
                }
                return json(['data'=>'','status'=>200,'msg'=>'用户删除成功!']);

            }catch (Exception $e){

                return json(['data' => '', 'status' => 400, 'msg' => '系统错误,请联系我们团队!']);

            }
        }
    }
}