<?php
require "src/api.php";
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

    <title><?= $res["name"] ?></title>

    <link rel="stylesheet" href="assets/uikit-3.14.3/uikit.min.css">
</head>

<body>
</body>

</html>