<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include('inc.head.php'); ?>
	<link rel="stylesheet" href="../public/css/miniplayer.css" type="text/css" media="screen" />

	<script type="text/javascript" src="js/jquery.mb.miniPlayer.js"></script>
	<script type="text/javascript" src="../public/js/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="../public/js/jquery.metadata.js"></script>
</head>
<body>
<?php include('util.php');
include('inc.check.php');
?>
<?php
$page = "setlist";
include('inc.header.php'); 
include('inc.autoload.php'); 
?>
 
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Editar Registro</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
		<?php
		
		if($_POST['send'] == 'sended'){
			
			$dados['nome']  	= $_POST['nome'];
			$dados['ordem']  	= $_POST['ordem'];
			$dados['url_play']  	= $_POST['url_play'];
			$dados['url_download'] 	= $_POST['url_download'];
			
			$setlist = new Setlist($_GET['id']);
			
			if($setlist->editar($dados)){
				?>
				
				<!--  start message-green -->
				<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">Item alterado com sucesso.</td>
					<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>
				<!--  end message-green -->
				
				<?php
				
			} else {
				?>
				
				<!--  start message-red -->
				<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left">Erro inesperado.</td>
					<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif"  alt="" /></a></td>
				</tr>
				</table>
				</div>
				<!--  end message-red -->
				
				<?php
			}
			
		}
		
		$setlist = new Setlist($_GET['id']);
		
		?>
	
	<!-- start id-form -->
	<form action="setlist-edicao.php?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Título:</th>
			<td><input type="text" class="inp-form" name="nome" value="<?=$setlist->getNome()?>"/></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Ordem:</th>
			<td><input type="text" class="inp-form" name="ordem" value="<?=$setlist->getOrdem()?>"/></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Url Play:</th>
			<td><input type="text" class="inp-form" name="url_play" value="<?=$setlist->getUrlPLay()?>"/></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Url Download:</th>
			<td><input type="text" class="inp-form" name="url_download" value="<?=$setlist->getUrlDownload()?>"/></td>
			<td></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td valign="top">
				<input type="hidden" value="sended" name="send" />
				<input type="submit" value="" class="form-submit" />
			</td>
			<td></td>
		</tr>
		</table>
	</form>
	<!-- end id-form  -->

	</td>
	<td>
</td>
</tr>
<tr>
<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>

<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->

<div class="clear">&nbsp;</div>
 
<script type="text/javascript">
$(document).ready(function() {
	$(".audio").mb_miniPlayer({
		width:240,
		inLine:false
	});
	
});
</script>

</body>
</html>