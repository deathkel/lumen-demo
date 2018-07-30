<?php
/**
 * @author: kel <genfaijuw@gmail.com>
 * @version: 1.0
 * @datetime: 2018/4/16 下午5:23
 */

namespace Mt\Tests\Unit;



trait GetOutputTrait
{
    /**
     * 获取return from a protect or private method
     *
     * @param $class
     * @param $method
     * @param $param
     * @return mixed
     */
    public function _callMethodNotAccessible($class, $method, $param)
    {
        if (!is_array($param)) {
            $param = [$param];
        }

        $reflectionClass = new \ReflectionClass($class);
        $reflectionMethod = $reflectionClass->getMethod($method);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs($class, $param);
    }

    /**
     * 获取return from a protect or private static method
     *
     * @param $class
     * @param $method
     * @param $param
     * @return mixed
     */
    public function _callStaticMethodNotAccessible($class, $method, $param)
    {
        if (!is_array($param)) {
            $param = [$param];
        }

        $reflectionClass = new \ReflectionClass($class);
        $reflectionMethod = $reflectionClass->getMethod($method);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs(null, $param);
    }
}
