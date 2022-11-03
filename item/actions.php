<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
if (!User::isLogged()){
    raiseHttpError(401);
    die();
}
$message="";

require_once("$ROOT/resources/php/classes/File.php");
require_once("$ROOT/resources/php/classes/Part.php");
require_once("$ROOT/resources/php/classes/Validator.php");
$original_manufacturer = null;
$original_name = null;
$original_cost = null;
$original_material = null;
$original_made_for = null;
$fully_compatible_for = null;
$partly_compatible_for = null;
$title="";


if ($mode=="edit"){
echo "редактирование детали с id=$pid<br>";
$pName = Part::convertIdToName($pid);
$title = "3DE | редактирование ".$pName;
$part = new Part();
$part->constructWithId($pid);
$original_manufacturer = $part->getOriginalManufacturer();
$original_name = $part->getOriginalName();
$original_cost = $part->getOriginalCost();
$original_material = $part->getOriginalMaterial();
$original_made_for = $part->getOriginalmadeFor();
$fully_compatible_for = $part->getFullyCompatibleWith();
$partly_compatible_for = $part->getPartlyCompatibleWith();
$tags = $part->getTags();
$category = $part->getCategory();
echo "<a href='".$part->getViewUrl()."'>просмотр</a>";
}elseif($mode=="create"){
    echo "создание детали";
    $part = new Part();
}

if (isset($_POST['confirm_value_change'])){
    if($mode=="edit"){
    Database::executeStmt(
    "update parts set original_manufacturer=?, original_name=?, original_cost=?, original_material=?, original_made_for=?, fully_compatible_with=?, partly_compatible_with=?, tags=?, category=? WHERE idparts=?",
    "ssssssssss",
    [
    $_POST['original_manufacturer'],
    $_POST['original_name'],
    $_POST['original_cost'],
    $_POST['original_material'],
    $_POST['original_made_for'],
    $_POST['fully_compatible_for'],
    $_POST['partly_compatible_for'],
    $_POST['tags'],
    $_POST['category'],
    $part->id
    ]
    );
    header('Location: '.$_SERVER['REQUEST_URI']);
    }elseif($mode=="create"){
        $part->first_author = User::convertUsernameToId(getLoggedAs());
        $part->original_manufacturer = $_POST['original_manufacturer'];
        $part->original_name = $_POST['original_name'];
        $part->original_cost = $_POST['original_cost'];
        $part->original_material = $_POST['original_material'];
        $part->original_made_for = $_POST['original_made_for'];
        $part->fully_compatible_with = $_POST['fully_compatible_for'];
        $part->partly_compatible_with = $_POST['partly_compatible_for'];
        $part->tags =  $_POST['tags'];
        $part->category = $_POST['category'];
        $part->register();
        header('Location: '.$part->geteditUrl());
    }


}
if ($mode =="edit"){
    if (isset($_POST['submit_docs_adding'])){

        foreach ($_FILES['docs']['tmp_name'] as $id => $tFile){
            $name=$_FILES['docs']['name'][$id];
            $npath = $part->getDocumentsFolder(true)."/".$name;
            File::moveAndRenameFile($tFile,$npath);
        }
    }

    if (isset($_POST['deleteImage'])){
        $part->deleteImage($_POST['img']);
    }
    if (isset($_POST['deleteDoc'])){
        $part->deleteDocument($_POST['doc']);
    }
    $docsList=$part->getDocumentsList();
    $imgsList=$part->getImagesList();
    
    File::cleanTempShit("$ROOT/item");
}


?>
<title><?=$title?></title>

<style>
form{
    width:50%;
    padding:5px;
    border: 1px gray solid;
}
.file{
    margin:0 auto 0 0;
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
<p>категория<select name = "category" id="category">
<?php
$seled=false;
$cats = Part::getCategoriesList();
foreach ($cats as $cat){
    $val = $cat['val'];
    $cdesc = $cat['desc'];
    if ($mode=='edit'){
    $pCat = $part->getCategory();
    }else{
        $pCat="none";
    }
    if ($pCat == $val and !$seled){
        $selected='selected';
        $seled=true;
    }else{
        $selected='';
    }
    echo "<option $selected value='$val'>$cdesc ";
}
?>
</select></p>
<input  type="submit" name="confirm_value_change" value="ок">
</form>

<div>


<?php
if ($mode=="edit"){

echo "<h3>Документы</h3>";
foreach ($docsList as $doc){
    $url = $part->getDocumentsFolder()."/".$doc;
    echo "
    <form class='file' action='' method='post'> <input type='submit' name='deleteDoc' value=X> <input type='hidden'name='doc' value=$doc>
    <button><a href=$url>открыть</a></button> 
    <button><a href=''download=$url target='_blank'>скачать</a></button>  ".
    $doc.
    "</form>";

}
echo '
</div>
<form action="" method="post" id="add_docs" enctype="multipart/form-data">
    <input type="file" name="docs[]" multiple="multiple">
    <input type="submit" name="submit_docs_adding" value="добавить файлы">
</form>
<div>
';
    



echo "<h3>Изображения</h3>";
foreach ($imgsList as $id=>$img){
    $url = $part->getImagesFolder()."/".$img;
    echo "
    <form class='file' action='' method='post'> <input type='submit' name='deleteImage' value=X> <input type='hidden'name='img' value=$img>
    <button><a href=$url>открыть</a></button> 
    <button><a href=''download=$url target='_blank'>скачать</a></button>  ".
    $img.
    "</form>";
}

if (isset($_POST['submit_image_adding'])){

// ! not good solution with goto
    foreach ($_FILES['images']['tmp_name'] as $id => $tFile){
        if (sizeof($part->getImagesList())>config::get('part_image_count')){
            goto end_of_image_processing;
        }
        $name=$_FILES['images']['name'][$id];
        if (preg_match('/image/m',$_FILES['images']['type'][$id])){
            if (File::fileSize($tFile)<config::get('part_image_max_size')){            
                $npath = $part->getimagesFolder(true)."/".$name;
                File::moveAndRenameFile($tFile,$npath);
                $message = " был добавлен";
            }else{
                $message = " не был добавлен, так как Файл слишком большой. Максимальный размер файла - ".config::get('part_image_max_size')/1024 ." MB";
            }
        }else{
            $message=" не был добавлен, так-как он не является изображением";
        }
        echo "$name $message <br>";
    }
    end_of_image_processing:
    echo "превышен лимит количества файлов";
}


    echo '
    <form  action="" method="post" id="add_imgs" enctype="multipart/form-data">
    <input type="file" accept="image/*" name="images[]" multiple="multiple">
    <input type="submit" name="submit_image_adding" value="добавить файлы">
    </form>
    </div>
';


}
?>

