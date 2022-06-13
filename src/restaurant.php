<?php

namespace Api;

class Restaurant
{
    protected static $request_url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/";
    /**
     * 任意のパラメータからレストランの一覧を取得
     *
     * @param array $params
     * @param string $api_key
     * @return string
     */
    public static function getAll($params, $api_key)
    {
        $url = static::$request_url . "?key=" . $api_key . static::paramsToString($params) . "&format=json";
        $conn = curl_init();
        // リクエスト先urlをセット
        curl_setopt($conn, CURLOPT_URL, $url);
        // リクエストを実行
        $res = curl_exec($conn);
        // セッションを閉じる
        curl_close($conn);
        return $res;
    }

    /**
     * 任意のパラメータを文字列に変換
     *
     * @param array $params
     * @return string
     */
    protected static function paramsToString($params): string
    {
        $string_params = "";
        foreach ($params as $key => $value) {
            $string_params .= "&" . $key . "=" . $value;
        }
        return $string_params;
    }
}
