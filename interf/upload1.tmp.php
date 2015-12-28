<?php


if($curent_user->QwestPriwilege('LOAD_FILES_IN_MATERIAL')){
	$idval=2;
}
?>							
							<div ><h2><p><b> Форма для загрузки файлов </b></p></h2>
							<form action="system/upload.php" method="post" enctype="multipart/form-data">
							<table class="table_inviz">
							<tr><td class="tr_table">
							<input type="file" name="filename"><br> 
							<input type="hidden" name="loadid" value="2"></td></tr>
							<tr><td class="tr_table">
							<input type="submit" value="Загрузить"><br></td></tr>
							</table>
							</form></div>'