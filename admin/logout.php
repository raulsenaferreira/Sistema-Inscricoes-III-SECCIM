<?php session_start();
include('util.php'); 
$_SESSION['flx-login'] = NULL;
redirect('index.php', 0);
exit();
?>

