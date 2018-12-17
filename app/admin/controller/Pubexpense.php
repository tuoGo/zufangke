<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2018/12/11
 * Time: 16:41
 */

namespace app\admin\controller;

use think\Controller;

class Pubexpense extends Controller
{
    //显示报修信息给房东看
    public function index()
    {
        $data = db('repair')->select();
        print_r($data);
    }
    public function repair()
    {
        return 'repair';
    }
}