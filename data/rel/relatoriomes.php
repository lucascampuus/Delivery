<?php
include "../connect/conexaomysql.php";
setlocale( LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese' );
date_default_timezone_set( 'America/Sao_Paulo' );
if ( $_POST[ 'mes' ] ) {

  $mes = $_POST[ 'mes' ];
  /*$datapesquisa = explode("/",$datapesquisa);
  $anoi= $datapesquisa[2];
  $mesi= $datapesquisa[1];
  $diai= $datapesquisa[0];
  $datapesquisa=$anoi;
  $datapesquisa.='-';
  $datapesquisa.=$mesi;	
  $datapesquisa.='-';
  $datapesquisa.=$diai;*/
  $dataini = date( "Y-$mes-01" );
  $datafim = date( "Y-$mes-t" );
  $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido between '$dataini' and '$datafim'" )or die( "$datafim,$dataini" );
  $npedidos = mysqli_num_rows( $cpedidos );
  if ( $npedidos > 0 ) {
    $resposta = '
<div class="card shadow mb-4 border-3"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Vendas</h6>
              </div><div class="table-responsive">
                  <table class="table table-bordered" id="tabelavendas" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Pedidos</th>
                        <th align="center">Batatas</th>
                        <th align="center">Valor</th>
                      </tr>
                    </thead>
                    <tbody>';


    $qtdbatatas = '0';
    while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
      $pedido = $lpedidos[ 'pedido' ];
      $cqtdbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '0'" );
      $lqtdbatatas = mysqli_num_rows( $cqtdbatatas );
      $qtdbatatas = $lqtdbatatas + $qtdbatatas;
    }
    $cvalorpedido = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE datapedido between '$dataini' and '$datafim'" );
    $lvalorpedidos = mysqli_fetch_assoc( $cvalorpedido );
    $valorpedidos = $lvalorpedidos[ 'total' ];


    $resposta .= '<tr align="center">
                        <td  align="center">' . $npedidos . '</td>
                        <td  align="center">' . $qtdbatatas . '</td>
                        <td align="center">R$ <b>' . number_format( $valorpedidos, 1 ) . '</b></td>
                      </tr></tbody>
                  </table>
                </div>
				</div>
				<div class="card shadow mb-4 border-3"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Compras</h6>
              </div>
				<div class="table-responsive">
                  <table class="table table-bordered" id="tabelacompras" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Compras</th>
                        <th align="center">Valor</th>
                      </tr>
                    </thead>
                    <tbody>';


    $cvalorcompra = mysqli_query( $link, "SELECT SUM(valor) AS total FROM compras WHERE data between '$dataini' and '$datafim'" );
    $cqtdcompra = mysqli_query( $link, "SELECT * FROM compras WHERE data between '$dataini' and '$datafim'" );
    $qtdcompras = mysqli_num_rows( $cqtdcompra );
    $lvalorcompras = mysqli_fetch_assoc( $cvalorcompra );
    $valorcompras = $lvalorcompras[ 'total' ];

    $balanTotal = $valorpedidos - $valorcompras;
    if ( $balanTotal > 0 ) {
      $text = 'success';
    } else {
      $text = 'danger';
    }

    $resposta .= '<tr align="center">
                        <td  align="center">' . $qtdcompras . '</td>
                        <td align="center">R$ <b>' . number_format( $valorcompras, 1 ) . '</b></td>
                      </tr></tbody></table>
					  </div>
					  </div>
					  </div>

		
				<div class="card shadow mb-4 border-3"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3  align-items-center justify-content-between bg-' . $text . '">
                <h6 class="m-0 font-weight-bold text-white">Balanço</h6>
              </div>
				
					<div class="form-control" align="center">R$ <b>' . number_format( $balanTotal, 1 ) . '</b></div>
                     
					
					  </div>
					  ';
    $retorno[ 'status' ] = 'success';
    $monthNum = $mes;

    $mes_extenso = array( '','Janeiro','Fevereiro','Marco','Abril','Maio','Junho','Julho','Agosto','Novembro','Setembro','Outubro','Dezembro');
    $mes = explode( "0", $mes );
    $mes = $mes[ 1 ];
    $retorno[ 'mes' ] = $mes_extenso[ $mes ];
    $retorno[ 'resposta' ] = $resposta;
  } else {
    $retorno[ 'status' ] = 'error';

  }


  echo json_encode( $retorno );
}
?>