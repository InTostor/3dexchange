<?php
// setting environment

getHTMLstuff();

$part_id = $_GET['id'];
if ($part_id==NULL){
    raiseHttpError(404);
    die();
}

$conn = getDBconnection();
$stmt = $conn->prepare("select * from parts where idparts=?;");
$stmt->bind_param("s",$part_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row==NULL){
    raiseHttpError(404);
    die();
}
$stmt->close();
$conn->close();

$part_name = $row['original_manufacturer']." | ".$row['original_name'];
$part_description = "Описание демонстрационной детали. Это описание делается - создателем модели, автором наиболее популярной реализации, администрацией. Должно быть в формате html без js";





$conn = getDBconnection();
$stmt = $conn->prepare("select * from realizations where is_realization_of = ?");
$stmt->bind_param("s",$part_id);
$stmt->execute();
$result = $stmt->get_result();
$realizations_all = $result->fetch_all();
$stmt->close();
$conn->close();
$number_of_realizations = sizeof($realizations_all);
if ($number_of_realizations=="NULL"){$number_of_realizations=0;}



?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/item/index.css">
</head>
<div class="content_wrapper">
    <?php include "$ROOT /resources/elements/header.php"; //include header 
    ?>
    <div class="container">


        <div class="description_block">

            <div class="left_column">
                <h1 class="part_header"><?= $part_name; ?></h1>
                <img class="img_gallery" src="/resources/images/lukashenko.png">
                <h6>Здесь должно быть схематичное изображение детали и средство просмотра 3д модели популярной реализации</h6>

            </div>

            <div class="right_column">
                <a class="right_side_button" href="#">Скопировать ссылку</a>
                <a class="right_side_button" href="#">Добавить реализацию</a>
                <a class="right_side_button" href="#">Сохранить в закладки</a>
                <a class="right_side_button" href="#">Тех.документация от производителя</a>

                <a class="right_side_button" href="#">Пожаловаться</a>
                

            </div>

        </div>
        <p class="part_decription"><?= $part_description; ?></p>
        <div class="realizations">
            <?php 
            $makeref="/realization?edit&pid=$part_id&rid=new";
            if($number_of_realizations==0){ echo "<h2 class='no_realizations'>Еще нет реализаций этой детали <a href=$makeref>добавить</a> </h2>";
            }else{echo "<h2 class='no_realizations'><a href=$makeref>добавить</a> реализацию</h2>";} ?>

            <?php

            if ($number_of_realizations!=0){

            foreach ($realizations_all as $rr){

                
                $rid = $rr[0];
                $author = getUsernameById($rr[3]);
                $rating = $rr[4];
                $make_date = $rr[5];
                $edit_date = $rr[6];
                $rel_description = $rr[7];
                if ($rel_description==NULL){$rel_description="N/A";}

                if (file_exists("$ROOT/upload/realizations/$rid.png")){
                    $relimage_url="/upload/realizations/$rid.png";
                }elseif (file_exists("$ROOT/upload/realizations/$rid.gif")){
                    $relimage_url="/upload/realizations/$rid.gif";
                }else{
                    $relimage_url = "/resources/images/no_image.png";
                }
                $file_url = "/upload/realizations/$part_id-$rid.zip";
                $editRelUrl ="/realization?edit&pid=1&rid=$rid";
            echo "
            <div class='realization'>
                <img class='realization_img' src=$relimage_url > 
                <p class='realization_text'> $rel_description </p>
                <a class='realization_author' href='/user?name=InTostor'>Автор: InTostor</a>
                <a href='$editRelUrl'> edit </a>

                <div class='realization_vote'>
                <a class='rating_change' href='#'><span class='material-symbols-outlined vote'>expand_more</span></a>
                $rating
                <a class='rating_change' href='#'><span class='material-symbols-outlined vote'>expand_less</span></a>
                </div>

                <a class='realization_download' href='$file_url'><span class='material-symbols-outlined'>file_download</span>.zip</a>
            </div>
            ";
                }

            }

            ?>

        </div>

        <div class="break"></div>

    </div>
</div>
<?php include "$ROOT /resources/elements/footer.php"; //include footer 
?>