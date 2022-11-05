<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/resources/php/classes/Part.php");
require_once("$ROOT/resources/php/classes/Realization.php");



$pid = $_POST['pid'];
$rid = $_POST['rid'];
$val = $_POST['val'];
$auth_method = $_POST['auth'];



$authorized = false;
$success = false;

$rel = new Realization();
$rel->is_realization_of=$pid;
$rel->id = $rid;
$isRelExists = $rel->isExists();


if ($auth_method=="cookie"){
    $authorized = User::isLegitLogin();
    $userId = User::convertUsernameToId(User::getLoggedAs());
}
if ($auth_method=="credentials"){
    $authorized = User::checkCredentials($_POST['username'],$_POST['password'],"raw");
    $userId = User::convertUsernameToId($_POST['username']);
}
$voted = implode('',Database::executeStmt('SELECT EXISTS(SELECT * FROM realizations_rating where user=? and realization = ?)',"ss",[$userId,$rid])[0]);

if ($authorized and $voted==0 and $isRelExists){
    $rel-> increaseRating($val);
    Database::executeStmt('insert into realizations_rating (user,realization,value) values (?,?,?)',"sss",[$userId,$rid,$val]);
    $success = true;
}

if ($authorized and $voted==1 and $isRelExists){
    $currVal = implode('',Database::executeStmt('select value from realizations_rating where user=? and realization=?',"ss",[$userId,$rid])[0]);
    $rel->decreaseRating($currVal);
    Database::executeStmt('update realizations_rating set value = ? where user=? and realization = ?',"sss",[$val,$userId,$rid]);
    $rel->increaseRating($val);
    $success = true;
}

$new_val = Database::selectField('realizations','rating','idrealizations',$rid);
$success = $success ? 'true' : 'false';
// return json
echo "
{\"success\": $success,\"new_value\":$new_val}
";

/* Requests
through web pages Body pid=1'&'rid=1'&'val=1'&'auth=cookie
with credentials Body pid=1'&'rid=1'&'val=1'&'auth=credentials'&'username=User'&'password=qwerty123

*/