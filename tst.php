<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/settings/settings.php");
require_once("$ROOT/resources/php/common.php");
require_once("$ROOT/settings/settings.php");
require_once("$ROOT/resources/php/classes/Errors.php");
require_once("$ROOT/resources/php/classes/Realization.php");

$rel = new Realization();
$rel->id = 1;
$rel->is_realization_of=1;
$rel->getDocumentBrowser();