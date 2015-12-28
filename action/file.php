<?php
include 'funktions.php';
class FileData{
	public function getXLSShet($xls){
		$a=array();
		include_once 'Classes/PHPExcel/IOFactory.php';
		$objPHPExcel = PHPExcel_IOFactory::load($xls);
		$a=$objPHPExcel->getSheetNames();
		return $a;
	}
	
	public function getXLS($xls, $Activsheet=0){ //открывет xls и возвращает масив
		
		if(file_exists($xls)){
		include_once 'Classes/PHPExcel/IOFactory.php';
		$objPHPExcel = PHPExcel_IOFactory::load($xls);
		$objPHPExcel->setActiveSheetIndex($Activsheet);
		$aSheet = $objPHPExcel->getActiveSheet();
		
		
		
		$array = array();//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
		//получим итератор строки и пройдемся по нему циклом
		foreach($aSheet->getRowIterator() as $row){
			//получим итератор ячеек текущей строки
			$cellIterator = $row->getCellIterator();
			//пройдемся циклом по ячейкам строки
			$item = array();//этот массив будет содержать значения каждой отдельной строки
			foreach($cellIterator as $cell){
				//заносим значения ячеек одной строки в отдельный массив
				array_push($item, iconv('utf-8', 'cp1251', $cell->getCalculatedValue()));
			}
			//заносим массив со значениями ячеек отдельной строки в "общий массв строк"
			array_push($array, $item);
		}
		}
		else{$array=false;
			echo '<br>файл не существует<br>';
		}
		return $array;
	}
	public function FilterArrayXLS($xlsArr,$keyArr, $key='non'){// отфильтровать масив
		$n=count($xlsArr);
		$n_key=count($keyArr);
		$addArr=false;//флаг нужно ли добавлять елемент в масив
		$resultArr=array();
		$k=1;
		$resultArr[0]=$xlsArr[0];
	
		if($key=='non'){
			return $xlsArr;
		}else{
			for ($i=1; $i<$n; $i++){
				$tt=$xlsArr[$i][0];
			//	$tt=iconv('cp1251', 'utf-8',  $xlsArr[$i][1]);
			//	echo "$tt == $key".' <br>';
				if($addArr==false && $xlsArr[$i][0]==$key){// начало отбора с фильтра
					$addArr=true;	
					echo 'отбор начат'.$key;
				}
				if($addArr==true){
					$resultArr[$i]=$xlsArr[$k++]; // перебрасываем елементы в масив результат
					echo "<br>перерброс $i == $k елемента <br>";
					print_r($resultArr[$i]);
				}
				if($addArr==true && $xlsArr[$i][0]!=$key){ // Закончить переброс
					for($j=0;$j<$n_key;$j++){
						if($xlsArr[$i][0]==$keyArr[$j]){
							$addArr==false;
							echo 'отбор окончен';
							return $resultArr;
							break;
						}
					}
				}
			}
		}
	}
//----------получить номера строк котрые попадают по условию

	public function FilterArrayXLSReturnID($xlsArr,$keyArr, $key='non'){// отфильтровать масив
		$n=count($xlsArr);
		$n_key=count($keyArr);
		$addArr=false;//флаг нужно ли добавлять елемент в масив
		$resultArr=array();
		$k=1;
		if($key=='non'){
			$xlsArr[0]=0;
			$xlsArr[1]='end';
			return $xlsArr;
		}else{

			$key=$this->LoadOrgFaindFoID($key);
			for($j=0;$j<$n_key;$j++){
				if($keyArr[$j]=== $key){
					$end_key=$keyArr[$j+1];
					break;
				}
			}
			
			$key=$this->LoadOrgFaindFoID($key);
			
			for ($i=0; $i<$n; $i++){
				$tt= $xlsArr[$i][0];
				if( $tt==$key){// начало отбора с фильтра
					$addArr=true;	
					$resultArr[0]=$i;
				}
				
				if($addArr===true && $tt===$end_key){ // Закончить переброс
						$addArr=false;
						$resultArr[1]=$i;
						return $resultArr;
						break;
								
				}
			}
		}
	}
	
	public function LoadOrganization(){
		$f=fopen('system/organiz.dat','r');
		$res_arr= array();
		$i=0;
		while(!feof($f)){
			$data=fgets($f);
			$array_dat=explode(',',$data);
			$res_arr[$i++]=$array_dat;
		}
		fclose($f);
		return $res_arr;
	}
	public function LoadOrganizationID(){
		$f=fopen('system/orgid.dat','r');
		$res_arr= array();
		$i=0;
		while(!feof($f)){
			$data=fgets($f);
			$array_dat=explode(',',$data);
			$res_arr[$i++]=$array_dat[1];
		}
		fclose($f);
		return $res_arr;
	}
//--------------получить название организации по ее ИД
	public function LoadOrganizationFoID($id){
		$f=fopen('system/organiz.dat','r');
		
		//echo "id=$id<br>";
		
		while(!feof($f)){
			$data=fgets($f);
			$array_dat=explode(',',$data);
		//	echo'load id= '.$array_dat[0].'=='.$id.'<br>' ;
			$id2=(int)$array_dat[0];
			if($array_dat[0]==$id){
					$name[0]=$array_dat[2];
					$name[1]=$array_dat[1];
					break;
			}
		}
		fclose($f);
		return $name;
	}
	public function LoadOrgFaindFoID($id){
		$f=fopen('system/orgid.dat','r');
		
		//echo "id=$id<br>";
		
		while(!feof($f)){
			$data=fgets($f);
			$array_dat=explode(',',$data);
			
			$id2=(int)$array_dat[0];
			if($array_dat[0]===$id){
					$id=$array_dat[1];
					
					break;
			}
		}
		fclose($f);
		return $id;
	}

	public function ViewArrayTable($arr){ //Вывод масива в виде таблицы
		
		if(is_array($arr)){ 
			$n=count($arr);
			echo'<table align="center" border = "1">';
			for ($i=0;$i<$n;$i++){
				echo '<tr>';
				if (is_array($arr[$i])){
					$n1=count($arr[$i]);
					for($j=0;$j<$n1;$j++){
						echo '<td>'.iconv('cp1251', 'utf-8', $arr[$i][$j] ).'</td>';
					//	echo '<td>'.$arr[$i][$j].'</td>';
					}
				}else{
					echo '<td>'.iconv('cp1251', 'utf-8', $arr[$i] ).'</td>';
				}
				echo '</tr>';
			}
		echo '</table>';
		}
		else{
			echo 'Не является масивом';
		}
	}
//----------------------Вывод  масива в виде таблицы с выбором какие строки и столбци выводить
	public function ViewArrayTableNummCol($arr,$colls,$rowstart=0, $rowend='end' ){ //Вывод масива в виде таблицы
		
		if(is_array($arr)){ 
			if($rowend=='end'){
				$n=count($arr);
			}else{
				$n=$rowend;
			}
			$col=explode(',',$colls);
			echo'<table align="center" border = "1">';
			//if($rowstart!=0){// если отображать не с начала
				$n1=count($col);
				for($j=0;$j<$n1;$j++){
					echo '<th align="center"><b>'.iconv('cp1251', 'utf-8', $arr[0][$col[$j]] ).'<b></th>';
					//	echo '<td>'.$arr[$i][$j].'</td>';
				}
			//}
			if($rowstart==0){$rowstart=1;}
			for ($i=$rowstart;$i<$n;$i++){
				if($arr[$i][2]!==""){
					$bb=$arr[$i][1]+1;
					if($bb==1 && $arr[$i][1]!==""){
						echo '<tr class="td_table">';
					}else{
						echo '<tr>';
					}
					if (is_array($arr[$i])){// если ето масив
						$n1=count($col);
						for($j=0;$j<$n1;$j++){
							if($arr[$i][1]!==""){
									$aa=iconv('cp1251', 'utf-8', $arr[$i][$col[$j]] );
									$b=$aa+1;
									if($j>=2 ){
										
										if($b!=1){
											$aa=round(floatval($aa),3);
											$aa=number_format($aa, 3, ',', ' ');
											if($aa==0){$aa="";}
										}
										
									//	$aa=$aa+$c;
									}
								
								echo '<td>'.$aa.'</td>';
							}else{
									$aa=iconv('cp1251', 'utf-8', $arr[$i][$col[$j]] );
									if($j>=2 ){
										$b=$aa+1;
										if($b!=1){
											$aa=round(floatval($aa),3);
											$aa=number_format($aa, 3, ',', ' ');
											if($aa==0){$aa="";}
										}
									}
								echo '<td><b>'.$aa.'<b></td>';
							}
						}
					}else{
					echo '<td>'.iconv('cp1251', 'utf-8', $arr[$i] ).'</td>';
					}
					echo '</tr>';
				}
			}
		echo '</table>';
		}
		else{
			echo 'Не является масивом';
		}
	}
	
	//----------------------Вывод  масива в виде таблицы с выбором какие строки и столбци выводить
	public function ArrayInDbNummCol($arr,$colls,$rowstart=0, $rowend='end' ){ //Вывод масива в виде таблицы
		include 'system/db_works';
		if(is_array($arr)){ 
			if($rowend=='end'){
				$n=count($arr);
			}else{
				$n=$rowend;
			}
			$col=explode(',',$colls);
			echo'<table align="center" border = "1">';
			if($rowstart!=0){// если отображать не с начала
				$n1=count($col);
				for($j=0;$j<$n1;$j++){
					echo '<th align="center"><b>'.iconv('cp1251', 'utf-8', $arr[0][$col[$j]] ).'<b></th>';
					//	echo '<td>'.$arr[$i][$j].'</td>';
				}
			}
			for ($i=$rowstart;$i<$n;$i++){
				if($arr[$i][2]!==""){// не отображать пустые строки
					echo '<tr>';
					if (is_array($arr[$i])){// если ето масив
						$n1=count($col);
						for($j=0;$j<$n1;$j++){
							if($arr[$i][1]!==""){// Выделять подпункты
									$aa=iconv('cp1251', 'utf-8', $arr[$i][$col[$j]] );
									if($j==2){
										$aa=round(floatval($aa),3);
										$aa=number_format($aa, 3, ',', ' ');
										if($aa==0){$aa="";}
									}
									
								echo '<td>'.$aa.'</td>';
							}else{
									$aa=iconv('cp1251', 'utf-8', $arr[$i][$col[$j]] );
									if($j==2){
										$aa=round(floatval($aa),3);
										$aa=number_format($aa, 3, ',', ' ');
										if($aa==0){$aa="";}
									}
								echo '<td><b>'.$aa.'<b></td>';
							}
						}
					}else{
					echo '<td>'.iconv('cp1251', 'utf-8', $arr[$i] ).'</td>';
					}
					echo '</tr>';
				}
			}
		echo '</table>';
		}
		else{
			echo 'Не является масивом';
		}
	}
	
	public function FilterArrayXLSANDView($xlsArr,$keyArr, $colls, $key='non'){// отфильтровать масив
		$n=count($xlsArr);
		$n_key=count($keyArr);
		$addArr=false;//флаг нужно ли добавлять елемент в масив
		$resultArr=array();
		$k=1;
		//----------------ЗАГОЛОВОК ТАБЛИЦИ-----------------------
					$col=explode(',',$colls);
					echo'<table align="center" border = "1">';
				//	if($rowstart!=0){// если отображать не с начала
						$n1=count($col);
						for($j=0;$j<$n1;$j++){
							echo '<th align="center"><b>'.iconv('cp1251', 'utf-8', $xlsArr[0][$col[$j]] ).'<b></th>';
					//	echo '<td>'.$arr[$i][$j].'</td>';
						}
				//	}
		
		
		//-----------------------------------------------------
		if($key=='non'){
			$xlsArr[0]=0;
			$xlsArr[1]='end';
			return $xlsArr;
		}else{

			$key=$this->LoadOrgFaindFoID($key);
			for($j=0;$j<$n_key;$j++){
				if($keyArr[$j]=== $key){
					$end_key=$keyArr[$j+1];
					break;
				}
			}
			
			//$key=$this->LoadOrgFaindFoID($key);
			
			for ($i=0; $i<$n; $i++){
				$tt= $xlsArr[$i][1];
				if( $tt==$key){// начало отбора с фильтра
					$addArr=true;	
					$resultArr[0]=$i;
				}
				
				if($addArr===true && $tt===$end_key){ // Закончить переброс
						$addArr=false;
						$resultArr[1]=$i;
						return $resultArr;
						break;
								
				}
	//-----------------------------------вывод таблици----------------
				if($addArr===true){ 
						if($xlsArr[$i][2]!==""){//не показывать пустые строки
							$bb=$xlsArr[$i][1]+1;// переводим в число
							if($bb==1 && $xlsArr[$i][1]!=""){// выделять обл
								echo '<tr class="td_table">';
							}else{
								echo '<tr>';
							}
							if (is_array($xlsArr[$i])){// если ето масив
								$n1=count($col);
								for($j=0;$j<$n1;$j++){
									if($xlsArr[$i][3]!==""){
										$aa=iconv('cp1251', 'utf-8', $xlsArr[$i][$col[$j]] );
										$b=$aa+1;//перебрасываем в число
										if($j>=2 ){
										
											if($b!=1){
												$aa=round(floatval($aa),3);
												$aa=number_format($aa, 3, ',', ' ');
												if($aa==0){$aa="";}
											}
										
									
										}
									
										echo '<td>'.$aa.'</td>';
									}else{
										$aa=iconv('cp1251', 'utf-8', $xlsArr[$i][$col[$j]] );
										if($j>=2 ){
											$b=$aa+1;
											if($b!=1){
												$aa=round(floatval($aa),3);
												$aa=number_format($aa, 3, ',', ' ');
												if($aa==0){$aa="";}
											}
										}
										echo '<td><b>'.$aa.'<b></td>';
									}
								}
							}else{
								echo '<td>'.iconv('cp1251', 'utf-8', $xlsArr[$i] ).'</td>'; // если ето не масив
							}
							echo '</tr>';
						}
				}
		//--------------------------------конец вывода		
				
			}
			echo '</table>';
			
		}
		
	}
	public function  checkMenu(){
		
		$pmenu=$this->getXLSShet('../xls/tor.xls');
		include_once 'db.php';
		$n=count($pmenu);
		for($i=0; $i<$n-2; $i++){
			$result = mysql_query("SELECT * FROM menu_works WHERE id='$i'");
				if($pmenusql=mysql_fetch_array($result)){
					if($pmenu[$i]!=$pmenusql['name']){
						
						$result = mysql_query("UPDATE menu_works SET name='$pmenu[$i]' WHERE id='$i' ");
						echo "<br>в загруженом файле изменился лист $pmenusql[name] на $pmenu[$i]";
					}
				}else{
										
					//$result = mysql_query("INSERT INTO menu_works ( name) VALUES( '$pmenu[$i]'");
					echo "<br>в загруженом файле добавлен лист $pmenu[$i]";
				}
		}
	}
	public function getDateAddexel($date, $interval, $format = 'd.m.Y')
    {
        $d1 = new DateTime($date);
        $result = $d1->add(new DateInterval($interval))->format($format);
        return $result;
    }
	
	public function GetIDOrganization($sekondname){
		
		include_once 'db.php';
		$sekondname=clean_str($sekondname);
		$resull_org = mysql_query("SELECT * FROM `site_base.organization` WHERE `findnamesecond`='$sekondname'");
								echo $sekondname;
				if($myorg=mysql_fetch_array($resull_org)){
					return  $myorg['id'];
				}else{
					$ret=0;
					echo ' ошибка ';
					return $ret;
				}
		
	}
	public function GetArrayOrganizationIDfinsek(){
		
		include_once 'db.php';
		
		$resull_org = mysql_query("SELECT * FROM `organization` ");
					$i=0;			
				While($myorg=mysql_fetch_array($resull_org)){
					$ret[$i++]=array('id'=>$myorg['id'],'find'=>$myorg['findnamesecond']);
					
				}
				return $ret;
		
	}
	public function ExportArrayXLSInDB($xlsArr,$arrorg=array()){//експорт в базу материалов
		if (is_array($xlsArr)){// если ето масив
			
			include_once 'db_material.php';
			//echo '   connectdb <br>';
			$n=count($xlsArr);
			$norg=count($arrorg);
			for($i=1; $i<$n; $i++){
				
				$format = 'Y-m-d';//формат даты для преобразования
					$a1=date($format, PHPExcel_Shared_Date::ExcelToPHP($xlsArr[$i][1])); //переобразование даты с екселя

					$a2=iconv('cp1251', 'utf-8', $xlsArr[$i][2] );// пердмет закупывлы
					$a3=iconv('cp1251', 'utf-8', $xlsArr[$i][3] );// ви дыяльност

					$resull_vid = mysql_query("SELECT * FROM vid_diyal WHERE name='$a3'");
					if($mydiyaln=mysql_fetch_array($resull_vid)){
						$a3=$mydiyaln['id'];
					}
					$a4=iconv('cp1251', 'utf-8', $xlsArr[$i][4] );//Постачальник 
					$a5=iconv('cp1251', 'utf-8', $xlsArr[$i][5] );// Постачальник 2
					$a6=iconv('cp1251', 'utf-8', $xlsArr[$i][6] );//покупець

					for($j=0;$j<$norg;$j++){
						if($arrorg[$j]['find']==$a6){
							$a6=$arrorg[$j]['id'];
							break;
						}
					}

					$a7=iconv('cp1251', 'utf-8', $xlsArr[$i][7] );// сума закупки
					$a8=iconv('cp1251', 'utf-8', $xlsArr[$i][8] );//Сума продажи
							
					$a9=iconv('cp1251', 'utf-8', $xlsArr[$i][12] );// К
					$a10=iconv('cp1251', 'utf-8', $xlsArr[$i][13] );// расходы
					$a11=iconv('cp1251', 'utf-8', $xlsArr[$i][14] );// файл
					$a12=iconv('cp1251', 'utf-8', $xlsArr[$i][16] );// примытки
					$a13=iconv('cp1251', 'utf-8', $xlsArr[$i][15] );// ИД менедера
					switch ($a13){
						case 1:
							$a13=18;
							break;
						case 2:
							$a13=20;
							break;
						case 3:
							$a13=19;
							break;
						case 4:
							$a13=17;
							break;
						case 5:
							$a13=16;
							break;
						case 0:
							$a13=14;
							break;
						
					}
					
					$a14=iconv('cp1251', 'utf-8', $xlsArr[$i][9] );//Предоплата
					$a15=iconv('cp1251', 'utf-8', $xlsArr[$i][10] );//остаточний розрахунок
					$a16=iconv('cp1251', 'utf-8', $xlsArr[$i][11] );//Строк поставки
					$a17=iconv('cp1251', 'utf-8', $xlsArr[$i][17] );// примітки Shared
					
				$resull = mysql_query("SELECT * FROM zvit WHERE data_kp='$a1' AND predm_zakup='$a2' AND vid_diyaln='$a3' AND postach='$a4' AND postachsekondary='$a5' AND pokypets='$a6' AND file='$a11'");
				//echo '     cvery db <br>';
				$us=23;
				if(!$myrole=mysql_fetch_array($resull)){
					
					//echo "   add db ".$a7.'---'.$xlsArr[$i][7];
					$result = mysql_query("INSERT INTO `zvit`(`data_kp`, `predm_zakup`, `vid_diyaln`, `postach`, `tranzit`, `pokypets`, `summ_zakup`, `summ_prod`, `k`, `rasxod`, `file`, `primit`, `id_user`, `predoplata`, `povn_opl_pis_pos`, `strok_postv`, `prim_shared` )VALUES( '$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$a8', '$a9', '$a10', '$a11', '$a12', '$a13', '$a14', '$a15', '$a16', '$a17')");
					if($result){
					//echo' добавлено <br>';
					}
					else{echo' ошибка  <br>'.  mysql_error ();}
				}
			}
		}
	}
	public function GetVidDiyalFoID($id){
		include_once 'db_material.php';
		$resullt = mysql_query("SELECT * FROM  vid_diyal WHERE id='$id'");
		$myvid=mysql_fetch_array($resullt);
		return $myvid['name'];
	}
	public function ViweMaterialTable($arrorg=array(), $arrus=array()){
		include_once 'db_material.php';
		$resullt = mysql_query("SELECT * FROM zvit ");
		echo '<table align="center">';
		echo '<tr><td><b>Дата КП</b></td><td><b>Предмет закупівлі</td><td><b>Вид діяльності</td><td><p align="center"><b>Постачальник</td><td><b>Покупець</td><td><b>Сума закупівлі, грн з ПДВ</td><td><b>Сума продажу, грн з ПДВ</td><td><b>К</td><td><b>Расходы</td><td><b>Файл</td><td><b>Меджер</td><td><b>Предоплата</td><td><b>Остаточний розрахунок, днів</td><td><b>Строк поставки,  днів</td><td><b>Примітки SHARED</td><td><b>Примітки меджера</td><td></td></tr>';
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
						$trnzit=' , '.$mytr['name'];
					}else{
						$trnzit=$mytable['tranzit'];
					}
					
			echo '<tr>';
			echo '<td><p align="center">'.date("d.m.Y", strtotime($mytable['data_kp'])).'</td><td><p align="center">'.$mytable['predm_zakup'].'</td><td><p align="center">'.$this->GetVidDiyalFoID($mytable['vid_diyaln']).'</td>
			<td><p align="center">'.$mytable['postach'].' '.$trnzit.'</td><td><p align="center">'.$pokypets.'</td><td><p align="center">'.number_format($mytable['summ_zakup'], 3, ',', ' ').'</td><td><p align="center">'.number_format($mytable['summ_prod'], 3, ',', ' ').'</td><td><p align="center">'.$mytable['k'].'</td><td><p align="center">'.$mytable['rasxod'].'</td><td><p align="center">'.$mytable['file'].'</td><td><p align="center">'.$user.'</td><td><p align="center">'.$mytable['predoplata'].'%'.'</td><td><p align="center">'.$mytable['povn_opl_pis_pos'].'</td><td><p align="center">'.$mytable['strok_postv'].'</td><td><p align="center">'.$mytable['prim_shared'].'</td><td><p align="center">'.$mytable['primit'].'</td><td><a href="?action=material_table&idsp='.$mytable['id'].'">RS</a></td>';
			echo '</tr>';
		}
		echo'</table>';
	}
	public function ViweMaterialTableFoUsers($arrorg=array(),$id_user){
		include_once 'db_material.php';
		$resullt = mysql_query("SELECT * FROM zvit WHERE pokypets='$id_user'");
		echo '<table align="center">';
		echo '<th>Дата КП</th><th>Предмет закупівлі</th><th>Вид діяльності</th><th><p align="center">Постачальник</th><th>Сума продажу, грн з ПДВ</th>';
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
						$trnzit=' , '.$mytr['name'];
					}else{
						$trnzit=$mytable['tranzit'];
					}
			echo '<tr>';
			echo '<td><p align="center">'.date("d.m.Y", strtotime($mytable['data_kp'])).'</td><td><p align="center">'.$mytable['predm_zakup'].'</td><td><p align="center">'.$this->GetVidDiyalFoID($mytable['vid_diyaln']).'</td>
			<td><p align="center">'.$mytable['postach'].' '.$trnzit.'</td><td><p align="center">'.number_format($mytable['summ_prod'], 3, ',', ' ').'</td>';
			echo '</tr>';
		}
		echo'</table>';
	}
	public function ExportXLSArraySpecif($xlsArr=array()){
		unset($_POST);
		$killpos=count($xlsArr);
		for ($i=1;$i<$killpos;$i++){
			$pr=$i-1;
			$nm='name'.$pr;
			$od_v='od_vimir'.$pr;
			$prise_vx='prise_vxod_za_od'.$pr;
			$kilk='kilk'.$pr;
			$cont='contru'.$pr;
			$_POST[$nm]=iconv('cp1251', 'utf-8', $xlsArr[$i][0] );
			$_POST[$od_v]=iconv('cp1251', 'utf-8', $xlsArr[$i][1] );
			$_POST[$kilk]=$xlsArr[$i][2];
			$_POST[$prise_vx]=$xlsArr[$i][3];
			$_POST[$cont]=iconv('cp1251', 'utf-8', $xlsArr[$i][4] );
			
		}
		$_POST['kilkpos']=$killpos-2;
	//	print_r($_POST);
	}
};


?>