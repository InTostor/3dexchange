<?php
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";

if ($_GET==NULL){
    raiseHttpError(400);
    
    die();
}

if ($_GET['rid']=="new"){
    $mode="create";
}else{
    $mode="edit";
}

$rid = $_GET['rid']; # realization id
$pid = $_GET['pid']; # part id


function deleteOldrel_image($file){
    $path_arr=pathinfo($file);
    $fdir = $path_arr['dirname'];
    $fname = $path_arr['filename'];

    if (file_exists($fdir."/".$fname.".png")){unlink($fdir."/".$fname.".png");}
    if (file_exists($fdir."/".$fname.".png")){unlink($fdir."/".$fname.".gif");}
}

function setRealizationImage(){
    global $upload_path;
    $target_dir = "$upload_path/realizations/";
    global $rid;
    
    $target_file = "$target_dir/tmp";
    $extension = ".png";


    $uploadOk = 1;

    deleteOldrel_image($target_dir .$rid.$extension);

    if(exif_imagetype($_FILES['rel_image_file']['tmp_name']) ==  IMAGETYPE_GIF) 
    {
        $extension = ".gif";
        $target_file = $target_dir .$rid.$extension;
    }
    elseif(exif_imagetype($_FILES['rel_image_file']['tmp_name']) ==  IMAGETYPE_JPEG) 
    {
        $target_file = $target_dir .$rid.".png";
        $target_file = imagepng(imagecreatefromjpeg($_FILES['rel_image_file']['tmp_name']), $target_file);
    }
    elseif(exif_imagetype($_FILES['rel_image_file']['tmp_name']) ==  IMAGETYPE_PNG) 
    {
        $extension = ".png";
        $target_file = $target_dir .$rid.$extension;
    }else{
        return "file is not the image";
        $uploadOk = 0;
    }
    

    if ($_FILES["rel_image_file"]["size"] > 500000) {
        return "Sorry, your file is too large.";
        $uploadOk = 0;
      }
      if ($uploadOk==1){

        move_uploaded_file($_FILES["rel_image_file"]['tmp_name'], $target_file);
      }

}

function setRealizationZipFile(){
    global $upload_path;
    $target_dir = "$upload_path/realizations/";
    global $rid;
    global $pid;

    $path_arr=pathinfo($target_dir."$pid-$rid.zip");
    $fdir = $path_arr['dirname'];
    $fname = $path_arr['filename'];
    if (file_exists($fdir."/".$fname.".png")){unlink($fdir."/".$fname.".png");}

    move_uploaded_file($_FILES["rel_image_file"]['tmp_name'], "$target_dir/$pid-$rid.zip");
}

function setRealizationDescription($text){
    global $rid;
    global $pid;
    global $mode;
    $conn=getDBconnection();
    if ($mode=="edit"){
    $stmt = $conn->prepare('UPDATE realizations SET description = ? edit_date = ? WHERE idrealizations=?; ');
    $stmt->bind_param("sis", $text ,time(),$rid);
    }elseif($mode=="create"){

        $stmt = $conn->prepare('INSERT INTO realizations (is_realization_of, name, author, make_date, description) VALUES (?,?,?,?,?); ');
        $usid = getUserIdByUsername(getLoggedAs());
        $time = time();
        $name = "null";
        $stmt->bind_param("isiis",$pid,$name, $usid, $time,$text );
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();
}


if (isset($_POST)){
    
 
    if (isset($_POST["description_md"])){
        setRealizationDescription($_POST["description_md"]);

    }

    if (isset($_POST["rel_image_file"])){
        setRealizationImage();

    }
    if (isset($_POST["rel_zipfile"])){

        setRealizationZipFile();
    
    }

}



if ($is_development){
echo "debug data<br>";
echo "mode: $mode<br>";
echo "part id = $pid<br>";
echo "realization id = $rid<br>";

}

if ($mode=="create"){

    if (!isLogged()){
        raiseHttpError(401);
        die();
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



<form action="" method="post" id="change_rel_image"  enctype="multipart/form-data">
    <p>смена изображения реализации</p>
    <input type="file" accept=".jpeg,.jpg,.png,.gif" name="rel_image_file">
    <input  type="submit" name="rel_image_file" value="применить">
</form>

<form action="" method="post" id="change_rel_zipfile"  enctype="multipart/form-data">
    <p>смена архива с файлами реализации</p>
    <input type="file" accept=".zip" name="rel_image_file">
    <input  type="submit" name="rel_zipfile" value="применить">
</form>

<form action="" method="post" id="change_description">
<p><textarea maxlength="512" type="text" name="description_md" required placeholder="Описание реализации"></textarea></p>
    <input  type="submit" name="confirm" value="применить">
</form>