<?php 
// setting environment
$ROOT = $_SERVER['DOCUMENT_ROOT'];
require "$ROOT/settings/settings.php";
require "$ROOT/resources/php/common.php";
getHTMLstuff();

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">

</head>
<div class="content_wrapper">
<?php include "$ROOT /resources/elements/header.html"; //include header ?>



<div class="container">

    <div class="items_row">
        <a href="/category?1" class="item i1">Крупная бытовая техника</a>
        <a href="/category?2" class="item i2">Малая бытовая техника</a>
        <a href="/category?3" class="item i3">Легкий транспорт</a>
        <a href="/category?4" class="item i4">Носимая электроника</a>
        <a href="/category?5" class="item i5">Игрушки и РУ модели</a>
        <a href="/category?6" class="item i6">Тяжелый транспорт</a>
        <a href="/category?7" class="item i7">фототехника</a>
        <a href="/category?8" class="item i8">памятники ссср</a>
        <a href="/category?9" class="item i9">акультисткие тотемы</a>
        <a href="/category?10" class="item i10">космические аппараты</a>
        <a href="/category?11" class="item i11">дореволюционная авиация</a>
        <a href="/category?12" class="item i12">инопланетные технологии</a>
    </div>



</div>

</div>

<?php include "$ROOT /resources/elements/footer.html"; //include footer ?>