<?php

namespace App\Lib\Constants;

//错误码
class ErrorCode {
    const SUCCESS = 200;
    const FAIL = 0;
    const NOT_FOUND = 404;
    const NOT_ALLOWED_METHOD = 405;
    const SYSTEM_ERR = 500;

    //jwt token相关 10XX
    const TOKEN_EXPIRED = 1001;
    const TOKEN_ABSENT = 1002;
    const TOKEN_INVALID = 1003;
    const TOKEN_USER_NOT_FOUND = 1004;

    //api 3xxx
    const API_PARAM_ERROR = 3001;

    const USER_CREATE_FAIL = 3101;
}