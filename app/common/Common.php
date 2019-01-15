<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/30
 * Time: 16:37
 */
namespace app\common;
class Common{

    private $address  = '127.0.0.1';
    private $port = 8083;
    public $_sockets;
    public function __construct($address = '', $port='')
    {
        if(!empty($address)){
            $this->address = $address;
        }
        if(!empty($port)) {
            $this->port = $port;
        }
    }


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


    public function service(){
        //获取tcp协议号码。
        $tcp = getprotobyname("tcp");
        $sock = socket_create(AF_INET, SOCK_STREAM, $tcp);
        socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
        if($sock < 0)
        {
            throw new Exception("failed to create socket: ".socket_strerror($sock)."\n");
        }
        socket_bind($sock, $this->address, $this->port);
        socket_listen($sock, $this->port);
        echo "listen on $this->address $this->port ... \n";
        $this->_sockets = $sock;
    }

    public function run(){
        $this->service();
        $clients[] = $this->_sockets;
        while (true){
            $changes = $clients;
            $write = NULL;
            $except = NULL;
            socket_select($changes,  $write,  $except, NULL);
            foreach ($changes as $key => $_sock){
                if($this->_sockets == $_sock){ //判断是不是新接入的socket
                    if(($newClient = socket_accept($_sock))  === false){
                        die('failed to accept socket: '.socket_strerror($_sock)."\n");
                    }
                    $line = trim(socket_read($newClient, 1024));
                    $this->handshaking($newClient, $line);
                    //获取client ip
                    socket_getpeername ($newClient, $ip);
                    $clients[$ip] = $newClient;
                    echo  "Client ip:{$ip}   \n";
                    echo "Client msg:{$line} \n";
                } else {
                    socket_recv($_sock, $buffer,  2048, 0);
                    $msg = $this->message($buffer);
                    //在这里业务代码
//                    echo "{$key} clinet msg:",$msg,"\n";
//                    fwrite(STDOUT, 'Please input a argument:');
//                    $response = trim(fgets(STDIN));
//                    $this->send($_sock, $response);
                    echo "{$key} response to Client:","\n";
                }
            }
        }
    }

    /**
     * 握手处理
     * @param $newClient socket
     * @return int  接收到的信息
     */
    public function handshaking($newClient, $line){

        $headers = array();
        $lines = preg_split("/\r\n/", $line);
        foreach($lines as $line)
        {
            $line = chop($line);
            if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
            {
                $headers[$matches[1]] = $matches[2];
            }
        }
        $secKey = $headers['Sec-WebSocket-Key'];
        $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $this->address\r\n" .
            "WebSocket-Location: ws://$this->address:$this->port/websocket/websocket\r\n".
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
        return socket_write($newClient, $upgrade, strlen($upgrade));
    }

    /**
     * 解析接收数据
     * @param $buffer
     * @return null|string
     */
    public function message($buffer){
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;
        if ($len === 126)  {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        } else if ($len === 127)  {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        } else  {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }
        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return $decoded;
    }

    /**
     * 发送数据
     * @param $newClinet 新接入的socket
     * @param $msg   要发送的数据
     * @return int|string
     */
    public function send($newClinet, $msg){
        $msg = $this->frame($msg);
        socket_write($newClinet, $msg, strlen($msg));
    }

    public function frame($s) {
        $a = str_split($s, 125);
        if (count($a) == 1) {
            return "\x81" . chr(strlen($a[0])) . $a[0];
        }
        $ns = "";
        foreach ($a as $o) {
            $ns .= "\x81" . chr(strlen($o)) . $o;
        }
        return $ns;
    }

    /**
     * 关闭socket
     */
    public function close(){
        return socket_close($this->_sockets);
    }

    function date_format($a){
        return date('Y-m-d H:i:s',$a);
    }

    function conversion($time){
        $day = ($time / 60 / 60 / 24);
        return $day;
    }


}