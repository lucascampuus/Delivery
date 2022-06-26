<?php	
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( $_POST[ 'data' ] = '1') {
	
$datapesquisa = $_POST['datapesquisa'];
$datapesquisaview = $_POST['datapesquisa'];	
$datapesquisa = explode("/",$datapesquisa);
$anoi= $datapesquisa[2];
$mesi= $datapesquisa[1];
$diai= $datapesquisa[0];
$datapesquisa=$anoi;
$datapesquisa.='-';
$datapesquisa.=$mesi;	
$datapesquisa.='-';
$datapesquisa.=$diai;	
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
						<th align="center">Alaminutas</th>
						<th align="center">Batatas</th>
                        <th align="center">Massas</th>
                        <th align="center">Valor</th>
                      </tr>
                    </thead>
                    <tbody>';
                      				
                      $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido = '$datapesquisa'" );
	$cpedidos2 = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido = '$datapesquisa'" );
	$cpedidos3 = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido = '$datapesquisa'" );
                      $npedidos = mysqli_num_rows( $cpedidos );
                      $qtdbatatas = '0';
					  $qtdalaminutas='0';
					  $qtdmassas='0';	
                      while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
                        $pedido = $lpedidos[ 'pedido' ];
                        $cqtdbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido'AND tipo = '0'" );
                        $lqtdbatatas = mysqli_num_rows( $cqtdbatatas );
                        $qtdbatatas = $lqtdbatatas + $qtdbatatas;
                       }
	 while ( $lpedidos2 = mysqli_fetch_array( $cpedidos2 ) ) {
                        $pedido2 = $lpedidos2[ 'pedido' ];
                        $cqtdbatatas2 = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido2'AND tipo = '7'" );
                        $lqtdbatatas2 = mysqli_num_rows( $cqtdbatatas2 );
                        $qtdalaminutas = $lqtdbatatas2 + $qtdalaminutas;
                       }
	 while ( $lpedidos3 = mysqli_fetch_array( $cpedidos3 ) ) {
                        $pedido3 = $lpedidos3[ 'pedido' ];
                        $cqtdbatatas3 = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido3'AND tipo = '8'" );
                        $lqtdbatatas3 = mysqli_num_rows( $cqtdbatatas3 );
                        $qtdmassas = $lqtdbatatas3 + $qtdmassas;
                       }
				      $cvalorpedido = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE datapedido = '$datapesquisa'" );
        		      $lvalorpedidos = mysqli_fetch_assoc( $cvalorpedido );
        			  $valorpedidos = $lvalorpedidos[ 'total' ];


                      
                      $resposta.= '<tr align="center">
                        <td  align="center">'.$npedidos.'</td>
						<td  align="center">'.$qtdalaminutas.'</td>
						<td  align="center">'.$qtdbatatas.'</td>
                        <td  align="center">'.$qtdmassas.'</td>
                        <td align="center">R$ <b>'.number_format($valorpedidos,1).'</b></td>
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
	

				      $cvalorcompra = mysqli_query( $link, "SELECT SUM(valor) AS total FROM compras WHERE data = '$datapesquisa'" );
	$cqtdcompra = mysqli_query( $link, "SELECT * FROM compras WHERE data = '$datapesquisa'" );
					 $qtdcompras = mysqli_num_rows( $cqtdcompra );
						$lvalorcompras = mysqli_fetch_assoc( $cvalorcompra );
        			  $valorcompras = $lvalorcompras[ 'total' ];
	
	  $resposta.= '<tr align="center">
                        <td  align="center">'.$qtdcompras.'</td>
                        <td align="center">R$ <b>'.number_format($valorcompras,1).'</b></td>
                      </tr></tbody>
					  </div>
					  </div>';
	
	
	
	
	
	
	
	$retorno['data'] = $datapesquisaview;
	$retorno['resposta'] = $resposta;
	$retorno['status'] = 'success';
	echo json_encode( $retorno );
}
?>