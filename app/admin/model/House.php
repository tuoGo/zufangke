<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 13:44
 */
namespace app\admin\model;
use think\Model;
class House extends Model
{
    //默认时间格式为int类型
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $readonly = ['create_time'];
}