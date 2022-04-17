<?php

namespace app\api\controller;
use think\Db;
use app\common\controller\Api;
use think\Config;
use app\common\model\User;
use app\common\library\Jialan;
use fast\Http;
use think\Exception;
/**
 * 微信店员监控接口
 */
class Wechat extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
    
    /**
     * 云端微信监控收款情况
     */
    public function index()
    {
        //1.查询所有通道三的微信记录
        $list = Db::name('qrlist')->where('type','wxpay')->where('status',1)->where('code','wxpay_cloud')->select();
        if(empty($list))
        {
            exit('Crontab Success!');
        }
        //2.遍历
        foreach ($list as $row)
        {
            $order_count = Db::name('order')->where('qr_id',$row['id'])->where('typedata','wxpay')->where('out_time','>',time())->count();
            if($order_count>0)
            {
                //检查是否存在未支付的订单，不存在跳出循环
                $res = Jialan::SuccessOrder($row['cookie']);
                if($res->code==-1)//微信掉线发送邮件
                {
                    Db::name('qrlist')->where('id', $row['id'])->update(['status' => 0]);
                    $user = Db::name('user')->where('id',$row['user_id'])->find();
                    $obj = \app\common\library\Email::instance();
                    $result = $obj
                        ->to($user['email'])
                        ->subject(__("掉线通知邮件-", config('site.name')))
                        ->message('<div style="min-height:550px; padding: 100px 55px 200px;">' . __('您有微信已掉线，请登录检查', config('site.name')) . '</div>')
                        ->send();
                }
                if(!empty($res->data) && $res->code==1)
                {
                    foreach ($res->data as $item)
                    {
                        //根据订单号和金额查询未支付的订单
                        $orderrow = Db::name('order')->where('out_trade_no',$item->trade_no)->where('status',0)->where('typedata','wxpay')->where('money',$item->money)->find();
                        if(!empty($orderrow))
                        {
                            $u = Jialan::creat_callback($orderrow);
                            get_curl($u['notify']);
                        }
                    }
                }
                
                Db::name('qrlist')->where('id', $row['id'])->update(['updatetime' => time()]);
            }
            else
            {
                //没有订单检查状态
                if($row['updatetime']+120<time())
                {
                    //检查状态
                    try 
                    {
                        $res = Jialan::checkStatus($row['cookie']);
                        if($res->code==1)
                        {
                            Db::name('qrlist')->where('id', $row['id'])->update(['updatetime' => time()]);
                        }
                        else
                        {
                            Db::name('qrlist')->where('id', $row['id'])->update(['updatetime' => time(),'status'=>0]);
                        }
                    }catch (\Exception $e){
                        Db::name('qrlist')->where('id', $row['id'])->update(['updatetime' => time()]);
                    }
                }
                
            }
        }
        exit('Crontab Success!');
    }
    
    
    
    /**
     * 软件通讯密钥验证
     */
    public function auth($apikey='')
    {
        $config = Config::get('site');
        if(empty($apikey))
        {
            $this->error("通讯密钥不可为空");
        }
        if(empty($config['cloud_key']))
        {
            $this->error("还未设置通讯密钥");
        }
        if($apikey==$config['cloud_key'])
        {
            $this->success('验证通过');
        }
        else
        {
            $this->error("通讯密钥错误!");
        }
    }

    /**
     * 微信收款通知
     */
    public function notity($apikey='',$money='',$wxname='')
    {
        $config = Config::get('site');
        if(empty($apikey))
        {
            $this->success("通讯密钥不可为空");
        }
        if(empty($config['cloud_key']))
        {
            $this->success("还未设置通讯密钥");
        }
        if($apikey!=$config['cloud_key'])
        {
            $this->success('密钥错误,请检查');
        }
        if(empty($money))
        {
            $this->success('金额参数不可为空');
        }
        if(empty($wxname))
        {
            $this->success('店员名称参数不可为空');
        }
        //查询此店员名称,如果不在线则修改状态为在线
        $qrmodel = Db::name('qrlist')->where('wx_name', $wxname)->find();
        if($qrmodel['status']==0)
        {
            Db::name('qrlist')->where('wx_name', $wxname)->update(['status' => 1]);
        }
        $orderrow = Db::name('order')->where('qr_id',$qrmodel['id'])->where('status',0)->where('typedata','wxpay')->where('truemoney',$money)->where('out_time','>',time())->order('id desc')->find();
        if(empty($orderrow))
        {
            $this->success('店员名称：'.$wxname.' 金额：'.$money.' 未查询到平台有订单');
        }
        //检测完毕
        $u = Jialan::creat_callback($orderrow);
        get_curl($u['notify']);
        $this->success('请求成功');
    }
    
    
    
    
}
