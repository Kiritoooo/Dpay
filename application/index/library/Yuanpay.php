<?php

namespace app\index\library;
use think\Db;
use fast\Http;
use app\common\library\Jialan;
use think\Exception;
/**
 * 支付公共类
 */
class Yuanpay
{
    /************支付宝本地免挂*************/
    public static function alipay_mg($trade_no,$QR_row,$params)
    {
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        $pay_qrcode =urlencode('alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money", "u": "'.$QR_row['zfb_pid'].'", "a": "'.$params['money'].'", "m": "'.$params['out_trade_no'].'"}');
        //组装H5地址
        $request = \think\Request::instance();
        $h5 = "alipays://platformapi/startapp?appId=20000067&appClearTop=false&startMultApp=YES&showTitleBar=YES&showToolBar=NO&showLoading=YES&pullRefresh=YES&url=".$request->root(true) . "/index/pay/zfbh5.html?out_trade_no=".$params['out_trade_no'];
        $ip = request()->ip();
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $params['money'],
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=>$pay_qrcode,
                'h5_qrurl'=>$h5,
                'yuantype'=>$params['ytype'],
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
    }
    /************支付宝个人本地免挂*************/
    public static function alipay_grmg($trade_no,$QR_row,$params)
    {
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $m_status = 0;
        $truemoney = $params['money'];
        while($m_status==0){
            $orderrow = Db::name('order')->where('qr_id',$QR_row['id'])->where('status',0)->where('typedata',$params['type'])->where('truemoney',$truemoney)->where('out_time','>',time())->order('id desc')->find();
            if(empty($orderrow))
            {
               $m_status = 1;
            }
            else
            {
               $truemoney = $truemoney+ 0.01;
            }
        }
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        $pay_qrcode =urlencode('alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money", "u": "'.$QR_row['zfb_pid'].'", "a": "'.$truemoney.'", "m": "'.$params['out_trade_no'].'"}');
        //组装H5地址
        $request = \think\Request::instance();
        $h5 = "alipays://platformapi/startapp?appId=20000067&appClearTop=false&startMultApp=YES&showTitleBar=YES&showToolBar=NO&showLoading=YES&pullRefresh=YES&url=".$request->root(true) . "/index/pay/zfbh5.html?out_trade_no=".$params['out_trade_no'];
        $ip = request()->ip();
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $truemoney,
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=>$pay_qrcode,
                'h5_qrurl'=>$h5,
                'yuantype'=>$params['ytype'],
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
    }
    
    /************支付宝APP监控*************/
    public static function alipay_app($trade_no,$QR_row,$params)
    {
        $ip = request()->ip();
        $m_status = 0;
        $truemoney = $params['money'];
        while($m_status==0){
            $orderrow = Db::name('order')->where('qr_id',$QR_row['id'])->where('status',0)->where('typedata',$params['type'])->where('truemoney',$truemoney)->where('out_time','>',time())->order('id desc')->find();
            if(empty($orderrow))
            {
               $m_status = 1;
            }
            else
            {
               $truemoney = $truemoney+ 0.01;
            }
        }
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        //计算成功并将订单记录存入数据库
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $truemoney,
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=>$QR_row['qr_url'],
                'yuantype'=>$params['ytype'],
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
    }
    /************支付宝PC监控*************/
    public static function alipay_cloud($trade_no,$QR_row,$params)
    {
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        $ip = request()->ip();
        $pay_qrcode =urlencode('alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money", "u": "'.$QR_row['zfb_pid'].'", "a": "'.$params['money'].'", "m": "'.$params['out_trade_no'].'"}');
        //组装H5地址
        $request = \think\Request::instance();
        $h5 = "alipays://platformapi/startapp?appId=20000067&appClearTop=false&startMultApp=YES&showTitleBar=YES&showToolBar=NO&showLoading=YES&pullRefresh=YES&url=".$request->root(true) . "/index/pay/zfbh5.html?out_trade_no=".$params['out_trade_no'];
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $params['money'],
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=>$pay_qrcode,
                'h5_qrurl'=>$h5,
                'yuantype'=>$params['ytype'],
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
    }
    /************微信店员免挂*************/
    public static function wxpay_dy($trade_no,$QR_row,$params)
    {
        $ip = request()->ip();
        $m_status = 0;
        $truemoney = $params['money'];
        while($m_status==0){
            $orderrow = Db::name('order')->where('qr_id',$QR_row['id'])->where('status',0)->where('typedata',$params['type'])->where('truemoney',$truemoney)->where('out_time','>',time())->order('id desc')->find();
            if(empty($orderrow))
            {
               $m_status = 1;
            }
            else
            {
               $truemoney = $truemoney+ 0.01;
            }
        }
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        //计算成功并将订单记录存入数据库
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $truemoney,
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=>$QR_row['qr_url'],
                'yuantype'=>$params['ytype'],
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
    }
    /************微信云端免挂*************/
    public static function wxpay_cloud($trade_no,$QR_row,$params)
    {
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        $ip = request()->ip();
        $params['money'] = sprintf("%.2f",$params['money']);
        $wx_fen = intval(strval( $params['money']*100 ));
        try {
           $res = Jialan::WXTransferSet($QR_row['cookie'],$wx_fen,$params['out_trade_no']);
           $wx_url = $res->data->pay_url;
           
        }catch (\Exception $e){
           $wx_url = "微信状态异常";  
        }
        $wxres = "weixin://";
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $params['money'],
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=>$wx_url,
                'yuantype'=>$params['ytype'],
                'h5_qrurl'=>$wxres,
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
        
        
    }
    /************微信APP监控*************/
    public static function wxpay_app($trade_no,$QR_row,$params)
    {
        $ip = request()->ip();
        $m_status = 0;
        $truemoney = $params['money'];
        while($m_status==0){
            $orderrow = Db::name('order')->where('qr_id',$QR_row['id'])->where('status',0)->where('typedata',$params['type'])->where('truemoney',$truemoney)->where('out_time','>',time())->order('id desc')->find();
            if(empty($orderrow))
            {
               $m_status = 1;
            }
            else
            {
               $truemoney = $truemoney+ 0.01;
            }
        }
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        //计算成功并将订单记录存入数据库
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $truemoney,
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=>$QR_row['qr_url'],
                'yuantype'=>$params['ytype'],
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
    }
    /************QQ免挂*************/
    public static function qqpay_mg($trade_no,$QR_row,$params)
    {
        $ip = request()->ip();
        $m_status = 0;
        $truemoney = $params['money'];
        while($m_status==0){
            $orderrow = Db::name('order')->where('qr_id',$QR_row['id'])->where('status',0)->where('typedata',$params['type'])->where('truemoney',$truemoney)->where('out_time','>',time())->order('id desc')->find();
            if(empty($orderrow))
            {
               $m_status = 1;
            }
            else
            {
               $truemoney = $truemoney+ 0.01;
            }
        }
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $outtime=$user['order_out_time']?$user['order_out_time']:180;//订单过期时间设定
        $out_time=time()+($outtime>180?$outtime:180);
        //计算成功并将订单记录存入数据库
        $data = [
                'trade_no' =>$trade_no, 
                'out_trade_no' => $params['out_trade_no'],
                'notify_url' => $params['notify_url'],
                'return_url' => $params['return_url'],
                'typedata' => $params['type'],
                'user_id' => $params['pid'],
                'name' => $params['name'],
                'money' => $params['money'],
                'truemoney' => $truemoney,
                'qr_id' =>$QR_row['id'],
                'ip' => $ip,
                'createtime' => time(),
                'out_time' => $out_time,
                'status' => 0,
                'sitename' => $params['sitename'],
                'qrcode'=> urlencode($QR_row['qr_url']),
                'yuantype'=>$params['ytype'],
            ];
        $res = Db::name('order')->insert($data);
        Db::name('qrlist')->where('id', $QR_row['id'])->setInc('num');
        return $res;
    }
    
    
}
