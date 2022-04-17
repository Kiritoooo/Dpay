<?php

namespace app\api\controller;

use app\common\controller\Api;

use addons\superads\controller\Index as Superads2; //导入命名空间
use addons\superads\controller\Publist; //导入命名空间

/**
 * 广告接口
 */
class Superads extends Api
{

    // 无需登录的接口,*表示全部
    protected $noNeedLogin = ['*'];
    // 无需鉴权的接口,*表示全部
    protected $noNeedRight = ['*'];


    public function getsuperadsbytag()
    {
        $tagname = $this->request->param('tagname', '');

        if (empty($tagname)) {
            $this->error('参数tagname不能为空');
        }
        /*
        *其他控制器使用方式一样
        */
        $Superads = new Superads2;

        $data = $Superads->getadsbytag($tagname);

        $this->success('返回成功', $data);
    }

    public function getsuperadsbyid()
    {
        $id = $this->request->param('id', '0');
        if (empty($id)) {
            $this->error('参数id不能为空');
        }
        /*
        *其他控制器使用方式一样
        */
        $Superads = new Superads2;

        $data = $Superads->getadsbyid($id);

        $this->success('返回成功', $data);
    }

    public function getsuperadsall()
    {

        $Superads = new Superads2;

        $data = $Superads->getadslistall();

        $this->success('返回成功', $data);
    }

    public function getpublistone()
    {
        $Publist = new Publist;
        $tagname = $this->request->param('tagname', '');

        if (empty($tagname)) {
            $this->error('参数tagname不能为空');
        }

        $data = $Publist->getpublistone($tagname);
        // $data = $Publist->getpublistall();

        $this->success('返回成功', $data);
    }

}
