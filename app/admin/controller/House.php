<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/3
 * Time: 11:18
 */
namespace app\admin\controller;
use app\common\Common;
use think\Controller;
use think\Request;
class House extends Controller
{
    public function index()
    {
        return $this->fetch('house/house_list');
    }

    /**
     * 编辑(添加或修改)
     */
    public function edit(Request $request){
        try{

            if($request->isPost()){//若为post则添加
                $result = input('post');
                $data = array(
                    'address'   => $result['address'],
                    'area'      => $result['area'],
                    'doormodel' => $result['doormodel'],
                    'status'    => $result['status']
                );
                if($result['id'] == null){
                    //添加
                    //$this->add($data);
                }else{
                    //修改
                    //$this->update($id,$data);
                }

            }else{//修改回显
                $id = input('get')['id'];
                //$this->select($id);
            }

        }catch (Exception $e){
            $this->error('编辑错误');
        }


    }
}