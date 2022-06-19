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

    <title><?= $res["name"] ?>&#65372;レストラン検索</title>
</head>

<body>
    <div class="uk-background-secondary uk-position-z-index" uk-sticky>
        <div class="uk-width-5-6 uk-width-3-4@l uk-margin-auto uk-flex uk-flex-between uk-flex-middle">
            <a href="./" class="uk-link-heading" style="color:white;">RestaurantSearch</a>
            <ul class="uk-subnav uk-subnav-divider" uk-margin>
                <li><a href="#"><span uk-icon="icon: star; ratio: 0.8"></span><span class="uk-visible@s">保存済みリスト</span></a></li>
                <li><a href="#"><span uk-icon="icon: info; ratio: 0.8"></span><span class="uk-visible@s">このサイトについて</span></a></li>
            </ul>
        </div>
    </div>
</body>

</html>