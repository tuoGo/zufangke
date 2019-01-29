<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2019/1/3
 * Time: 11:01
 */

namespace app\admin\controller;


use think\Controller;
use think\File;

class Upload extends Controller
{
    public function index(){
        return $this->fetch('index');
    }
    public function picture(){
        // 获取表单上传文件
        $files = request()->file('image');
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move('uploads' . DS . 'infoimg');
            $path = DS . 'uploads' . DS . 'infoimg'. DS .$info->getSaveName();
            $pathNow = str_replace('\\','/',$path);
//            db('contract')->where()
//            if($info){
//                // 成功上传后 获取上传信息
//                // 输出 jpg
//                echo $info->getExtension();
//                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
//            }else{
//                // 上传失败获取错误信息
//                echo $file->getError();
//            }
        }
    }
}