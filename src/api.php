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
     * 空白（半角、全角）→+変換
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
        return str_replace("　", "+", str_replace(" ", "+", $string_params));
    }

    /**
     * JSONで取得し、連想配列で返す
     * NULL可能性あり
     *
     * @param string $url
     * @return array
     */
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
/**
 * リクルートWEBサービス ホットペッパーグルメ
 * 店舗の一覧、詳細、ジャンルの取得
 * 
 * @link https://webservice.recruit.co.jp/doc/hotpepper/reference.html
 */
class Restaurant extends Api
{
    private $api_key;
    private $request_url = "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/";
    private $request_url_genre = "https://webservice.recruit.co.jp/hotpepper/genre/v1/";

    function __construct()
    {
        Dotenv\Dotenv::createImmutable(__DIR__ . "/../")->load();
        $this->api_key = $_ENV['HOTPEPPER_API_KEY'];
    }
    /**
     * 任意のパラメータからレストランの一覧を取得
     * [results_available][results_start]等取得のため[results]内を返す
     *
     * @param array $params
     * @return array|false
     */
    function getAll($params)
    {
        $url = $this->request_url . "?key=" . $this->api_key . parent::paramsToString($params) . "&format=json";
        $array = parent::getJson($url);
        return (!is_null($array) && array_key_exists("error", $array["results"])) ? false : $array["results"];
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
        // 念の為、マッチ件数が1件か
        if (!is_null($array) && array_key_exists("results_available", $array["results"]) && $array["results"]["results_available"] === 1) {
            return $array["results"]["shop"][0];
        } else {
            return false;
        }
    }

    /**
     * ジャンルの取得
     *
     * @return array|false
     */
    function getGenre()
    {
        $url = $this->request_url_genre . "?key=" . $this->api_key . "&format=json";
        $array = parent::getJson($url);
        if (!array_key_exists("error", $array["results"])) {
            return $array["results"]["genre"];
        } else {
            return false;
        }
    }
}
