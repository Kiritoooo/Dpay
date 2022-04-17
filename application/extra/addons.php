<?php

return [
    'autoload' => false,
    'hooks' => [
        'app_init' => [
            'epay',
            'templates',
        ],
        'admin_login_init' => [
            'loginbg',
        ],
        'user_sidenav_after' => [
            'message',
            'recharge',
            'withdraw',
        ],
        'send_message' => [
            'message',
        ],
        'module_init' => [
            'templates',
        ],
        'addon_module_init' => [
            'templates',
        ],
        'config_init' => [
            'third',
        ],
    ],
    'route' => [
        '/third$' => 'third/index/index',
        '/third/connect/[:platform]' => 'third/index/connect',
        '/third/callback/[:platform]' => 'third/index/callback',
        '/third/bind/[:platform]' => 'third/index/bind',
        '/third/unbind/[:platform]' => 'third/index/unbind',
    ],
    'priority' => [],
    'domain' => '',
];
