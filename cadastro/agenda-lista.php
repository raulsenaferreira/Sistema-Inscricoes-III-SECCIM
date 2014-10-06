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
?>
 
<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>MINHA AGENDA</h1>
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
				<h2>Olá, <?=$nomeLogado?>! Aqui estão todos os eventos que você está cadastrado!</h2>
				<br />
				<br />
				
				<form id="mainform" action="">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-options line-left minwidth-1"><a href="javascript:void(0);">Data</a></th>
					<th class="table-header-repeat line-left"><a href="javascript:void(0);">Título</a></th>
					<th class="table-header-repeat line-left"><a href="javascript:void(0);">Descrição</a></th>	
					<th class="table-header-options line-left"><a href="javascript:void(0);">Modalidade</a></th>
					<th class="table-header-options line-left"><a href="javascript:void(0);">Número de inscritos</a></th>
					<th class="table-header-options line-left"><a href="javascript:void(0);">Vagas restantes</a></th>
					<th class="table-header-options line-left"><a href="javascript:void(0);">Opções</a></th>
				</tr>
				<?php
				$flag=$_SESSION['flx-login']['id'];

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

					if($_GET['action'] == 'delete'){
						
						$id = $_GET['id'];
						$id2 = $_GET['id2'];
						$id3 = $flag;
						$cadastro = new Cadastro($id, $id2, $id3);
						$cadastro->apagar();
						
						redirect('agenda-lista.php', 1);
						exit();
					}
					$cadastros = Cadastro::getRegistros(array('start' => 0, 'limit' => 500), array("id_evento" => "ASC"));
					$i=0;

					if(count($cadastros)>0){
						foreach ($cadastros as $cad) { 
							if($flag==$cad->getIdAluno()){
								$arrayCadastros[$i]=$cad->getIdEvento();
								$idDoCadastro[$i]=$cad->getIdCadastro();
								$i++;
							}
						}
					}

					$agendas = Agenda::getRegistros(array('start' => 0, 'limit' => 500), array("data" => "ASC"));
	
					if(count($agendas)>0){
						$j=0;
						foreach($agendas as $age){
							$inscritos = qtdInscritos($age->getIdEvento());
							if($age->getIdEvento()==$arrayCadastros[$j]){
								$idDC = $idDoCadastro[$j];
								$j++;
				?>
					<tr>
						<td><?=$age->getData()?>  <br> <?=$age->getInicio()?> às <?= $age->getTermino() ?></td>
						<td><?=$age->getTitulo()?></td>
						<td><?=$age->getDescricao()?></td>
						<td><?=$age->getTipo()?></td>
						<td><?=$inscritos?></td>
						<td><?=$age->getVagas()-$inscritos?></td>
						<td style="width:20px;">
						<a href="agenda-lista.php?id=<?=$idDC?>&id2=<?=$age->getIdEvento()?>&action=delete" title="Sair do evento" class="icon-2 info-tooltip"></a>
						</td>
					</tr>
				<?php 		
							}
						}
					}
					
				?>	
				</table>
				<!--  end product-table................................... --> 
				</form>
			</div>
			
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
<footer>Desenvolvido por <a href="http://www.raulferreira.com.br" target="_blank">Raul S. Ferreira</a> - CACC UFRRJ</footer>
</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
    

</body>
</html>