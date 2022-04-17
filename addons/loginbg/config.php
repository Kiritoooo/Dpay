<?php

return [
    [
        'name' => 'mode',
        'title' => '模式',
        'type' => 'radio',
        'content' => [
            'fixed' => '固定',
            'random' => '每次随机',
            'daily' => '每日切换',
        ],
        'value' => 'random',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'image',
        'title' => '固定背景图',
        'type' => 'image',
        'content' => [],
        'value' => '/assets/img/loginbg.jpg',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
];
