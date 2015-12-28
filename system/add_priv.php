<?php
ini_set('display_errors','On');
include 'db.php';
$result=mysql_query("INSERT INTO `privileges`(`name`) VALUES ('VIEW_TABLE_MANAGER_MATERIAL')");
//$result=mysql_query("DELETE FROM `zvit`");

if($result){
	echo 'Успешно добавлено';
}else{
	echo 'ошибка';
}
?>