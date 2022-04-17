<?php

namespace app\index\controller;
use app\common\controller\Frontend;
use think\Exception;
use think\Db;
use app\common\model\User;
use think\Config;
use app\common\library\Jialan;
/**
 * 通道
 */
class Order extends Frontend
{
    protected $layout = 'default';
    protected $noNeedLogin = [''];
    protected $noNeedRight = ['*'];
    
    public function index($keywords='')
    {
        if(empty($keywords))
        {
            $list = Db::name('order')->where('user_id',$this->auth->id)->order('id desc')->paginate(10);
        }
        else
        {
            $list = Db::name('order')->whereOr('trade_no',$keywords)->whereOr('out_trade_no',$keywords)->where('user_id',$this->auth->id)->order('id desc')->paginate(10);
        }
        
        $this->view->assign('orderlist', $list);
        $this->view->assign('title', __('订单管理'));
        return $this->view->fetch();
    }
    
    public function vip()
    {
        $list = Db::name('vippack')->where('id',1)->find();
        $list2 = Db::name('vippack')->where('id',2)->find();
        $list3 = Db::name('vippack')->where('id',3)->find();
        $this->view->assign('viplist', json_decode($list['taocans'],true));
        $this->view->assign('viplist2', json_decode($list2['taocans'],true));
        $this->view->assign('viplist3', json_decode($list3['taocans'],true));
        $this->view->assign('title', __('套餐管理'));
        return $this->view->fetch();
    }
    
    public function vip_submit($days,$paytype)
    {
        $vip = Db::name('vippack')->where('vip_type',$paytype)->find();
        $taocan = json_decode($vip['taocans'],true);
        $money = 0;
        $feilv = 0;
        foreach ($taocan as $value) {
            if($value['day']==$days)
            {
                $money = $value['money'];
                $feilv = $value['feilv'];
            }
        }
        if(empty($days))
        {
            $this->error("请选择要购买的套餐");
        }
        
        if($vip['status']!=1)
        {
            $this->error("套餐禁售中");
        }
        $user = Db::name('user')->where('id',$this->auth->id)->find();
        if($user['money']<$money)
        {
            $this->error("余额不足请充值");
        }
        //扣款并写入
        User::money("-".$money, $this->auth->id, '会员购买套餐');
        if($vip['vip_type']=='alipay')
        {
            if($user['alipay_time']<time())
            {
                $due_time = strtotime('+'.$days.'day');
            }
            else
            {
                $due_time = strtotime('+'.$days.'day',$user['alipay_time']);
            }
            Db::name('user')->where('id', $this->auth->id)->update(['alipay_time' =>$due_time,'alipay_feilv'=>$feilv]);
        }
        else if($vip['vip_type']=='wxpay')
        {
            if($user['wxpay_time']<time())
            {
                $due_time = strtotime('+'.$days.'day');
            }
            else
            {
                $due_time = strtotime('+'.$days.'day',$user['wxpay_time']);
            }
            Db::name('user')->where('id', $this->auth->id)->update(['wxpay_time' =>$due_time,'wxpay_feilv'=>$feilv]);
        }
        else
        {
            if($user['qqpay_time']<time())
            {
                $due_time = strtotime('+'.$days.'day');
            }
            else
            {
                $due_time = strtotime('+'.$days.'day',$user['qqpay_time']);
            }
            Db::name('user')->where('id', $this->auth->id)->update(['qqpay_time' =>$due_time,'qqpay_feilv'=>$feilv]);
        }
        $this->success(__('购买成功'), url('order/vip'));
    }
    
    //订单补单
    public function notity_order($id='')
    {
        $orderrow = Db::name('order')->where('id',$id)->where('user_id',$this->auth->id)->find();
        if(empty($orderrow))
        {
            return json(['code'=>0,'msg'=>'订单不存在!']);
        }
        $u = Jialan::creat_callback($orderrow);
        $res = get_curl($u['notify']);
        return json(['code'=>1,'msg'=>$res]);
    }
    
    
    public function delorder($id)
    {
        $orderrow = Db::name('order')->where('id',$id)->where('user_id',$this->auth->id)->find();
        Db::table('fa_order')->where('id',$orderrow['id'])->delete();
        return json(['code'=>1,'msg'=>'删除成功!']);
    }
    

    
}
