<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/30 下午3:24
 */

namespace App\Services;


use App\Models\User;

class UserService
{
    public function getOne($openId){
        $info = User::where('openid', $openId)->first();
        if(!$info){
            return null;
        }

        return $info->toArray();
    }


    public function create($params){

        $info = User::create([
            'openid' => $params['openId'],
            'nickname' => $params['nickName'],
            'sex' => $params['gender'],
            'city' => $params['city'],
            'province' => $params['province'],
            'country' => $params['country'],
            'avatar' => $params['avatarUrl']
        ]);

        if(!$info){
            return false;
        }

        return $info->toArray();
    }
}
