<?php

namespace addons\superads\controller;

use think\addons\Controller;

class Index extends Controller
{
    public $model;
    public $superads_images_model;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \addons\superads\model\Superads;
        $this->superads_images_model = new \addons\superads\model\SuperadsImages;
    }

    public function index()
    {
        $this->error("当前插件暂无前台页面");
    }

    public function getjscode()
    {
        $aid = $this->request->param('aid', '1');
        $aid = (isset($aid) && is_numeric($aid)) ? $aid : 0;
        if ($aid == 0) die('document.write("Request Error!") ');
        $now = time();//用于判断是否过期
        $ads_model = $this->model;
        $ads_data = $ads_model->get($aid);
        if (empty($ads_data)) {
            die('document.write("no data")');
        }
        $superadsImages_model = $this->superads_images_model;
        $imgData = $superadsImages_model->where('status', 1)->where('superads_id', $ads_data->id)->order('id')->select();
        if (empty($imgData)) {
            die('document.write("no data in ads")');
        }
        $adslist = [];

        foreach ($imgData as $key2 => $val2) {

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

        if (empty($adslist)) {
            die('document.write("no data")');
        }

        $ads_data->adslist = $adslist;

        // dump($ads_data);
        $width = ($ads_data->adswidth != 0) ? $ads_data->adswidth : 'auto';
        $height = ($ads_data->adsheight != 0) ? $ads_data->adsheight : 'auto';

        if ($ads_data->typedata == 1) {
            $adBody = <<<SHTML
    <img src="{$ads_data->adslist[0]->localimg}" width="{$width}" height="{$height}" alt="{$ads_data->adslist[0]->imgtitle}" />
SHTML;
        } else if ($ads_data->typedata == 2) {

            $sider = '';
            foreach ($ads_data->adslist as $k => $val) {
                $sider .= '<div class="swiper-slide">
                <img src="' . $val->localimg . '" width="' . $width . '" height="' . $height . '" alt="' . $val->imgtitle . '" />
                </div>';
            }
            $adBody = <<<SHTML
<div class="swiper-container{$ads_data->id}">
    <div class="swiper-wrapper">
        {$sider}
    </div>
</div>
SHTML;
        } else if ($ads_data->typedata == 3) {
            $adBody = $ads_data->adslist[0]->adscontent;
        }

        $adBody = str_replace('"', '\"', $adBody);
        $adBody = str_replace("\r", "\\r", $adBody);
        $adBody = str_replace("\n", "\\n", $adBody);

        $adBody = "<!--\r\ndocument.write(\"{$adBody}\");\r\n-->\r\n";
        echo $adBody;
        die;

    }

    //接口调用方法

    public function getadslistall()
    {

        $data = $this->model->where('status', 1)->select();
        $superadsImages_model = $this->superads_images_model;
        $now = time();//用于判断是否过期

        foreach ($data as $key => &$val) {
            $imgData = $superadsImages_model->where('status', 1)->where('superads_id', $val->id)->select();
            if (!empty($imgData)) {
                $adslist = [];
                foreach ($imgData as $key2 => $val2) {
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
                $val->adslist = $adslist;
            }
        }
        return $data;
    }

    public function getadsbytag($tagName)
    {
        if (empty($tagName)) {
            return [];
        }
        $data = $this->model->where('adstag', $tagName)->where('status', 1)->find();
        // dump($data);
        if (empty($data)) {
            return [];
        }

        $superadsImages_model = $this->superads_images_model;


        $imgData = $superadsImages_model->where('status', 1)->where('superads_id', $data->id)->select();
        $now = time();//用于判断是否过期

        $adslist = [];
        if (!empty($imgData)) {

            foreach ($imgData as $key2 => $val2) {
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
        $superadsImages_model = $this->superads_images_model;
        $imgData = $superadsImages_model->where('status', 1)->where('superads_id', $data->id)->select();
        $now = time();//用于判断是否过期

        $adslist = [];
        if (!empty($imgData)) {

            foreach ($imgData as $key2 => $val2) {
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


}
