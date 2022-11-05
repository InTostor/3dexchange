<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/resources/php/classes/Realization.php");
require_once("$ROOT/resources/php/classes/Validator.php");
require_once("$ROOT/resources/php/classes/Settings.php");

$pid = $_GET['pid'];
$rid = $_GET['rid'];

if ($rid=="new"){
    $mode="create";
}else{
    $mode="edit";
}

$message="";

$rel = new Realization();
$rName="";
$rDescription="";

if ($mode == "create"){
echo "создание реализации для детали с id $pid";
$title =  "3DE | создание реализации";
    if (isset($_POST['submit_values_change'])){
        $rel->author= User::convertUsernameToId(User::getLoggedAs());
        $rel->make_date=time();
        $rel->name = $_POST['name'];
        $rel->description = $_POST['description'];
        $rel->is_realization_of=$pid;
        $rel->register();
        $edit_url=$rel->geteditUrl();
        header("location: $edit_url");
    }

}elseif($mode=="edit"){
    $title =  "3DE | редактирование реализации";
    echo "редактирование реализации id $rid для детали с id $pid<br>";
    echo "<a href=\"item?view&id=$pid\" >вернуться</a>";
    $rel->constructWithId($rid);
    $rel->is_realization_of = $pid;
    $rName=$rel->getName();
    $rDescription = $rel->getDescription();
    $filesList=$rel->getFilesList();

    if (isset($_POST['submit_values_change'])){
        $rel->updateDescription(Validator::sanitizeUserInput($_POST['description']));
        $rel->updateEditDate(time());
        $rel->updateName(Validator::sanitizeUserInput($_POST['name']));
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
    if (isset($_POST['change_file'])){
        if (sizeof($filesList) < config::get('realization_file_count')){
            if (File::fileSize($_FILES['archive']['tmp_name'])<config::get('realization_file_max_size')){
                $newFile = $rel->getFolder(true)."/".$_FILES['archive']['name'];
                echo "<pre> $newFile </pre><br>";
                File::moveAndRenameFile($_FILES['archive']['tmp_name'],$newFile);
            }else{
                $message =  "Файл слишком большой. Максимальный размер файла - ".config::get('realization_file_count')/1024 ." MB";
            }
        }else{
            $message =  "превышен лимит на загрузку";
        }
    }
    if (isset($_POST['deleteFile'])){
        $rel->deleteFile($_POST['file']);
    }

    if (isset($_POST['submit_image_change'])){
        $rel->updateImage($_FILES['image']['tmp_name']);
    }


}




File::cleanTempShit("$ROOT/realization");
?>
<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/item/index.css">
    <title><?=$title?></title>
</head>

<body>


<form action="" method="post">
    название<input type="text" name="name" placeholder="название" required value=<?=$rName?>>
    <p>описание<textarea type="text" name="description" placeholder="описание"><?=$rDescription?></textarea></p>
    <input type="submit" name="submit_values_change" value="применить">
</form>


<?php

if ($mode=="edit"){
    
echo '<h3>Файлы</h3>';

$filesList =$rel->getFilesList();
foreach ($filesList as $file){
    $url = $rel->getFolder()."/".$file;
    echo "
    <form class='file' action='' method='post'> <input type='submit' name='deleteFile' value=X> <input type='hidden'name='file' value=$file>
    <button><a href=$url>открыть</a></button> 
    <button><a href=''download=$url target='_blank'>скачать</a></button>  ".
    $file.
    "</form>";

}

echo'
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="archive" required>
    <input type="submit" name="change_file" value="загрузить">
</form>
';
echo "<b>$message</b><br>";
$currImg = $rel->getImageUrl();
echo "
<h3>изображение</h3>
<form class=\"image\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">
<img class=\"currentImagePreview\" width=\"50px\" src = $currImg >
<input type=\"file\" accept=\"image/*\" name=\"image\" required>
<input type=\"submit\" name=\"submit_image_change\" value=\"загрузить\">
</form>
";
}
?>




</body>
</html>