<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set("Brazil/East");
if ( isset( $_POST[ 'editarpedido' ] ) ) {
  $idcliente = $_POST[ 'idcliente' ];
  $valortotalpedido = $_POST[ 'valortotalpedido' ];
  $entregador = $_POST['entregador'];
  $session = $_POST[ 'session' ];
  $metodopagamento = $_POST[ 'metodopagamento' ];
  $obs = $_POST[ 'obs' ];
  $plataforma=$_POST['plataforma'];	
  $atualizarpedido=mysqli_query($link,"UPDATE pedido SET plataforma = '$plataforma', metodopagamento = '$metodopagamento', obs = '$obs', valorpedido = '$valortotalpedido' WHERE pedido = '$session'");
  $atualizarentregador= mysqli_query($link,"UPDATE entrega SET entregador_identregador = '$entregador' WHERE pedido = '$session'");
  $consultafrete=mysqli_query($link,"SELECT valor FROM carrinho WHERE tipo = '3' AND pedido = '$session'");
  $frete=mysqli_fetch_assoc($consultafrete);
  $valorfrete=$frete['valor'];
  $atualizarfrete=mysqli_query($link,"UPDATE entrega SET valor = '$valorfrete' WHERE pedido = '$session'");
  if($entregador == '1' || $entregador == '9')
  {
   $atualizarstatus=mysqli_query($link,"UPDATE entrega SET status = 'PAGO' WHERE pedido = '$session'");  
  }
  else
  {
	   $atualizarstatus=mysqli_query($link,"UPDATE entrega SET status = 'ABERTO' WHERE pedido = '$session'");    
  }
	 $consultanomecliente=mysqli_query($link,"SELECT * FROM cliente WHERE idcliente = '$idcliente' ")or die($cliente_idcliente);
 while($cconsultanomecliente=mysqli_fetch_array($consultanomecliente))
 {
	 $nomecliente=$cconsultanomecliente['nomecliente'];
 }

  if ( $atualizarpedido ) {
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
	$retorno['nomecliente'] = $nomecliente;

  session_regenerate_id();
  echo json_encode( $retorno );


