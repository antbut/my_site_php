<h3><p align="center">Групы просмотра организаций для пользователей</p></h3>
<table align="center">
<?php
$resultroll = mysql_query("SELECT * FROM `viewgroup` ");
		while($myrol=mysql_fetch_array($resultroll)){
			echo '<tr><td><a href="?action=edit_gr_view&idr='.$myrol['id'].'">'.$myrol['name'].'</a></td></tr>';
		}
?>
</table>