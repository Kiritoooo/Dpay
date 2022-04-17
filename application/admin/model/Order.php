<?php

namespace app\admin\model;

use think\Model;


class Order extends Model
{
    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'typedata_text',
        'end_time_text',
        'out_time_text',
        'status_text'
    ];
    

    
    public function getTypedataList()
    {
        return ['alipay' => __('Typedata alipay'), 'wxpay' => __('Typedata wxpay'), 'qqpay' => __('Typedata qqpay')];
    }

    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1')];
    }


    public function getTypedataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['typedata']) ? $data['typedata'] : '');
        $list = $this->getTypedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getEndTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['end_time']) ? $data['end_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getOutTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['out_time']) ? $data['out_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setEndTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setOutTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
