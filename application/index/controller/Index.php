<?php

namespace app\index\controller;
use think\Config;
use addons\recharge\library\Order;
use app\common\controller\Frontend;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        $config = Config::get('site');
        $sitenav = $config['sitenav'];
        $this->view->assign('sitenav',$sitenav);
        return $this->view->fetch();
    }
    
    
    public function work()
    {
        return $this->view->fetch();
    }
    
    public function test()
    {
        $trade_no='Y'.date("YmdHis").rand(11111,99999);
        $this->view->assign('trade_no',$trade_no);
        return $this->view->fetch();
    }
    
    public function testpay($money,$typeid)
    {
        if($typeid==1)
        {
            $paytype = 'alipay';
        }
        else if($typeid==2){
            $paytype = 'wxpay';
        }
        else{
            $paytype = 'qqpay';
        }
        $response = Order::epay_test($money, $paytype);
        return $response;
    }
    
    public function return_yipay()
    {
        $this->success("恭喜你！测试成功!", url("index/index"));
        return;
    }
    
    //收银台重新发起付款
    public function consolepay()
    {
        $params = $this->request->param();
        if($params['typeid']==1)
        {
            $params['type'] = 'alipay';
        }
        else if($params['typeid']==2){
            $params['type'] = 'wxpay';
        }
        else{
            $params['type'] = 'qqpay';
        }
        unset($params['typeid']);
        //组装数据拉起支付
        $response = Order::epay_console($params);
        return $response;
    }
    
    

}
