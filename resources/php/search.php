<?php 
require_once "$ROOT/resources/php/classes/Database.php";
// Поиск по базе данных, с использваонием тэгов, regex и пр.

function getRels($q){
    $q="%$q%";
    $conn = getDBconnection();
    $stmt = $conn->prepare("select * from realizations where `idrealizations` like ? or `name` like ? or `description` like ? ");
    $stmt->bind_param("sss",$q,$q,$q);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<br>реализации";
    while ($data = mysqli_fetch_assoc($result)){
        echo'<pre>'; print_r($data); echo '</pre>';
        echo "<a href = /item?view&id=".$data['is_realization_of']."#".$data['idrealizations']."> перейти </a>";
    }
    $stmt->close();
    $conn->close();
}

function getParts($q){
    $q="%$q%";
$conn = getDBconnection();
$stmt = $conn->prepare("select * from parts where idparts like ? or original_manufacturer like ? or original_name like ? or original_made_for like ? or fully_compatible_with like ? or category like ?");
$stmt->bind_param("ssssss",$q,$q,$q,$q,$q,$q);
$stmt->execute();
$result = $stmt->get_result();

echo "<br>детали";
while ($data = mysqli_fetch_assoc($result)){
echo'<pre>'; print_r($data); echo '</pre>';
echo "<a href = /item?view&id=".$data['idparts']."> перейти </a>";
}
$stmt->close();
$conn->close();
}

function getUsers($q){
    $q="%$q%";
$conn = getDBconnection();
$stmt = $conn->prepare("select idusers,username from users where idusers like ? or username like ?");
$stmt->bind_param("ss",$q,$q);
$stmt->execute();
$result = $stmt->get_result();

echo "<br>пользователи";
while ($data = mysqli_fetch_assoc($result)){
echo'<pre>'; print_r($data); echo '</pre>';
echo "<a href = /user?username=".$data['username']."> перейти </a>";
}
$stmt->close();
$conn->close();
}


// select * from realizations where make_date like '%166565827%'
#select * from realizations
// ;
// '


?>