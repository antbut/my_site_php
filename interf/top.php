			<?php
			echo "<h3>Здраствуйте $curent_user->name  ". $curent_user->GetOrganization()."</h3>"; 
			echo '<section>';
			echo '<nav class="cl-effect-7">';
			echo '<p align="right"><a href="javascript:history.back();">На уровень выше</a><a href="?action=main">Выбраь другой раздел </a><a href="?action=exit">  Выход</a></p>';
			echo '</nav></section>';
			?>