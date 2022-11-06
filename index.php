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
    <title>3DE | Главная</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<div class="content_wrapper">
<?php include "$ROOT /resources/elements/header.php"; //include header ?>



<div class="container">

    <div class="items_row">
        <a href="/search?category=large_appliances" class="item i1">Крупная бытовая техника</a>
        <a href="/search?category=small_appliances" class="item i2">Малая бытовая техника</a>
        <a href="/search?category=light_vehicle" class="item i3">Легкий транспорт</a>
        <a href="/search?category=heavy_vehicle" class="item i6">Тяжелый транспорт</a>
        <a href="/search?category=wearable_electronics" class="item i4">Носимая электроника</a>
        <a href="/search?category=toys_rc" class="item i5">Игрушки и РУ модели</a>
        <a href="/search?category=photo_equipment" class="item i7">фототехника</a>
        <a href="/search?category=none" class="item i8">памятники ссср</a>
        <a href="/search?category=none" class="item i9">акультисткие тотемы</a>
        <a href="/search?category=none" class="item i10">космические аппараты</a>
        <a href="/search?category=none" class="item i11">дореволюционная авиация</a>
        <a href="/search?category=none" class="item i12">инопланетные технологии</a>
    </div>



</div>

</div>

<?php include "$ROOT /resources/elements/footer.php"; //include footer ?>