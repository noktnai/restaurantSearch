<?php
require "src/restaurant.php";
if (isset($_POST["id"])) {
    $res = (new Restaurant())->getAll($_POST);
} else {
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
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.14.3/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.14.3/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.14.3/dist/js/uikit-icons.min.js"></script>
    <!-- jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="assets/list.js"></script>

    <title>検討リスト&#65372;レストラン検索</title>
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
    <main class="uk-margin-mediun-top uk-margin-large-bottom uk-width-5-6 uk-width-3-4@l uk-margin-auto">
        <div class="uk-comment-primary uk-padding-small uk-margin-small-top uk-margin-small-bottom uk-border-rounded">
            <h4 class="uk-comment-title uk-margin-remove-bottom">検討リスト（最大10件）</h4>
        </div>
        <?php if ($res && $res["results_returned"] != 0) : ?>
            <div class="uk-child-width-1-2@m uk-grid-match" uk-grid>
                <?php foreach ($res["shop"] as $shop) : ?>
                    <div>
                        <article class="uk-comment uk-height-1-1 uk-comment-primary uk-border-rounded uk-padding-small">
                            <header class="uk-comment-header uk-position-relative">
                                <div class="uk-flex uk-flex-between">
                                    <div class="uk-width-5-6 uk-height-small">
                                        <img class="uk-border-rounded uk-height-max-small" src="<?= $shop["photo"]["pc"]["l"] ?>" alt="">
                                    </div>
                                    <div class="uk-flex-none"><a tabindex="-1" class="js_removelist" data-id="<?= $shop["id"] ?>"><span class="uk-icon-button" uk-icon="icon: trash; ratio: 0.8"></span></a></div>
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
        <?php else : ?>
            <article class="uk-comment uk-comment-primary uk-border-rounded uk-padding-small">
                リストに追加されていません。
            </article>
        <?php endif; ?>
    </main>
    <?php if ($res && $res["results_returned"] >= 4) : ?>
        <div class="uk-background-secondary uk-text-center uk-padding-small">
            <a href="#" uk-totop uk-scroll></a>
        </div>
    <?php endif; ?>
</body>

</html>