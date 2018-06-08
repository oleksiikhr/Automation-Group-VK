<?php

/**
 * | ------------------------------------------------------------------------
 * | TOKENS
 * | ------------------------------------------------------------------------
 * |
 * | string  site    - vk, google, etc                       | Request t_site
 * | string  type    - user or group                         | Request t_type
 * | array   access  - permissions (ex. admin, message etc)  | Request t_access
 * | string  token   - received from the site
 * |
 */

return [
    [
        'site' => 'vk',
        'type' => 'user',
        'access' => ['admin'],
        'token' => 'TOKEN'
    ],
    [
        'site' => '',
        'type' => '',
        'access' => [''],
        'token' => ''
    ],
    [
        'site' => '',
        'type' => '',
        'access' => [''],
        'token' => ''
    ]
];
