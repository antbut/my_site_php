<?php
			
			$idst=$_GET['idst'];
			$n=7;
					$result = mysql_query("SELECT * FROM menu_works WHERE id='$idst'");
					$mymenu=mysql_fetch_array($result);
			$data= new FileData();
			if($idst<$n){
				if($idst==''){$idst=0;}
					echo '<h3><p align ="center">Информация по ценам '.$mymenu['name'].'</p></h3>';
				//print_r($_GET);
					switch($idst){
						case 0:
							$colls='1,2,4,9';
						break;
						case 1:
							$colls='1,2,4,7';
						break;
						case 2:
							$colls='1,2,4,7';
						break;
						case 3:
							$colls='1,2,3,5';
						break;
						case 4:
							$colls='1,2,3,5';
						break;
						case 5:
							$colls='1,2,3,4';
						break;
						case 6:
							$colls='1,2,3,4';
						break;
					}
				//	echo __DIR__;
				//	echo '<br>';
					if($curent_user->QwestPriwilege('VIEW_MY_TABLE')){
						$data->FilterArrayXLSANDView($data->getXLS('xls/tor.xls',$idst),$data->LoadOrganizationID(),$colls,$curent_user->GetOrganizationid());
					}
					if($curent_user->QwestPriwilege('VEIW_OLL_TABLE_WORK')){
						$data->ViewArrayTableNummCol($data->getXLS('xls/tor.xls',$idst),$colls);
					}
					
				
				
			}
	?>