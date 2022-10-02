добавление детали

<?php

if (isset($_POST['confirm'])){
echo var_dump($_POST);
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
