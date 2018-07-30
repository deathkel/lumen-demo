<?php

use App\Lib\Constants\ErrorCode;

return [
    ErrorCode::SUCCESS => '成功',
    ErrorCode::FAIL => '系统错误',
    ErrorCode::NOT_FOUND => '系统错误',
    ErrorCode::NOT_ALLOWED_METHOD => '系统错误',
    ErrorCode::SYSTEM_ERR => '系统错误',


    ErrorCode::TOKEN_EXPIRED => 'token过期',
    ErrorCode::TOKEN_ABSENT => 'token缺失',
    ErrorCode::TOKEN_INVALID => 'token不合法',
    ErrorCode::TOKEN_USER_NOT_FOUND => '用户登录信息已失效,请重新登录',

    ErrorCode::USER_CREATE_FAIL => '创建用户失败',
];