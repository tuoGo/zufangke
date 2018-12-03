<?php
namespace app\admin\controller;
use Think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch('index');
    }
}