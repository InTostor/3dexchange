<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/settings/settings.php");
require_once("$ROOT/resources/php/common.php");

$usr = new User();
$usr->consturctWithCurrentLogin();
$assoc = $usr->getAssocData();
print_r($assoc);
print_r($usr->id);