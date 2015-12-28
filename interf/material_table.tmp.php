
<?php
//ini_set('display_errors','On');
$data= new FileData();
if(isset($_GET['idsp'])){
	$idsp=$_GET['idsp']; //id спецификации
	echo '<h3><p align="center">Спецификация</p></h3>';
	include 'interf/view_specif.php';
}else{
	
	/*if($curent_user->QwestPriwilege('VEIW_OLL_TABLE_MATERIAL')){
		$data->ViweMaterialTable($data->GetArrayOrganizationIDfinsek(),$curent_user->GetUsersIdViewname());
	}
	if($curent_user->QwestPriwilege('VIEW_MY_TABLE_MATERIAL')){
		$data->ViweMaterialTableFoUsers($data->GetArrayOrganizationIDfinsek(),$curent_user->GetOrganizationID());
	}*/
	include 'system/db.php';
	$idviewolltable=false;// поменять если надо будет показать всю таблицу
	
	if($curent_user->QwestPriwilege('VEIW_OLL_TABLE_MATERIAL')){
		$delete=false;
		if($curent_user->QwestPriwilege('DELETE_MATERIAL_SPECIFIKATION ')){
			$delete=true;
		}
		$summ=0;
		echo '<ul id="nav3">';
		$resull_org = mysql_query("SELECT * FROM organization ");
		While($myorg=mysql_fetch_array($resull_org)){
			if($myorg['findnamesecond']!="" && $myorg['findnamesecond']!="Проматом" && $myorg['findnamesecond']!="Енерджі Сервіс" ){
				echo '<li><a href="?action=material_table&idorg='.$myorg['id'].'">'.$myorg['findnamesecond'].'</a>';
			}
		}
		echo '</ul>';
		
		if(isset($_GET['idorg'])){
			$idorg=$_GET['idorg']; //id 
			$resull_org = mysql_query("SELECT * FROM organization WHERE id='$idorg'");
			if($myorg=mysql_fetch_array($resull_org)){
				echo '<h3><p align="center">Таблиця метеріали та послуги по '.$myorg['name'].'</p></h3>';
			}
			
			
			mysql_close($db);
			$arrorg=$data->GetArrayOrganizationIDfinsek();
			$arrus=$curent_user->GetUsersIdViewname();
			$oldwievdata  = date("Y-m-d", mktime(0, 0, 0, date("m")-6,   date("d"),   date("Y"))); //дата после которой не покзивать инфу
	
			include 'system/db_material.php';
			echo '<table align="center" width="auto" style="position : absolute; top: 250px; left: 245px" >';
			echo '<tr><td><b>Дата КП</b></td><td><b><p align="center">Предмет закупівлі</td><td><p align="center"><b>Вид діяльності</td><td><p align="center"><b>Постачальник</td>';
			if($idviewolltable){
				echo '<td><b>Покупець</td><td><p align="center"><b>Сума закупівлі, грн з ПДВ</td>';
			}
			echo '<td><p align="center"><b>Сума продажу, грн з ПДВ</td>';
			if($idviewolltable){
				echo'<td><p align="center"><b>К</td><td><b>Расходы</td><td><b>Меджер</td><td><b>Предоплата</td><td><p align="center"><b>Остаточний розрахунок, днів</td><td><p align="center"><b>Строк поставки,  днів</td><td><b>Примітки SHARED</td>';
			}
			echo '<td><p align="center"><b>Примітки меджера</td><td> </td><td> </td><td></td></tr>';
			
			$resullt = mysql_query("SELECT * FROM zvit WHERE data_kp>'$oldwievdata' AND pokypets='$idorg' ORDER BY data_kp DESC ");
		
		
			$norg=count($arrorg);
			$nus=count($arrus);

			While($mytable=mysql_fetch_array($resullt)){
				$user='Не назначен';
				$pokypets='Не определен';
						for($j=0;$j<$norg;$j++){
							if($arrorg[$j]['id']==$mytable['pokypets']){
								$pokypets=$arrorg[$j]['find'];
								break;
							}
						}
						for($j=0;$j<$nus;$j++){
							if($arrus[$j]['id']==$mytable['id_user']){
								$user=$arrus[$j]['name'];
								break;
							}
						}
						$tran=$mytable['tranzit'];
						$restr = mysql_query("SELECT * FROM tranzit WHERE id='$tran'");
						if($mytr=mysql_fetch_array($restr)){
							$trnzit=$mytr['name'].' , ';
						}else{
						$trnzit=$mytable['tranzit'];
						}
						$k=$mytable['k']*100;
				echo '<tr>';
				$rasxod=$mytable['rasxod']*100;
				echo '<td><p align="center">'.date("d.m.Y", strtotime($mytable['data_kp'])).'</td><td><p align="center">'.$mytable['predm_zakup'].'</td><td><p align="center">'.$data->GetVidDiyalFoID($mytable['vid_diyaln']).'</td><td><p align="center">'.$trnzit.' '.$mytable['postach'].'</td>';
				if($idviewolltable){
					echo'<td><p align="center">'.$pokypets.'</td><td><p align="center">'.number_format($mytable['summ_zakup'], 3, ',', ' ').'</td>';
				}
				echo'<td><p align="center">'.number_format($mytable['summ_prod'], 3, ',', ' ').'</td>';
				if($idviewolltable){
					echo'<td><p align="center">'.$k.'%</td><td><p align="center">'.$rasxod.'%</td><td><p align="center">'.$user.'</td><td><p align="center">'.$mytable['predoplata'].'%'.'</td><td><p align="center">'.$mytable['povn_opl_pis_pos'].'</td><td><p align="center">'.$mytable['strok_postv'].'</td><td><p align="center">'.$mytable['prim_shared'].'</td>';
				}
				echo '<td><p align="center">'.$mytable['primit'].'</td><td><a href="?action=material_table&idsp='.$mytable['id'].'">RS</a></td><td><p align="center">'.$mytable['file'].'</td>';
				
				$idsp=$mytable[id];
				$rezup=mysql_query("SELECT * FROM `spesifikats` WHERE `id_zvit`='$idsp'");
				
				if(!$myupl=mysql_fetch_array($rezup)){
					echo '<td><a href="work.php?action=load_manager_specif&idsp='.$mytable['id'].'&loadful=1"><img src="images/gwget.png" width="32px" height="32px"></a></td>';
				}else{
					echo '<td><img src="images/success.png" width="32px" height="32px"></td>';
				}
				if($delete){
					echo '<td><a href="work.php?action=delete_spetc&idsp='.$mytable['id'].'"><img src="images/delete.png" width="32px" height="32px"></a></td>';
				}
				
				
				echo '</tr>';
				$summ=$summ+$mytable['summ_prod'];
			}
			echo '<tr><td colspan="4"><b>Cума</td><td align="center"><b>'.number_format($summ, 3, ',', ' ').'</td><td></td></tr>';
			echo'</table>';
		}
	}
	if($curent_user->QwestPriwilege('VIEW_MY_TABLE_MATERIAL')){
		
		echo '<h3><p align="center">Материалы и услуги</h3>';
		//echo $curent_user->GetViewGroup();
		
		if($curent_user->GetViewGroup()==1){
			$data->ViweMaterialTableFoUsers($data->GetArrayOrganizationIDfinsek(),$curent_user->GetOrganizationID());
		}else{
			$arr=GetOrganizationFoViewGroup($curent_user->GetViewGroup());
			$n=count($arr);
			echo '<ul id="nav3">';
			$resull_org = mysql_query("SELECT * FROM organization ");
			While($myorg=mysql_fetch_array($resull_org)){
				for($i=0;$i<$n;$i++){
					if($myorg['id']==$arr[$i]){
						echo '<li><a href="?action=material_table&idorg='.$myorg['id'].'">'.$myorg['findnamesecond'].'</a>';
						break;
					}
				}
			}
			echo '</ul>';
		//	mysql_close($db);
		//	$data= new FileData();
		if(isset($_GET['idorg'])){
			$idorg=$_GET['idorg'];
		}
			$data->ViweMaterialTableFoUsers($data->GetArrayOrganizationIDfinsek(),$idorg);
			
		}
	}
	if($curent_user->QwestPriwilege('VIEW_TABLE_MANAGER_MATERIAL')){
		//ini_set('display_errors','On');
		$arrorg=$data->GetArrayOrganizationIDfinsek();
	//	$id_user=$curent_user->GetOrganizationID();//для обла
		$id_user=$curent_user->id_user;//для менеджера
		//echo $id_user;
		$oldwievdata  = date("Y-m-d", mktime(0, 0, 0, date("m")-6,   date("d"),   date("Y"))); //дата после которой не покзивать инфу
		
		mysql_close($db);
		include_once 'system/db_material.php';
		
		if($curent_user->QwestPriwilege('VIEW_MY_TABLE_MATERIAL')){
		//	$resullt = mysql_query("SELECT * FROM zvit WHERE pokypets='$id_user' ORDER BY data_kp DESC");
		}
		
		$resullt = mysql_query("SELECT * FROM zvit WHERE `id_user`='$id_user' ORDER BY data_kp DESC");
		//$resullt = mysql_query("SELECT * FROM zvit  ORDER BY data_kp DESC");
		
		echo '<table align="center">';
		echo '<th>Дата КП</th><th>Предмет закупівлі</th><th>Вид діяльності</th><th><p align="center">Постачальник</th><th>Сума продажу, грн з ПДВ</th><th><p align="center">Примітки менджера</th><th></th><th></th><th></th>';
		$norg=count($arrorg);
		
		While($mytable=mysql_fetch_array($resullt)){
					for($j=0;$j<$norg;$j++){
						if($arrorg[$j]['id']==$mytable['pokypets']){
							$pokypets=$arrorg[$j]['find'];
							break;
						}
					}
					$tran=$mytable['tranzit'];
					$restr = mysql_query("SELECT * FROM tranzit WHERE id='$tran'");
					if($mytr=mysql_fetch_array($restr)){
						$trnzit=$mytr['name'].' , ';
					}else{
						$trnzit=$mytable['tranzit'];
					}
			echo '<tr>';
			echo '<td><p align="center">'.date("d.m.Y", strtotime($mytable['data_kp'])).'</td><td><p align="center">'.$mytable['predm_zakup'].'</td><td><p align="center">'.$data->GetVidDiyalFoID($mytable['vid_diyaln']).'</td>
			<td><p align="center">'.$trnzit.' '.$mytable['postach'].'</td><td><p align="center">'.number_format($mytable['summ_prod'], 3, ',', ' ').'</td><td><p align="center">'.$mytable['primit'].'</td> <td><a href="?action=material_table&idsp='.$mytable['id'].'">RS</a></td><td><p align="center">'.$mytable['file'].'</td>';
			
			$idsp=$mytable[id];
				$rezup=mysql_query("SELECT * FROM `spesifikats` WHERE `id_zvit`='$idsp'");
				
				if(!$myupl=mysql_fetch_array($rezup)){
					echo '<td><a href="work.php?action=load_manager_specif&idsp='.$mytable['id'].'&loadful=1"><img src="images/gwget.png" width="32px" height="32px"></a></td>';
				}else{
					echo '<td><img src="images/success.png" width="32px" height="32px"></td>';
				}
			echo '</tr>';
			$summ=$summ+$mytable['summ_prod'];
		}
		echo '<tr><td colspan="4">Cума</td><td>'.$summ.'</td><td></td></tr>';
		echo'</table>';
	
	}
}	
?>