<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once "$ROOT/settings/settings.php";
require_once "$ROOT/resources/php/common.php";
require_once "$ROOT/resources/php/classes/User.php";

session_set_cookie_params(0);
session_start();
if (isset($_SESSION['ClassUser'])){
$usr = $_SESSION['ClassUser'];
}else{
    $usr = new User();
}

if ( isset($_GET['add']) ){    
    if ($usr->checkPermission('part.create')){
        $mode="create";
        include "actions.php";
    }else{
        echo "no permission";
    }
}elseif ( isset($_GET['view']) and isset($_GET['id']) ){
    if ($usr->checkPermission('part.view')){
        $pid = $_GET['id'];
        $mode="view";
        include "view.php";
    }else{
        echo "no permission";
    }
}elseif ( isset($_GET['edit']) and isset($_GET['id']) ){
    if ($usr->checkPermission('part.edit')){
        $pid = $_GET['id'];
        $mode="edit";
        include "actions.php";
    }else{

    }
}elseif ( isset($_GET['browse']) and isset($_GET['id']) ){

    $pid = $_GET['id'];
    $mode="edit";
    include "browse.php";
}else{
    raiseHttpError(404);
    die();
}


?>