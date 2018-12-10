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
use think\Exception;
use think\Request;

class House extends Controller
{
    public function index()
    {
        return $this->fetch('house/house_list');
    }

    /**
     * 添加
     */
    public function add(Request $request){
        $result = input('post');
        $data = array(
            'address'   => '翻斗大街翻斗花园2号楼1001室',//$result['address']
            'area'      => '280.5',//$result['area']
            'doormodel' => '四室一厅二卫',//$result['doormodel']
            'status'    => '2',//$result['status']
        );

        try{
            //数据库存储操作
            model('house')->save($data);
            dump('成功');exit;
        }catch (Exception $e){
            return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
        }
    }

    /**
     * 编辑
     */
    public function edit(Request $request){
        if($request->isPost()){
            $result = input('post');//数据
            $hid = $result['hid'];//主键
            $data = array(
                'address'   => $result['address'],
                'area'      => $result['area'],
                'doormodel' => $result['doormodel'],
                'status'    => $result['status']
            );
            try{
                model('house')->allowField(true)->save($data,['hid' => $hid]);
                return json(['data'=>'','status'=>200,'msg'=>'用户编辑成功!']);
            }catch (Exception $e){
                return json(['data'=>'','status'=>400,'msg'=>'系统错误,请联系我们团队!']);
            }
        }else{

        }



    }
}