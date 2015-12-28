<h3><p align="center">Роли пользователей</p></h3>
<table align="center">
<?php
$resultroll = mysql_query("SELECT * FROM `roles` ");
		while($myrol=mysql_fetch_array($resultroll)){
			echo '<tr><td><a href="?action=edit_rol&idr='.$myrol['id'].'">'.$myrol['name'].'</a></td></tr>';
		}
?>
</table>