<?php

namespace App\Http\Controllers;

use App\Http\Traits\JsonOutputTrait;
use Illuminate\Support\Facades\Input;
use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller{
    use JsonOutputTrait;

    const DEFAULT_PAGE_SIZE = 10;

    protected function _getPage(){
        $page_size = Input::get('page');
        return $page_size ? $page_size : 1;
    }

    protected function _getPageSize()
    {
        $page_size = Input::get('page_size');
        return $page_size ? $page_size : self::DEFAULT_PAGE_SIZE;
    }
}