<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/30 下午4:55
 */
return [
    'secret' => env('JWT_SECRET'),
    'expire' => env('JWT_EXPIRE', 3600)
];