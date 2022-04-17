<?php

namespace app\api\controller;
use think\Db;
use app\common\controller\Api;
use app\common\library\Email;
use app\common\library\Jialan;
use app\common\model\User;
use think\Config;
use app\api\library\Alipay;
use fast\Http;
use think\Exception;
@set_time_limit(0);
/**
 * 首页接口
 */
class Cron extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    
    
    //QQ监控
    public function index()
    {
        $list = Db::name('qrlist')->where('type','qqpay')->where('status',1)->select();
        if(empty($list))
        {
            exit('Crontab Success!');
        }
        foreach ($list as $row)
        {
            $pass_file = './cache/' . md5($row['id']) . '.tmp';
        	if (is_dir('./cache') == false) mkdir('./cache');
        	if (is_file($pass_file) == false) file_put_contents($pass_file, '');
            
            if($row['type']=='qqpay')
            {
                if(!empty($row['cookie']))
                {
                    preg_match('/uin\=o(.*?)\;/', base64_decode($row['cookie']), $uin);
                    $uin = $uin[1];
                    $preg = '/[0]*/';
                    $uin = preg_replace($preg, '', $uin, 1);
                }
                else
                {
                    $uin = null;
                }
                
            }
        	$thread_data[] = [
        		'id' => $row['id'],
        		'type' => $row['type'],
        		'cookie' => base64_decode($row['cookie']),
        		'url' => ($row['type'] == 'qqpay' ? 'https://myun.tenpay.com/cgi-bin/clientv1.0/qwallet_record_list.cgi?limit=15&offset=0&s_time=2019-04-20&ref_param=&source_type=7&time_type=0&bill_type=3&uin=' . $uin : 'https://mrchportalweb.alipay.com/user/asset/queryData?_ksTS=1564846095488_41&_input_charset=utf-8&ctoken=FQYMdJvdmydgpjeM'),
        	];
        }
        $thread = curl2($thread_data);
        if ($thread == false) exit('Crontab Success!');//为空直接结束
        $thread_count = count($thread);
        
        //发送数据总数
        $thread_data_count = count($thread_data);
        if ($thread_count != $thread_data_count) exit('{"code":-1,"message":"数据上报异常"}');
        for ($i = 0; $i < $thread_data_count; $i++) 
        {
            $id = $thread_data[$i]['id'];
            $type = $thread_data[$i]['type'];
            $row = Db::name('qrlist')->where('id',$id)->find();
            $qqres = $thread[$i];
            $arr = json_decode($qqres, true);
            if($arr['retcode'] != 0 && $arr['retmsg'] != 'OK')
            {
                $this->sendsms($row['user_id'],$id);
                Db::name('qrlist')->where('id', $id)->update(['status' => 0]);
            }
            else
            {
                if(!empty($arr['records'][0]))
                {
                    $param = $arr['records'][0];
                $money = $param['price'] / 100; //支付金额
                $checks = $param['price'] . '-' . $param['desc'] . '-' . $param['trans_id'];
                $pass_file = './cache/' . md5($id) . '.tmp';
                $last = file_get_contents($pass_file);
                preg_match('/uin\=o(.*?)\;/', base64_decode($row['cookie']), $uin);
                $uin = $uin[1];
                $preg = '/[0]*/';
                $uin = preg_replace($preg, '', $uin, 1);
                Db::name('qrlist')->where('id', $row['id'])->update(['qq' => $uin,'money'=>$money]);
                if($last=='')
                {
                    file_put_contents($pass_file, $checks);
                }
                else
                {
                        
                    if ($last != $checks)
                    {
                        file_put_contents($pass_file, $checks);
                        $orderrow = Db::name('order')->where('qr_id',$row['id'])->where('status',0)->where('money',$money)->where('out_time','>',time())->where('typedata',$type)->order('id desc')->find();
                            if($orderrow)
                            {
                                $u = Jialan::creat_callback($orderrow);
                                get_curl($u['notify']);
                            }
                        }
 
                    }
                }
                }
                
        }
        $this->success('请求成功');
    }
     
    function sendsms($receiver='',$id='')
    {
        $config = Config::get('site');
        $user = Db::name('user')->where('id',$receiver)->find();
        $qrlist = Db::name('qrlist')->where('id',$id)->find();
        if($qrlist['diaoxian_notity']==0)
        {
            $obj = \app\common\library\Email::instance();
            $result = $obj
                ->to($user['email'])
                ->subject(__("掉线通知邮件-", config('site.name')))
                ->message('<div style="min-height:550px; padding: 100px 55px 200px;">' . __('您有支付宝通道已掉线，请登录检查', config('site.name')) . '</div>')
                ->send();
            Db::name('qrlist')->where('id', $id)->update(['diaoxian_notity'=>1]);//改为已通知
        }
        
        return true; 
    }
    
    
    //支付宝监控
    public function alipay()
    {
        $list = Db::name('qrlist')->where('type','alipay')->where('code','alipay_mg')->where('status',1)->where('is_status',1)->select();
        if(empty($list))
        {
            exit('Crontab Success!');
        }
        $aliobj = new Alipay();
        foreach ($list as $row)
        {
            $cookie = base64_decode($row['cookie']);
            $beat = $aliobj->BaoHuo($cookie,$row['id']);
            if(empty($beat))
            {
                Db::name('qrlist')->where('id', $row['id'])->update(['status' => 0]);
                $this->sendsms($row['user_id'],$row['id']);
                continue;
            }
            $m = $aliobj->Get_Alipay_Money($row['cookie'],$beat);
            if(empty($m['result']['availableBalance']))
            {
                continue;
            }
            $old_money = $row['money'];
            $money = $m['result']['availableBalance'];
            if($row['money']!=$money)
            {
                Db::name('qrlist')->where('id', $row['id'])->update(['money' => $money,'updatetime'=>time()]);
            }
            if($old_money!=$money)
            {
                $order_count = Db::name('order')->where('qr_id',$row['id'])->where('typedata','alipay')->where('out_time','>',time())->count();
                if($order_count>0)
                {
                    $orders = $aliobj->getAliOrder($row['cookie'],$row['zfb_pid']);//获取订单请求
                    if($orders['status']==='deny')
                    {
                        Db::name('qrlist')->where('id', $row['id'])->update(['status' => 0]);
                        $this->sendsms($row['user_id'],$row['id']);
                        continue;//请求频繁或者掉线
                    }
                    $_orderlist=empty($orders['result']['detail'])?array():$orders['result']['detail'];
                    $_order=[];
                    $orderrow=null;
                    foreach ($_orderlist as $order)
                    {
                           $orderrow=null;
                           $pay_money=$order['tradeAmount'];//⾦额
                           $pay_des=$order['transMemo'];//备注
                           $tradeNo=$order['tradeNo'];//⽀付宝订单号
                           if(!empty($pay_des))
                           {
                                $orderrow = Db::name('order')->where('out_trade_no',$pay_des)->where('status',0)->where('qr_id',$row['id'])->where('truemoney',sprintf("%.2f",$pay_money))->where('typedata','alipay')->where('out_time','>',time())->order('id desc')->find();
                                if(!empty($orderrow))
                                {
                                    $u = Jialan::creat_callback($orderrow);
                                    get_curl($u['notify']);
                                }
                            }
                       }
                }
            }
        }
        $this->success('请求成功');
    }
    //个人支付宝监控
    public function alipay_gr()
    {
        $list = Db::name('qrlist')->where('type','alipay')->where('code','alipay_grmg')->where('status',1)->where('is_status',1)->select();
        if(empty($list))
        {
            exit('Crontab Success!');
        }
        $aliobj = new Alipay();
        foreach ($list as $row)
        {
            $cookie = base64_decode($row['cookie']);
            $res = $aliobj->Get_Alipay_Cookie($cookie);
            $info = json_decode($res,true);
            
            if(empty($info))
            {
                Db::name('qrlist')->where('id', $row['id'])->update(['status' => 0]);
                //掉线通知邮件
                $this->sendsms($row['user_id'],$row['id']);
                continue;
            }
            //不为空获取PID
            $old_money = $row['money'];
            $pid = $info['data']['userinfo']['userId'];//账户的PID
            $money = $info['data']['rpc']['assets']['data']['amountSummary']['totalAvailableBalance'];//当前余额
            //检查余额是否变动，如果余额变动更新数据
            if($row['money']!=$money || $row['zfb_pid']!=$pid)
            {
                Db::name('qrlist')->where('id', $row['id'])->update(['money' => $money,'zfb_pid'=>$pid,'updatetime'=>time()]);
            }
             
            if($old_money!=$money)
            {
                $od_money = $money - $old_money;
                $order_count = Db::name('order')->where('qr_id',$row['id'])->where('typedata','alipay')->where('out_time','>',time())->count();
                if($order_count>0)
                {
                   $orderrow = Db::name('order')->where('status',0)->where('qr_id',$row['id'])->where('truemoney',sprintf("%.2f",$od_money))->where('typedata','alipay')->where('out_time','>',time())->order('id desc')->find();
                    if(!empty($orderrow))
                    {
                        $u = Jialan::creat_callback($orderrow);
                        get_curl($u['notify']);
                    }
                }
            }
            
        }
        $this->success('请求成功');
    }
    
}
