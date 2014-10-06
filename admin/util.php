<?php
	function redirect($pagina,$tempo) {
		echo "<meta http-equiv='REFRESH' content=\"$tempo; URL='$pagina'\">";
	}
?>