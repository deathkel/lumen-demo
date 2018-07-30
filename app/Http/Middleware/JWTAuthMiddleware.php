<?php
/**
 * Created by PhpStorm.
 * User: kel
 * Date: 2017/9/21
 * Time: 下午6:31
 */

namespace App\Http\Middleware;

use App\Codes\LogType;
use App\Http\Traits\JsonOutputTrait;
use App\Lib\Constants\ErrorCode;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use PHPUnit\Framework\Error\Error;

class JWTAuthMiddleware
{
    use JsonOutputTrait;

    const JWT_IN_BODY_NAME = 'bearer_token';

    public function handle(Request $request, Closure $next)
    {
        $simulateUserId = $request->header('whosyourdaddy') ?: $request->get('whosyourdaddy', null);
        if ($simulateUserId && config('app.debug')) {
            //如果是模拟登陆, 跳过jwt认证
            $user = User::find($simulateUserId);
            if (!$user) return $this->_error(ErrorCode::FAIL, '用户不存在');
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
            //删除模拟参数
            $request->query->remove('whosyourdaddy');
            return $next($request);
        }

        $bearerToken = $this->_getJWTToken($request);
        if (!$bearerToken) {
            return $this->_error(ErrorCode::TOKEN_ABSENT);
        }
        $signer = new Sha256();
        $secret = config('jwt.secret');
        try {
            $token = (new Parser())->parse((string)$bearerToken);
        } catch (\Throwable $throwable) {
            save_log($throwable->getMessage(), '', LogType::JWT);
            return $this->_error(ErrorCode::TOKEN_INVALID);
        }
        //签名验证
        if (!$token->verify($signer, $secret)) {
            return $this->_error(ErrorCode::TOKEN_INVALID);
        }

        //是否过期
        if ($token->isExpired()) {
            return $this->_error(ErrorCode::TOKEN_EXPIRED);
        }

        //获取请求用户
        $uid = $token->getClaim('uid');
        $authInfo = $token->getClaim('auth_info');
        if (!$authInfo) {
            return $this->_error(ErrorCode::TOKEN_USER_NOT_FOUND);
        }

        $request->setUserResolver(function () use ($authInfo) {
            return $authInfo;
        });

        return $next($request);
    }

    protected function _getJWTToken(Request $request)
    {
        $token = $request->header('Authorization') ?: $request->input(self::JWT_IN_BODY_NAME);
        if (!$token) {
            return null;
        }
        $authType = substr($token, 0, 7);
        if ($authType == 'Bearer ' || $authType == 'bearer ') {
            $token = substr($token, 7);
        }
        return $token;
    }
}