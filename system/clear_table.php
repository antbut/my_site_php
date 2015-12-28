<?php
ini_set('display_errors','On');
include 'db_material.php';
$result=mysql_query("TRUNCATE TABLE `zvit` ");
//$result=mysql_query("DELETE FROM `zvit`");

if($result){
	echo 'Успешно удалено';
}else{
	echo 'ошибка';
}
?>