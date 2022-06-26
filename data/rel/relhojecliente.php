<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );

/////////////////////////////////////////////////////////// CONSULTA CARRINHO
if ( $_POST[ 'pedido' ] == '1' ) {
  $idcliente=$_POST['idcliente'];
  $resposta='<div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>Pedido</th>
                    <th>Data Pedido</th>
                    <th>Valor</th>
                    <th>Plataforma</th>
					 <th>Pagamento</th>
					 <th>Entregador</th>
					 <th>Status</th>
                  </tr>
                </thead>
                <tbody>';
                  $valortotalpedidoscliente=0;
                  $pedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE cliente_idcliente = '$idcliente' " )or die( "ERRO AO BUSCAR PEDIDOS" );
				if(mysqli_num_rows($pedidos) > 0){	
                  while ( $linhapedidos = mysqli_fetch_array( $pedidos ) ) {

                    $idpedido = $linhapedidos[ 'idpedido' ];
					 $pedido = $linhapedidos['pedido'];
					$centrega=mysqli_query($link,"SELECT entregador_identregador FROM entrega WHERE pedido = '$pedido'");
					$entregador=mysqli_fetch_assoc($centrega);
          if(mysqli_num_rows($centrega)>0){
					$entregador=$entregador['entregador_identregador'];
					$centregador=mysqli_query($link,"SELECT nomeentregador FROM entregador WHERE identregador = '$entregador'");
					$nentregador=mysqli_fetch_assoc($centregador);
					$nentregador=$nentregador['nomeentregador'];
          }
          else
          {
            $nentregador='Batattos';
          }
					$datapedido=explode("-",$linhapedidos['datapedido']);  
					$datapedido=$datapedido[2].'/'.$datapedido[1].'/'.$datapedido[0];
                    $cliente_idcliente = $linhapedidos[ 'cliente_idcliente' ];
                    $valorpedido = number_format($linhapedidos[ 'valorpedido' ],2);
					$status = $linhapedidos['status'];
					if($status == '0')
					{
					$valortotalpedidoscliente=$valortotalpedidoscliente+$valorpedido;
					$bg='#FFFFFF';
					$status='Concluído';
					}
					if($status == '1')
					{
					$bg='#F0CBCB';	
					$status='Cancelado'; 
					}
					 
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
                    
                 $resposta.= "<tr align='center' bgcolor='$bg'>
                    <td  align='center'><a href='#' onClick='btnPedido(\"$pedido\",$cliente_idcliente);' class='btn btn-success'>$idpedido</i></a></td>
                    <td  align='center'>$datapedido</td>
                    <td  align='center'><B>R$ $valorpedido</B></td>
                    <td  align='center'>$nomeplataforma</td>
					<td  align='center'>$nomepagamento</td>
					<td  align='center'>$nentregador</td>
					<td  align='center'>$status</td>
                  </tr>";
                  }
                  
                $resposta.= '</tbody>
              </table>
            </div>';
	
  $retorno[ 'status' ] = 'success';
  $retorno[ 'resposta' ] = $resposta;
  $retorno['cliente'] = $nomecliente;
  $retorno['valortotal']=number_format($valortotalpedidoscliente,2);
				}
 else
{
	$retorno['status']='error'; 
 }
 
}

echo json_encode( $retorno );	
ob_end_flush();
?>
