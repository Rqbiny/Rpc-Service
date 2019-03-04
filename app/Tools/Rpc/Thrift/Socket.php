<?php
/**
 * Created by PhpStorm.
 * User: renqingbin
 * Date: 2019/2/9
 * Time: 4:03 PM
 */

namespace App\Tools\Rpc\Thrift;

use Thrift\Exception\TException;
use Thrift\Factory\TBinaryProtocolFactory; // 二进制的数据序列化的门面
use Thrift\Factory\TCompactProtocolFactory; // 压缩后的二进制数据序列化的门面
use Thrift\Factory\TTransportFactory; // 传输方式的门面
use Thrift\Server\TServerSocket; // Socket
use Thrift\Server\TForkingServer; // 非阻塞式服务
use Thrift\Server\TSimpleServer; // 阻塞式服务
use Thrift\TMultiplexedProcessor; // 服务端口复用模式

class Socket
{
    // 序列化对象
    protected $tProtocol;

    // 传输方式
    protected $tTransport;

    // 端口复用
    protected $tTProcessor;

    /**
     * Socket constructor.
     * @param $processorConfig
     */
    public function __construct(
        TCompactProtocolFactory $compactProtocolFactory,
        TBinaryProtocolFactory $binaryProtocolFactory,
        TTransportFactory $transportFactory,
        TMultiplexedProcessor $multiplexedProcessor

    )
    {
        // 使用压缩二进制来序列化对象
        $this->tProtocol = $compactProtocolFactory;
        // 实例化传输方式
        $this->tTransport = $transportFactory;
        // 端口复用
        $this->tTProcessor = $multiplexedProcessor;
    }

    /**
     * 启动监听服务
     *
     * @var
     * [
     *      'processorName' => [
     *          'processor' => Processor,
     *          'host' => '127.0.0.1',
     *          'port' => '9988',
     *      ]
     * ]
     * @author renqingbin
     */
    public function run($processorConfig)
    {
        try {
            foreach ($processorConfig as $processorName => $processorInfo){
                app('log')->info($processorName);
                // 注册服务
                $this->tTProcessor->registerProcessor($processorName, $processorInfo['processor']);
                // 监听开始
                $transport = new TServerSocket($processorInfo['host'], $processorInfo['port']);
                // 使用非阻塞模式
                $server = new TForkingServer($this->tTProcessor, $transport, $this->tTransport, $this->tTransport, $this->tProtocol, $this->tProtocol);
                $server->serve();

            }
        } catch (TException $te) {
            app('log')->error('Socket运行错误', ['error' => $te->getMessage()]);
        }
    }
}