<?php
if($_SESSION['flx-login']['on'] != 'true'){
	redirect('index.php', 0);
	exit();
}
?>
