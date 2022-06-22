<?php
require "src/restaurant.php";
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
    <script src="assets/list.js"></script>
    <script src="assets/search.js" defer></script>
    <script src="assets/result.js" defer></script>

    <title>レストラン検索App</title>
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
            <input class="uk-search-input" style="font-size:18px;" type="search" name="keyword" placeholder="店名 住所 駅名" value="<?= isset($_GET["keyword"]) ? $_GET["keyword"] : "" ?>">
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
                        <option value="0" <?= !isset($_GET["range"]) ? "selected" : "" ?>>しない</option>
                        <option value="1" <?= isset($_GET["range"]) && $_GET["range"] == 1 ? "selected" : "" ?>>半径300m</option>
                        <option value="2" <?= isset($_GET["range"]) && $_GET["range"] == 2 ? "selected" : "" ?>>半径500m</option>
                        <option value="3" <?= isset($_GET["range"]) && $_GET["range"] == 3 ? "selected" : "" ?>>半径1km</option>
                        <option value="4" <?= isset($_GET["range"]) && $_GET["range"] == 4 ? "selected" : "" ?>>半径2km</option>
                        <option value="5" <?= isset($_GET["range"]) && $_GET["range"] == 5 ? "selected" : "" ?>>半径3km</option>
                    </select>
                </div>
                <span class="uk-label js_location"></span>
            </div>
            <div class="">
                <label class="uk-form-label" for="form-stacked-text">ジャンル</label>
                <div class="uk-form-controls">
                    <?php foreach ($genres as $genre) : ?>
                        <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="genre" value="<?= $genre["name"] ?>" data-code="<?= $genre["code"] ?>" <?= isset($_GET["genre"]) && strpos($_GET["genre"], $genre["code"]) !== false ? "checked" : "" ?>>&nbsp;&nbsp;<?= $genre["name"] ?></label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label">その他条件</div>
                <div class="uk-form-controls">
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" value="駐車場有" data-key="parking" <?= isset($_GET["parking"]) && $_GET["parking"] == 1 ? "checked" : "" ?>>&nbsp;&nbsp;駐車場有</label>
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" value="コース有" data-key="course" <?= isset($_GET["course"]) && $_GET["course"] == 1 ? "checked" : "" ?>>&nbsp;&nbsp;コース有</label>
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" value="食べ放題" data-key="free_food" <?= isset($_GET["free_food"]) && $_GET["free_food"] == 1 ? "checked" : "" ?>>&nbsp;&nbsp;食べ放題</label>
                    <label class="uk-margin-small-right"><input class="uk-checkbox" type="checkbox" name="other" value="飲み放題" data-key="free_drink" <?= isset($_GET["free_drink"]) && $_GET["free_drink"] == 1 ? "checked" : "" ?>>&nbsp;&nbsp;飲み放題</label>
                </div>
            </div>

        </div>
    </div>
    <main class="uk-margin-mediun-top uk-margin-large-bottom uk-width-5-6 uk-width-3-4@l uk-margin-auto">
        <div class="uk-comment-primary uk-padding-small uk-margin-small-top uk-margin-small-bottom uk-border-rounded">
            <h4 class="uk-comment-title uk-margin-small-bottom">
                検索結果&nbsp;<strong><?= $res["results_available"] ?></strong>&nbsp;件<?php if ($res["results_available"] != 0) : ?>中&nbsp;<strong><?= $res["results_start"] . "&nbsp;〜&nbsp;" . ($res["results_start"] + $res["results_returned"] - 1) ?></strong>&nbsp;件表示<?php endif; ?>
            </h4>
            <div class="js_conditions">

            </div>
            <?php if ($res["results_available"] != 0) : ?>
                <div class="uk-flex uk-flex-between">
                    <!-- ページング -->
                    <button class="uk-button uk-button-small uk-button-primary uk-border-rounded <?= ($res["results_start"] != 1) ? "" : "uk-invisible" ?> js_back">前へ</button>
                    <div>
                        <strong class="js_now"><?= ceil($res["results_start"] / 20) ?></strong>&nbsp;&#47;&nbsp;<strong><?= ceil($res["results_available"] / 20) ?></strong>
                    </div>
                    <button class="uk-button uk-button-small uk-button-primary uk-border-rounded <?= ($res["results_start"] + 20 <= $res["results_available"]) ? "" : "uk-invisible" ?> js_next">次へ</button>
                </div>
            <?php endif; ?>
        </div>
        <div class="uk-child-width-1-2@m uk-grid-match" uk-grid>
            <?php foreach ($res["shop"] as $shop) : ?>
                <div>
                    <article class="uk-comment uk-height-1-1 uk-comment-primary uk-border-rounded uk-padding-small" tabindex="-1">
                        <header class="uk-comment-header uk-position-relative">
                            <div class="uk-flex uk-flex-between">
                                <div class="uk-width-5-6 uk-height-small">
                                    <img class="uk-border-rounded uk-height-max-small" src="<?= $shop["photo"]["pc"]["l"] ?>" alt="">
                                </div>
                                <div class="uk-flex-none"><a tabindex="-1" class="js_addlist" data-id="<?= $shop["id"] ?>"><span class="uk-icon-button" uk-icon="icon: star; ratio: 0.8"></span></a></div>
                            </div>
                            <h4 class="uk-comment-title uk-margin-small-bottom"><a href="./show.php?id=<?= $shop["id"] ?>" class="uk-text-decoration-none"><?= $shop["name"] ?></a></h4>
                            <p class="uk-comment-meta uk-margin-remove"><?= $shop["genre"]["catch"] ?></p>
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

        <?php if ($res["results_available"] != 0) : ?>
            <div class="uk-comment-primary uk-padding-small uk-margin-small-top uk-margin-small-bottom uk-border-rounded">
                <div class="uk-flex uk-flex-between">
                    <!-- ページング -->
                    <button class="uk-button uk-button-small uk-button-primary uk-border-rounded <?= ($res["results_start"] != 1) ? "" : "uk-invisible" ?> js_back">前へ</button>
                    <div>
                        <strong><?= ceil($res["results_start"] / 20) ?></strong>&nbsp;&#47;&nbsp;<strong><?= ceil($res["results_available"] / 20) ?></strong>
                    </div>
                    <button class="uk-button uk-button-small uk-button-primary uk-border-rounded <?= ($res["results_start"] + 20 <= $res["results_available"]) ? "" : "uk-invisible" ?> js_next">次へ</button>
                </div>
            </div>
        <?php endif; ?>
    </main>
    <?php if ($res["results_returned"] >= 4) : ?>
        <div class="uk-background-secondary uk-text-center uk-padding-small">
            <a href="#" uk-totop uk-scroll></a>
        </div>
    <?php endif; ?>
</body>

</html>