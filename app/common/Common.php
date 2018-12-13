<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/30
 * Time: 16:37
 */
namespace app\common;
class Common{
    public function index(){
        return 1;
    }
    /**
     * 模拟post进行url请求
     * @param string $url
     * @param array $post_data
     */
    function request_post($url = '', $post_data = array()) {
//        $arr = array(
//            'apiKey' => '4218ce5136404fe695b62f0c18b70130',
//            'tpl_Id' => '529',
//            'content'=> '尊敬的客户，你的房租就快到期了，如有续租请准备好租金今日即可交付。【租房客】',
//            'mobile' =>	'13175001592',
//        );
        $post_url = $url;
        //json也可以
        $data_string =  json_encode($post_data);
        //普通数组也行
        //$data_string = $arr;

        // echo $data_string;exit;
        //echo '<br>';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $post_url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string)
            )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
}