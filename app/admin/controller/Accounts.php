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

class Accounts extends Base
{

    /*
     * 用户列表
     */
    public function index()
    {
//        $data = Db::table('zfk_user')->select();
        return $this->fetch('index');
    }

}