<?php

namespace app\admin\controller;
use think\Db;
use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Channel extends Backend
{
    
    /**
     * Channel模型对象
     * @var \app\admin\model\Channel
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Channel;

    }

    public function import()
    {
        parent::import();
    }
    
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
                
            foreach ($list as &$item){
                $item['count']=  Db::name('qrlist')->where('code',$item['code'])->count();
            }    

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }
    
    public function openStatus(){
		$post = $this->request->param();
		db::name('channel')->where(['id' => $post['id']])->update(['status' => $post['status']]);
		return json(['data' => '', 'msg' => '操作成功', 'code' => 200]);
	}
	
	public function closeStatus(){
		$post = $this->request->param();
		db::name('channel')->where(['id' => $post['id']])->update(['status' => $post['status']]);
		return json(['data' => '', 'msg' => '操作成功', 'code' => 200]);
	}

    
    

}
