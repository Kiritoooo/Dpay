<?php

return array(
    array(
        'name'    => 'key',
        'title'   => '应用key',
        'type'    => 'string',
        'content' =>
            array(),
        'value'   => 'your key',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ),
    array(
        'name'    => 'secret',
        'title'   => '密钥secret',
        'type'    => 'string',
        'content' =>
            array(),
        'value'   => 'your secret',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ),
    array(
        'name'    => 'sign',
        'title'   => '签名',
        'type'    => 'string',
        'content' =>
            array(),
        'value'   => 'your sign',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ),
    array(
        'name'    => 'template',
        'title'   => '短信模板',
        'type'    => 'array',
        'content' =>
            array(),
        'value'   =>
            array(
                'register'     => 'SMS_114000000',
                'resetpwd'     => 'SMS_114000000',
                'changepwd'    => 'SMS_114000000',
                'changemobile' => 'SMS_114000000',
                'profile'      => 'SMS_114000000',
                'notice'       => 'SMS_114000000',
            ),
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ),
    array(
        'name'    => '__tips__',
        'title'   => '温馨提示',
        'type'    => 'string',
        'content' =>
            array(),
        'value'   => '应用key和密钥你可以通过 https://ak-console.aliyun.com/?spm=a2c4g.11186623.2.13.fd315777PX3tjy#/accesskey 获取',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ),
);
