<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\User;
use app\common\controller\Backend;
use app\common\model\Attachment;
use fast\Date;
use think\Db;

/**
 * 控制台
 *
 * @icon   fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
        try {
            \think\Db::execute("SET @@sql_mode='';");
        } catch (\Exception $e) {

        }
        $column = [];
        $starttime = Date::unixtime('day', -6);
        $endtime = Date::unixtime('day', 0, 'end');
        $joinlist = Db("user")->where('jointime', 'between time', [$starttime, $endtime])
            ->field('jointime, status, COUNT(*) AS nums, DATE_FORMAT(FROM_UNIXTIME(jointime), "%Y-%m-%d") AS join_date')
            ->group('join_date')
            ->select();
        for ($time = $starttime; $time <= $endtime;) {
            $column[] = date("Y-m-d", $time);
            $time += 86400;
        }
        $userlist = array_fill_keys($column, 0);
        foreach ($joinlist as $k => $v) {
            $userlist[$v['join_date']] = $v['nums'];
        }

        $dbTableList = Db::query("SHOW TABLE STATUS");
        $this->view->assign([
            'totaluser'       => User::count(),
            'totaladdon'      => count(get_addon_list()),
            'totaladmin'      => Admin::count(),
            //'totalcategory'   => \app\common\model\Category::count(),
            'todayusersignup' => User::whereTime('jointime', 'today')->count(),
            'todayuserlogin'  => User::whereTime('logintime', 'today')->count(),
            'sevendau'        => User::whereTime('jointime|logintime|prevtime', '-7 days')->count(),
            'thirtydau'       => User::whereTime('jointime|logintime|prevtime', '-30 days')->count(),
            'threednu'        => User::whereTime('jointime', '-3 days')->count(),
            'sevendnu'        => User::whereTime('jointime', '-7 days')->count(),
            'dbtablenums'     => count($dbTableList),
            'dbsize'          => array_sum(array_map(function ($item) {
                return $item['Data_length'] + $item['Index_length'];
            }, $dbTableList)),
            'attachmentnums'  => Attachment::count(),
            'attachmentsize'  => Attachment::sum('filesize'),
            'picturenums'     => Attachment::where('mimetype', 'like', 'image/%')->count(),
            'picturesize'     => Attachment::where('mimetype', 'like', 'image/%')->sum('filesize'),
            'wxcount'         => Db::name('qrlist')->where('type','wxpay')->count(),
            'alicount'        => Db::name('qrlist')->where('type','alipay')->count(),
            'allmoney'=>Db::name('order')->where('status',1)->sum('truemoney'),
            'daymoney'=>Db::name('order')->where('status',1)->whereTime('end_time', 'today')->sum('truemoney'),
            'allmoneycount'=>Db::name('order')->where('status',1)->count(),
            'daymoneycount'=>Db::name('order')->where('status',1)->whereTime('end_time', 'today')->count()
        ]);

        $this->assignconfig('column', array_keys($userlist));
        $this->assignconfig('userdata', array_values($userlist));

        return $this->view->fetch();
    }

}
