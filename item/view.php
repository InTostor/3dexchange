<?php
// setting environment

getHTMLstuff();

$part_id = $_GET['id'];
if ($part_id==NULL){
    raiseHttpError(404);
    die();
}

require_once("$ROOT/resources/php/classes/User.php");
require_once("$ROOT/resources/php/classes/Part.php");
require_once("$ROOT/resources/php/classes/Realization.php");
$badRatingColor = "rgb(130,50,50)";
$goodRatingColor = "rgb(50,130,50)";


$part = new Part();
$part->constructWithId($part_id);

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

$part_name = $part->getOriginalManufacturer() . " | ". $part->getOriginalName();
$part_tags = $part->getTags();
$part_category = $part->getCategory();
$tags_exploded = explode(";",$part_tags);
$title =  "3DE | ".Part::convertIdToName($part_id);

$imgsForGallery = array();
foreach ($part->getImagesList() as $iid => $img){
    $url = $part->getImagesFolder()."/".$img;
    $id = $iid+1;
    $imgsForGallery[] = "<img class='img_in_gallery' id='gImg$id' src='$url'>";
}



$realizations_all = $part->getRealizations();

$number_of_realizations = sizeof($realizations_all);
if ($number_of_realizations=="NULL"){$number_of_realizations=0;}
$makeref="/realization?edit&pid=$part_id&rid=new";

$canUserEditPart = $usr->isAuthorOf("part",$part_id) and $usr->checkPermission("part.edit.self") or $usr->checkPermission('realization.edit.any');

?>

<!DOCTYPE HTML>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/item/index.css">
    <title><?=$title?></title>
</head>

<body>


<div class="content_wrapper">
    <?php include "$ROOT /resources/elements/header.php"; //include header 
    ?>
    <div class="container">

        <div class="description_block">

            <div class="left_column">
                <h1 class="part_header"><?= $part_name; ?></h1>
                <div class="img_gallery">
                <?php 
                if (sizeof($imgsForGallery)==0){
                echo '<img class="img_in_gallery" id="gImg0" src="/resources/images/lukashenko.png">';
                }
                ?>
                <?=implode('',$imgsForGallery)?>
                </div>
                <div class="gallery_conrols_box">
                <button class="moveImage" onclick="prevImage()"><</button>
                <button class="moveImage" onclick="nextImage()">></button>
                </div>

            </div>

            <div class="right_column">
                <!-- <a class="right_side_button" href="#">Скопировать ссылку</a> -->
                <a class="right_side_button" href="<?=$makeref?>">Добавить реализацию</a>
                <!-- <a class="right_side_button" href="#">Сохранить в закладки</a> -->
                <a class="right_side_button" href="/item/browse.php?id=<?=$pid?>">Документация</a>
                <?php if ($canUserEditPart){echo '<a class="right_side_button" href="/item?edit&id=<?=$part_id?>">Редактировать</a>';}?>

                <a class="right_side_button" href="#">Пожаловаться</a>
                <h3>Тэги: </h3>
                <div class="tags">
                <?php
                foreach ($tags_exploded as $tag){
                    echo "<p><span class='tag'><a href='/search?q=$tag'>$tag</a></span></p>";}                
                ?>
                </div>
            </div>

        </div>
        
        <div class="realizations">
<?php
// changing link if realizations exists or not
if($number_of_realizations==0){ 
    echo "<h2 class='no_realizations'>Еще нет реализаций этой детали <a href=$makeref>добавить</a> </h2>";
}else{
    echo "<h2 class='no_realizations'><a href=$makeref>добавить</a> реализацию</h2>";
} 

// getting and printing all realizations of this part
if ($number_of_realizations!=0){
    foreach ($realizations_all as $rr){

        $rid = $rr['idrealizations'];
        $name = $rr['name'];
        $author = User::convertIdToUsername($rr['author']);
        $rating = $rr['rating'];
        $make_date = $rr['make_date'];
        $edit_date = $rr['edit_date'];
        $rel_description = $rr['description'];
        $authorUrl = User::getViewUrlWithId($rr['author']);
        if ($rel_description==NULL){$rel_description="N/A";}
        $relimage_url = Realization::getImageUrlWithIds($pid,$rid);
        $file_url = "/realization/browse.php?rid=$rid&pid=$pid";
        $editRelUrl ="/realization?edit&pid=1&rid=$rid";
        $canUserEditRel = ($usr->checkPermission('realization.edit.*') and $usr->isAuthorOf("realization",$rid)) or $usr->checkPermission('realization.edit.any');
        if ($rating<0){
            $ratingColor = $badRatingColor;
        }else{
            $ratingColor = $goodRatingColor;
        }

        echo "
        <div class='realization' id=$rid>
            <img class='realization_img' src=$relimage_url>
        ";
        if( $canUserEditRel ){
            echo "<a href='$editRelUrl'> <span class='material-icons'>edit</span> </a>";
        }else{
            echo "<div style='width:30px'></div>";
        }
        echo "
            <p class='realization_text'> <b>$name</b> <br>$rel_description </p>
            <a class='realization_author' href='$authorUrl'>Автор: $author</a>
            <div class='realization_vote'>
            <button class='rating_change' id='decrease_$rid' onclick='decreaseRating(this,$pid,$rid)' ><span class='material-symbols-outlined vote'>expand_more</span></button>
            <p style='color: $ratingColor' class=\"rating\" id=rating$rid>$rating</p>
            <button class='rating_change' id='increase_$rid' onclick='increaseRating(this,$pid,$rid)' ><span class='material-symbols-outlined vote'>expand_less</span></button>
            </div>
            <a class='realization_download' href='$file_url'><span class='material-symbols-outlined'>file_download</span>.файлы </a>
        </div>
        ";
    }
}
?>

        </div>
        <div class="break"></div>
    </div>
</div>





<?php include "$ROOT /resources/elements/footer.php"; //include footer ?>
</body>

<script>
    var arr = document.getElementsByClassName("img_in_gallery");
    var imgCount = arr.length;
    var counter = 0;

    function hideUnhide(){
        for(var i=0; i<imgCount; i++){
            var element = document.querySelector('img.'+arr[i].className+"#"+arr[i].id);
            if (i!=counter){        
                element.style.display = "none";   
            }else{
                element.style.display = "block"; 
            }   
        }
        console.log(counter);
    }
    hideUnhide();

    function nextImage(event) {
        if (counter>=imgCount-1){
            counter = 0;
        }else{
            counter=counter+1;
        }
        hideUnhide();
    }

    function prevImage(event) {
        if (counter<=0){
            counter = imgCount-1;
        }else{
            counter=counter-1;
        }
        hideUnhide();
    }

    function increaseRating(element,pid, rid){
        changeRating(element,pid,rid,1)
    }
    function decreaseRating(element,pid, rid){
        changeRating(element,pid,rid,-1)
    }

    function changeRating(element,pid,rid,rating){
        var xmlhttp = new XMLHttpRequest();
        var buttonId = element.id
        var ratingStrId = buttonId.replace("increase_","").replace("decrease_","")
        
        var POSTq = "pid=" + pid + "&rid="+rid+"&val="+rating+"&auth=cookie"
        var response;
        var success;
        var newVal;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/v1/changeRelRating.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            response = JSON.parse(xhr.response)
            success = response.success
            newVal = response.new_value
            if (success==true){
                var ratingTxt = document.getElementById('rating'+ratingStrId)
                ratingTxt.innerHTML = ' '+newVal+' '
                if (newVal<0){
                    ratingTxt.style.color = "<?=$badRatingColor?>"
                }else{
                    ratingTxt.style.color = "<?=$goodRatingColor?>"
                }
            }else{
                showMessage('только для зарегестрированных пользователей');
            }
        }};

        xhr.send(POSTq)
    }
</script>

</body>
</html>