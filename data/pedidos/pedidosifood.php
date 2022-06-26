<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );

/////////////////////////////////////////////////////////// CONSULTA CARRINHO
if ( $_POST[ 'consultapedido' ]) {
if($_POST['x'] == '0')
{	
$mondaypass = strtotime("last monday");
$mondaypass = date('W', $mondaypass)==date('W') ? $mondaypass-7*86400 : $mondaypass;
$monday = date("Y-m-d",$mondaypass);	
$dom = strtotime("last monday");
$dom = date('W', $dom)==date('W') ? $dom-7*86400 : $dom;
$dom = strtotime(date("Y-m-d",$dom)." +6 days");													
$hoje = date("Y-m-d",$dom);	
}
else
{
$monday = strtotime("last monday");
$monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
$sunday = strtotime(date("Y-m-d",$monday)." +7 days");	
$monday = date("Y-m-d",$sunday);	
$hoje= date("Y-m-d");
}
$dtinicio = explode("-",$monday);
$anoi= $dtinicio[2];
$mesi= $dtinicio[1];
$diai= $dtinicio[0];
$dtinicio=$anoi;
$dtinicio.='/';
$dtinicio.=$mesi;	
$dtinicio.='/';
$dtinicio.=$diai;

$dtfim = explode("-",$hoje);
$anof= $dtfim[2];
$mesf= $dtfim[1];
$diaf= $dtfim[0];
$dtfim=$anof;
$dtfim.='/';
$dtfim.=$mesf;	
$dtfim.='/';
$dtfim.=$diaf;	
$resposta='<div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Plataforma</th>
					 <th>Pagamento</th>
					 <th>Entregador</th>
					 <th>Data</th>
                  </tr>
                </thead>
                <tbody>';
                  
                  $pedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE plataforma='2' AND datapedido between '$monday' and '$hoje'" )or die( "ERRO AO BUSCAR PEDIDOS" );
				if(mysqli_num_rows($pedidos) > 0){	
                  while ( $linhapedidos = mysqli_fetch_array( $pedidos ) ) {

                    $idpedido = $linhapedidos[ 'idpedido' ];
					 $datapedido=explode("-",$linhapedidos['datapedido']);
					 $datapedido=$datapedido[2].'/'.$datapedido[1].'/'.$datapedido[0];
					 
					  
					  $pedido = $linhapedidos['pedido'];
					  $centrega=mysqli_query($link,"SELECT entregador_identregador FROM entrega WHERE pedido = '$pedido'");
					$entregador=mysqli_fetch_assoc($centrega);
					$entregador=$entregador['entregador_identregador'];
					$centregador=mysqli_query($link,"SELECT nomeentregador FROM entregador WHERE identregador = '$entregador'");
					$nentregador=mysqli_fetch_assoc($centregador);
					$nentregador=$nentregador['nomeentregador'];
                    $cliente_idcliente = $linhapedidos[ 'cliente_idcliente' ];
                    $valorpedido = number_format($linhapedidos[ 'valorpedido' ],2);
					 $status = $linhapedidos['status'];
                    $metodo = $linhapedidos[ 'metodopagamento' ];
    $cmetodo = mysqli_query( $link, "SELECT * FROM `pagamento` WHERE idpagamento='$metodo'" )or die( "ERRO AO BUSCAR pagamento" );
    while ( $linhapagamento = mysqli_fetch_array( $cmetodo ) ) {
      $nomepagamento = $linhapagamento[ 'nomepagamento' ];
    }
	  $plataforma = $linhapedidos['plataforma'];
					 $cplataformas = mysqli_query( $link, "SELECT * FROM `plataforma` WHERE idplataforma='$plataforma'" )or die( "ERRO AO BUSCAR PLATAFORMA" );
                      while ( $linhaplataforma = mysqli_fetch_array( $cplataformas ) ) {
                        $nomeplataforma = $linhaplataforma[ 'plataforma' ];
					  
					  };
 
					  
					$buscanome = mysqli_query( $link, "SELECT nomecliente FROM `cliente` WHERE idcliente = '$cliente_idcliente'" )or die( "ERRO AO CLIENTE" );
					while( $linhabuscanome = mysqli_fetch_array($buscanome))
					{
						$nomecliente = $linhabuscanome['nomecliente'];
					}
                    
                 $resposta.= "<tr align='center'>
                    <td  align='center'><a href='#' onClick='btnPedido(\"$pedido\",$cliente_idcliente);' class='btn btn-success'>$idpedido</a></td>
                    <td  align='center'>$nomecliente</td>
                    <td  align='center'><B>R$ $valorpedido</B></td>
                    <td  align='center'>$nomeplataforma</td>
					<td  align='center'>$nomepagamento</td><td  align='center'>$nentregador</td>
					<td  align='center'>$datapedido</td>
                  </tr>";
                  }
                  
                $resposta.= '</tbody>
              </table>
            </div>';
	
  $retorno[ 'status' ] = 'success';
  $retorno[ 'resposta' ] = $resposta;
				}
 else
{
	$retorno['status']='error'; 
 }
 
}
echo json_encode( $retorno );	
ob_end_flush();
?>
