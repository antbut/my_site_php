
<?php
$data= new FileData();
if(isset($_GET['idsp'])){
	$idsp=$_GET['idsp']; //id спецификации
	echo '<h3><p align="center">Спецификация</p></h3>';
	include 'interf/view_specif.php';
}else{
	echo '<h3><p align="center">Таблица метериалы и услуги</p></h3>';
	if($curent_user->QwestPriwilege('VEIW_OLL_TABLE_MATERIAL')){
		$data->ViweMaterialTable($data->GetArrayOrganizationIDfinsek(),$curent_user->GetUsersIdViewname());
	}
	if($curent_user->QwestPriwilege('VIEW_MY_TABLE_MATERIAL')){
		$data->ViweMaterialTableFoUsers($data->GetArrayOrganizationIDfinsek(),$curent_user->GetOrganizationID());
	}
}
?>