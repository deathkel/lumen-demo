<?php
namespace App\Lib;


/**
 * ID加密解密 主要用于接口id返回和读取
 *
 * @author kel
 */
class IdGenerator
{

    /**
     * @var int 加密因子
     */
    const DEFAULT_ENCRYPT_FACTOR = 1000000;

    protected function __construct($encryptFactor = '0')
    {
        if($encryptFactor) {
            $this->encryptFactor = $encryptFactor;
        }
    }

    /**
     * 加密
     *
     * @param $id
     * @return string
     */
    public static function encrypt($id, $encryptFactor = null)
    {
        if(empty($encryptFactor)){
            $encryptFactor = self::DEFAULT_ENCRYPT_FACTOR;
        }

        return dechex($id + $encryptFactor);
    }

    /**
     * 解密
     * @param $string
     * @return number
     */
    public static function decrypt($string, $encryptFactor = null)
    {
        if(empty($encryptFactor)){
            $encryptFactor = self::DEFAULT_ENCRYPT_FACTOR;
        }

        return hexdec($string) - $encryptFactor;
    }
}