<?php

namespace addons\qcloudsms;

use addons\qcloudsms\library\SmsSingleSender;
use addons\qcloudsms\library\SmsVoicePromptSender;
use addons\qcloudsms\library\SmsVoiceverifyCodeSender;
use addons\qcloudsms\library\TtsVoiceSender;
use think\Addons;
use think\Config;

/**
 * 插件
 */
class Qcloudsms extends Addons
{
    private $appid = null;
    private $appkey = null;
    private $config = null;
    private $sender = null;
    private $sendError = '';

    public function ConfigInit()
    {
        $this->config = $this->getConfig();
        //如果使用语音短信  更换成语音短信模板
        if ($this->config['isVoice'] == 1) {
            $this->config['template'] = $this->config['voiceTemplate'];
            //语音短信 需要另行设置Aappid 与Appkey
            $this->appid = $this->config['voiceAppid'];
            $this->appkey = $this->config['voiceAppkey'];
        } else {
            $this->appid = $this->config['appid'];
            $this->appkey = $this->config['appkey'];
        }
    }

    /**
     * 短信发送行为
     * @param Sms $params
     * @return  boolean
     */
    public function smsSend(&$params)
    {
        $this->ConfigInit();
        try {
            if ($this->config['isTemplateSender'] == 1) {
                $templateID = $this->config['template'][$params->event];
                if ($this->config['isVoice'] != 1) {
                    //普通短信发送
                    $this->sender = new SmsSingleSender($this->appid, $this->appkey);
                    $result = $this->sender->sendWithParam("86", $params['mobile'], $templateID, ["{$params->code}"], $this->config['sign'], "", "");
                } else {
                    //语音短信发送
                    $this->sender = new TtsVoiceSender($this->appid, $this->appkey);
                    //参数： 国家码,手机号、模板ID、模板参数、播放次数(可选字段)、用户的session内容,服务器端原样返回(可选字段)
                    $result = $this->sender->send("86", $params['mobile'], $templateID, [$params->code]);
                }
            } else {
                //判断是否是语音短信
                if ($this->config['isVoice'] != 1) {
                    $this->sender = new SmsSingleSender($this->appid, $this->appkey);
                    //参数：短信类型{1营销短信，0普通短信 }、国家码、手机号、短信内容、扩展码（可留空）、服务的原样返回的参数
                    $result = $this->sender->send($params['type'], '86', $params['mobile'], $params['msg'], "", "");
                } else {
                    $this->sender = new SmsVoiceVerifyCodeSender($this->appid, $this->appkey);
                    //参数：国家码、手机号、短信内容、播放次数（默认2次）、服务的原样返回的参数
                    $result = $this->sender->send('86', $params['mobile'], $params['msg']);
                }
            }

            $rsp = json_decode($result, true);
            if ($rsp['result'] == 0 && $rsp['errmsg'] == 'OK') {
                return true;
            } else {
                //记录错误信息
                $this->setError($rsp);
                return false;
            }
        } catch (\Exception $e) {
            $this->setError($e->getMessage());
        }
        return false;
    }

    /**
     * 短信发送通知
     * @param array $params
     * @return  boolean
     */
    public function smsNotice(&$params)
    {
        $this->ConfigInit();
        try {
            if ($this->config['isTemplateSender'] == 1) {
                $templateID = $this->config['template'][$params['template']];

                if ($this->config['isVoice'] != 1) {
                    //普通短信发送
                    $this->sender = new SmsSingleSender($this->appid, $this->appkey);
                    $result = $this->sender->sendWithParam("86", $params['mobile'], $templateID, ["{$params['msg']}"], $this->config['sign'], "", "");
                } else {
                    //语音短信发送
                    $this->sender = new TtsVoiceSender($this->appid, $this->appkey);
                    //参数： 国家码,手机号、模板ID、模板参数、播放次数(可选字段)、用户的session内容,服务器端原样返回(可选字段)
                    $result = $this->sender->send("86", $params['mobile'], $templateID, [$params['msg']]);
                }
            } else {
                //判断是否是语音短信
                if ($this->config['isVoice'] != 1) {
                    $this->sender = new SmsSingleSender($this->appid, $this->appkey);
                    //参数：短信类型{1营销短信，0普通短信 }、国家码、手机号、短信内容、扩展码（可留空）、服务的原样返回的参数
                    $result = $this->sender->send($params['type'], '86', $params['mobile'], $params['msg'], "", "");
                } else {
                    $this->sender = new SmsVoicePromptSender($this->appid, $this->appkey);
                    //参数：国家码、手机号、语音类型（目前固定为2）、短信内容、播放次数（默认2次）、服务的原样返回的参数
                    $result = $this->sender->send('86', $params['mobile'], 2, $params['msg']);
                }
            }
            $rsp = (array)json_decode($result, true);
            if ($rsp['result'] == 0 && $rsp['errmsg'] == 'OK') {
                return true;
            } else {
                //记录错误信息
                $this->setError($rsp);
                return false;
            }
        } catch (\Exception $e) {
            var_dump($e);
            exit();
        }
    }

    /**
     * 记录失败信息
     * @param [type] $err [description]
     */
    private function setError($err)
    {
        $this->sendError = $err;
    }

    /**
     * 获取失败信息
     * @return [type] [description]
     */
    public function getError()
    {
        return $this->sendError;
    }

    /**
     * 检测验证是否正确
     * @param Sms $params
     * @return  boolean
     */
    public function smsCheck(&$params)
    {
        return true;
    }

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        return true;
    }
}
