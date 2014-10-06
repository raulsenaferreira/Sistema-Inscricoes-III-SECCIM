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
$page = "optin";
include('inc.header.php'); 
include('inc.autoload.php'); 
?>
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Cadastro</h1>
	</div>
	<!-- end page-heading -->

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
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
			
		 
				<!--  start product-table ..................................................................................... -->
				Os registros são ordenados, por ordem, depois por título e por último por Data de Inclusão
				<br />
				<br />
				
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left minwidth-1"><a href="javascript:void(0);">Nome</a></th>
					<th class="table-header-repeat line-left"><a href="javascript:void(0);">E-mail</a></th>	
					<th class="table-header-options line-left"><a href="javascript:void(0);">Opções</a></th>
				</tr>
				<?php
					if($_GET['action'] == 'delete'){
						
						$optlist = new Optin($_GET['id']);
						$optlist->apagar();
						
						redirect('optin-lista.php', 1);
						exit();
						
					}
					
					$optin = Optin::getRegistros(array('start' => 0, 'limit' => 500), array("nome" => "ASC"));
					if(count($optin)>0){
						foreach($optin as $opt){
							
				?>
					<tr>
						<td><?=$opt->getNome()?></td>
						<td><?=$opt->getEmail()?></td>
						<td class="options-width">
						<a href="optin-lista.php?id=<?=$opt->getId()?>&action=delete" title="Apagar" class="icon-2 info-tooltip"></a>
						</td>
					</tr>
				<?php
						}
					}
				?>	
				</table>
				<!--  end product-table................................... --> 
				</form>
			</div>
			<!--  end content-table  -->
		
			<!--  start paging..................................................... -->
			<? /*<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
			<tr>
			<td>
				<a href="" class="page-far-left"></a>
				<a href="" class="page-left"></a>
				<div id="page-info">Page <strong>1</strong> / 15</div>
				<a href="" class="page-right"></a>
				<a href="" class="page-far-right"></a>
			</td>
			</tr>
			</table> */ ?>
			<!--  end paging................ -->
			
			<div class="clear"></div>
		 
		</div>
		<!--  end content-table-inner ............................................END  -->
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
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
    

</body>
</html>