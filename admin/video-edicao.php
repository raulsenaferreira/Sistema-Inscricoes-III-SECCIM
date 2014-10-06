<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include('inc.head.php'); ?>
</head>
<body>
<?php include('util.php');
include('inc.check.php');
?>
<?php
$page = "video";
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
			$dados['url']  		= $_POST['url'];
			$dados['ordem']  	= $_POST['ordem'];
			
			$video = new Video($_GET['id']);
			
			if($video->editar($dados)){
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
		
		$video = new Video($_GET['id']);
		
		?>
	
	<!-- start id-form -->
	<form action="video-edicao.php?id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Título:</th>
			<td><input type="text" class="inp-form" name="nome" value="<?=$video->getNome()?>"/></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Url:</th>
			<td><input type="text" class="inp-form" name="url" value="<?=$video->getUrl()?>"/></td>
		</tr>
		<tr>
			<th valign="top">Ordem:</th>
			<td><input type="text" class="inp-form" name="ordem" value="<?=$video->getOrdem()?>"/></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
				<iframe id="yt-iframe" width="249" height="146" src="http://www.youtube.com/embed/<?=$video->getUrl()?>" frameborder="0" allowfullscreen style="margin-top:10px;float:left;"></iframe>
			</td>
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
 
</body>
</html>