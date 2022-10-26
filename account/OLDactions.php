<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";

if (!isLogged()){
    raiseHttpError(401);
    die();
}

function deleteUser(){
    $conn=getDBconnection();
    $stmt = $conn->prepare('DELETE FROM `3dexchange`.`users` WHERE (`username` = "?")');
    $stmt->bind_param("s", getLoggedAs());
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function setUserDescription($text){
    $conn=getDBconnection();
    $stmt = $conn->prepare('UPDATE users SET description_md = ? WHERE username=?; ');
    $stmt->bind_param("ss", $text ,getLoggedAs());
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function setUserMood($text){
    $conn=getDBconnection();
    $stmt = $conn->prepare('UPDATE users SET mood = ? WHERE username=?; ');
    $stmt->bind_param("ss", $text ,getLoggedAs());
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function setUserLocation($text){
    $conn=getDBconnection();
    $stmt = $conn->prepare('UPDATE users SET location = ? WHERE username=?; ');
    $stmt->bind_param("ss", $text ,getLoggedAs());
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function deleteOldAvatar($file){
    $path_arr=pathinfo($file);
    $fdir = $path_arr['dirname'];
    $fname = $path_arr['filename'];

    if (file_exists($fdir."/".$fname.".png")){unlink($fdir."/".$fname.".png");}
    if (file_exists($fdir."/".$fname.".png")){unlink($fdir."/".$fname.".gif");}
}

function setUserAvatar(){
    global $upload_path;
    $target_dir = "$upload_path/avatars/";
    $logged_as = getLoggedAs();
    $user_id = getUserIdByUsername($logged_as);
    $target_file = "$target_dir/tmp";
    $extension = ".png";


    $uploadOk = 1;

    deleteOldAvatar($target_dir .$user_id.$extension);

    if(exif_imagetype($_FILES['avatar_file']['tmp_name']) ==  IMAGETYPE_GIF) 
    {
        $extension = ".gif";
        $target_file = $target_dir .$user_id.$extension;
    }
    elseif(exif_imagetype($_FILES['avatar_file']['tmp_name']) ==  IMAGETYPE_JPEG) 
    {
        $target_file = $target_dir .$user_id.".png";
        $target_file = imagepng(imagecreatefromjpeg($_FILES['avatar_file']['tmp_name']), $target_file);
    }
    elseif(exif_imagetype($_FILES['avatar_file']['tmp_name']) ==  IMAGETYPE_PNG) 
    {
        $extension = ".png";
        $target_file = $target_dir .$user_id.$extension;
    }else{
        return "file is not the image";
        $uploadOk = 0;
    }
    

    if ($_FILES["avatar_file"]["size"] > 500000) {
        return "Sorry, your file is too large.";
        $uploadOk = 0;
      }
      if ($uploadOk==1){

        move_uploaded_file($_FILES["avatar_file"]['tmp_name'], $target_file);
      }


}



if (isset($_POST)){
    
 
        if (isset($_POST["description_md"])){
            setUserDescription($_POST["description_md"]);

        }
        if (isset($_POST["mood"])){
            setUserMood($_POST["mood"]);
        }
        if (isset($_POST["location"])){

            setUserLocation($_POST["location"]);
        }
        if (isset($_POST["avatar_file"])){

            setUserAvatar();

        }
    
}






?>

<style>
form{
    width:50%;
    padding:5px;
    border: 1px gray solid;
}


</style>


<form action="" method="post" id="change_description">
<p><textarea maxlength="4096" type="text" name="description_md" required placeholder="Текст на странице аккаунта в формате html"></textarea></p>
    <input  type="submit" name="confirm" value="применить">
</form>

<form action="" method="post" id="change_mood">
<p><textarea maxlength="45" type="text" name="mood" required placeholder="статус на странице аккаунта"></textarea></p>
    <input  type="submit" name="confirm" value="применить">
</form>

<form action="" method="post" id="change_location">
<p><textarea maxlength="45" type="text" name="location" required placeholder="Местоположение"></textarea></p>
    <input  type="submit" name="confirm" value="применить">
</form>

<form action="" method="post" id="change_avatar"  enctype="multipart/form-data">
    <p>смена фото</p>
    <input type="file" accept=".jpeg,.jpg,.png,.gif" name="avatar_file">
    <input  type="submit" name="avatar_file" value="применить">
</form>