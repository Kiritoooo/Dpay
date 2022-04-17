<?php

namespace addons\loginbg;

use think\Addons;

/**
 * 登录背景图插件
 */
class Loginbg extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    public function adminLoginInit(\think\Request &$request)
    {
        $config = $this->getConfig();
        if ($config['mode'] == 'random' || $config['mode'] == 'daily')
        {
            $index = $config['mode'] == 'random' ? mt_rand(1, 4000) : date("Ymd") % 4000;
            $background = "https://api.nmb.show/xiaojiejie2.php";
        }
        else
        {
            $background = cdnurl($config['image']);
        }
        \think\View::instance()->assign('background', $background);
    }

}
