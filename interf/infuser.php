
<?php
include_once'system/db.php';
$usid=$_GET['usid'];

$link;// где обрабатывать ссылку
if($usid==""){
	$link='?action=add_user&add=1';
	$button='Создать';
}else{
	$link="?action=all_users&edit=1&usid=$usid";
	$result = mysql_query("SELECT * FROM users WHERE id='$usid'");
		if($myuser=mysql_fetch_array($result)){
			$new_user=$myuser['login'];
			//$passwd=$myuser['login'];
			$viewnam=$myuser['viewname'];
			$email=$myuser['email'];
			$organiz=$myuser['orgnizid'];
			$priv=$myuser['privilege'];
			$viewgroup=$myuser['viewgroup'];
			$button='Изменить';
		}
	
}

?>
<h3 align="center">Пользователь</h3>
<?php
echo '<form method="post"  action="'. $link .'" autocomplete="off" align="center">';
?>
       <table align="center">
       <tr>
		<td><label for="username">Логин</label></td>
	<?php echo	'<td><input type="text" name="new_user" value="'.$new_user.'"></input></td>'; ?>
       </tr>
	   <tr>
		<td><label for="username">Отображаемое имя</label></td>
	<?php echo	'<td><input type="text" name="viewnam" value="'.$viewnam.'"></input></td>'; ?>
       </tr>
       <tr>
		<td><label for="password">Пароль</label></td>
		<td><input name="passwd" type="password"></input></td>
       </tr>
		<tr>
		<td><label for="email">Емейл</label></td>
	<?php echo	'<td><input type="text" name="email" value="'.$email.'"></input></td>'; ?>
       </tr>
	   <tr>
		<td><label for="organiz">Организация</label></td>
		<td><select name="organiz" size="1">
			<?php 
			$resull = mysql_query("SELECT * FROM organization");
				while($myorg=mysql_fetch_array($resull)){
					if($myorg['id']==$organiz){
						echo '<option selected="selected" value="'.$myorg['id'].'">'.$myorg['name'].'</option>';
					}else{
						echo '<option value="'.$myorg['id'].'">'.$myorg['name'].'</option>';
					}
				}
			?>
			</select>
			</td>
	
       </tr>
	   <tr>
		<td><label for="privilege">Уровень привилегий</label></td>
			<td><select name="privilege" size="1">
			<?php 
			$resull = mysql_query("SELECT * FROM roles");
				while($myrole=mysql_fetch_array($resull)){
					if($myrole['id']==$priv){
						echo '<option selected="selected" value="'.$myrole['id'].'">'.$myrole['name'].'</option>';
					}else{
						echo '<option value="'.$myrole['id'].'">'.$myrole['name'].'</option>';
					}
				}
			?>
			</select>
			</td>
	   </tr>
	   <tr>
		<td><label for="privilege">Група просмотра</label></td>
			<td><select name="viewgroup" size="1">
			<?php 
			$resull = mysql_query("SELECT * FROM viewgroup");
				while($myrole=mysql_fetch_array($resull)){
					if($myrole['id']==$viewgroup){
						echo '<option selected="selected" value="'.$myrole['id'].'">'.$myrole['name'].'</option>';
					}else{
						echo '<option value="'.$myrole['id'].'">'.$myrole['name'].'</option>';
					}
				}
			?>
			</select>
			</td>
	   </tr>
       <tr>
	   <td></td>
	<?php echo	'<td align="center"><input type="submit" value="'.$button.'" size="5" style="width:150px;height:30px" ></input></td>'; ?>
       </tr>
       </table>
</form>


