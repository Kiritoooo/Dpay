<?php

namespace addons\superads\controller;

use think\addons\Controller;

class Publist extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \addons\superads\model\SuperadsPublist;
    }

    public function getpublistall()
    {

        list($where, $sort, $order, $offset, $limit) = $this->buildparams();

        $list = $this->model
            ->where($where)
            ->order($sort, $order)
            ->paginate($limit);

        $result = array("total" => $list->total(), "rows" => $list->items());

        if (!empty($result)) {
            foreach ($result as $key => &$val) {
                if (isset($val->pubimage) && !empty($val->pubimage)) {
                    $val->localurl = cdnurl($val->pubimage, true);
                }

            }
        }
        return ($result);
    }

    public function getpublistone($tagname)
    {
        if (empty($tagname)) {
            return [];
        }
        $now = time();
        // $where = [
        //     'livestime'=>['<=',$now],
        //     'liveetime'=>['>=',$now],

        // ];
        $data = $this->model->where('pubtag', $tagname)->where('status', 1)->find();

        if (!empty($data) && !empty($data->pubimage)) {

            if ($data->isforeverdata != 1) {
                if ($data->livestime > $now || $data->liveetime < $now) {
                    return [];
                }
            }

            $data->localurl = cdnurl($data->pubimage, true);
        }
        return $data;
    }


}
