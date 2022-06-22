<?php
require "src/restaurant.php";
$res = (isset($_GET["id"])) ? (new Restaurant())->get($_GET["id"]) : false;
if (!$res) {
    include("404.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/uikit-3.14.3/uikit.min.css" />
    <script src="assets/uikit-3.14.3/uikit.min.js"></script>
    <script src="assets/uikit-3.14.3/uikit-icons.min.js"></script>
    <script src="assets/jquery-3.6.0.js"></script>
    <script src="assets/list.js"></script>

    <title><?= $res["name"] ?>&#65372;レストラン検索</title>
</head>

<body>
    <div class="uk-position-fixed uk-width-expand uk-position-z-index-negative uk-height-viewport uk-background-cover" style="background-image: url(assets/img/first_view.png);"></div>
    <div class="uk-background-secondary uk-position-z-index" uk-sticky>
        <div class="uk-width-5-6 uk-width-3-4@l uk-margin-auto uk-flex uk-flex-between uk-flex-middle">
            <a href="./" class="uk-link-heading" style="color:white;">RestaurantSearch</a>
            <form action="./list.php" method="post">
                <input type="hidden" name="id">
            </form>
            <ul class="uk-subnav uk-subnav-divider" uk-margin>
                <li><a tabindex="-1" class="js_tolist"><span uk-icon="icon: star; ratio: 0.8"></span><span class="uk-visible@s">検討リスト</span></a></li>
                <li><a href="./description.html"><span uk-icon="icon: info; ratio: 0.8"></span><span class="uk-visible@s">このサイトについて</span></a></li>
            </ul>
        </div>
    </div>
    <main class="uk-margin-mediun-top uk-width-5-6@s uk-width-3-4@l uk-margin-auto uk-background-secondary">
        <article class="uk-comment uk-comment-primary">
            <div class="uk-flex uk-flex-between">
                <a href="#" onclick="history.back(-1);return false;" class="uk-text-decoration-none"><span uk-icon="icon: chevron-left"></span>戻る</a>
            </div>
            <hr class="uk-margin-small">
            <header class="uk-comment-header">
                <div class="uk-grid-medium uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <img class="uk-comment-avatar uk-border-rounded" src="<?= $res["photo"]["pc"]["l"] ?>" alt="">
                    </div>
                    <div class="uk-width-expand@s">
                        <a tabindex="-1" class="uk-flex uk-flex-middle uk-text-decoration-none uk-text-muted uk-margin-small-bottom js_addlist" data-id="<?= $res["id"] ?>"><span uk-icon="icon: star; ratio: 0.8"></span><strong class="uk-margin-small-left">検討リストに追加</strong></a>
                        <span class="uk-label"><?= $res["station_name"] ?>駅</span>
                        <span class="uk-label"><?= $res["genre"]["name"] ?></span>
                        <span class="uk-label"><?= isset($res["sub_genre"]["name"]) ? $res["sub_genre"]["name"] : "" ?></span>
                        <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#"><?= $res["name"] ?></a></h4>
                        <p class="uk-comment-meta uk-margin-remove"><?= $res["genre"]["catch"] ?></p>
                        <p class="uk-comment-meta uk-margin-remove"><a href="<?= $res["urls"]["pc"] ?>" target="_blank" class="uk-text-decoration-none">ホットペッパーグルメで閲覧する</a></p>
                    </div>
                </div>
            </header>
            <div class="uk-comment-body" uk-grid>
                <div>
                    <dl class="uk-description-list uk-margin-remove">
                        <dt>住所</dt>
                        <dd><?= $res["address"] ?></dd>
                        <dt>アクセス</dt>
                        <dd><?= $res["access"] ?></dd>
                        <dt>最寄駅</dt>
                        <dd><?= $res["station_name"] ?>駅</dd>
                        <dt>営業日</dt>
                        <dd><?= $res["open"] ?></dd>
                        <dt>定休日</dt>
                        <dd><?= $res["close"] ?></dd>
                        <dt>駐車場</dt>
                        <dd><?= $res["parking"] ?></dd>
                        <dt>総席数</dt>
                        <dd><?= $res["capacity"] ?></dd>
                    </dl>
                </div>
                <div>
                    <table class="uk-table uk-table-small">
                        <caption>その他詳細</caption>
                        <tbody>
                            <tr>
                                <td class="uk-table-expand">ランチ</td>
                                <td class="uk-table-expand"><?= $res["lunch"] ?></td>
                            </tr>
                            <tr>
                                <td>コース</td>
                                <td><?= $res["course"] ?></td>
                            </tr>
                            <tr>
                                <td>食べ放題</td>
                                <td><?= $res["course"] ?></td>
                            </tr>
                            <tr>
                                <td>飲み放題</td>
                                <td><?= $res["course"] ?></td>
                            </tr>
                            <tr>
                                <td>個室</td>
                                <td><?= $res["private_room"] ?></td>
                            </tr>
                            <tr>
                                <td>掘りごたつ</td>
                                <td><?= $res["horigotatsu"] ?></td>
                            </tr>
                            <tr>
                                <td>座敷</td>
                                <td><?= $res["tatami"] ?></td>
                            </tr>
                            <tr>
                                <td>カード</td>
                                <td><?= $res["card"] ?></td>
                            </tr>
                            <tr>
                                <td>喫煙席</td>
                                <td><?= $res["non_smoking"] ?></td>
                            </tr>
                            <tr>
                                <td>貸切</td>
                                <td><?= $res["charter"] ?></td>
                            </tr>
                            </tr>
                            <tr>
                                <td>設備</td>
                                <td><?= $res["other_memo"] ?></td>
                            </tr>
                            <tr>
                                <td>ペット</td>
                                <td><?= $res["pet"] ?></td>
                            </tr>
                            <tr>
                                <td>wifi</td>
                                <td><?= $res["wifi"] ?></td>
                            </tr>
                            </tr>
                            <tr>
                                <td>備考</td>
                                <td><?= $res["shop_detail_memo"] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
        </div>
    </main>
</body>

</html>