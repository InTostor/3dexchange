<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/Realization.php");
require_once("$ROOT/resources/php/classes/Part.php");
$pid = $_GET['pid'];
$rid = $_GET['rid'];
$rel = new Realization();
$rel->is_realization_of=$pid;
$rel->id = $rid;
$rel->getDocumentBrowser();

$pName = Part::convertIdToName($pid);
$title = "3DE | файлы реализации ".$pName;
?>

<title><?=$title?></title>