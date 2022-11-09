<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";

$username_given = $_COOKIE["logged_as"];
$password_given = $_COOKIE["logged_with"];

$is_legit = isLegitLogin();

?>
страница аккаунта<br>

вы  <i> <?=$is_legit ? ' легально ' : ' нелегально '?> </i>  вошли в систему как пользователь<br>

<?=$username_given?> <br>

<a href="/account/logout.php">выйти</a><br>
<a href="/">на главную</a><br>
<a href="/user?username=<?=getLoggedAs()?>">на страницу аккаунта</a><br>
<a href="/account/actions.php">Действия</a>