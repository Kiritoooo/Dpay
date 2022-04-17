<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use fast\Http;
use think\Db;
use think\Cache;
use think\Config;

/**
 * 密钥管理
 */
class Cloud extends Backend {

    /**
     * 查看密钥
     */
    public function checkCloud()
    {
        $cloud = Db::name('admin')->where('id',1)->find();
        return json(['code' => 1, 'msg' => $cloud['cloudkey']]);
    }
    
    public function updatekey($cloudkey){
        if(empty($cloudkey))
        {
            return json(['code' => 0, 'msg' => "请输入云端密钥"]);
        }
        Db::name('admin')->where('id', 1)->update(['cloudkey' =>$cloudkey]);
        return json(['code' => 1, 'msg' => '设置成功']);
    }


}
