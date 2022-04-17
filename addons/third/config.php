<?php

return array(
    0 =>
        array(
            'name'    => 'qq',
            'title'   => 'QQ',
            'type'    => 'array',
            'content' =>
                array(
                    'app_id'     => '',
                    'app_secret' => '',
                    'scope'      => 'get_user_info',
                ),
            'value'   =>
                array(
                    'app_id'     => '100000000',
                    'app_secret' => '123456',
                    'scope'      => 'get_user_info',
                ),
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '',
            'extend'  => '',
        ),
    1 =>
        array(
            'name'    => 'wechat',
            'title'   => '微信',
            'type'    => 'array',
            'content' =>
                array(
                    'app_id'     => '',
                    'app_secret' => '',
                    'callback'   => '',
                    'scope'      => 'snsapi_base',
                ),
            'value'   =>
                array(
                    'app_id'     => '100000000',
                    'app_secret' => '123456',
                    'scope'      => 'snsapi_userinfo',
                ),
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '',
            'extend'  => '',
        ),
    2 =>
        array(
            'name'    => 'weibo',
            'title'   => '微博',
            'type'    => 'array',
            'content' =>
                array(
                    'app_id'     => '',
                    'app_secret' => '',
                    'scope'      => 'get_user_info',
                ),
            'value'   =>
                array(
                    'app_id'     => '100000000',
                    'app_secret' => '123456',
                    'scope'      => 'get_user_info',
                ),
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '',
            'extend'  => '',
        ),
    3 =>
        array(
            'name'    => 'bindaccount',
            'title'   => '账号绑定',
            'type'    => 'radio',
            'content' =>
                array(
                    1 => '开启',
                    0 => '关闭',
                ),
            'value'   => '1',
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '是否开启账号绑定',
            'extend'  => '',
        ),
    4 =>
        array(
            'name'    => 'status',
            'title'   => '前台第三方登录开关',
            'type'    => 'checkbox',
            'content' =>
                array(
                    'qq'     => 'QQ',
                    'wechat' => '微信',
                    'weibo'  => '微博',
                ),
            'value'   => 'qq,wechat,weibo',
            'rule'    => '',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '前台第三方登录的开关',
            'extend'  => '',
        ),
    5 =>
        array(
            'name'    => 'rewrite',
            'title'   => '伪静态',
            'type'    => 'array',
            'content' =>
                array(),
            'value'   =>
                array(
                    'index/index'    => '/third$',
                    'index/connect'  => '/third/connect/[:platform]',
                    'index/callback' => '/third/callback/[:platform]',
                    'index/bind'     => '/third/bind/[:platform]',
                    'index/unbind'   => '/third/unbind/[:platform]',
                ),
            'rule'    => 'required',
            'msg'     => '',
            'tip'     => '',
            'ok'      => '',
            'extend'  => '',
        ),
);
