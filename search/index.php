<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";
require "$ROOT/resources/php/search.php";
$title = "3DE | ";
if (isset($_GET['q'])){
    $title .= $_GET['q'];
}
?>

<!DOCTYPE HTML>
<html lang="ru">
<body>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/item/index.css">
    <title><?=$title?></title>
    <meta name="description" content='Поиск деталей, реализаций и пользователей по запросу: "<?=$query?>"  '>
</head>

<?php
if (isset($_GET['q'])){
    $query = $_GET['q'];
    echo "запрос: $query";
    getRels($query);
    getParts($query);
    getUsers($query);
    $title = "3DE | поиск: $query";
}elseif(isset($_GET['category'])){
    $query = $_GET['category'];
    getParts($query);
}
?>








</body>
</html>