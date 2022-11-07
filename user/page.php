<?php
$userPositiveRating = Database::executeStmt('SELECT sum(rating) from realizations where rating>0 and author = ?',"s",[$user_id])[0]['sum(rating)'];
$userNegativeRating = Database::executeStmt('SELECT sum(rating) from realizations where rating<0 and author = ?',"s",[$user_id])[0]['sum(rating)'];

if ($userPositiveRating == ""){$userPositiveRating=0;}
if ($userNegativeRating == ""){$userNegativeRating=0;}

$userPage=$user_id==User::convertUsernameToId(User::getLoggedAs());


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
                <h1><span class="material-symbols-outlined smallIcon">handyman</span> <?= $username ?></h1>
                <h3><span class="material-symbols-outlined smallIcon">location_on</span> <?= $location ?></h3>
                <h4><span class="material-symbols-outlined smallIcon">cloud</span> <?= $mood ?></h4>
                <div class="rating_div">
                    <h2 class="rating_t">Рейтинг </h2>
                    <h2 style="color:rgb(120,50,50)" class="rating"><?=$userNegativeRating?></h2>
                    <h2 class="rating_breaker">/</h2>
                    <h2 style="color:rgb(50,120,50)" class="rating"><?=$userPositiveRating?></h2>
                </div>
            </div>
            <p class="description"><?= $description_md ?></p>
            <?php if($userPage){echo '<a class="accountEdit" href="/account/actions.php"><span class="material-icons">edit</span></a>';}?>



        </div>

        


    </div>
    </div>
    <?php include "$ROOT /resources/elements/footer.php"; //include footer 
    ?>

