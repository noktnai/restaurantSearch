<?php
require "src/api.php";
$res = (new Restaurant())->getGenre();
if (!$res) {
    include("404.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

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
    <div class="uk-background-secondary uk-position-fixed uk-position-top uk-position-z-index">
        <div class="uk-width-5-6 uk-width-3-4@l uk-margin-auto uk-flex uk-flex-between uk-flex-middle">
            <a href="/" class="uk-link-heading" style="color:white;">RestaurantSearch</a>
            <ul class="uk-subnav uk-subnav-divider" uk-margin>
                <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: bookmark; ratio: 0.8"></span><span class="uk-visible@s">保存済みリスト</span></a></li>
                <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: info; ratio: 0.8"></span><span class="uk-visible@s">このサイトについて</span></a></li>
            </ul>
        </div>
    </div>
    <form id="Search" action="search.php" method="get" onsubmit="return false;">
        <div class="uk-flex uk-flex-column uk-flex-center uk-flex-middle uk-position-fixed uk-width-expand uk-height-viewport uk-background-cover" data-src="assets/img/first_view.png" uk-img>
            <div>
                <h1 class="uk-h1" style="color:white;">レストラン検索</h1>
            </div>
            <div class="uk-flex uk-border-rounded uk-overflow-hidden uk-width-5-6 uk-width-3-5@s uk-width-2-5@l">
                <a class="uk-light uk-flex uk-flex-middle uk-background-secondary uk-link-text" style="color:white;" uk-toggle="target: #modal-center">
                    <span class="uk-margin-small-right uk-margin-small-left" uk-icon="icon: settings; ratio: 1.1"></span>
                </a>
                <div class="uk-search uk-search-navbar uk-background-default uk-flex-1 uk-flex uk-flex-middle">
                    <span class="uk-form-icon" uk-search-icon="ratio: 0.8"></span>
                    <input class="uk-search-input" style="font-size:18px;" type="search" name="keyword" placeholder="店名 住所 駅名">
                </div>
                <input type="button" class="uk-button uk-button-primary uk-button-small" value="検索" onclick="submit();">
            </div>
        </div>
        <div id="modal-center" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-border-rounded">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">現在地の取得</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="form-stacked-select">
                            <option value="0" checked>しない</option>
                            <option value="1">半径300m</option>
                            <option value="2">半径500m</option>
                            <option value="3">半径1km</option>
                            <option value="4">半径2km</option>
                            <option value="5">半径3km</option>
                        </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">ジャンル</label>
                    <div class="uk-form-controls">
                        <?php foreach ($res as $genre) : ?>
                            <label class="uk-margin-small-right"><input class="uk-checkbox" data-code="<?= $genre["code"] ?>" type="checkbox">&nbsp;&nbsp;<?= $genre["name"] ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-form-label">その他条件</div>
                    <div class="uk-form-controls">
                        <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox">&nbsp;&nbsp;駐車場有</label>
                        <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox">&nbsp;&nbsp;コース有</label>
                        <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox">&nbsp;&nbsp;食べ放題</label>
                        <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox">&nbsp;&nbsp;飲み放題</label>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <!--
    <div class="uk-width-5-6 uk-width-3-5@s uk-margin-auto uk-margin-medium-top">
        <form action="search.php" method="get">
            <input type="text" name="keyword" class="uk-input uk-border-rounded" value="azica">
            <input type="text" name="range" class="uk-input" id="" value="5">
            <input type="text" name="start" class="uk-input" id="" value="2">
            <input type="text" name="lat" class="uk-input" id="" value="35.0353722">
            <input type="text" name="lng" class="uk-input" id="" value="135.9821589">
            <select class="uk-select">
                <option></option>
                <option></option>
            </select>
            <textarea class="uk-textarea"></textarea>
            <input class="uk-radio" type="radio">
            <input class="uk-checkbox" type="checkbox">
            <input class="uk-range" type="range" min="1" max="5" step="1">
            <input type="submit" value="submit" class="uk-button">
        </form>
    </div>-->
</body>

</html>