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
$nomeLogado = $_SESSION['flx-login']['lg'];
$flag=$_SESSION['flx-login']['id'];
?>
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Programação Cadastrada</h1>
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
				<?php if ($flag == 1) { ?><h2>Olá, <?=$nomeLogado?>! Aqui está a Programação do evento cadastrada até o momento, para cadastrar ou excluir os eventos basta clicar em "Opções".</h2>
							<?php }else{?><h2>Olá, <?=$nomeLogado?>! Aqui está a Programação do evento cadastrada até o momento</h2><?php }?>
				<br />
				<br />
				
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-options line-left minwidth-1"><a href="javascript:void(0);">Data</a></th>
					<th class="table-header-repeat line-left"><a href="javascript:void(0);">Título</a></th>
					<th class="table-header-repeat line-left"><a href="javascript:void(0);">Descrição</a></th>	
					<th class="table-header-options line-left"><a href="javascript:void(0);">Modalidade</a></th>
					<th class="table-header-options line-left"><a href="javascript:void(0);">Nº de inscritos</a></th>
					<th class="table-header-options line-left"><a href="javascript:void(0);">Vagas restantes</a></th>
					<?php
							if ($flag == 1) { ?><th class="table-header-options line-left"><a>Opções</a></th>
							<?php }?>
				</tr>
				<?php
				$agendas = Agenda::getRegistros(array('start' => 0, 'limit' => 500), array("id_evento" => "ASC"));

					function converteMinutos($hora){
						$var_array_h_m = explode(":",$hora);      
					    $var_tot_minutos = ($var_array_h_m[0] *60)+ $var_array_h_m[1];
					    
					    return $var_tot_minutos;
					}
					function converteDia($data){
						$var_array_h_m = explode("-",$data);   
					    $var_total = $var_array_h_m[2];
					    return $var_total;
					}
					function converteData($data){
						$var_array_h_m = explode("-",$data);   
					    $var_total = $var_array_h_m[2]."/".$var_array_h_m[1]."/".$var_array_h_m[0];
					    return $var_total;
					} 
					function qtdInscritos($id_evento){
						$cadastros = Cadastro::getRegistros(array('start' => 0, 'limit' => 500), array("id_evento" => "ASC"));
						$i=0;

						if(count($cadastros)>0){
							foreach ($cadastros as $cad) {
								if($id_evento==$cad->getIdEvento()){
									$i++;
								}
							}
						}

						return $i;
					}
					?>
				<?php
					if($_GET['action'] == 'delete'){
						
						$agenda = new Agenda($_GET['id']);
						$agenda->apagar();
						
						redirect('agenda-lista.php', 1);
						exit();
						
					}
					
					if(count($agendas)>0){
						foreach($agendas as $age){
						$inscritos = qtdInscritos($age->getIdEvento());	
				?>
					<tr>
						<td><?=converteData($age->getData())?>  <br> <?=$age->getInicio()?> às <?= $age->getTermino() ?></td>
						<td><?=$age->getTitulo()?></td>
						<td><?=$age->getDescricao()?></td>
						<td><?=$age->getTipo()?></td>
						<td><?=$inscritos?></td>
						<td><?=$age->getVagas()-$inscritos?></td>
						<?php
							if ($flag == 1) { ?>
								<td style="width:20px;">
									<a href="agenda-geral.php?id=<?=$age->getIdEvento()?>&action=delete" title="Apagar Evento" class="icon-1 info-tooltip"></a>
								</td>
						<?php	}?>
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