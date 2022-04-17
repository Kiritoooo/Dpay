<?php

namespace app\api\controller;

use app\common\controller\Api;
use fast\Http;
/**
 * 示例接口
 */
class Demo extends Api
{

    //如果$noNeedLogin为空表示所有接口都需要登录才能请求
    //如果$noNeedRight为空表示所有接口都需要验证权限才能请求
    //如果接口已经设置无需登录,那也就无需鉴权了
    //
    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    
    
    


    /**
     * 无需登录的接口
     *
     */
    public function test1()
    {
        $rs = Http::post('http://103.40.242.208:82/api/Login/WXLogout', ["Guid"=>'d473dd4a-87a4-4dc5-b711-ad3c6dcf14bb']);
        //echo($rs);
        $rs = json_decode($rs,true);
        return json($rs);
        //$this->success('返回成功', $rs);
    }

    /**
     * 需要登录的接口
     *
     */
    public function test2()
    {
        $this->success('返回成功', ['action' => 'test2']);
    }

    /**
     * 需要登录且需要验证有相应组的权限
     *
     */
    public function test3()
    {
        $this->success('返回成功', ['action' => 'test3']);
    }

}
