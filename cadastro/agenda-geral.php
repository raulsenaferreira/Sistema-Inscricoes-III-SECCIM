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
		<h1>PROGRAMAÇÃO</h1>
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
				<h2>Olá, <?=$nomeLogado?>! Aqui está a Programação do evento, para se cadastrar basta clicar no ícone situado na coluna "Opções", bom evento :)</h2>
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
					<th class="table-header-options line-left"><a>Opções</a></th>
				</tr>
				
				<?php
					$flag=$_SESSION['flx-login']['id'];

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

					function verificaCadastro($id_evento, $id_aluno){
						$cadastros = Cadastro::getRegistros(array('start' => 0, 'limit' => 500), array("id_evento" => "ASC"));
						$i=0;

						if(count($cadastros)>0){
							foreach ($cadastros as $cad) {
								if($id_aluno==$cad->getIdAluno()){
									$arrayCadastros[$i]=$cad->getIdEvento();
									$i++;
								}
							}
							$isCadastrado = 0;
							for ($j = 0; $j < $i; $j++) {
							 	if($id_evento==$arrayCadastros[$j]){ 
							 		$isCadastrado = 1;
							 	}
							}
						}
						return $isCadastrado;
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

					$agendas = Agenda::getRegistros(array('start' => 0, 'limit' => 500), array("id_evento" => "ASC"));
					
					if($_GET['action']=='cadastrar'){
						$dados['id_evento'] = $_GET['id'];
						$dados['id_aluno'] = $flag;
						$dados['inscrito'] = 1;
						$dados['data_inscricao'] = date("Y/m/d G:i:s");

						$isCadastrado = verificaCadastro($dados['id_evento'], $flag);

						if(count($agendas)>0){
							$k = 0;
							foreach($agendas as $age){
								if($age->getIdEvento()==$dados['id_evento']){
									$dataEvento = converteDia($age->getData());
									$inicioEvento = converteMinutos($age->getInicio());
									$fimEvento = converteMinutos($age->getTermino());
									$cont = $k;
								}
								$arrayDataEvento[$k] = converteDia($age->getData());
								$arrayInicioEvento[$k] = converteMinutos($age->getInicio());
								$arrayFimEvento[$k] = converteMinutos($age->getTermino());
								$arrayIdEvento[$k] = $age->getIdEvento();
								$k++;
							}
							$isHoraIncompativel = 0;
							for($x = 0; $x < $k; $x++){
								if($arrayDataEvento[$x]==$dataEvento){
									if(($inicioEvento > $arrayFimEvento[$x] || $inicioEvento == $arrayFimEvento[$x]) || ($fimEvento < $arrayInicioEvento[$x] || $fimEvento == $arrayInicioEvento[$x])){
										$isHoraIncompativel = 0;
									}
									else{
										$negado = verificaCadastro($arrayIdEvento[$x], $flag);
																				
										if($negado==1){
											$isHoraIncompativel = 1;
										}
									}
								}
							}
						}
						
							if($isCadastrado==0 && $isHoraIncompativel==0){
								$cadastro = new Cadastro();
								if($cadastro->cadastrar($dados)){
									?>
									<!--  start message-green -->
									<div id="message-green">
										<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td class="green-left">Parabéns <?=$nomeLogado?>! Seu cadastro foi realizado com sucesso!</td>
											<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif"   alt="" /></a></td>
										</tr>
										</table>
									</div>
									<!--  end message-green -->
									<?php
								
									$lastId = Cadastro::getLastId();
									
									redirect('agenda-lista.php', 2);
									exit();
								} 
								else { ?>
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
						<?php 	redirect('agenda-geral.php', 2);
									exit();
								}
							}
							else if($isCadastrado==1){ ?>
								<div id="message-red">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td class="red-left">Desculpe <?=$nomeLogado?>! Mas você já se cadastrou neste evento.</td>
											<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif"  alt="" /></a></td>
										</tr>
									</table>
								</div>
					<?php	redirect('agenda-geral.php', 2);
									exit();
							}
							elseif ($isHoraIncompativel == 1) {?>
								<div id="message-red">
									<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td class="red-left">Desculpe <?=$nomeLogado?>! Mas o horário deste evento entra em choque com outro evento em que você está cadastrado.</td>
											<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif"  alt="" /></a></td>
										</tr>
									</table>
								</div>
						<?php	redirect('agenda-geral.php', 2);
									exit();
							}			
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
						<td style="width:20px;">
						<a href="agenda-geral.php?id=<?=$age->getIdEvento()?>&action=cadastrar" title="Cadastrar-se no Evento" class="icon-1 info-tooltip"></a>
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
<footer>Desenvolvido por <a href="http://www.raulferreira.com.br" target="_blank">Raul S. Ferreira</a> - CACC/UFRRJ</footer>
</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>  

</body>
</html>