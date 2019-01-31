<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2019/1/31
 * Time: 13:45
 */

namespace app\admin\model;


use think\Model;

class Underlying extends Model
{
    //默认时间格式为int类型
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $readonly = ['create_time'];
}