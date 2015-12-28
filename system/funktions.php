<?php

function clean_str($str){
	
	return trim(strip_tags($str));
}

function render($path, $param =array()){
	//print_r($param);
	extract($param, EXTR_OVERWRITE); //разбить масив на переменные
	print_r($pmenu);
	
	ob_start();//весь вывод писать в память
	
	if(!include($path.".php")){
		exit("<br>Нет такого шаблона");
	}
	
	return ob_get_clean();
	
}
function createSpicsfication( $predm_zakup, $vid_diyaln, $postach,  $pokypets, $id_user, $strok_postv, $yamov_postav, $predoplata, $povn_opl_pis_pos, $prots, $tranzit, $postachsekondary=""  ){
	
	include_once 'db_material.php';
	
	$data_kp=date("Y-m-d");
		$predm_zakup=mysql_real_escape_string($predm_zakup);// екранирование
		
	$result = mysql_query("INSERT INTO `zvit`(`data_kp`, `predm_zakup`, `vid_diyaln`, `postach`, `postachsekondary`, `pokypets`, `file`, `id_user`, `strok_postv`, `yamov_postav`, `predoplata`, `povn_opl_pis_pos`, `prots`, `tranzit`) VALUES( '$data_kp', '$predm_zakup', '$vid_diyaln', '$postach', '$postachsekondary', '$pokypets',  'н.з', '$id_user', '$strok_postv', '$yamov_postav', '$predoplata', '$povn_opl_pis_pos', '$prots', '$tranzit')");
	
	if ($result){
		//echo '<br>dobavleno<br>';
				
		$resultid = mysql_query("SELECT id FROM `zvit` ORDER BY id DESC");
		if($myid=mysql_fetch_array($resultid)){
			
			return $myid['id'];
		}else{
			echo '<br>id в таблице не найден';
		}
	}else{
		echo '<br>ошибка добавления новой спецификации';
	}
}

function addPunktSpecifikation($data=array()){
	include_once 'db_material.php';
	$suma_zakup=0;
	$suma_prod=0;
	$n=$data['kilkpos'];
	$id_form=$data['idform'];
	
	for ($i=0;$i<=$n;$i++){
		
		
		$nm=$data['name'.$i];
		$nm=mysql_real_escape_string($nm);
		if($nm!=''){
			$ov=$data['od_vimir'.$i];
			$kill=$data['kilk'.$i];
		
			$countr=$data['contru'.$i];
			if($id_form!=1){
				$pr_vxod=$data['prise_vxod_za_od'.$i];
				$prise_prod=round(($pr_vxod/5*1.5) , 2)*5;
			
			}else{
				$prise_prod=$data['prise_vxod_za_od'.$i];
				$pr_vxod=0;
			}
			$summ_vxod_za=$pr_vxod*$kill;
			$summ_prod=$prise_prod*$kill;
		
			$result = mysql_query("INSERT INTO `spesifikats` (`id_zvit`,`name`,`od_vimir`,`kilk`,`prise_vxod_za_od`,`contru`,`summ_vxod_za_od`,`prise_prod_za_od`,`summ_prod_za_od`) VALUES('$data[idsp]','$nm','$ov','$kill','$pr_vxod', '$countr','$summ_vxod_za','$prise_prod','$summ_prod')");
			if(!$result){
				echo'ошибка отправления';
			}
			$suma_zakup=$suma_zakup+$summ_vxod_za;
			$suma_prod=$suma_prod+$summ_prod;	
		}
	}
	$suma_prod=$suma_prod*1.2;
	$suma_zakup=$suma_zakup*1.2;
//	echo '<br>$suma_zakup='.$suma_zakup;
//	echo '<br>$suma_prod='.$suma_prod;
	if($id_form!=1){
		$k=($suma_prod-$suma_zakup)/$suma_prod;
		$resultzv = mysql_query("UPDATE `zvit` SET `summ_zakup`='$suma_zakup', `summ_prod`='$suma_prod',`k`='$k' WHERE id='$data[idsp]'");
	}else{
		$resultzv = mysql_query("UPDATE `zvit` SET `summ_zakup`='$suma_zakup', `summ_prod`='$suma_prod' WHERE id='$data[idsp]'");
	}
	if(!$resultzv){
		echo'ошибка при добавлении в базу звіт';
	}
	
}
	function QwestPriwilegeRole($namePrivilege='aa', $id_role=0){
		
		//this->privilege
	//	include_once 'db.php';
		$resultpr = mysql_query("SELECT privileges.name FROM privileges, role_and_privilege WHERE role_and_privilege.id_privilege=privileges.id AND role_and_privilege.id_role='$id_role' AND privileges.name='$namePrivilege'");
		while ($myprivileges=mysql_fetch_array($resultpr)){
			//echo 'true';
			return true;
			
		}
		//echo 'false';
		return false;
		
}
	function QwestViewGroupFoID($namePrivilege='1', $id_role=0){
		
		//this->privilege
	//	include_once 'db.php';
		
		//echo 'nameorg='.$namePrivilege.'id_gr='.$id_role;
		$resultpr = mysql_query("SELECT organization.id FROM organization, viewgroup_and_organiz WHERE viewgroup_and_organiz.id_organization=organization.id AND viewgroup_and_organiz.id_viewgrup='$id_role' AND organization.id='$namePrivilege'");
		while ($myprivileges=mysql_fetch_array($resultpr)){
			//echo 'true';
			return true;
			
		}
		//echo 'false'.mysql_error();
		return false;
		
}
	
	function DeleteSpetcif($idsp){
		
		//include_once 'db_material.php';
		
		$reszv=mysql_query("DELETE FROM `zvit` WHERE id='$idsp' ");
		$restm=mysql_query("DELETE FROM `spesifikats` WHERE id_zvit='$idsp'");
		
		if($reszv && $restm){
			return true;
		}else{
			if(!$reszv){
				echo 'Ошибка при удалении спецификации'.mysql_error ().'<br>';
			}
			if(!$restm){
			echo 'Ошибка при удалении пунктов спецификации'.mysql_error ().'<br>';
			}
			return false;
		}
	}
	function GetOrganizationFoViewGroup($idgr){
		$resuzt=mysql_query("SELECT * FROM viewgroup_and_organiz WHERE  id_viewgrup='$idgr'");
		$res=array();
		$i=0;
		while($myorg=mysql_fetch_array($resuzt)){
			$res[$i++]=$myorg['id_organization'];
		}
		
		return $res;
	}

?>
