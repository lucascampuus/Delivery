<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );

/////////////////////////////////////////////////////////// CONSULTA CARRINHO
if ( $_POST[ 'pedido' ] == '1' ) {
  $hoje = date( "Y-m-d" );
  $resposta = '<div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th>Plataforma</th>
					 <th>Pagamento</th>
					 <th>Entregador</th>
                  </tr>
                </thead>
                <tbody>';
  $totalcartao = 0;
  $totaldinheiro = 0;
  $totalifood = 0;
  $pedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido = '$hoje'" )or die( "ERRO AO BUSCAR PEDIDOS" );
  if ( mysqli_num_rows( $pedidos ) > 0 ) {
    while ( $linhapedidos = mysqli_fetch_array( $pedidos ) ) {

      $idpedido = $linhapedidos[ 'idpedido' ];
      $pedido = $linhapedidos[ 'pedido' ];
      $centrega = mysqli_query( $link, "SELECT entregador_identregador FROM entrega WHERE pedido = '$pedido'" );
      $entregador = mysqli_fetch_assoc( $centrega );
      $entregador = $entregador[ 'entregador_identregador' ];
      $centregador = mysqli_query( $link, "SELECT nomeentregador FROM entregador WHERE identregador = '$entregador'" );
      $nentregador = mysqli_fetch_assoc( $centregador );
      $nentregador = $nentregador[ 'nomeentregador' ];

      $cliente_idcliente = $linhapedidos[ 'cliente_idcliente' ];
      $valorpedido = number_format( $linhapedidos[ 'valorpedido' ], 2 );
      $status = $linhapedidos[ 'status' ];
      $metodo = $linhapedidos[ 'metodopagamento' ];
      $cmetodo = mysqli_query( $link, "SELECT * FROM `pagamento` WHERE idpagamento='$metodo'" )or die( "ERRO AO BUSCAR pagamento" );
      while ( $linhapagamento = mysqli_fetch_array( $cmetodo ) ) {
        $nomepagamento = $linhapagamento[ 'nomepagamento' ];
      }
      $plataforma = $linhapedidos[ 'plataforma' ];
      $cplataformas = mysqli_query( $link, "SELECT * FROM `plataforma` WHERE idplataforma='$plataforma'" )or die( "ERRO AO BUSCAR PLATAFORMA" );
      while ( $linhaplataforma = mysqli_fetch_array( $cplataformas ) ) {
        $nomeplataforma = $linhaplataforma[ 'plataforma' ];

      };
      if ( $metodo == '1' ) {
        $totaldinheiro = $valorpedido + $totaldinheiro;
      }
      if ( $metodo == '2' || $metodo == '3' || $metodo == '5' ) {
        $totalcartao = $valorpedido + $totalcartao;
      }
      if ( $metodo == '4' ) {
        $totalifood = $totalifood + $valorpedido;
      }


      $buscanome = mysqli_query( $link, "SELECT nomecliente FROM `cliente` WHERE idcliente = '$cliente_idcliente'" )or die( "ERRO AO CLIENTE" );
      while ( $linhabuscanome = mysqli_fetch_array( $buscanome ) ) {
        $nomecliente = $linhabuscanome[ 'nomecliente' ];
      }

      $resposta .= "<tr align='center'>
                    <td  align='center'><a href='#' onClick='btnPedido(\"$pedido\",$cliente_idcliente);' class='btn btn-success'>$idpedido</i></a></td>
                    <td  align='center'><a href='#' onClick='pedidoscliente($cliente_idcliente);'>$nomecliente</i></a></td>
                    <td  align='center'><B>R$ $valorpedido</B></td>
                    <td  align='center'>$nomeplataforma</td>
					<td  align='center'>$nomepagamento</td>
					<td  align='center'>$nentregador</td>
                  </tr>";
    }

    $resposta .= '</tbody>
              </table>
            </div>';
    $retorno[ 'mercadopago' ] = $totalcartao;
    $retorno[ 'caixa' ] = $totaldinheiro;
    $retorno[ 'ifood' ] = $totalifood;

    $retorno[ 'status' ] = 'success';
    $retorno[ 'resposta' ] = $resposta;
  } else {
    $retorno[ 'status' ] = 'error';
  }

}
if ( $_POST[ 'compra' ] == '1' ) {

  $hoje = date( "Y-m-d" );
  $resposta = '<div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>Compra</th>
                    <th>Produto</th>
                    <th>Valor</th>
                  </tr>
                </thead>
                <tbody>';

  $compras = mysqli_query( $link, "SELECT * FROM compras WHERE data = '$hoje'" )or die( "ERRO AO BUSCAR COMPRAS" );
  if ( mysqli_num_rows( $compras ) > 0 ) {
    while ( $linhacompras = mysqli_fetch_array( $compras ) ) {

      $idcompra = $linhacompras[ 'idcompra' ];
      $compra = $linhacompras[ 'compra' ];
      $valorpedido = number_format( $linhacompras[ 'valor' ], 2 );

      $resposta .= "<tr align='center'>
                    <td  align='center'><class='btn btn-success'>$idcompra</i></td>
                    <td  align='center'>$compra</td>
                    <td  align='center'><B>R$ $valorpedido</B></td>
                  </tr>";
    }

    $resposta .= '</tbody>
              </table>
            </div>';

    $retorno[ 'status' ] = 'success';
    $retorno[ 'resposta' ] = $resposta;
  } else {
    $retorno[ 'status' ] = 'error';
  }
}

echo json_encode( $retorno );
ob_end_flush();
?>
