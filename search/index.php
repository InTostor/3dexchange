<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";
require "$ROOT/resources/php/search.php";

$query = $_GET['q'];
echo "запрос: $query";
getRels($query);
getParts($query);
getUsers($query);

?>