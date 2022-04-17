<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 广告内容管理
 *
 * @icon fa fa-circle-o
 */
class SuperadsImages extends Backend
{

    /**
     * SuperadsImages模型对象
     * @var \app\admin\model\SuperadsImages
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\SuperadsImages;
        $this->view->assign("isforeverdataList", $this->model->getIsforeverdataList());
        $this->view->assign("statusList", $this->model->getStatusList());
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
        $ads_ids = $this->request->param('ids', '0');

        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            $ads_ids = $this->request->param('ids', '0');
            $where2 = ['superads_id' => ['>', 0]];
            if ($ads_ids) {
                $where2 = ['superads_id' => $ads_ids];
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $list = $this->model
                ->where($where)
                ->where($where2)
                ->order($sort, $order)
                ->paginate($limit);

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        $this->assignconfig('ads_ids', $ads_ids);
        return $this->view->fetch();
    }

}
