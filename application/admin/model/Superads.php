<?php

namespace app\admin\model;

use think\Model;


class Superads extends Model
{


    // 表名
    protected $name = 'superads';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'typedata_text',
        'status_text'
    ];


    public function getTypedataList()
    {
        return ['1' => __('Typedata 1'), '2' => __('Typedata 2'), '3' => __('Typedata 3')];
    }

    public function getStatusList()
    {
        return ['1' => __('Status 1'), '0' => __('Status 0')];
    }


    public function getTypedataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['typedata']) ? $data['typedata'] : '');
        $list = $this->getTypedataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


}
