<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/table.css" type="text/css" />
<link rel="stylesheet" href="css/button.css" type="text/css" />
<link rel="stylesheet" href="css/links.css" type="text/css" />

<?php include 'system/db.php' ?>

<table align="center">
	<th>id</th>
	<th>Логин</th>
	<th>Отображаемое имя</th>
	<th>Организация</th>
	<th>Емейл</th>
	<th>Редактировать</th>
<?php
$result = mysql_query("SELECT * FROM users ORDER BY login");
while ($myuser=mysql_fetch_array($result)){
	echo '
	<tr>
	<td><p align="center">'.$myuser['id'].'</p></td>
	<td><p align="center">'.$myuser['login'].'</p></td>
	<td><p align="center">'.$myuser['viewname'].'</p></td>
	<td><p align="center">'.$myuser['orgniz'].'</p></td>
	<td><p align="center">'.$myuser['email'].'</p></td>
	<td><p align="center"><a href="#">'.'edit'.'</a></p></td>
	</tr>';
}
?>
</table>