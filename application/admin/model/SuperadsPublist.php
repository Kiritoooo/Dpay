<?php

namespace app\admin\model;

use think\Model;


class SuperadsPublist extends Model
{


    // 表名
    protected $name = 'superads_publist';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'isforeverdata_text',
        'livestime_text',
        'liveetime_text',
        'status_text'
    ];


    public function getIsforeverdataList()
    {
        return ['1' => __('Isforeverdata 1'), '0' => __('Isforeverdata 0')];
    }

    public function getStatusList()
    {
        return ['1' => __('Status 1'), '0' => __('Status 0')];
    }


    public function getIsforeverdataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['isforeverdata']) ? $data['isforeverdata'] : '');
        $list = $this->getIsforeverdataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getLivestimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['livestime']) ? $data['livestime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getLiveetimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['liveetime']) ? $data['liveetime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setLivestimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setLiveetimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
