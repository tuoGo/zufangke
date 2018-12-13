<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2018/12/13
 * Time: 13:40
 */

namespace app\admin\model;


use think\Model;

class Smslog extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $readonly = ['create_time'];
}