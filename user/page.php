<?php
$userPositiveRating = Database::executeStmt('SELECT sum(rating) from realizations where rating>0 and author = ?',"s",[$user_id])[0]['sum(rating)'];
$userNegativeRating = Database::executeStmt('SELECT sum(rating) from realizations where rating<0 and author = ?',"s",[$user_id])[0]['sum(rating)'];

if ($userPositiveRating == ""){$userPositiveRating=0;}
if ($userNegativeRating == ""){$userNegativeRating=0;}

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/user/index.css">
    <title><?=$title?></title>
</head>
<div class="content_wrapper">
    <?php include "$ROOT /resources/elements/header.php"; //include header 
    ?>
    <div class="container">
    <div class="break"></div>
        <div class="row">
            <div class="avatar">
                <img class="avatar_img" src=<?= "$avatar_url" ?>>
                <h1><?= $username ?></h1>
                <h3><?= $location ?></h3>
                <h4><?= $mood ?></h4>
                <div class="rating_div">
                    <h2 class="rating_t">Рейтинг </h2>
                    <h2 style="color:rgb(120,50,50)" class="rating"><?=$userNegativeRating?></h2>
                    <h2 class="rating_breaker">/</h2>
                    <h2 style="color:rgb(50,120,50)" class="rating"><?=$userPositiveRating?></h2>
                </div>
            </div>
            <p class="description"><?= $description_md ?></p>



        </div>

        


    </div>
    </div>
    <?php include "$ROOT /resources/elements/footer.php"; //include footer 
    ?>

