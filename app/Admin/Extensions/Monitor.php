<?php

namespace App\Admin\Extensions;

use GuzzleHttp\Client;

class Monitor
{
    const URL = 'http://192.168.1.73/api_jsonrpc.php';

    public static function user_auth()
    {
        $http = new Client(['headers' => ['Content-Type' => 'application/json-rpc']]);

        // 构建请求参数
        $query = [
            "jsonrpc"     =>  '2.0',
            "method"  => "user.login",
            "params" => [
                'user'=>'Admin',
                'password'=>'zabbix'
            ],
            "id"  => 1
        ];
        $response = $http->request('POST',self::URL,['body'=>json_encode($query)]);

        $result = json_decode($response->getBody()->getContents());
        return $result->result;
    }

    public  static function item($method,$params)
    {
        $http = new Client(['headers' => ['Content-Type' => 'application/json-rpc']]);

        // 构建请求参数
        $query = [
            "jsonrpc"     =>  '2.0',
            "method"  => $method,
            "params" => $params,
            "auth"=>'5cf94d741a7169e84c4ef6980c6663dc',
            "id"  => 1
        ];
        $response = $http->request('POST',self::URL,['body'=>json_encode($query)]);

        $result = json_decode($response->getBody()->getContents());


        return $result;

    }


}