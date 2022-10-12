<?php
// setting environment

getHTMLstuff();

$conn = getDBconnection();
$stmt = $conn->prepare("select * from parts where idparts=?;");
$stmt->bind_param("s",$_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();

$part_name = $row['original_manufacturer']." | ".$row['original_name'];
$part_description = "Описание демонстрационной детали. Это описание делается - создателем модели, автором наиболее популярной реализации, администрацией. Должно быть в формате html без js";

$number_of_realizations = 0;




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
            <?php if($number_of_realizations!=0){ echo '<h2 class="no_realizations">Еще нет реализаций этой детали <a href="#">добавить</a> </h2>';} ?>

            <?php

            echo "
            <div class='realization'>
                <img class='realization_img' src='/resources/images/lukashenko.png' > 
                <p class='realization_text'> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                <a class='realization_author' href='/user?name=InTostor'>Автор: InTostor</a>

                <div class='realization_vote'>
                <a class='rating_change' href='#'><span class='material-symbols-outlined vote'>expand_more</span></a>
                +100500
                <a class='rating_change' href='#'><span class='material-symbols-outlined vote'>expand_less</span></a>
                </div>

                <a class='realization_download' href=''><span class='material-symbols-outlined'>file_download</span>.zip</a>
            </div>
            "
            ?>

        </div>

        <div class="break"></div>

    </div>
</div>
<?php include "$ROOT /resources/elements/footer.php"; //include footer 
?>