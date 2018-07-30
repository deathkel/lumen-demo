<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/29 下午1:58
 */

namespace App\Http\Controllers;


use App\Lib\Constants\ErrorCode;
use App\Services\JWTService;
use App\Services\UserService;
use EasyWeChat\MiniProgram\Application;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends BaseController
{
    /**
     * @apiTest
     * @param string code 授权js-code，通过wx.login获取
     * @param string encrypted_data 通过wx.getUserInfo获取
     * @param string iv 通过wx.getUserInfo获取
     * @说明
     * 微信小程序登录
     * 先调用 wx.login 然后调用 wx.getUserInfo 获取以上3个信息
     * 微信文档：
     * https://developers.weixin.qq.com/miniprogram/dev/api/api-login.html#wxloginobject
     * https://developers.weixin.qq.com/miniprogram/dev/api/open.html#wxgetuserinfoobject
     *
     * @返回格式
     * jwt: json web token,调用其他接口时在Header中添加 Authorization: Bearer {jwt}
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxMiniProgramLogin(Request $request, Application $app, UserService $userService)
    {
        $code = $request->input('code');
        $data = $request->input('encrypted_data');
        $iV = $request->header('iv');
        if (!$code) {
            return $this->_error(ErrorCode::API_PARAM_ERROR);
        }
        $info = $app->auth->session($code);
        $decryptData = \openssl_decrypt(
            base64_decode($data),
            'AES-128-CBC',
            base64_decode($info['session_key']),
            OPENSSL_RAW_DATA,
            base64_decode($iV));

        $userOriginalInfo = json_decode($decryptData, JSON_OBJECT_AS_ARRAY);

        $info = $userService->getOne($info['openid']);
        if(!$info){
            $info = $userService->create($userOriginalInfo);
            if(!$info){
                return $this->_error(ErrorCode::USER_CREATE_FAIL);
            }
        }

        $token = JWTService::create($info['id'], $info);

        return $this->_success(['jwt'=>(string)$token]);
    }
}
