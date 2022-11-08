<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/settings/settings.php");
require_once("$ROOT/resources/php/common.php");
require_once("$ROOT/settings/settings.php");
require_once("$ROOT/resources/php/classes/Errors.php");
require_once("$ROOT/resources/php/classes/Realization.php");

$usr = new User();
$usr->consturctWithCurrentLogin();
echo "<pre>";
echo var_dump($usr->checkCredentials('InTostor','Cummunism','raw'));
echo "</pre>";
