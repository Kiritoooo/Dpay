<?php

namespace app\api\controller;
use think\Db;
use app\common\controller\Api;
use think\Config;
use app\common\model\User;
use app\common\library\Jialan;
/**
 * 首页接口
 */
class Yuanapi extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
    
    /**
     * APP通讯密钥验证
     */
    public function auth($apiid='',$apikey='')
    {
        if(empty($apikey))
        {
            $this->error("密钥不可为空");
        }
        if(empty($apiid))
        {
            $this->error("商户编号为空");
        }
        $userrow = Db::name('user')->where('id',$apiid)->where('user_key',$apikey)->find();
        $res['wxpay_open'] = 1;
        if(!empty($userrow))
        {
            $this->success('验证通过',$res);
        }
        else
        {
            $this->error("验证失败!");
        }
    }

    /**
     * 微信收款通知
     */
    public function notity($apiid='',$apikey='',$money='',$type='')
    {
        if(empty($apikey))
        {
            $this->error("密钥不可为空");
        }
        if(empty($apiid))
        {
            $this->error("商户编号为空");
        }
        if(empty($money))
        {
            $this->error("金额为空");
        }
        if(empty($type))
        {
            $this->error("支付类型不可为空");
        }
        $userrow = Db::name('user')->where('id',$apiid)->where('user_key',$apikey)->find();
        if(empty($userrow))
        {
            $this->error("用户不存在");
        }
        $orderrow = Db::name('order')->where('user_id',$userrow['id'])->where('status',0)->where('typedata',$type)->where('truemoney',$money)->where('out_time','>',time())->order('id desc')->find();
        if(empty($orderrow))
        {
            $this->error("未查询到有订单");
        }
        $u = Jialan::creat_callback($orderrow);
        get_curl($u['notify']);
        $this->success('请求成功');
    }
    
    public function order($pid='',$key='',$out_trade_no='')
    {
        if(!$pid || !$key || !$out_trade_no )
        {
            $this->error("参数不可为空");
        }
        $userrow = Db::name('user')->where('id',$pid)->where('user_key',$key)->find();
        if(empty($userrow))
        {
            $this->error("用户不存在");
        }
        $orderrow = Db::name('order')->where('user_id',$pid)->where('out_trade_no',$out_trade_no)->field('trade_no,out_trade_no,typedata,user_id,createtime,status,end_time,name,money,truemoney')->find();
        if(empty($orderrow))
        {
            $this->error("订单不存在");
        }
        $this->success('请求成功',$orderrow);
    }
    
    
}
