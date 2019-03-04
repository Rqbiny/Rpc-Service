<?php
/**
 * Created by PhpStorm.
 * User: renqingbin
 * Date: 2019/2/9
 * Time: 10:22 AM
 */
namespace App\Http\Controllers;

use App\Rpc\Thrift\Server;
use App\Rpc\Thrift\TestServiceProcessor;
use App\Tools\Rpc\Thrift\Socket;
use Illuminate\Http\Request;

class SocketController extends Controller
{
    /**
     * 启动 socket 连接
     */
    public function server(Socket $socket, Server $server)
    {
        // 创建thrift的处理对象
        $testServiceProcessor = new TestServiceProcessor($server);
        $processorConfig = [
            [
                'SendServicceProcessor' => [
                    'processor' => $testServiceProcessor,
                    'host' => 'api.rqbiny.com',
                    'port' => '9998'
                ],
            ],
            [
                'TestServiceProcessor' => [
                    'processor' => $testServiceProcessor,
                    'host' => 'api.rqbiny.com',
                    'port' => '9998'
                ],
            ],
        ];
        foreach ($processorConfig as $v){
            $socket->run($v);
        }

    }
}