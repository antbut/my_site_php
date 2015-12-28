				<?php
				
				//include '../system/db.php';
				
				echo '<ul id="nav3">';
					
					$result = mysql_query("SELECT * FROM menu_works");
					while($mymenu=mysql_fetch_array($result)){
						
							echo '<li><a href="?action=work_table&idst='.$mymenu['id'].'">'.$mymenu['name'].'</a>';
						
					}
				echo '</ul>';
				?>