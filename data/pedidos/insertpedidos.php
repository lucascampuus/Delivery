<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set("Brazil/East");
if ( isset( $_POST[ 'inserirpedido' ] ) ) {
  $idcliente = $_POST[ 'idcliente' ];
  $valortotalpedido = $_POST[ 'valortotalpedido' ];
  $entregador = $_POST['entregador'];
  $valorentrega = $_POST['valorentrega'];
  $session = $_POST[ 'session' ];
  $datahoje = date( "Y-m-d" );

  $metodopagamento = $_POST[ 'metodopagamento' ];
  $obs = $_POST[ 'obs' ];
  $tipo = 'Normal';
  $combopromocional = $_POST[ 'combopromocional' ];
  $plataforma=$_POST['plataforma'];	


 if ( $combopromocional != '' ) {
    $tipo = $combopromocional;
  }
if($entregador == '1'){$statusentregador='PAGO';}
else{$statusentregador='ABERTO';}	


////////////////////////////////////////////// INSERINDO PEDIDO //////////////////////////////////////////////
	$consultarep = mysqli_query($link,"SELECT * FROM pedido WHERE pedido = '$session'");
	if(mysqli_num_rows($consultarep) == 0)
	{
  $inserirpedido = mysqli_query( $link, "INSERT INTO `pedido`(`idpedido`, `pedido`, `tipopedido`, `plataforma`, `cliente_idcliente`, `valorpedido`, `metodopagamento`, `obs`,`datapedido`, `status`) VALUES ('','$session','$tipo','$plataforma','$idcliente','$valortotalpedido','$metodopagamento','$obs','$datahoje','0')" )or die( "Erro ao Inserir Pedido" );

  $clientes = mysqli_query( $link, "SELECT * FROM `cliente` WHERE idcliente = '$idcliente'" )or die( "ERRO AO BUSCAR CLIENTES" );
  while ( $linhacliente = mysqli_fetch_array( $clientes ) ) {
    $qtdpedido = $linhacliente[ 'qtdpedido' ];
  }
  $qtdpedido = $qtdpedido + 1;
  /*
  if($qtdpedido == '4' && $qtdpedido < '5')
  {	  
  $cupom=rand(0,99999);
  $validade=date( 'Y-m-d', strtotime( "+30 days", strtotime($datahoje) ) ); 	  
  $inserindocupom=mysqli_query($link,"INSERT INTO `cupom`(`idcupom`, `cupom`, `cliente_idcliente`, `pedido`, `valor`, `validade`, `status`) VALUES ('','#$cupom','$idcliente','','5.00','$validade','0')");
  $retorno['cupom']='R$ 5.00';	  
  }
 else if($qtdpedido == '9' && $qtdpedido < '10')
  {	  
  $cupom=rand(0,99999);
  $validade=date( 'Y-m-d', strtotime( "+30 days", strtotime($datahoje) ) ); 	  
  $inserindocupom=mysqli_query($link,"INSERT INTO `cupom`(`idcupom`, `cupom`, `cliente_idcliente`, `pedido`, `valor`, `validade`, `status`) VALUES ('','#$cupom','$idcliente','','10.00','$validade','0')");
  $retorno['cupom']='R$ 10.00';	  
  }
else
{
	$retorno['cupom']=0;
}*/
	

////////////////////////////////////////////// ATUALIZANDO CLIENTE //////////////////////////////////////////////
  $atualizandocliente = mysqli_query( $link, "UPDATE `cliente` SET `qtdpedido`='$qtdpedido',`dtultimopedido`='$datahoje' WHERE idcliente = '$idcliente'" )or die( "ERRO AO ALTERAR CLIENTE" );
	
////////////////////////////////////////////// INSERINDO ENTREGA //////////////////////////////////////////////	
if($entregador != '9')
{
$inserirentrega = mysqli_query($link,"INSERT INTO `entrega`(`identrega`, `entregador_identregador`, `pedido`, `valor`,`dataentrega`, `status`) VALUES ('','$entregador','$session','$valorentrega','$datahoje','$statusentregador')") or die("erro add entrega ('','$entregador','$session','$valorentrega','$datahoje','$statusentregador') ");

///////////////////////////////////////////// ATUALIZANDO ENTREGADOR /////////////////////////////////////////
	$consultaentregador = mysqli_query($link, "SELECT * FROM entregador WHERE identregador = '$entregador'");
	$linhaentregador = mysqli_fetch_assoc($consultaentregador);
	$qtdentregas = $linhaentregador['qtdentregas'] + 1;
	
$atualizandoentregador = mysqli_query( $link, "UPDATE `entregador` SET `qtdentregas`='$qtdentregas' WHERE identregador = '$entregador'" )or die( "ERRO AO ALTERAR ENTREGADOR" );	
}
	
	

  if ( $inserirpedido ) {
    $retorno[ 'status' ] = 'success';
	$retorno['repetido'] = '0';
	$retorno['cupom']=0; 

  } else {
    $retorno[ 'status' ] = 'error';
  }
	}
	else{
		$retorno['repetido'] = '1';
		
	}
	$retorno['pedido'] = $session;
	$retorno['cliente']= $idcliente;

  session_regenerate_id();
  echo json_encode( $retorno );
}

