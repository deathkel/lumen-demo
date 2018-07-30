<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/7/12 下午4:08
 */

namespace App\Http\Controllers;


use Deathkel\Apitest\ApiReflection;

class ApiTestController extends BaseController
{
    public function index(){
        $apiReflection = new ApiReflection();
        $api = $apiReflection->getApi();

        return view('apitest.index', ['api' => $api]);
    }
}
