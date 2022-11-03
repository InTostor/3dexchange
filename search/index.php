<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";
require "$ROOT/resources/php/search.php";

if (isset($_GET['q'])){
    $query = $_GET['q'];
    echo "запрос: $query";
    getRels($query);
    getParts($query);
    getUsers($query);
}elseif(isset($_GET['category'])){
    $query = $_GET['category'];
    getParts($query);
}



?>