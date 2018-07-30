<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/20 下午2:02
 */

namespace App\Http\Controllers;


use App\Lib\Constants\ErrorCode;
use Illuminate\Http\Request;

class UserController extends BaseController{

    public function info(Request $request){
        $user = $request->user();
        if(!$user){
            return $this->_error(ErrorCode::EMPTY_ACCESS_TOKEN, '未登录');
        }
        return $this->_success($user->toArray());
    }
}
