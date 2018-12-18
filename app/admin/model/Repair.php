<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2018/12/18
 * Time: 15:57
 */

namespace app\admin\model;


use think\Model;

class Repair extends Model
{
    //默认时间格式为int类型
    protected $autoWriteTimestamp = true;
    protected $readonly = ['create_time'];
}