<?php
$pid = $_GET['id'];
if (isset($_GET['edit'])){
echo "редактирование детали $pid";
}
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/resources/php/classes/File.php");
require_once("$ROOT/resources/php/classes/Part.php");
require_once("$ROOT/resources/php/classes/Validator.php");

if (!isLogged()){
    raiseHttpError(401);
    die();
}

$part = new Part();
$part->constructWithId($pid);
$original_manufacturer = $part->getOriginalManufacturer();
$original_name = $part->getOriginalName();
$original_cost = $part->getOriginalCost();
$original_material = $part->getOriginalMaterial();
$original_made_for = $part->getOriginalmadeFor();
$fully_compatible_for = $part->getFullyCompatibleWith();
$partly_compatible_for = $part->getPartlyCompatibleWith();

if (isset($_POST['confirm_value_change'])){
    echo getUserIdByUsername(getLoggedAs());
    echo $_POST['original_manufacturer'];
    echo $_POST['original_name'];
    echo $_POST['original_cost'];
    echo $_POST['original_material'];
    echo $_POST['original_made_for'];
    echo $_POST['fully_compatible_for'];
    echo $_POST['partly_compatible_for'];


    Database::executeStmt(
    "update parts set original_manufacturer=?, original_name=?, original_cost=?, original_material=?, original_made_for=?, fully_compatible_with=?, partly_compatible_with=? WHERE idparts=?",
    "ssssssss",
    [
    $_POST['original_manufacturer'],
    $_POST['original_name'],
    $_POST['original_cost'],
    $_POST['original_material'],
    $_POST['original_made_for'],
    $_POST['fully_compatible_for'],
    $_POST['partly_compatible_for'],
    $part->id
    ]
);
header('Location: '.$_SERVER['REQUEST_URI']);
}





?>


<style>
form{
    width:50%;
    padding:5px;
    border: 1px gray solid;
}
</style>


<form action="" method="post" id="edit_part">
<p>----производитель-----<textarea maxlength="45" cols="100" type="text" name="original_manufacturer" required placeholder="Название компании производителя. Например ВАЗ"><?=$original_manufacturer?></textarea></p>
<p>-------название-------<textarea maxlength="45" cols="100" type="text" name="original_name" required placeholder="Оригинальное название детали (как её называет производитель). Например: бачок омывателя"><?=$original_name?></textarea></p>
<p>---------цена---------<textarea maxlength="45" cols="100" type="text" name="original_cost"  placeholder="Оригинальная цена (цена от производителя)"><?=$original_cost?></textarea></p>
<p>-------материал-------<textarea maxlength="45" cols="100" type="text" name="original_material" required placeholder="Материал оригинальной детали. Например ABS или фанера 4мм"><?=$original_material?></textarea></p>
<p>---предназначен для---<textarea maxlength="45" cols="100" type="text" name="original_made_for"  required placeholder="Для чего была предназначена деталь (если несколько вариантов, то они записываются через ; ). Например жигули 2121; жигули 2101; жигули 2106"><?=$original_made_for?></textarea></p>
<p>полностью совместим с-<textarea maxlength="45" cols="100" type="text" name="fully_compatible_for"  placeholder="Для чего эта деталь подходит без изменений (если несколько вариантов, то они записываются через ; ). Например жигули 2102; жигули 2103; жигули 2107"><?=$fully_compatible_for?></textarea></p>
<p>-частично совместим с-<textarea maxlength="45" cols="100" type="text" name="partly_compatible_for"  placeholder="Для чего эта деталь подходит с некоторыми изменениями (если несколько вариантов, то они записываются через ; ). Например УАЗ hunter"><?=$partly_compatible_for?></textarea></p>
<p>-Тэги-<textarea maxlength="45" cols="100" type="text" name="tags"  placeholder="Тэги"><?=$partly_compatible_for?></textarea></p>
    <input  type="submit" name="confirm_value_change" value="создать деталь">
</form>
