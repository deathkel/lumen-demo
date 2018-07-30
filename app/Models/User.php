<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    CONST TEST_YES = 1;
    CONST TEST_NO = 0;

    CONST MEMBER_YES = 1;
    CONST MEMBER_NO = 0;

    protected $table = 'users';

    protected $fillable = [
        'nickname', 'mobile', 'sex', 'mobile', 'city', 'province', 'country', 'avatar', 'openid'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];


}