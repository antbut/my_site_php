<?php
 ini_set('display_errors','On');
//echo '<br>на странице';
$kilkpos=0;

mysql_close($db);
//echo __DIR__;
include 'system/db_material.php';
if(!empty($_POST)){
	//echo "не пустой";
//	print_r($_POST);
	$kilkpos=$_POST['kilkpos']+1;
	$idsp=$_POST['idsp'];
	
}

//echo 'id2'.$idsp;
//$idsp=82;
$resultid = mysql_query("SELECT * FROM `zvit` WHERE id='$idsp' ");
		if($myress=mysql_fetch_array($resultid)){
?>
			<table>
				<tr>
		<td><label for="zvit">Предмет закупівлі</label></td>
		<td><?php echo $myress['predm_zakup'];?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Постачальник</label></td>
		<td><?php echo $myress['postach'];?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Транзит</label></td>
		<td><?php 
			$tri=$myress['tranzit'];
			$resulttr = mysql_query("SELECT * FROM `tranzit` WHERE id='$tri' ");
			if($mytr=mysql_fetch_array($resulttr)){
				echo $mytr['name'];
			}else{
				echo 'ошибка получения с базы';
			}
			
		?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Покупець</label></td>
		<td><?php 
			mysql_close($db_m);
			include 'system/db.php';
			$pok=$myress['pokypets'];
			$resultpok = mysql_query("SELECT * FROM `organization` WHERE id='$pok' ");
			if($mypc=mysql_fetch_array($resultpok)){
				echo $mypc['name'];
			}else{
				echo 'ошибка получения с базы';
			}
			
		
		?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Вид діяльності</label></td>
		<td><?php switch ($myress['vid_diyaln']){
			case 1: echo 'Поточна';
					break;
			case 2: echo 'ІП';
					break;
			case 3: echo 'Приєднання';
					break;
			}
		?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Строк поставки,  днів</label></td>
		<td><?php echo $myress['strok_postv'];?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Умови поставки</label></td>
		<td><?php echo $myress['yamov_postav'];?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Передоплата, %</label></td>
		<td><?php echo $myress['predoplata'];?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Повна оплата, після поставки, днів</label></td>
		<td><?php echo $myress['povn_opl_pis_pos'];?></td>
       </tr>
	   <tr>
		<td><label for="zvit">файл</label></td>
		<td><?php echo $myress['file'];?></td>
      
			</table>
<?php		
		}else{
			echo'<br>ошибка базы данных'. mysql_error();
		}
		
		if(empty($_POST)){

				
							echo '<form action="?action=upload_specif&idsp='.$idsp.'&loadful='.$loadful.'&idfile='.$myress['file'].'" method="post" enctype="multipart/form-data">';
?>
							<table  class="tr_table" style="position: absolute; top: 250px; right: 100px">
							<th >Загрузить спецификацию</th>
							<tr ><td class="tr_table">
							<input type="file" name="filename"><br>
							
							<input type="hidden" name="loadid" value="1"></td></tr>
							<tr><td class="tr_table">
							<input type="submit" value="Загрузить"></td></tr>
							</table>
							</form>
<?php
		}
?>

<h3><p align="center">Специфікація</p></h3>
<form method="post"  action="work.php?action=new_specif">
<input type="hidden" name="kilkpos" value="<?php echo $kilkpos; ?>">
<input type="hidden" name="idsp" value="<?php echo $idsp; ?>">
<input type="hidden" name="idform" value="<?php echo $myress['tranzit']; ?>">
	<table align="center">
		<th>№пп</th><th>Найменування</th><th>Од. вим.</th><th>К-ть</th><th>Ціна без ПДВ за од.</th><th>Країна виробник</th>
		<?php
			$i=1;
		//	for($i=0; $i<$kilkpos; $i++){
			for($i=0;$i<$kilkpos;$i++){
				echo '<tr>';
					$npp=$i+1;
					$nam='name'.$i;
					$od_vim='od_vimir'.$i;
					$kil='kilk'.$i;
					$prise_vxod='prise_vxod_za_od'.$i;
					$cont='contru'.$i;
					echo '<td><p align="center">'.$npp.'</td>';
					echo '<td><input type="text" name="name'.$i.'" value="'.$_POST[$nam].'" ></input></td>';
					echo '<td><input type="text" name="od_vimir'.$i.'" value="'.$_POST[$od_vim].'"></input></td>';
					echo '<td><input type="text" name="kilk'.$i.'" value="'.$_POST[$kil].'"></input></td>';
					echo '<td><input type="text" name="prise_vxod_za_od'.$i.'" value="'.$_POST[$prise_vxod].'"></input></td>';
					echo '<td><input type="text" name="contru'.$i.'" value="'.$_POST[$cont].'" ></input></td>';
				echo '</tr>';
			}
		?>
		
		<tr>
			<td><p align= "center"><?php echo $kilkpos+1 ;?></td>
			<td><input type="text" name="name<?php echo $kilkpos ;?>" ></input></td>
			<td><input type="text" name="od_vimir<?php echo $kilkpos ;?>" ></input></td>
			<td><input type="text" name="kilk<?php echo $kilkpos ;?>" ></input></td>
			<td><input type="text" name="prise_vxod_za_od<?php echo $kilkpos ;?>" ></input></td>
			<td><input type="text" name="contru<?php echo $kilkpos ;?>" value="Україна" ></input></td>
			
		</tr>
		<tr>
			<td><input type="submit" name="type_send" value="Добавить пункт" size="5" style="width:150px;height:30px" ></input></td>
			<td><input type="submit" name="type_send" value="Отправить в базу" size="5" style="width:150px;height:30px" ></input></td>
		</tr>
	</table>
</form>
