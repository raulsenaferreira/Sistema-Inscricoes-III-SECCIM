<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SECCIM - Login</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<!--  jquery core -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="js/jquery/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="js/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg"> 
<?php include('util.php'); ?>
<?php include('inc.autoload.php'); ?>
 
<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	
	<div id="logo-login">
		<h1> SECCIM - Login </h1>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
	<!--  start login-inner -->
	<div id="login-inner">
		<?php
		$submit = $_POST["send"];
		if($submit=="sended") {
				
			$aluno = new Aluno();
			
			$email = trim($_POST['email']);
			$senha = trim($_POST['senha']);
			
			$id = $aluno->autenticacao($email,$senha);
			if(!$id){
				echo "<b style='font-size:10px;'>Login ou senha incorretos</b>";
			} else {
				echo "<b style='font-size:10px;'>Redirecionando para o sistema</b>";
				$_SESSION['flx-login']['on'] = 'true';
				$_SESSION['flx-login']['id'] = $id[0];
				$_SESSION['flx-login']['lg'] = $id[1];
				
				redirect('agenda-lista.php',1);
				exit();
			}
		}
		?>
		<form action="index.php" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>E-mail</th>
			<td><input type="text"  class="login-inp" name="email"/></td>
		</tr>
		<tr>
			<th>Senha</th>
			<td><input type="password" name="senha" value="******"  onfocus="this.value=''" class="login-inp" /></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="hidden" value="sended" name="send" /><input type="submit" class="submit-login" /></td>
		</tr>
		</form>
		</table>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
 </div>
 <!--  end loginbox -->
 
</div>
<!-- End: login-holder -->
</body>
</html>
