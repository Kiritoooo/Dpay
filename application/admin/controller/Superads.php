<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 广告管理
 *
 * @icon fa fa-circle-o
 */
class Superads extends Backend
{

    /**
     * Superads模型对象
     * @var \app\admin\model\Superads
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Superads;
        $this->view->assign("typedataList", $this->model->getTypedataList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }

    public function import()
    {
        parent::import();
    }

    /**
     * 查看
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

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }


    public function getjscode()
    {

        $ids = $this->request->param('ids', '1');

        $data = $this->model->where('id', $ids)->find();

        if (empty($data)) {
            $this->error('没有该条数据');
        }

        $url = addon_url('Superads/index/getjscode', [':aid' => $ids]);
        $this->assign('url', $url);
        // dump($data);

        return $this->fetch();

    }

    //接口调用方法

    public function getadslistall()
    {

        $data = $this->model->where('status', 1)->select();
        $superadsimages_model = new \app\admin\model\Superadsimages;
        $now = time();//用于判断是否过期

        foreach ($data as $key => &$val) {
            $imgdata = $superadsimages_model->where('status', 1)->where('superads_id', $val->id)->select();
            $adslist = [];
            if (!empty($imgdata)) {
                foreach ($imgdata as $key2 => $val2) {
                    if ($val2->isforeverdata != 1) {
                        if ($val2->livestime > $now) {
                            continue;
                        }
                        if ($val2->liveetime < $now) {
                            continue;
                        }
                    }
                    if (isset($val2->adsimage) && !empty($val2->adsimage)) {
                        $val2->localimg = cdnurl($val2->adsimage, true);
                    }
                    $adslist[] = $val2;
                }
            }
            $val->adslist = $adslist;
        }
        return $data;
    }

    public function getadsbytag($tagname)
    {
        if (empty($tagname)) {
            return [];
        }
        $data = $this->model->where('adstag', $tagname)->where('status', 1)->find();
        // dump($data);
        if (empty($data)) {
            return [];
        }
        $superadsimages_model = new \app\admin\model\Superadsimages;
        $imgdata = $superadsimages_model->where('status', 1)->where('superads_id', $data->id)->select();
        $now = time();//用于判断是否过期

        $adslist = [];
        if (!empty($imgdata)) {

            foreach ($imgdata as $key2 => $val2) {
                if ($val2->isforeverdata != 1) {
                    if ($val2->livestime > $now) {
                        continue;
                    }
                    if ($val2->liveetime < $now) {
                        continue;
                    }
                }
                if (isset($val2->adsimage) && !empty($val2->adsimage)) {
                    $val2->localimg = cdnurl($val2->adsimage, true);
                }
                $adslist[] = $val2;
            }

        }
        $data->adslist = $adslist;
        return $data;

    }

    public function getadsbyid($id)
    {
        if (empty($id)) {
            return [];
        }
        $data = $this->model->where('id', $id)->where('status', 1)->find();
        if (empty($data)) {
            return [];
        }
        $superadsimages_model = new \app\admin\model\Superadsimages;
        $imgdata = $superadsimages_model->where('status', 1)->where('superads_id', $data->id)->select();
        $now = time();//用于判断是否过期

        $adslist = [];
        if (!empty($imgdata)) {

            foreach ($imgdata as $key2 => $val2) {
                if ($val2->isforeverdata != 1) {
                    if ($val2->livestime > $now) {
                        continue;
                    }
                    if ($val2->liveetime < $now) {
                        continue;
                    }
                }
                if (isset($val2->adsimage) && !empty($val2->adsimage)) {
                    $val2->localimg = cdnurl($val2->adsimage, true);
                }

                $adslist[] = $val2;
            }
        }
        $data->adslist = $adslist;
        return $data;

    }

    //打开帮助页面
    public function showhelp()
    {
        // $Superads = new \app\admin\controller\Superads;
        // $result = $Superads->getadsbytag('index_heng');//调用单个
        // $this->assign('adsdata',$result);
        return $this->fetch();
    }


}
