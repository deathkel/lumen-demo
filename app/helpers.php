<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/11 下午3:37
 */

if (! function_exists('session')) {
    /**
     * Get / set the specified session value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed|\Illuminate\Session\Store|\Illuminate\Session\SessionManager
     */
    function session($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('session');
        }

        if (is_array($key)) {
            return app('session')->put($key);
        }

        return app('session')->get($key, $default);
    }
}


/**
 * 把数据库查询数组中的主键当key
 * @param array $arr
 * @param string $index 主键名
 * @return array
 * */
if (!function_exists('setPrimaryKeyToArrayKey')) {
    function setPrimaryKeyToArrayKey(array $arr, $index = "id")
    {
        $data = array();
        foreach ($arr as $v) {
            $data[$v[$index]] = $v;
        }
        return $data;
    }
}

/**
 * 把数组中的某个字段值当key并合并相同key的value
 * @param array $arr
 * @param string $index 字段名
 * @return array
 */
if (!function_exists('setColumnToArrayKeyMerge')) {
    function setColumnToArrayKeyMerge(array $array, $column)
    {
        $data = array();
        foreach ($array as $_key =>$v) {
            $data[$v[$column]][$_key] = $v;
        }
        return $data;
    }
}

/**
 * 字符搜索替换
 */
if (!function_exists('str_replace_limit')) {
    function str_replace_limit($search, $replace, $subject, $limit = -1)
    {
        // constructing mask(s)...
        if (is_array($search)) {
            foreach ($search as $k => $v) {
                $search[$k] = '`' . preg_quote($search[$k], '`') . '`';
            }
        } else {
            $search = '`' . preg_quote($search, '`') . '`';
        }
        // replacement
        return preg_replace($search, $replace, $subject, $limit);
    }
}

/**
 * 封装写入日志
 *
 * @param  string $message
 * @param  array $content
 * @param  string $sub_path
 * @param  string $level
 * @return void
 */
if (!function_exists("save_log")) {
    function save_log($message, $context = [], $sub_path = '', $level = 'info')
    {
        try {
            $day = date('Y-m-d');
            $path = config('global.log_save_path');

            if (!empty($sub_path)) {
                $path .= "/{$sub_path}";
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
            }

            if ($level == 'error') {
                $path .= "/error-{$day}.log";
            } else {
                $path .= "/{$day}.log";
            }

            $logger = \Illuminate\Support\Facades\Log::getMonolog();

            $handlers = $logger->getHandlers();
            $needToAddHandler = true;

            foreach ($handlers as $handler) {
                if ($handler->getUrl() == $path) {
                    $needToAddHandler = false;
                }
            }

            if ($needToAddHandler) {
                $logger->pushHandler(new \Monolog\Handler\StreamHandler($path, $level));
            }

            $logger->log($level, $message, $context);

            app()->make('Illuminate\Contracts\Events\Dispatcher')->fire('illuminate.log', compact('level', 'message', 'context'));
        } catch (ErrorException $err) {
            Illuminate\Support\Facades\Log::error($err->getMessage(), $err->getTrace());
        }
    }
}

