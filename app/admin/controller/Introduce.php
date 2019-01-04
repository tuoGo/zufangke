<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 10:48
 */

namespace app\admin\controller;

use think\Controller;

class Introduce extends Base
{
    public function index()
    {
        $data = [
            'ip'           => GetHostByName($_SERVER['SERVER_NAME']),
            'php_version'  => PHP_VERSION,
            'zend_version' => Zend_Version(),
            'apache'       => $_SERVER ['SERVER_SOFTWARE'],
        ];

        return $this->fetch('admin/introduce', ['data' => $data]);
    }
}