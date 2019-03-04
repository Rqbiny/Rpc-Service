<?php
namespace App\Tools\SendMessage;

use Curder\LaravelAliyunSms\AliyunSms;

class SendMessage {

    public function send($arr)
    {
        $flag = isset($arr['flag'])?$arr['flag']:1;
        $phoneNumber = isset($arr['phone'])?$arr['phone']:'13462344968';
        $name = isset($arr['name'])?$arr['name']:'';
        $code = isset($arr['code'])?$arr['code']:'';
        $variable = [];
        // 默认模版
        $template = 'SMS_145670823';
        switch ($flag){
            // 注册短信验证
            case 1:
                $variable = [
                    'code' => $code
                ];
                $template = 'SMS_145670823';
                break;

            // 登录确认
            case 2:
                $variable = [
                    'code' => $code
                ];
                $template = 'SMS_145670825';
                break;

            // 修改密码
            case 3:
                $variable = [
                    'code' => $code
                ];
                $template = 'SMS_145670822';
                break;

            // 信息变更
            case 4:
                $variable = [
                    'code' => $code
                ];
                $template = 'SMS_145670821';
                break;
        }
//        $send = new AliyunSms();
//        $response = $send->send($phoneNumber, $template, $variable);
//        $message = $response->Message;
        $message = 'OK';
        if ($message == 'OK') {
            app('log')->info($phoneNumber.'发送成功');
            return true;// 成功
        } else {
            app('log')->error(date('Y-m-d H:i:s').':\''.$phoneNumber.'\'短信发送失败.失败原因是:'.$message);
            return false;// 失败
        }
    }
}
