<?php

namespace app\index\controller;

use addons\recharge\library\Order;
use addons\recharge\model\MoneyLog;
use app\common\controller\Frontend;
use think\Exception;
use think\Config;

/**
 * 充值
 */
class Recharge extends Frontend
{
    protected $layout = 'default';
    protected $noNeedLogin = ['pay', 'epay','yipay'];
    protected $noNeedRight = ['*'];

    /**
     * 充值余额
     * @return string
     */
    public function recharge()
    {
        $config = get_addon_config('recharge');
        $moneyList = [];
        foreach ($config['moneylist'] as $index => $item) {
            $moneyList[] = ['value' => $item, 'text' => $index, 'default' => $item === $config['defaultmoney']];
        }

        $paytypeList = [];
        foreach (explode(',', $config['paytypelist']) as $index => $item) {
            $paytypeList[] = ['value' => $item, 'image' => '/assets/addons/recharge/img/' . $item . '.png', 'default' => $item === $config['defaultpaytype']];
        }
        $this->view->assign('addonConfig', $config);
        $this->view->assign('moneyList', $moneyList);
        $this->view->assign('paytypeList', $paytypeList);
        $this->view->assign('title', __('Recharge'));
        return $this->view->fetch();
    }

    /**
     * 余额日志
     * @return string
     */
    public function moneylog()
    {
        $moneyloglist = MoneyLog::where(['user_id' => $this->auth->id])
            ->order('id desc')
            ->paginate(10);

        $this->view->assign('title', __('Balance log'));
        $this->view->assign('moneyloglist', $moneyloglist);
        return $this->view->fetch();
    }

    /**
     * 创建订单并发起支付请求
     * @throws \think\exception\DbException
     */
    public function submit()
    {
        $money = $this->request->request('money');
        $paytype = $this->request->request('paytype');
        if ($money <= 0) {
            $this->error('充值金额不正确');
        }
        $config = get_addon_config('recharge');
        if (isset($config['minmoney']) && $money < $config['minmoney']) {
            $this->error('充值金额不能低于' . $config['minmoney'] . '元');
        }
        //检查支付方式是否开启
        $yuanpay = db('yuanpay')->where(['status'=>1])->find();
        $y_pay = json_decode($yuanpay['value'],true);

        $config = Config::get('site');//获取支付配置
        try {
            if(empty($paytype) || $paytype=='wechat')
            {
                $paytype = 'wxpay';
            }
            if(empty($y_pay[$paytype]))
            {
                $this->error('该支付通道已关闭');
            }
            
            $response = Order::epay_submit($money, $paytype);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        return $response;
    }

    /**
     * 企业支付通知和回调
     * @throws \think\exception\DbException
     */
    public function epay()
    {
        $type = $this->request->param('type');
        $paytype = $this->request->param('paytype');
        if ($type == 'notify') {
            $pay = \addons\epay\library\Service::checkNotify($paytype);
            if (!$pay) {
                echo '签名错误';
                return;
            }
            $data = $pay->verify();
            try {
                $payamount = $paytype == 'alipay' ? $data['total_amount'] : $data['total_fee'] / 100;
                \addons\recharge\library\Order::settle($data['out_trade_no'], $payamount);
            } catch (Exception $e) {
            }
            echo $pay->success();
        } else {
            $pay = \addons\epay\library\Service::checkReturn($paytype);
            if (!$pay) {
                $this->error('签名错误');
            }
            //微信支付没有返回链接
            if ($pay === true) {
                $this->success("请返回网站查看支付状态!", "");
            }

            //你可以在这里定义你的提示信息,但切记不可在此编写逻辑
            $this->success("恭喜你！充值成功!", url("user/index"));
        }
        return;
    }
    
    /**
     * 易支付通知和回调
     */
    public function yipay()
    {
        $type = $this->request->param('type');
        $trade_no = $this->request->param('trade_no');
        $out_trade_no = $this->request->param('out_trade_no');
        $result = Order::pay_notify($type);
            if($result){
                $res = Order::epaysettle($out_trade_no,$trade_no);
                if($res){
                    echo "success";
                }else{
                    echo "fail";
                }
            }else{
                echo "fail";
            }
        return;
    }
    
    public function return_yipay()
    {
        $this->success("恭喜你！充值成功!", url("user/index"));
        return;
    }
    
    
    
}
