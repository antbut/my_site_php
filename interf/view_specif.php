<?php
include 'system/db_material.php';
$idsp=$_GET['idsp']; //id спецификации

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
		//	mysql_close($db);
			$tri=$myress['tranzit'];
			$resulttr = mysql_query("SELECT * FROM `tranzit` WHERE id='$tri' ");
			if($mytr=mysql_fetch_array($resulttr)){
				echo $mytr['name'];
			}else{
				echo $myress['tranzit'];
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
		<td><label for="zvit">Передоплата, %</label></td>
		<td><?php echo $myress['predoplata'];?></td>
       </tr>
	   <tr>
		<td><label for="zvit">Повна оплата, після поставки, днів</label></td>
		<td><?php echo $myress['povn_opl_pis_pos'];?></td>
       </tr>
	   
      
			</table>
<?php		
		}else{
			echo'<br>ошибка базы данных'. mysql_error();
		}
		
		if($curent_user->QwestPriwilege('VEIW_OLL_TABLE_MATERIAL')){
			$view_oll=true;
		}else{
			$view_oll=false;
		}
		
		mysql_close($db);
include 'system/db_material.php';
	$resulsp = mysql_query("SELECT * FROM `spesifikats` WHERE id_zvit='$idsp' ");
			$i=1;
			$view_dat=false;
			echo '<table align="center">';
			echo '<th>№</th><th>Найменування</th><th>одиниці вимірювання</th><th>кількість</th>';
			if($view_oll){
				echo '<th>Ціна закупівлі</th><th>Сума закупівлі</th>';
			}
			
			echo '<th>Ціна без ПДВ</th><th>Сума без ПДВ</th><th>Країна виробник</th>';
			while($mytr=mysql_fetch_array($resulsp)){
				$view_dat=true;
				echo '<tr><td><p align="center">'.$i++.'</td><td><p align="center">'.$mytr['name'].'</td><td><p align="center">'.$mytr['od_vimir'].'</td><td><p align="center">'.$mytr['kilk'].'</td>';
				
				if($view_oll){
					echo '<td><p align="center">'.$mytr['prise_vxod_za_od'].'</td><td><p align="center">'.$mytr['summ_vxod_za_od'].'</td>';
				}
				
				echo'<td><p align="center">'.$mytr['prise_prod_za_od'].'</td><td><p align="center">'.$mytr['summ_prod_za_od'].'</td><td><p align="center">'.$mytr['contru'].'</td></tr>';
				
			}
			echo '</table>';
			if(!$view_dat){
				echo '<h3><p align="center">Нет информации по данной спецификации<p></h3>';
			}
?>