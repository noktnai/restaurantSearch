<?php
require "src/api.php";
$res = (new Restaurant())->getAll($_GET);
if (!$res) {
    include("404.html");
    exit();
}
print_r($res);
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
    <div class="uk-background-secondary uk-position-fixed uk-position-top uk-position-z-index">
        <div class="uk-width-5-6 uk-width-3-4@l uk-margin-auto uk-flex uk-flex-between uk-flex-middle">
            <a href="/" class="uk-link-heading" style="color:white;">RestaurantSearch</a>
            <ul class="uk-subnav uk-subnav-divider" uk-margin>
                <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: bookmark; ratio: 0.8"></span><span class="uk-visible@s">保存済みリスト</span></a></li>
                <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: info; ratio: 0.8"></span><span class="uk-visible@s">このサイトについて</span></a></li>
            </ul>
        </div>
    </div>
</body>

</html>