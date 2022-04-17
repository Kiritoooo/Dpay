<?php

namespace app\index\controller;
use think\Db;
use app\common\controller\Frontend;

class News extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    
    public function index($page=1)
    {
        $list = Db::name('superads_publist')
            ->order(['id','id'=>'desc'])
            ->paginate(20);
        $this->assign('page',$list);
        $this->assign('list',$list->items());
        return $this->view->fetch();
    }
    
    
    //anninfo
    public function anninfo($id)
    {
        $ann = Db::name('superads_publist')->where('id',$id)->find();
        $this->assign('ann',$ann);
        return $this->view->fetch();
    }

}
