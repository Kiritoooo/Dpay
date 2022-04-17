<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Lang;
use think\Db;
use fast\Http;
use app\common\library\Jialan;
/**
 * Ajax异步请求接口
 * @internal
 */
class Ajax extends Frontend
{

    protected $noNeedLogin = ['lang', 'upload','cloud'];
    protected $noNeedRight = ['*'];
    protected $layout = '';
    
    public $id;

    /**
     * 加载语言包
     */
    public function lang()
    {
        header('Content-Type: application/javascript');
        header("Cache-Control: public");
        header("Pragma: cache");

        $offset = 30 * 60 * 60 * 24; // 缓存一个月
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT");

        $controllername = input("controllername");
        $this->loadlang($controllername);
        //强制输出JSON Object
        $result = jsonp(Lang::get(), 200, [], ['json_encode_param' => JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE]);
        return $result;
    }

    /**
     * 上传文件
     */
    public function upload()
    {
        return action('api/common/upload');
    }
    
    public function cloud($type='',$loginid='',$qr_id='',$qrlist_id='')
    {
        $request = \think\Request::instance();
        if($type=='getqrcode')
        {
            $option=array('ssl'=>array('verify_peer' => false,'verify_peer_name' => false));
            $res = file_get_contents($request->root(true).'/alipayqr.php?act='.$type,false,stream_context_create($option));
            $res = json_decode($res,true);
            return $res;
        }
        else if($type=='getcookie')
        {
            $option=array('ssl'=>array('verify_peer' => false,'verify_peer_name' => false));
            $res = file_get_contents($request->root(true).'/alipayqr.php?act='.$type.'&loginid='.$loginid,false,stream_context_create($option));
            $res = json_decode($res,true);
            return $res;
        }
        else if($type=='getqrpic')
        {
            $option=array('ssl'=>array('verify_peer' => false,'verify_peer_name' => false));
            $res = file_get_contents($request->root(true).'/qqpayqr.php?do='.$type,false,stream_context_create($option));
            $res = json_decode($res,true);
            return json(['code'=>1,'msg'=>'获取成功!','id'=>$res['qrsig'],'qr_url'=>'data:image/png;base64,' . $res['data']]);
        }
        else if($type=='getWeChatQr') 
        {
            $re = Db::name('qrlist')->where('id', $qrlist_id)->find();
            $res = Jialan::wxGetLoginQrcode($re['cookie']);
            if($res->code==0)
            {
                return json(['code'=>0,'msg'=>'服务返回错误!']);
            }
            Db::name('qrlist')->where('id', $qrlist_id)->update(['cookie' =>$res->guid]);
            return json(['code'=>1,'msg'=>'获取成功!','data'=>$res,'qr_url'=>'data:image/png;base64,'.$res->data->qrcode]);
        }
        else if($type=='WXCheckLoginQrcode') 
        {
            $res = Jialan::wxCheckLoginQrcode($qr_id,$loginid);
            
            return json($res);
        }
        else
        {
            $option=array('ssl'=>array('verify_peer' => false,'verify_peer_name' => false));
            $res = file_get_contents($request->root(true).'/qqpayqr.php?do='.$type.'&qrsig='.$qr_id,false,stream_context_create($option));
            $res = json_decode($res,true);
            return $res;
        }
    }
    
    
    public function upqrstatus($id='',$cookie='')
    {
        
        //查询是否为支付宝免挂，如果是则获取PID
        $res = Db::name('qrlist')->where('id', $id)->where('user_id', $this->auth->id)->update(['status' => 1,'cookie'=>$cookie,'diaoxian_notity'=>0]);
        if($res)
        {
            return json(['code'=>1,'msg'=>'更新成功!']);
            
        }
        else
        {
            return json(['code'=>0,'msg'=>'更新失败!']);
        }
    }
    
    public function offchannel($id='')
    {
        
        $user = Db::name('qrlist')->where('id', $id)->where('user_id', $this->auth->id)->find();
        if($user['is_status']==1)
        {
            $is_status = 0 ;
        }
        else
        {
            $is_status = 1 ;
        }
        unlink('ck/'.$id.'_cookie.txt');
        $res = Db::name('qrlist')->where('id', $id)->where('user_id', $this->auth->id)->update(['is_status' => $is_status]);
        return json(['code'=>1,'msg'=>'操作成功!']);
    }
    
    
    

}
