<?php

namespace app\admin\model;

use think\Model;


class Vippack extends Model
{

    

    

    // 表名
    protected $name = 'vippack';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'vip_type_text',
        'status_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getVipTypeList()
    {
        return ['alipay' => __('Vip_type alipay'), 'wxpay' => __('Vip_type wxpay'), 'qqpay' => __('Vip_type qqpay')];
    }

    public function getStatusList()
    {
        return ['1' => __('Status 1'), '0' => __('Status 0')];
    }


    public function getVipTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['vip_type']) ? $data['vip_type'] : '');
        $list = $this->getVipTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
