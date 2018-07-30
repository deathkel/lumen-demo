<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/30 下午4:27
 */

namespace App\Services;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;


class JWTService
{

    /**
     * 创建jwt
     * @param int $uid 用户id
     * @param array $authInfo 用户信息
     * @return Token
     */
    public static function create($uid, $authInfo)
    {
        $domain = config('app.domain');
        $secret = config('jwt.secret');
        $signer = new Sha256();

        $token = (new Builder())->setIssuer($domain)// Configures the issuer (iss claim)
        ->setAudience($domain)// Configures the audience (aud claim)
        ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
        ->setNotBefore(time())// Configures the time that the token can be used (nbf claim)
        ->setExpiration(time() + 3600)// Configures the expiration time of the token (exp claim)
        ->set('uid', $uid)// Configures a new claim, called "uid"
        ->set('auth_info', $authInfo)
        ->sign($signer, $secret)// creates a signature
        ->getToken(); // Retrieves the generated token

        return $token;

    }

}
