<?php
/**
 * Created by PhpStorm.
 * User: renqingbin
 * Date: 2019/2/9
 * Time: 11:05 AM
 */
namespace App\Rpc\Thrift;

use App\Rpc\Thrift\TestServiceIf;
use App\Rpc\Thrift\Response;

class Server implements TestServiceIf
{
    /**
     * 实现 socket 各个service 之间的转发
     * @param string $params
     * @return Response
     * @throws \Exception
     */
    public function invokeMethod($params)
    {
        // 转换字符串 json
        $input = json_decode($params, true);
        app('log')->info($input['serviceName'].'====='.$input['methodName'], $input['params']);
        // 自己可以实现转发的业务逻辑
//        app('log')->info(json_encode($input));
        $serviceName = $input['serviceName'];
        $methodName = $input['methodName'];
        $param = $input['params'];
        $result = app($serviceName)->$methodName($param);

        $response = new Response();
        if($result){
            $response->code = 200;
        }
        $response->code = 400;
        $response->msg = '';
        $response->data = json_encode($input);
        return $response;
    }
}