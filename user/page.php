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
    <?php include "$ROOT /resources/elements/header.php"; //include header ?>
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
            <div class="description">
                <?=$description_md?>
            </div>
            
            <?php if($userPage){echo '<a class="accountEdit" href="/account/actions.php"><span class="material-icons">edit</span></a>';}?>



        </div>
        <div class="break"></div>
        <div class="column">
            <h2>Работы</h2>
            <div class="break"></div>
            <div class="works_grid">
            <?php
            $usrP = new User();
            $usrP->constructWithId($user_id);
            foreach ($usrP->getWorks(12)['realizations'] as $num => $relR){
                // echo "<pre>"; print_r($relR); echo "</pre>";
                $rid = $relR['idrealizations'];
                $rName = $relR['name'];
                $rPid = $relR['is_realization_of'];
                $rImg = Realization::getImageUrlWithIds($rPid,$rid);
                $rRating = $relR['rating'];
                if ($rRating<0){
                    $rRatingColor = "color:rgb(120,50,50)";
                }else{
                    $rRatingColor = "color:rgb(50,120,50)";
                }
                $rDesc = $relR['description'];
                $rDownloads = "-";
                $rPname = Part::convertIdToName($rPid);
                $rUrl = Realization::getUrlWithIds($rPid,$rid);
            
            echo "
            <a href='$rUrl'>
            <div class=\"work_container\">
                <img alt=\"work_img\" src=\"$rImg\" class=\"work_img\">
                <div class=\"work_text\">
                    <h3>$rName</h3>
                    <p class=\"work_desc\">$rDesc</p>
                    <h4>для детали:$rPname</h4>
                    </div>
                    <div class=\"work_bottom\">
                        <h4 style=\"$rRatingColor\" class=\"work_rating\"><span style=\"color:black\" class=\"material-symbols-outlined work_symbol\">thumbs_up_down</span> $rRating</h4>
                        <h4 class=\"work_downloads\"><span style=\"color:black\" class=\"material-symbols-outlined work_symbol\">download</span> $rDownloads</h4>
                    </div>
                
            </div>
            </a>
            ";
            }
            ?>
            </div>
            <div class="break"></div>
        </div>
        


    </div>
    </div>
    <?php include "$ROOT /resources/elements/footer.php"; //include footer 
    ?>

