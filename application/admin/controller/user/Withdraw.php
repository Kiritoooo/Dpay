<?php

namespace app\admin\controller\user;

use addons\epay\library\Service;
use app\common\controller\Backend;
use think\Exception;
use Yansongda\Pay\Pay;

/**
 * 提现管理
 *
 * @icon fa fa-circle-o
 */
class Withdraw extends Backend
{

    /**
     * Withdraw模型对象
     * @var \app\admin\model\user\Withdraw
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\user\Withdraw;
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    /**
     * 查看
     */
    public function index()
    {
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with(['user'])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(['user'])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    //查询转账状态
    public function query()
    {
        $ids = $this->request->param('ids', '');
        $model = $this->model->where('id', $ids)->find();
        if (!$model) {
            $this->error(__('No Results were found'));
        }
        $result = null;
        try {
            $config = Service::getConfig('alipay');
            $pay = Pay::alipay($config);
            $result = $pay->find($model['orderid']);

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        if ($result && isset($result['code']) && $result['code'] == 10000) {
            $this->success("转账成功！");
        } else {
            $this->error('转账失败！');
        }
    }

}
