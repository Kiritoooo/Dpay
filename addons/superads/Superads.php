<?php

namespace addons\superads;

use app\common\library\Menu;
use think\Addons;

/**
 * 插件
 */
class Superads extends Addons
{
    public $menu_name = 'superadsmenu';
    public $menu = [
        [
            'name'    => 'superadsmenu',
            'title'   => '广告公告管理',
            'icon'    => 'fa fa-file-text-o',
            'remark'  => '常用于管理广告图片',
            'sublist' => [
                [
                    'name'    => 'superads',
                    'title'   => '广告管理',
                    'ismenu'  => 1,
                    'sublist' => [
                        ['name' => 'superads/index', 'title' => '查看'],
                        ['name' => 'superads/showhelp', 'title' => '使用帮助'],
                        ['name' => 'superads/add', 'title' => '添加'],
                        ['name' => 'superads/edit', 'title' => '编辑'],
                        ['name' => 'superads/del', 'title' => '删除'],
                    ]
                ],
                [
                    'name'    => 'superads_publist',
                    'title'   => '公告管理',
                    'ismenu'  => 1,
                    'sublist' => [
                        ['name' => 'superads_publist/index', 'title' => '查看'],
                        ['name' => 'superads_publist/add', 'title' => '添加'],
                        ['name' => 'superads_publist/edit', 'title' => '编辑'],
                        ['name' => 'superads_publist/del', 'title' => '删除'],
                    ]
                ]
            ]
        ]
    ];

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {

        Menu::create($this->menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete($this->menu_name);
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {

        Menu::enable($this->menu_name);
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable($this->menu_name);
        return true;
    }

}
