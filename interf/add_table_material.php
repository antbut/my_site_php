<?php
ini_set('display_errors','On');
$id_user=$curent_user->id_user;
//	echo 'id_user='.$id_user;
?>
<form method="post"  action="work.php?action=new_specif" autocomplete="off" align="center">
<table align="left">
       <tr>
		<td><label for="zvit">Предмет закупівлі</label></td>
		<td><input type="text" name="predm_zakup" ></input></td>
       </tr>
	   <tr>
		<td><label for="zvit">Постачальник</label></td>
		<td><input type="text" name="postach" "></input></td>
       </tr>
	   <tr>
		<td><label for="zvit">Транзит</label></td>
		<td><select name="tranzit" size="1">
			<?php 
			mysql_close($db);
			include 'system/db_material.php';
			$resull = mysql_query("SELECT * FROM tranzit");
				while($myorg=mysql_fetch_array($resull)){
					
					
						echo '<option value="'.$myorg['id'].'">'.$myorg['name'].'</option>';
					
				}
			?>
			</select>
			</td>
       </tr>
	   <tr>
		<td><label for="zvit">Покупець</label></td>
		<td><select name="pokypets" size="1">
			<?php 
			include 'system/db.php';
			$resull = mysql_query("SELECT * FROM organization");
				while($myorg=mysql_fetch_array($resull)){
					
					
						echo '<option value="'.$myorg['id'].'">'.$myorg['name'].'</option>';
					
				}
			?>
			</select>
			</td>
       </tr>
	   <tr>
		<td><label for="zvit">Вид діяльності</label></td>
		<td><select name="vid_diyaln" size="1">
			<option selected="selected" value="1">Поточна</option>
			<option value="2">ІП</option>
			<option value="3">Приєднання</option>
			</select>
		</td>
       </tr>
	   <tr>
		<td><label for="zvit">Строк поставки,  днів</label></td>
		<td><input type="text" name="strok_postv" value="30"></input></td>
       </tr>
	   <tr>
		<td><label for="zvit">Умови поставки</label></td>
		<td><input type="text" name="yamov_postav" value="DDP"></input></td>
       </tr>
	   <tr>
		<td><label for="zvit">Передоплата, %</label></td>
		<td><input type="text" name="predoplata" value="50"></input></td>
       </tr>
	   <tr>
		<td><label for="zvit">Повна оплата, після поставки, днів</label></td>
		<td><input type="text" name="povn_opl_pis_pos" value="5"></input></td>
       </tr>
	   <tr>
		<td><label for="zvit">%</label></td>
		<td><input type="text" name="prots" value="0"></input></td>
       </tr>
	   <tr><td></td><input type="hidden" name="id_user" value="<?php echo $curent_user->id_user; ?>"></td>
	   <td align="center"><input type="submit" name="type_send" value="Создать Спецификацию" size="5" style="width:150px;height:30px" ></input></td>
	   </tr>
	   
</table>
</form>

		<form action="?action=upload_ful_specif" method="post" enctype="multipart/form-data">
							<table  class="tr_table" style="position: absolute; top: 250px; right: 100px">
							<th >Загрузить спецификацию</th>
							<tr ><td class="tr_table">
							<input type="file" name="filename"><br>
							
							<input type="hidden" name="loadid" value="1"></td></tr>
							<tr><td class="tr_table">
							<input type="submit" value="Загрузить"></td></tr>
							</table>
							</form>

<