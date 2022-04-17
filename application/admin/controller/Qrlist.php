<?php

namespace app\admin\controller;
use think\Db;
use app\common\controller\Backend;

/**
 * 二维码列管理
 *
 * @icon fa fa-circle-o
 */
class Qrlist extends Backend
{
    
    /**
     * Qrlist模型对象
     * @var \app\admin\model\Qrlist
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Qrlist;
        $this->view->assign("typeList", $this->model->getTypeList());
    }

    public function import()
    {
        parent::import();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->paginate($limit);
            foreach ($list as &$item)
            {
                $item['money']=Db::name('order')->where('qr_id',$item['id'])->where('status',1)->sum('truemoney');
                $item['succ_ordercount'] = Db::name('order')->where('qr_id',$item['id'])->where('status',1)->count();
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }
    
    
    public function detail($id)
    {
        //设置过滤方法
        $detail = Db::name('qrlist')->where('id',$id)->find();
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
    
    public function openStatus(){
		$post = $this->request->param();
		db::name('qrlist')->where(['id' => $post['id']])->update(['is_cloud' => $post['status']]);
		return json(['data' => '', 'msg' => '操作成功', 'code' => 200]);
	}
	
	public function closeStatus(){
		$post = $this->request->param();
		db::name('qrlist')->where(['id' => $post['id']])->update(['is_cloud' => $post['status']]);
		return json(['data' => '', 'msg' => '操作成功', 'code' => 200]);
	}

}
