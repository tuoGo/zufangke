<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2019/1/3
 * Time: 11:01
 */

namespace app\admin\controller;


use think\Controller;

class Upload extends Controller
{
    public function picture()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        //校验器，判断图片格式是否正确
        if (true !== $this->validate(['image' => $file], ['image' => 'require|image'])) {
            $this->error('请选择图像文件');
        } else {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息

                //存入相对路径/upload/日期/文件名
                $data = DS . 'uploads' . DS . $info->getSaveName();
                //模板变量赋值
                return json(['data' => $data, 'status' => 200, 'msg' => '']);
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}