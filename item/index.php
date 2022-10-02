<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";

if (isset($_GET['add'])){
    include "add.php";
}elseif (isset($_GET['view']) and isset($_GET['id'])){
    include "view.php";
}else{
    raiseHttpError(404);
    die();
}


?>