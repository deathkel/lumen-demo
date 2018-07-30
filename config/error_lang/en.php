<?php

use App\Lib\Constants\ErrorCode;

return [
    ErrorCode::SUCCESS => 'success',
    ErrorCode::FAIL => 'system error',
    ErrorCode::NOT_FOUND => 'system error',
    ErrorCode::NOT_ALLOWED_METHOD => 'system error',
    ErrorCode::SYSTEM_ERR => 'system error',

    ErrorCode::TOKEN_EXPIRED => 'token expire',
    ErrorCode::TOKEN_ABSENT => 'token absent',
    ErrorCode::TOKEN_INVALID => 'invalid token',
    ErrorCode::TOKEN_USER_NOT_FOUND => 'login fail, please try again',

    //API错误
    ErrorCode::API_PARAM_ERROR => "params error",
];
