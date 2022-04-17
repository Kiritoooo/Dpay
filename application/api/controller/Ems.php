<?php

namespace app\api\controller;
use think\Config;
use app\common\controller\Api;
use app\common\library\Ems as Emslib;
use app\common\model\User;

/**
 * 邮箱验证码接口
 */
class Ems extends Api
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
        $request = \think\Request::instance();
        \think\Hook::add('ems_send', function ($params) {
            $obj = \app\common\library\Email::instance();
            $result = $obj
                ->to($params->email)
                ->subject('平台验证码')
                ->message('
                <table width="700" border="0" align="center" cellspacing="0" style="width:700px;">
                <tbody>
                <tr>
                    <td>
                        <div style="width:700px;margin:0 auto;margin-bottom:30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="700" height="39" style="font:12px Tahoma, Arial, 宋体;">
                                <tbody><tr><td width="210"></td></tr></tbody>
                            </table>
                        </div>
                        <div style="width:680px;padding:0 10px;margin:0 auto;">
                            <div style="line-height:1.5;font-size:14px;margin-bottom:25px;color:#4d4d4d;">
                                <strong style="display:block;margin-bottom:15px;">尊敬的用户：<span style="color:#f60;font-size: 16px;"></span>您好！</strong>
                                <strong style="display:block;margin-bottom:15px;">
                                    您的验证码是：<span style="color:#f60;font-size: 24px">'."$params->code".'</span>，输入验证码以完成操作。
                                </strong>
                            </div>
                            <div style="margin-bottom:30px;">
                                <small style="display:block;margin-bottom:20px;font-size:12px;">
                                    <p style="color:#747474;">
                                        注意：此操作可能会修改您的密码、登录邮箱或绑定手机。如非本人操作，请及时登录并修改密码以保证帐户安全
                                        <br>（工作人员不会向你索取此验证码，请勿泄漏！)
                                    </p>
                                </small>
                            </div>
                        </div>
                        <div style="width:700px;margin:0 auto;">
                            <div style="padding:10px 10px 0;border-top:1px solid #ccc;color:#747474;margin-bottom:20px;line-height:1.3em;font-size:12px;">
                                <p>此为系统邮件，请勿回复<br>
                                    请保管好您的邮箱，避免账号被他人盗用
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            </body>
            ')->send();
            return $result;
        });
    }

    /**
     * 发送验证码
     *
     * @ApiMethod (POST)
     * @param string $email 邮箱
     * @param string $event 事件名称
     */
    public function send()
    {
        $email = $this->request->post("email");
        $event = $this->request->post("event");
        $event = $event ? $event : 'register';

        $last = Emslib::get($email, $event);
        if ($last && time() - $last['createtime'] < 5) {
            $this->error(__('发送频繁,等60秒后重试！'));
        }
        if ($event) {
            $userinfo = User::getByEmail($email);
            if ($event == 'register' && $userinfo) {
                //已被注册
                $this->error(__('已被注册！'));
            } elseif (in_array($event, ['changeemail']) && $userinfo) {
                //被占用
                $this->error(__('已被占用！'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未注册
                $this->error(__('未注册！'));
            }
        }
        $ret = Emslib::send($email, null, $event);
        if ($ret) {
            $this->success(__('发送成功'));
        } else {
            $this->error(__('发送失败'));
        }
    }

    /**
     * 检测验证码
     *
     * @ApiMethod (POST)
     * @param string $email   邮箱
     * @param string $event   事件名称
     * @param string $captcha 验证码
     */
    public function check()
    {
        $email = $this->request->post("email");
        $event = $this->request->post("event");
        $event = $event ? $event : 'register';
        $captcha = $this->request->post("captcha");

        if ($event) {
            $userinfo = User::getByEmail($email);
            if ($event == 'register' && $userinfo) {
                //已被注册
                $this->error(__('已被注册'));
            } elseif (in_array($event, ['changeemail']) && $userinfo) {
                //被占用
                $this->error(__('已被占用'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未注册
                $this->error(__('未注册'));
            }
        }
        $ret = Emslib::check($email, $captcha, $event);
        if ($ret) {
            $this->success(__('成功'));
        } else {
            $this->error(__('验证码不正确'));
        }
    }
}
