
<?php
//include_once 'system/funktions.php'
$link='work.php?action=edit_rol';
if(isset($_GET['idr'])){
	$idr=$_GET['idr'];
	$link=$link.'&idr='.$idr;
	if(!empty($_POST)){
		//print_r($_POST);
		$curent_user->editrole($idr,array_keys($_POST));
	}
}else{
	$idr=0;
	print_r($_POST);
}


?>
<form method="post" action="<?php echo $link ?>">
<?php
$resultroll = mysql_query("SELECT * FROM `roles` WHERE id='$idr'");
		if($myrol=mysql_fetch_array($resultroll)){
			echo '<h3><p align="center">Параметры роли '.$myrol['name'].'</p></h3>';
		}
		$resultpriv = mysql_query("SELECT * FROM `privileges` ");
		echo '<table align="center">';
		while($mypriv=mysql_fetch_array($resultpriv)){
			if(QwestPriwilegeRole($mypriv['name'], $idr)){
				echo '<tr><td><input type="checkbox" name="'.$mypriv['id'].'" value="1" checked>'.$mypriv['name'].'<Br></td></tr>';
			}else{
				echo '<tr><td><input type="checkbox" name="'.$mypriv['id'].'" value="1">'.$mypriv['name'].'<Br></td></tr>';
				
			}			
		}
		//QwestPriwilegeRole($mypriv['name'], $idr)
?>
<tr><td><input type="submit" value="Изменить привилегии"></td></tr>
</table>
</form>