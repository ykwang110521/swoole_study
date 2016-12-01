<?php
class Client
{
    private $client;

    public function __construct() {
        $this->client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->client->on('Connect', array($this, 'onConnect'));
        $this->client->on('Receive', array($this, 'onReceive'));
        $this->client->on('Close', array($this, 'onClose'));
        $this->client->on('Error', array($this, 'onError'));
    }

    public function connect() {
        if(!$fp = $this->client->connect("127.0.0.1", 9501 , 1)) {
            echo "Error: {$fp->errMsg}[{$fp->errCode}]\n";
            return;
        }
    }

    //connect之后,会调用onConnect方法
    public function onConnect($cli) {
        swoole_timer_tick(1000, function ($timer_id) {
            $msg = "输入消息：".rand(1,9999);
            $this->client->send($msg);
        });

//        fwrite(STDOUT, "Enter Msg:");
//        swoole_event_add(STDIN,function(){
//            //fwrite(STDOUT, "Enter Msg1:");
//            $msg = trim(fgets(STDIN));
//            $this->send($msg);
//        });
    }

    public function onClose($cli) {
        echo "Client close connection\n";
    }

    public function onError() {

    }

    public function onReceive($cli, $data) {
        echo "Received: ".$data."\n";
        //fwrite(STDOUT, "Enter Msg1:");
    }

    public function send($data) {
        $this->client->send($data);
    }

}

$client = new Client();
$client->connect();
