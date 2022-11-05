<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];

require_once("$ROOT/resources/php/classes/Part.php");
$pid = $_GET['id'];
$part = new Part();
$part->id = $pid;
$part->getDocumentBrowser();

$pName = Part::convertIdToName($pid);
$title = "3DE | файлы реализации ".$pName;
?>

<title><?=$title?></title>