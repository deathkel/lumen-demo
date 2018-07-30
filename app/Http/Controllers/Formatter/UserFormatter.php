<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/20 下午2:52
 */

namespace App\Http\Controllers\Formatter;


use App\Lib\ApiFormatter\Formatter;
use App\Lib\ApiFormatter\Type;

class UserFormatter extends Formatter
{
    protected static $fields = [
        'nickname' => Type::STRING,
        'sex' => Type::STRING,
        'mobile' => Type::STRING,
        'city' => Type::STRING,
        'province' => Type::STRING,
        'country' => Type::STRING,
        'avatar' => Type::STRING,
    ];

    protected static function item($key, $item, $type, &$info = null)
    {
        switch ($key){
            default:
                $item = parent::item($key, $item, $type, $info);
                break;
        }
        return $item;
    }
}
