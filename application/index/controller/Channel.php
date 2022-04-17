<?php

namespace app\index\controller;
use app\common\controller\Frontend;
use think\Exception;
use think\Db;
use fast\Http;
/**
 * 通道
 */
class Channel extends Frontend
{
    protected $layout = 'default';
    protected $noNeedLogin = [''];
    protected $noNeedRight = ['*'];
    
    public function index()
    {
        $list = Db::name('qrlist')->where('user_id',$this->auth->id)->select();
        foreach ($list as &$item)
        {
            $item['money']=Db::name('order')->where('qr_id',$item['id'])->where('status',1)->sum('truemoney');
            $item['succ_ordercount'] = Db::name('order')->where('qr_id',$item['id'])->where('status',1)->count();
            $channel = Db::name('channel')->where('code',$item['code'])->find();
            $item['name']=$channel['name'];
        }
        
        $this->view->assign('wxlist', Db::name('channel')->where('type','wxpay')->where('status',1)->select());
        $this->view->assign('alilist', Db::name('channel')->where('type','alipay')->where('status',1)->select());
        $this->view->assign('qqlist', Db::name('channel')->where('type','qqpay')->where('status',1)->select());
        $this->view->assign('qrlist', $list);
        $this->view->assign('title', __('通道管理'));
        return $this->view->fetch();
    }
    
    public function delchannel($id)
    {
        $qrlist = Db::name('qrlist')->where('id',$id)->where('user_id',$this->auth->id)->find();
        Db::table('fa_qrlist')->where('id',$qrlist['id'])->delete();
        return json(['code'=>1,'msg'=>'删除成功!']);
    }
    
    public function basic()
    {
        if($this->request->isPost()) 
        {
            $lixian_notity = $this->request->post("lixian_notity");
            $console_notity = $this->request->post("console_notity");
            $tix = $this->request->post("yuyin_notity");
            $pay_temp = $this->request->post("pay_temp");
            $is_login_email = $this->request->post("is_login_email");
            $is_other = $this->request->post("is_other");
            $min_money_tx = $this->request->post("min_money_tx");
            Db::name('user')->where('id', $this->auth->id)->update(['yuyin_notity'=>$tix,'console_notity'=>$console_notity,'pay_temp'=>$pay_temp,'is_login_email'=>$is_login_email,'min_money_tx'=>$min_money_tx,'is_other'=>$is_other]);
            return json(['code'=>1,'msg'=>'修改成功!']);
            
        }
        $this->view->assign('title', __('通道配置'));
        return $this->view->fetch();
    }
    
    //通道详情
    public function detail($id='')
    {
        $detail = Db::name('qrlist')->where('id',$id)->where('user_id',$this->auth->id)->find();
        $res['all_money_count']=Db::name('order')->where('qr_id',$id)->where('status',1)->count();//总收款笔数
        $res['all_money']=Db::name('order')->where('qr_id',$id)->where('status',1)->sum('truemoney');//总收款金额
        $res['day_money_count']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'today')->count();
        $res['day_money']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'today')->sum('truemoney');
        $res['yday_money_count']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'yesterday')->count();
        $res['yday_money']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'yesterday')->sum('truemoney');
        $res['week_money_count']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'week')->count();
        $res['week_money']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'week')->sum('truemoney');
        $res['year_money_count']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'year')->count();
        $res['year_money']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'year')->sum('truemoney');
        $res['yue_money_count']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'month')->count();
        $res['yue_money']=Db::name('order')->where('qr_id',$id)->where('status',1)->whereTime('end_time', 'month')->sum('truemoney');
        $this->view->assign('od', $res);
        $this->view->assign('detail', $detail);
        return $this->view->fetch();
    }
    
    
    public function addchannel()
    {
        $type = $this->request->post("type");
        $code = $this->request->post("channel_code");
        $wx_name = $this->request->post("wx_name",null);
        $zfb_pid = $this->request->post("zfb_pid",null);
        $ewm_url = $this->request->post("ewm_url",'');
        $memo = $this->request->post("memo",null);
        $user = Db::name('user')->where('id',$this->auth->id)->find();
        $channel = Db::name('channel')->where('code',$code)->find();
        if($type=='wxpay' && $code=='wxpay_dy')
        {
            if(empty($wx_name))
            {
                return json(['code'=>0,'msg'=>'店长昵称不可为空!']);
            }
            $is_wx = Db::name('qrlist')->where('wx_name',$wx_name)->find();
            if(!empty($is_wx))
            {
                return json(['code'=>0,'msg'=>'该微信名已存在,请更换!']);
            }
        }
        if($type=='wxpay' && $code=='wxpay_app')
        {
            if(empty($ewm_url))
            {
                return json(['code'=>0,'msg'=>'二维码不可为空!']);
            }
        }
        if($user[$type.'_time']<time())
        {
            return json(['code'=>0,'msg'=>'未开通会员或已过期!']);
        }
        //检查通道上限
        $c_count = Db::name('qrlist')->where('code',$channel['code'])->where('id',$this->auth->id)->count();
        if($c_count>=$channel['max_account'])
        {
            return json(['code'=>0,'msg'=>'该通道已达使用上限!']);
        }
        $data = [
                'user_id' =>$user['id'], 
                'type' => $type,
                'qr_url' => htmlspecialchars_decode($ewm_url),
                'zfb_pid' => $zfb_pid,
                'money' =>0,
                'succ_ordercount' =>0,
                'createtime' => time(),
                'wx_name'=>$wx_name,
                'memo'=>$memo,
                'code'=>$channel['code']
                
            ];

        Db::name('qrlist')->insert($data);
        return json(['code'=>1,'msg'=>'添加成功!']);
    }
    
    //微信小号信息
    public function wx_accout()
    {
        $list = Db::name('wxemp')->where('status',1)->select();
        $this->view->assign('wxlist', $list);
        return $this->view->fetch();
    }
    
    public function getqrlist($id='')
    {
        $qr = Db::name('qrlist')->where('id',$id)->where('user_id',$this->auth->id)->find();
        return json(['code'=>1,'msg'=>'成功!','data'=>$qr]);
    }
    

    
}
