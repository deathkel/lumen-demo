<?php
namespace App\Library;

/**
 * Class Curl
 */
class Curl
{
    public static function get($url, $params = [], $options = [], &$responseHeaders = [])
    {
        $timeout = isset($options['timeout']) ? $options['timeout'] : 10;
        $headers = isset($options['headers']) ? $options['headers'] : [];
        if ($params) {
            $queryString = http_build_query($params);
            if (strpos($url, '?') === false) {
                $url .= '?' . $queryString;
            } else {
                $url .= '&' . $queryString;
            }
        }
        $curlHandle = curl_init();
        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_FOLLOWLOCATION => 1,
        ];
        if ($headers) {
            $opts[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($curlHandle, $opts);
        $result = curl_exec($curlHandle);
        $responseHeaders = [];
        $curlInfo = curl_getinfo($curlHandle);
        $responseHeaders['http_code'] = isset($curlInfo['http_code']) ? $curlInfo['http_code'] : null;
        if (empty($responseHeaders['http_code'])) {
            $responseHeaders['curl_erron'] = curl_errno($curlHandle);
            $responseHeaders['curl_error'] = curl_error($curlHandle);
            $responseHeaders['curl_info'] = $curlInfo;
        }
        curl_close($curlHandle);
        return $result;
    }

    public static function post($url, $params, $options = [], &$responseHeaders = [])
    {
        $timeout = isset($options['timeout']) ? $options['timeout'] : 10;
        $connectTimeout = isset($options['connect_timeout']) ? $options['connect_timeout'] : 10;
        $useHttpBuildQuery = isset($options['use_http_build_query']) ? (bool)$options['use_http_build_query'] : false;
        $headers = isset($options['headers']) ? $options['headers'] : array();

        if ($useHttpBuildQuery) {
            $params = http_build_query($params);
        }

        $curlHandle = curl_init();
        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_CONNECTTIMEOUT => $connectTimeout,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params
        ];
        if ($headers) {
            $opts[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt_array($curlHandle, $opts);
        $result = curl_exec($curlHandle);
        $responseHeaders = [];
        $curlInfo = curl_getinfo($curlHandle);
        $responseHeaders['http_code'] = isset($curlInfo['http_code']) ? $curlInfo['http_code'] : null;
        if (empty($responseHeaders['http_code'])) {
            $responseHeaders['curl_erron'] = curl_errno($curlHandle);
            $responseHeaders['curl_error'] = curl_error($curlHandle);
            $responseHeaders['curl_info'] = $curlInfo;
        }
        curl_close($curlHandle);
        return $result;
    }
}