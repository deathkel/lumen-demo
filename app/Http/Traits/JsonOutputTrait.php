<?php

namespace App\Http\Traits;

use App\Lib\Constants\ErrorCode;
use App\Lib\Lang;

trait JsonOutputTrait
{

    /**
     * ajax返回json格式规范
     *
     * 成功后的成功码可选 200x
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function _json()
    {
        $args = func_get_args();
        $json = [
            'code' => $args[0],
            'msg' => $args[1],
            'data' => $args[2]
        ];
        return response()->json($json);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * json函数的一种快捷方式，返回找不到对象错误，error_msg为not found  error_code为4004
     *
     */
    protected function _error_not_found()
    {
        return $this->_json(ErrorCode::NOT_FOUND, '没有找到', []);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * json函数的一种快捷方式，返回系统错误，error_msg为system error  error_code为5000
     *
     */
    protected function _error_system()
    {
        return $this->_json(ErrorCode::SYSTEM_ERR, '系统错误', []);
    }

    /**
     * @param $msg
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     *
     * json函数的一种快捷方式，返回业务成功，成功数据data可选，成功码success_code可选
     */
    protected function _success($data = [], $msg = "", $code = ErrorCode::SUCCESS)
    {
        return $this->_json($code, $msg, $data);
    }

    /**
     * @param $msg
     * @param $data
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     *
     * json函数的一种快捷方式，返回业务失败，接受错误消息error_msg、错误码error_code
     *
     */
    protected function _error($code, $msg = "", $data = [])
    {
        if(!$msg){
            $msg = app(Lang::class)->show($code);
        }
        return $this->_json($code, $msg, $data);
    }


}