<?php
$pid = $_GET['id'];
if(isset($_GET['add'])){
    echo "добавление детали $pid";
}


if (!isLogged()){
    raiseHttpError(401);
    die();
}

if (isset($_POST['confirm'])){
echo var_dump($_POST);
    $conn = getDBconnection();
    $result = $conn->query('select max(idparts) from parts');
    $next_id = $result->fetch_assoc()['max(idparts)'];
    if ($next_id=="NULL"){$next_id=0;}
    $next_id += 1;
    $conn->close();

    echo getUserIdByUsername(getLoggedAs());
    echo $_POST['original_manufacturer'];
    echo $_POST['original_name'];
    echo $_POST['original_cost'];
    echo $_POST['original_material'];
    echo $_POST['original_made_for'];
    echo $_POST['fully_compatible_for'];
    echo $_POST['partly_compatible_for'];


    $conn = getDBconnection();
    $stmt = $conn->prepare(
    "insert into parts 
    (`first_author`, `original_manufacturer`, `original_name`, `original_cost`, `original_material`, `original_made_for`,`fully_compatible_with`,`partly_compatible_with`) 
    VALUES (?,?,?,?,?,?,?,?);"
);
    $stmt->bind_param("ssssssss", 
    getUserIdByUsername(getLoggedAs()),
    $_POST['original_manufacturer'],
    $_POST['original_name'],
    $_POST['original_cost'],
    $_POST['original_material'],
    $_POST['original_made_for'],
    $_POST['fully_compatible_for'],
    $_POST['partly_compatible_for'],
);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("location:/item?view&id=$next_id");
}





?>


<style>
form{
    width:50%;
    padding:5px;
    border: 1px gray solid;
}
</style>


<form action="" method="post" id="add_part">
<p><textarea maxlength="45" cols="100" type="text" name="original_manufacturer" required placeholder="Название компании производителя. Например ВАЗ"></textarea></p>
<p><textarea maxlength="45" cols="100" type="text" name="original_name" required placeholder="Оригинальное название детали (как её называет производитель). Например: бачок омывателя"></textarea></p>
<p><textarea maxlength="45" cols="100" type="text" name="original_cost"  placeholder="Оригинальная цена (цена от производителя)"></textarea></p>
<p><textarea maxlength="45" cols="100" type="text" name="original_material" required placeholder="Материал оригинальной детали. Например ABS или фанера 4мм"></textarea></p>
<p><textarea maxlength="45" cols="100" type="text" name="original_made_for"  required placeholder="Для чего была предназначена деталь (если несколько вариантов, то они записываются через ; ). Например жигули 2121; жигули 2101; жигули 2106"></textarea></p>
<p><textarea maxlength="45" cols="100" type="text" name="fully_compatible_for"  placeholder="Для чего эта деталь подходит без изменений (если несколько вариантов, то они записываются через ; ). Например жигули 2102; жигули 2103; жигули 2107"></textarea></p>
<p><textarea maxlength="45" cols="100" type="text" name="partly_compatible_for"  placeholder="Для чего эта деталь подходит с некоторыми изменениями (если несколько вариантов, то они записываются через ; ). Например УАЗ hunter"></textarea></p>
    <input  type="submit" name="confirm" value="создать деталь">
</form>
