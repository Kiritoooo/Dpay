<?php

namespace app\common\library;
use app\common\library\Email;
use app\common\model\User;
use think\Config;
use think\Db;
use fast\Http;
use think\Exception;
/**
 * 支付公共类
 */
define('Host', 'http://改为你的');
class Jialan
{
    //支付异步同调方法
    public static function creat_callback($data)
    {
        $config = Config::get('site');
        $userrow = Db::name('user')->where('id',$data['user_id'])->find();
        $sign = MD5("money=".$data['money']."&name=".$data['name']."&out_trade_no=".$data['out_trade_no']."&pid=".$data['user_id']."&trade_no=".$data['trade_no']."&trade_status=TRADE_SUCCESS&type=".$data['yuantype'].$userrow['user_key']);
        $array=array('pid'=>$data['user_id'],'trade_no'=>$data['trade_no'],'out_trade_no'=>$data['out_trade_no'],'type'=>$data['yuantype'],'name'=>$data['name'],'money'=>$data['money'],'trade_status'=>'TRADE_SUCCESS');
        $urlstr=http_build_query($array);
        if($data['status']==0)
        {
            if(!empty($userrow[$data['yuantype'].'_feilv']))
            {
                $feilv = $userrow[$data['yuantype'].'_feilv'];
                if($feilv>0)
                {
                    //扣除用户额度
                    $feilv=$feilv / 100 ;
                    $kouchu_feilv = $feilv * $data['money'];
                    if($kouchu_feilv>0)
                    {
                        User::money("-".$kouchu_feilv, $userrow['id'], '扣除费率金额');
                    }
                    
                }
            }
            Db::name('order')->where('id', $data['id'])->update(['end_time' =>time(),'status'=>1]);
            //支付完成更改当前二维码过期时间为当前时间
            Db::name('qrlist')->where('id', $data['qr_id'])->update(['end_time' =>time()]);
            //检查余额判断是否额度不足提醒
            if($userrow['min_money_tx']>0)
            {
                if($userrow['money']<$userrow['min_money_tx'])
                {
                    try {
                        $obj = \app\common\library\Email::instance();
                        $result = $obj
                        ->to($user['email'])
                        ->subject(__("额度不足通知邮件"),'支付平台')
                        ->message('<div style="min-height:550px; padding: 100px 55px 200px;">' . __('您的余额不足,请及时登录平台充值', '支付平台') . '</div>')
                        ->send();
                    }catch (\Exception $e){
                        
                    }
                    
                }
            }
        }
        //更改订单状态,商户单号、结束时间
        if(strpos($data['notify_url'],'?'))
        {
            $url['notify']=$data['notify_url'].'&'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
        }
        else
        {
            $url['notify']=$data['notify_url'].'?'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
        }
        if(strpos($data['return_url'],'?'))
        {
            $url['return']=$data['return_url'].'&'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
        }
        else
        {
            $url['return']=$data['return_url'].'?'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
        }
		return $url;
        
        
    }
    
    //订单获取
    public static function SuccessOrder($guid)
    {
        $res = cloud_get_curl(Host.'/api/Payment/SuccessOrder', ["secretkey"=>(new Jialan)->getcloudkey(),'guid'=>$guid]);
        return $res;
    }
    
    //生成支付二维码
    public static function WXTransferSet($guid,$wx_fen,$trade_no)
    {
        $res = cloud_get_curl(Host.'/api/Payment/WXTransferSet', ["secretkey"=>(new Jialan)->getcloudkey(),'guid'=>$guid,'fee'=>$wx_fen,'description'=>$trade_no]);
        return $res;
    }
    
    //获取登录二维码
    public static function wxGetLoginQrcode($guid='')
    {
        $res = cloud_get_curl(Host.'/api/Cloud/wxGetLoginQrcode', ["secretkey"=>(new Jialan)->getcloudkey(),'guid'=>$guid]);
        return $res;
    }
    
    //验证登录
    public static function wxCheckLoginQrcode($guid,$uuid)
    {
        $res = cloud_get_curl(Host.'/api/Cloud/wxCheckLoginQrcode', ["secretkey"=>(new Jialan)->getcloudkey(),'guid'=>$guid,"uuid"=>$uuid]);
        return $res;
    }
    
    function getcloudkey()
    {
        $cloud = Db::name('admin')->where('id',1)->find();
        return $cloud['cloudkey'];
    }
    
    public static function checkStatus($guid)
    {
        $res = cloud_get_curl(Host.'/api/Cloud/checkStatus', ["secretkey"=>(new Jialan)->getcloudkey(),'guid'=>$guid]);
        return $res;
    }
    
}
