<?php

use function PHPSTORM_META\type;

require __DIR__ . "/../vendor/autoload.php";

abstract class Api
{
    private $api_key;
    private $request_url;
    /** apiキーの設定 */
    abstract function __construct();

    /**
     * 任意のパラメータを文字列に変換
     *
     * @param array $params
     * @return string
     */
    protected function paramsToString($params): string
    {
        $string_params = "";
        foreach ($params as $key => $value) {
            $string_params .= "&" . $key . "=" . $value;
        }
        return $string_params;
    }

    protected function getJson($url)
    {
        $conn = curl_init();
        // リクエスト先urlをセット
        curl_setopt($conn, CURLOPT_URL, $url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
        // リクエストを実行
        $res = curl_exec($conn);
        // セッションを閉じる
        curl_close($conn);
        return json_decode($res, true);
    }
}

class Restaurant extends Api
{
    private $api_key;
    private $request_url = "http://webservice.recruit.co.jp/hotpepper/gourmet/v1/";

    function __construct()
    {
        Dotenv\Dotenv::createImmutable(__DIR__ . "/../")->load();
        $this->api_key = $_ENV['HOTPEPPER_API_KEY'];
    }
    /**
     * 任意のパラメータからレストランの一覧を取得
     *
     * @param array $params
     * @return array|false
     */
    function getAll($params)
    {
        $url = $this->request_url . "?key=" . $this->api_key . parent::paramsToString($params) . "&format=json";
        $array = parent::getJson($url);
        return (array_key_exists("error", $array["results"])) ? false : $array["results"];
    }

    /**
     * 店舗情報の取得（1件）
     *
     * @param string $id
     * @return array|false 詳細情報、なければ（エラー）false
     */
    function get($id)
    {
        $url = $this->request_url . "?key=" . $this->api_key . "&id=" . $id . "&format=json";
        $array = parent::getJson($url);
        if (array_key_exists("results_available", $array["results"]) && $array["results"]["results_available"] === 1) {
            return $array["results"]["shop"][0];
        } else {
            return false;
        }
    }
}
