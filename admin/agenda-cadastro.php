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
$page = "agenda";
include('inc.header.php'); 
include('inc.autoload.php'); 
$flag=$_SESSION['flx-login']['id'];
if ($flag == 1) {
?>
 
<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Adicionar Registro</h1></div>


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
			
			$datapub = explode("/", $_POST['datapub']);
			
			$dados['nome']  	= $_POST['nome'];
			$dados['texto']		= $_POST['texto'];
			$dados['datapub']	= $datapub[2].$datapub[1].$datapub[0];
			$dados['url']		= $_POST['url'];
			
			$agenda = new Agenda();
			
			if($agenda->cadastrar($dados)){
				?>
				
				<!--  start message-green -->
				<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">Item adicionado com sucesso.</td>
					<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>
				<!--  end message-green -->
				
				<?php
				
				$lastId = Agenda::getLastId();
				
				redirect('agenda-edicao.php?id='.$lastId, 1);
				exit();
				
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
		
		?>
	
	<!-- start id-form -->
	<form action="agenda-cadastro.php" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
		<tr>
			<th valign="top">Título do Evento:</th>
			<td><input type="text" class="inp-form" name="nome" value="<?=$_POST['titulo']?>"/></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Descrição:</th>
			<td colspan="2"><textarea name="texto" style="width:97%;height:150px;" maxlength="180"><?=$_POST['descricao']?></textarea><br /><br /> Máximo de 180 Caracteres</td>
		</tr>
		<tr>
			<th valign="top">Data do Evento:</th>
			<td><input type="text" class="inp-form" name="datapub" value="<?=$_POST['datapub']?>" maxlength="10"/></td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Hora início:</th>
			<td><input type="text" class="inp-form" name="url" value="<?=$_POST['inicio']?>" maxlength="5"/></td>
			<th valign="top">Hora Fim:</th>
			<td><input type="text" class="inp-form" name="url" value="<?=$_POST['fim']?>" maxlength="5"/></td>
		</tr>
		<tr>
			<th valign="top">Tipo do Evento:</th>
			<td>
				<select>
					<option>Palestra</option>
					<option>Minicurso</option>
					<option>Dojo</option>
				</select>
			</td>
			<td></td>
		</tr>
		<tr>
			<th valign="top">Vagas:</th>
			<td><input type="text" class="inp-form" name="url" value="<?=$_POST['vagas']?>" maxlength="4"/></td>
			<td></td>
		</tr>
		<tr>
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
	$('input[name=datapub]').keypress(function(e){
		if ((e.which < 48 || e.which > 57) && e.which != 8 && e.which != 0)
			return false;
		v = $(this).val();
		v=v.replace(/\D/g,"");
		v=v.replace(/^(\d{4})(\d)/,"$1/$2");
		v=v.replace(/^(\d{2})(\d)/,"$1/$2");
		$(this).val(v);
	}); 
</script>
<?php }
else {?><h1 align="center" style="color:red;">VOCÊ ESTÁ TENTANDO BURLAR O SISTEMA ???? DEIXA DE SER MANÉ !!</h1><?php }?>
</body>
</html>