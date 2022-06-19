<?php

require __DIR__ . "/../vendor/autoload.php";

/**
 * リクルートWEBサービス ホットペッパーグルメ
 * 店舗の一覧、詳細、ジャンルの取得
 * 
 * @link https://webservice.recruit.co.jp/doc/hotpepper/reference.html
 */
class Restaurant
{
    private $api_key;
    private $request_url = "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/";
    private $request_url_genre = "https://webservice.recruit.co.jp/hotpepper/genre/v1/";

    /**
     * apiキーの取得
     */
    function __construct()
    {
        Dotenv\Dotenv::createImmutable(__DIR__ . "/../")->load();
        $this->api_key = $_ENV["HOTPEPPER_API_KEY"];
    }

    /**
     * 任意のパラメータからレストランの一覧を取得-件数20件
     * [results_available][results_start]等取得のため[results]内を返す
     *
     * @param array $params
     * @return array|false
     */
    function getAll($params)
    {
        $query = "";
        $count = 20;
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'p':
                    // ページング処理
                    if (is_numeric($value)) {
                        $start = ($value - 1) * $count + 1;
                        $query .= "&start=" . $start;
                    }
                    break;
                case 'keyword':
                case 'lat':
                case 'lng':
                case 'range':
                case 'genre':
                case 'parking':
                case 'course':
                case 'free_drink':
                case 'free_food':
                    $query .= "&" . $key . "=" . $value;
                    break;
                default:
                    // 許可パラメータ以外は破棄
                    break;
            }
        }
        // 全半角空白を念の為変換
        $query = str_replace("　", "+", str_replace(" ", "+", $query));
        $url = $this->request_url . "?key=" . $this->api_key . $query . "&count=" . $count . "&format=json";
        $array = $this->getJson($url);
        if (is_null($array) || array_key_exists("error", $array["results"]) || $array["results"]["results_start"] > $array["results"]["results_available"]) {
            // null結果,error,無効ページ数によるマッチ数を上回る表示開始位置
            return false;
        }else {
            return $array["results"];
        }
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
        $array = $this->getJson($url);
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
        $array = $this->getJson($url);
        if (!array_key_exists("error", $array["results"])) {
            return $array["results"]["genre"];
        } else {
            return false;
        }
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
