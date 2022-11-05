<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";

if (isset($_GET['add'])){
    $mode="create";
    include "actions.php";
}elseif (isset($_GET['view']) and isset($_GET['id'])){
    $pid = $_GET['id'];
    $mode="view";
    include "view.php";
}elseif (isset($_GET['edit']) and isset($_GET['id'])){
    $pid = $_GET['id'];
    $mode="edit";
    include "actions.php";
}elseif (isset($_GET['browse']) and isset($_GET['id'])){
    $pid = $_GET['id'];
    $mode="edit";
    include "browse.php";
}else{
    raiseHttpError(404);
    die();
}


?>