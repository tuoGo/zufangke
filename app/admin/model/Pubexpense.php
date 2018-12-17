<?php
/**
 * Created by PhpStorm.
 * User: linchuantuo
 * Date: 2018/12/14
 * Time: 11:32
 */

namespace app\admin\model;


class Pubexpense
{
    //默认时间格式为int类型
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $readonly = ['create_time'];
}