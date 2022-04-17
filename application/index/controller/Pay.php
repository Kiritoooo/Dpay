<?php
//date_default_timezone_set('PRC');
namespace app\index\controller;
use think\Db;
use app\common\controller\Frontend;
use think\Config;
use think\Request;
use fast\Http;
use app\common\library\Jialan;
use app\index\library\Yuanpay;

class Pay extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';
    
    //发起支付
    public function submit()
    {
        $params = $this->request->param();
        if(empty($params['pid'])){
            $this->view->assign('notity',"PID为空");
            return $this->view->fetch();
        }
        if(empty($params['type'])){
            $this->view->assign('notity',"支付类型不可为空");
            return $this->view->fetch();
        }
        if(empty($params['out_trade_no'])){
            $this->view->assign('notity',"订单号为空");
            return $this->view->fetch();
        }
        if(empty($params['notify_url'])){
            $this->view->assign('notity',"异步通知URL为空");
            return $this->view->fetch();
        }
        if(empty($params['return_url'])){
            $this->view->assign('notity',"同步通知URL为空");
            return $this->view->fetch();
        }
        if(empty($params['name'])){
            $this->view->assign('notity',"商品名称为空");
            return $this->view->fetch();
        }
        if(empty($params['money'])){
            $this->view->assign('notity',"金额为空");
            return $this->view->fetch();
        }
        if(empty($params['sitename']))
        {
            $params['sitename'] = "";
        }
        if(empty($params['ytype']))
        {
            $params['ytype'] = $params['type'];
            //return json($params['ytype']);
        }
        //查询用户获得Key进行验签
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $sign = \addons\recharge\library\Order::get_sign($params,$user['user_key']);
        if($params['sign']!=$sign)
        {
            $this->view->assign('notity',"签名校验失败，请检测好PID/KEY后返回重试！");
            return $this->view->fetch();
        }
        
        $config = Config::get('site');
        //检查会员
        if($user[$params['type'].'_time']<time())
        {
            $this->view->assign('notity',"未开通会员或已过期");
            return $this->view->fetch();
        }
        $feilv = $user[$params['type'].'_feilv'];
        if($feilv>0)
        {
            $feilv=$feilv / 100 ;
            $kouchu_feilv = $feilv * $params['money'];
            if($kouchu_feilv>$user['money'])
            {
                $this->view->assign('notity',"余额不足,不足以扣除手续费");
                return $this->view->fetch();
            }
        }
        if($params['money']>0 && $params['money']>$config['pay_maxmoney'])
        {
            $this->view->assign('notity',"最大支付金额为：".$config['pay_maxmoney']);
            return $this->view->fetch();
        }
        if($params['money']>0 && $params['money']<$config['pay_minmoney'])
        {
            $this->view->assign('notity',"最小支付金额为：".$config['pay_minmoney']);
            return $this->view->fetch();
        }
        if($params['money']<=0 || !is_numeric($params['money']))
        {
            $this->view->assign('notity',"金额不合法");
            return $this->view->fetch();
        }
        //判断订单号
        if(!preg_match('/^[a-zA-Z0-9.\_\-]+$/',$params['out_trade_no']))
        {
            $this->view->assign('notity',"订单号格式不正确");
            return $this->view->fetch();
        }
        if(!empty($config['blockname']))
        {
            $weigui = explode('|',$config['blockname']);
            //检查是否包含违规
            for($index=0;$index<count($weigui);$index++)
            {
                if(strpos($params['name'],$weigui[$index]) !== false)
                {
                    //存入数据库
                    $data = [
                        'user_id' =>$params['pid'], 
                        'contenttext' =>$params['name'],
                        'createtime' => time(),
                        'urltext'=>$_SERVER['HTTP_REFERER']
                    ];
                    Db::name('risk')->insert($data);
                    $this->view->assign('notity',"商品违规,已记录");
                    return $this->view->fetch();
                }
            }
        }
        $odcount = Db::name('order')->where('out_trade_no',$params['out_trade_no'])->count();
        if($odcount>0)
        {
            $this->view->assign('notity',"本地订单号错误,请重新发起支付");
            return $this->view->fetch();
        }
        $trade_no='Y'.date("YmdHis").rand(11111,99999);
        $QR_row =  Db::name('qrlist')->where('type',$params['type'])->where('user_id',$user['id'])->where('status',1)->where('is_status',1)->orderRaw('rand()')->find();//随机获取通道
        if(empty($QR_row))
        {
            if($user['is_other']==0)
            {
                $this->view->assign('notity',"暂无收款账号在线");
                return $this->view->fetch();
            }
            else
            {
                $urlstr=http_build_query($params);
                $url="http://".$_SERVER['HTTP_HOST'].'/index/pay/ConsoleYuan.html?'.$urlstr;
                exit("<script>window.location.href='{$url}';</script>");
                
            }
        }
        $action = $QR_row['code'];
        $res = Yuanpay::$action($trade_no,$QR_row,$params);
        if($res)
        {
            exit("<script>window.location.href='/index/Pay/console.html?trade_no={$trade_no}&sitename={$params['sitename']}';</script>");
        }
        else
        {
            $this->view->assign('notity',"订单生成错误,请重新发起支付");
            return $this->view->fetch();
        }
    }
    
    //支付页面
    public function console($trade_no='')
    {
        $order_row = Db::name('order')->where('trade_no', $trade_no)->find();
        $ms = $order_row['out_time']-time();
        $user = Db::name('user')->where('id', $order_row['user_id'])->find();
        //根据订单查询微信h5链接
        $this->view->assign('tixing', $user['yuyin_notity']);
        $this->view->assign('order', $order_row);
        $this->view->assign('console_notity', $user['console_notity']);
        $this->view->assign('ms', $ms);
        return $this->view->fetch($user['pay_temp']);
    }
    
    public function ConsoleYuan()
    {
        $params = $this->request->param();
        $this->view->assign('od',$params);
        return $this->view->fetch();
    }
    
    
    public function zfbh5($out_trade_no)
    {
        $order_row = Db::name('order')->where('out_trade_no', $out_trade_no)->find();
        $qr = Db::name('qrlist')->where('id', $order_row['qr_id'])->find();
        $res['zfb_pid'] = $qr['zfb_pid'];
        $res['money']=$order_row['truemoney'];
        $res['remark'] = $order_row['out_trade_no'];
        $this->view->assign('od', $res);
        return $this->view->fetch();
    }
    
    //Ajax请求
    public function Ycode_Get($trade_no='')
    {
        if(empty($trade_no))
        {
            return json(['code'=>0,'msg'=>'订单号为空!']);
        }
        $order_row = Db::name('order')->where('trade_no', $trade_no)->find();
        if(empty($order_row))
        {
            return json(['code'=>0,'msg'=>'订单不存在!']);
        }
        if($order_row['status']==1)
        {
            $u = Jialan::creat_callback($order_row);
            return json(['code'=>200,'msg'=>'订单支付成功!','url'=>$u['return']]);
        }
        if($order_row['out_time']<time())
        {
            return json(['code'=>0,'msg'=>'订单超时!']);
        }
        $qr_row = Db::name('qrlist')->where('id', $order_row['qr_id'])->find();
        if(empty($qr_row))
        {
            return json(['code'=>0,'msg'=>'二维码不存在!']);
        }
        $order_row['qrcode'] ='/qr.php?text='.$order_row['qrcode'];
        return json(['code'=>100,'msg'=>'二维码获取成功!','qr_url'=>$order_row['qrcode']]);
    }
    
    
    public function api_submit()
    {
        $params = $this->request->param();
        if(empty($params['pid'])){
            return json(['code'=>0,'msg'=>'PID为空!']);
        }
        if(empty($params['type'])){
            return json(['code'=>0,'msg'=>'支付类型不可为空!']);
        }
        if(empty($params['out_trade_no'])){
            return json(['code'=>0,'msg'=>'订单号为空!']);
        }
        if(empty($params['notify_url'])){
            return json(['code'=>0,'msg'=>'异步通知URL为空!']);
        }
        if(empty($params['return_url'])){
            return json(['code'=>0,'msg'=>'同步通知URL为空!']);
        }
        if(empty($params['name'])){
            return json(['code'=>0,'msg'=>'商品名称为空!']);
        }
        if(empty($params['money'])){
            return json(['code'=>0,'msg'=>'金额为空!']);
        }
        if(empty($params['sitename']))
        {
            $params['sitename'] = "";
        }
        //查询用户获得Key进行验签
        $user = Db::name('user')->where('id',$params['pid'])->find();
        $sign = \addons\recharge\library\Order::get_sign($params,$user['user_key']);
        if($params['sign']!=$sign)
        {
            $this->view->assign('notity',"签名校验失败，请检测好PID/KEY后返回重试！");
            return $this->view->fetch();
        }
        $config = Config::get('site');
        //检查会员
        if($user[$params['type'].'_time']<time())
        {
            return json(['code'=>0,'msg'=>'未开通会员或已过期!']);
        }
        $feilv = $user[$params['type'].'_feilv'];
        if($feilv>0)
        {
            $feilv=$feilv / 100 ;
            $kouchu_feilv = $feilv * $params['money'];
            if($kouchu_feilv>$user['money'])
            {
                return json(['code'=>0,'msg'=>'余额不足,不足以扣除手续费!']);
            }
        }
        if($params['money']>0 && $params['money']>$config['pay_maxmoney'])
        {
            return json(['code'=>0,'msg'=>"最大支付金额为：".$config['pay_maxmoney']]);
        }
        if($params['money']>0 && $params['money']<$config['pay_minmoney'])
        {
            return json(['code'=>0,'msg'=>"最小支付金额为：".$config['pay_minmoney']]);
        }
        if($params['money']<=0 || !is_numeric($params['money']))
        {
            return json(['code'=>0,'msg'=>'金额不合法!']);
        }
        //判断订单号
        if(!preg_match('/^[a-zA-Z0-9.\_\-]+$/',$params['out_trade_no']))
        {
            return json(['code'=>0,'msg'=>'订单号格式不正确!']);
        }
        if(!empty($config['blockname']))
        {
            $weigui = explode('|',$config['blockname']);
            //检查是否包含违规
            for($index=0;$index<count($weigui);$index++)
            {
                if(strpos($params['name'],$weigui[$index]) !== false)
                {
                    //存入数据库
                    $data = [
                        'user_id' =>$params['pid'], 
                        'contenttext' =>$params['name'],
                        'createtime' => time(),
                        'urltext'=>$_SERVER['HTTP_REFERER']
                    ];
                    Db::name('risk')->insert($data);
                    return json(['code'=>0,'msg'=>'商品违规,已记录!']);
                }
            }
        }
        $odcount = Db::name('order')->where('out_trade_no',$params['out_trade_no'])->count();
        if($odcount>0)
        {
            return json(['code'=>0,'msg'=>'本地订单号错误,请重新发起支付!']);
        }
        $trade_no='Y'.date("YmdHis").rand(11111,99999);
        $QR_row =  Db::name('qrlist')->where('type',$params['type'])->where('user_id',$user['id'])->where('status',1)->where('is_status',1)->order('num asc')->find();//随机获取通道
        if(empty($QR_row))
        {
            return json(['code'=>0,'msg'=>'暂无收款账号在线!']);
        }
        $action = $QR_row['code'];
        $res = Yuanpay::$action($trade_no,$QR_row,$params);
        if($res)
        {
            $od = Db::name('order')->where('trade_no',$trade_no)->find();
            return json(['code'=>0,'msg'=>'操作成功!','data'=>$od]);
        }
        else
        {
            return json(['code'=>0,'msg'=>'订单生成错误,请重新发起支付!']);
        }
    }
    
    
    

}
