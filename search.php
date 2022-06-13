<?php
require "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$api_key = $_ENV['API_KEY'];
$res = Api\Restaurant::getAll($_GET, $api_key);
print_r($res);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="assets/uikit-3.14.3/uikit.min.css">
</head>

<body>
</body>

</html>