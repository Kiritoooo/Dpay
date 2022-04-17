<?php

namespace addons\recharge\library;

use app\common\library\Auth;
use app\common\model\User;
use think\Exception;
use think\Config;
use think\Db;
require_once(dirname(dirname(__FILE__)) . "/EPaySDK/AlipaySubmit.php");
require_once(dirname(dirname(__FILE__)) . "/EPaySDK/AlipayNotify.php");
class Order
{
     public static function epaysettle($orderid,$trade_no=null, $payamount = null, $memo = '')
    {
        $order = db('recharge_order')->where(['orderid'=>$orderid])->find();
        if (!$order) {
            return false;
        }
        if ($order['status'] != 'expired') {
            db('recharge_order')->where('id',$order['id'])
            ->update(['updatetime' => time(),'status'=>'expired','orderid'=>$orderid]);
            // 更新会员余额
            User::money($order['amount'], $order['user_id'], '用户在线充值');
            return true;
        }else{
            return false;
        }
    }
    
    
    public static function epay_submit($money, $paytype = 'wxpay')
    {
        $auth = Auth::instance();
        $user_id = $auth->isLogin() ? $auth->id : 0;
        $orderid = date("Ymdhis") . sprintf("%08d", $user_id) . mt_rand(1000, 9999);
        $request = \think\Request::instance();
        if($paytype=="wechat"){$paytype="wxpay";}
        $notifyurl = $request->root(true) . '/index/recharge/yipay';
        $returnurl = $request->root(true) . '/index/recharge/return_yipay';
        $data = [
                'orderid'   => $orderid,
                'user_id'   => $user_id,
                'amount'    => $money,
                'createtime' => time(),
                'paytype'   => $paytype,
                'ip'        => $request->ip(),
                'useragent' => substr($request->server('HTTP_USER_AGENT'), 0, 255),
                'status'    => 'created'
            ];
        $order = \addons\recharge\model\Payorder::create($data);
        $config = Config::get('site');//获取支付配置
        $pay_config = \addons\recharge\library\Order::getpay($paytype);
        $payobj = new \AlipaySubmit($pay_config);
        $parameter = array(
                "pid" => $pay_config['partner'],
                "type" => $paytype,
                "notify_url" => $notifyurl,
                "return_url" => $returnurl,
                "out_trade_no" => $orderid,
                "name" => $config['name']."用户在线充值",
                "money"	=> $money,
                "sitename" => 'YuanPay',
            );
        return $payobj->buildRequestForm($parameter);
    }
    

	
	public static function getpay($type){
        $yuanpay = db('yuanpay')->where(['status'=>1])->find();
        $y_pay = json_decode($yuanpay['value'],true);
        $payInfo=null;
        $payInfo['partner'] =$y_pay['appid'];
        $payInfo['pkey'] = $y_pay['secret_key'];
        $payInfo['real_apiurl']=$y_pay['gateway_url'];
		$data = [
			"partner" => $payInfo['partner'],
        	"key" => $payInfo['pkey'],
        	"sign_type" => "MD5",
			"input_charset" => "utf-8",
			"transport" => "http://",
			"apiurl" => $payInfo['real_apiurl'],
        	"real_apiurl" => $payInfo['real_apiurl'],
		];
		return $data;
	}
    
    public static function pay_notify($type) {
        $pay_config = \addons\recharge\library\Order::getpay($type);
        $notifyobj = new \AlipayNotify($pay_config);
        $verify_result = $notifyobj->verifyNotify();
        if ($verify_result) {
           return true;
        } else {
           return false;
        }
    }
    
    public static function get_sign($data,$key) {
        $pay_config =[
			"partner" => $data['pid'],
        	"key" => $key,
        	"sign_type" => "MD5",
			"input_charset" => "utf-8",
			"transport" => "http://",
			"apiurl" => '',
        	"real_apiurl" => ''
		];
		unset($data['ytype']);
        $obj = new \AlipaySubmit($pay_config);
        $sign = $obj->buildRequestParaGetSign($data);
        return $sign;
    }
    
    
    public static function epay_test($money, $paytype = 'wxpay')
    {
        $auth = Auth::instance();
        $user_id = $auth->isLogin() ? $auth->id : 0;
        $orderid = date("Ymdhis") . sprintf("%08d", $user_id) . mt_rand(1000, 9999);
        $request = \think\Request::instance();
        if($paytype=="wechat"){$paytype="wxpay";}
        $notifyurl = $request->root(true) . '/index/recharge/yipay';
        $returnurl = $request->root(true) . '/index/index/return_yipay';
        $config = Config::get('site');//获取支付配置
        $pay_config = \addons\recharge\library\Order::getpay($paytype);
        $payobj = new \AlipaySubmit($pay_config);
        $parameter = array(
                "pid" => $pay_config['partner'],
                "type" => $paytype,
                "notify_url" => $notifyurl,
                "return_url" => $returnurl,
                "out_trade_no" => $orderid,
                "name" => $config['name']."用户在线充值",
                "money"	=> $money,
                "sitename" => 'YuanPay',
            );
        return $payobj->buildRequestForm($parameter);
    }
    
    public static function epay_console($params)
    {
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $request = \think\Request::instance();
        $pay_config = [
			"partner" => $user['id'],
        	"key" => $user['user_key'],
        	"sign_type" => "MD5",
			"input_charset" => "utf-8",
			"transport" => "http://",
			"apiurl" => $request->root(true).'/',
        	"real_apiurl" => $request->root(true).'/',
		];
		
        $payobj = new \AlipaySubmit($pay_config);
        $ytype = $params['ytype'];
        unset($params['ytype']);
        //$params['ytype'] ='';
        //var_dump($params);
		//exit();
        return $payobj->consolebuildRequestForm($params,$ytype);
    }
    
    
    
}
