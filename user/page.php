<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/user/index.css">
</head>
<div class="content_wrapper">
    <?php include "$ROOT /resources/elements/header.html"; //include header 
    ?>
    <div class="container">
    <div class="break"></div>
        <div class="row">
            <div class="avatar">
                <img class="avatar_img" src=<?= "/user/$avatar_url" ?>>
                <h1><?= $username ?></h1>
                <h3><?= $location ?></h3>
                <h4><?= $mood ?></h4>
            </div>
            <p class="description"><?= $description_md ?></p>



        </div>

        


    </div>
    </div>
    <?php include "$ROOT /resources/elements/footer.html"; //include footer 
    ?>

