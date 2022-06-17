<?php
require "src/api.php";
// ジャンルの取得
$genres = (new Restaurant())->getGenre();
if (!$genres) {
    include("404.html");
    exit();
}
$res = (new Restaurant())->getAll($_GET);
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
    <script src="assets/index.js"></script>

    <title>レストラン検索App</title>
</head>

<body>
    <div class="uk-position-fixed uk-width-expand uk-position-z-index-negative uk-height-viewport uk-background-cover" style="background-image: url(assets/img/first_view.png);"></div>
    <div class="uk-background-secondary uk-position-z-index" uk-sticky>
        <div class="uk-width-5-6 uk-width-3-4@l uk-margin-auto uk-flex uk-flex-between uk-flex-middle">
            <a href="/" class="uk-link-heading" style="color:white;">RestaurantSearch</a>
            <ul class="uk-subnav uk-subnav-divider" uk-margin>
                <li><a href="#"><span uk-icon="icon: bookmark; ratio:0.8"></span><span class="uk-visible@s">保存済みリスト</span></a></li>
                <li><a href="#"><span uk-icon="icon: info; ratio: 0.8"></span><span class="uk-visible@s">このサイトについて</span></a></li>
            </ul>
        </div>
    </div>
    <div class="uk-flex uk-border-rounded uk-overflow-hidden uk-width-5-6 uk-width-3-5@s uk-width-2-5@l uk-margin-auto uk-margin-large-top">
        <a class="uk-light uk-flex uk-flex-middle uk-background-secondary uk-link-text" style="color:white;" uk-toggle="target: #modal-center">
            <span class="uk-margin-small-right uk-margin-small-left" uk-icon="icon: settings; ratio: 1.1"></span>
        </a>
        <div class="uk-search uk-search-navbar uk-background-default uk-flex-1 uk-flex uk-flex-middle">
            <span class="uk-form-icon" uk-search-icon="ratio: 0.8"></span>
            <input class="uk-search-input" style="font-size:18px;" type="search" name="keyword" placeholder="店名 住所 駅名">
        </div>
        <input type="button" name="send" class="uk-button uk-button-primary uk-button-small" value="検索">
    </div>
    <!-- 絞り込み -->
    <div id="modal-center" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-border-rounded">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title">絞り込み</h2>
            <div class="">
                <label class="uk-form-label" for="form-stacked-select">現在地の取得</label>
                <div class="uk-form-controls">
                    <select id="form-stacked-select" class="uk-select" name="range">
                        <option value="0" selected>しない</option>
                        <option value="1">半径300m</option>
                        <option value="2">半径500m</option>
                        <option value="3">半径1km</option>
                        <option value="4">半径2km</option>
                        <option value="5">半径3km</option>
                    </select>
                </div>
                <span class="uk-label js_location"></span>
            </div>
            <div class="">
                <label class="uk-form-label" for="form-stacked-text">ジャンル</label>
                <div class="uk-form-controls">
                    <?php foreach ($genres as $genre) : ?>
                        <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="genre" data-code="<?= $genre["code"] ?>">&nbsp;&nbsp;<?= $genre["name"] ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label">その他条件</div>
                <div class="uk-form-controls">
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" data-key="parking">&nbsp;&nbsp;駐車場有</label>
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" data-key="course">&nbsp;&nbsp;コース有</label>
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" data-key="free_food">&nbsp;&nbsp;食べ放題</label>
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" data-key="free_drink">&nbsp;&nbsp;飲み放題</label>
                </div>
            </div>

        </div>
    </div>
    <main class="uk-margin-large-top uk-width-5-6 uk-width-3-4@l uk-margin-auto">
        <div class="uk-child-width-1-2@m uk-grid-match" uk-grid>
            <?php foreach ($res["shop"] as $shop) : ?>
                <div>
                    <article class="uk-comment uk-height-1-1 uk-comment-primary uk-visible-toggle uk-border-rounded uk-padding-small" tabindex="-1">
                        <header class="uk-comment-header uk-position-relative">
                            <div class="uk-grid-medium uk-flex-middle" uk-grid>
                                <div class="uk-width-auto">
                                    <div class="uk-overflow-hidden uk-border-rounded" style="height: 192px">
                                        <img class="uk-comment-avatar uk-width-expand uk-border-rounded" src="<?= $shop["photo"]["pc"]["l"] ?>" alt="">
                                    </div>
                                </div>
                                <div class="uk-width-auto">
                                    <h4 class="uk-comment-title uk-margin-small-bottom"><a href="" class=""><?= $shop["name"] ?></a></h4>
                                    <p class="uk-comment-meta uk-margin-remove"><?= $shop["genre"]["catch"] ?></p>
                                </div>
                            </div>
                            <div class="uk-position-top-right"><span uk-icon="icon: star"></span></div>
                        </header>
                        <div class="uk-comment-body">
                            <dl class="uk-description-list uk-margin-remove">
                                <dt>アクセス</dt>
                                <dd><?= $shop["access"] ?></dd>
                                <dt>営業日</dt>
                                <dd><?= $shop["open"] ?></dd>
                                <dt>定休日</dt>
                                <dd><?= $shop["close"] ?></dd>
                            </dl>
                            <hr class="uk-margin-small">
                            <span class="uk-label"><?= $shop["large_area"]["name"] ?></span>
                            <span class="uk-label"><?= $shop["small_area"]["name"] ?></span>
                            <span class="uk-label"><?= $shop["genre"]["name"] ?></span>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

</body>

</html>