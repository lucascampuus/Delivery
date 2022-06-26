<?php
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( $_POST[ 'entredatas' ] = '1' ) {


  $dtinicio = $_POST[ 'dtinicio' ];
  $dtinivis = $_POST[ 'dtinicio' ];
  $dtinicio = explode( "/", $dtinicio );
  $anoi = $dtinicio[ 2 ];
  $mesi = $dtinicio[ 1 ];
  $diai = $dtinicio[ 0 ];
  $dtinicio = $anoi;
  $dtinicio .= '-';
  $dtinicio .= $mesi;
  $dtinicio .= '-';
  $dtinicio .= $diai;

  $dtfim = $_POST[ 'dtfim' ];
  $dtfimvis = $_POST[ 'dtfim' ];
  $dtfim = explode( "/", $dtfim );
  $anof = $dtfim[ 2 ];
  $mesf = $dtfim[ 1 ];
  $diaf = $dtfim[ 0 ];
  $dtfim = $anof;
  $dtfim .= '-';
  $dtfim .= $mesf;
  $dtfim .= '-';
  $dtfim .= $diaf;


  $resposta = '<div class="card shadow mb-4 border-3"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Vendas</h6>
              </div>
<div class="table-responsive">
                  <table class="table table-bordered" id="tabelaadicionais" width="100%" cellspacing="0">
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
  $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE status = '0' AND datapedido between '$dtinicio' and '$dtfim'" );
  $cpedidos3 = mysqli_query( $link, "SELECT * FROM pedido WHERE status = '0' AND datapedido between '$dtinicio' and '$dtfim'" );
  $cpedidos2 = mysqli_query( $link, "SELECT * FROM pedido WHERE status = '0' AND datapedido between '$dtinicio' and '$dtfim'" );
  $npedidos2 = mysqli_num_rows( $cpedidos2 );
  $qtdbatatas = '0';
  $qtdalaminutas = '0';
  $qtdmassas = '0';
  while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
    $pedido = $lpedidos[ 'pedido' ];
    $cqtdbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido'AND tipo = '0' AND status = '1'" );
    $lqtdbatatas = mysqli_num_rows( $cqtdbatatas );
    $qtdbatatas = $lqtdbatatas + $qtdbatatas;
  }
  while ( $lpedidos2 = mysqli_fetch_array( $cpedidos2 ) ) {
    $pedido2 = $lpedidos2[ 'pedido' ];
    $cqtdbatatas2 = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido2'AND tipo = '7' AND status = '1'" );
    $lqtdbatatas2 = mysqli_num_rows( $cqtdbatatas2 );
    $qtdalaminutas = $lqtdbatatas2 + $qtdalaminutas;
  }
  while ( $lpedidos3 = mysqli_fetch_array( $cpedidos3 ) ) {
    $pedido3 = $lpedidos3[ 'pedido' ];
    $cqtdbatatas3 = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido3'AND tipo = '8' AND status = '1'" );
    $lqtdbatatas3 = mysqli_num_rows( $cqtdbatatas3 );
    $qtdmassas = $lqtdbatatas3 + $qtdmassas;
  }


  $cvalorpedido2 = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE status = '0' AND datapedido between '$dtinicio' and '$dtfim'" );
  $lvalorpedidos2 = mysqli_fetch_assoc( $cvalorpedido2 );
  $valorpedidos2 = $lvalorpedidos2[ 'total' ];


  $resposta .= '<tr align="center">
                        <td  align="center">' . $npedidos2 . '</td>
                        <td  align="center"><a href="#" onClick="btnQtdProduto(7);">'.$qtdalaminutas.'</i></a></td>
                        <td  align="center"><a href="#" onClick="btnQtdProduto(0);">'.$qtdbatatas.'</i></a></td>
                        <td  align="center"><a href="#" onClick="btnQtdProduto(8);">'.$qtdmassas.'</i></a></td>
                        <td align="center">R$ <b>' . number_format( $valorpedidos2, 1 ) . '</b></td>
                      </tr></tbody>
                  </table>
                </div>
				</div>
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Metodo Pagamento</h6>
              </div>
              <!-- Card Body -->
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelaporcao" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Metodo</th>
                        <th align="center">Qtd Vendas</th>
                        <th align="center">Valor Vendas</th>
                        <th align="center">Taxas</th>
                        <th align="center">Valor Taxas</th>
                      </tr>
                    </thead>
                    <tbody>';
                      $valortaxastotal=0;
					  $mensalidadeifood=100;
					  $taxas = 12;
					 $qtdvendasplataforma=mysqli_query($link,"SELECT * FROM pedido WHERE plataforma = '2' AND status = '0' AND datapedido between '$dtinicio' and '$dtfim'");
					$qtdvendas=mysqli_num_rows($qtdvendasplataforma);	  
					$csomaplataforma=mysqli_query($link,"SELECT SUM(valorpedido) as vtotal FROM pedido WHERE plataforma = '2' AND status = '0' AND datapedido between '$dtinicio' and '$dtfim'");	
					$lsp=mysqli_fetch_assoc($csomaplataforma);
					$valorplataforma= $lsp['vtotal'];					
					$taxaplataformareal = ($valorplataforma * $taxas / 100);	  
					$valorplataforma= $taxaplataformareal;
					  
					  
                      $cmetodo = mysqli_query( $link, "SELECT * FROM `pagamento` WHERE idpagamento != '1' AND idpagamento != '5'" )or die( "ERRO AO BUSCAR pagamento" );
                      while ( $linhapagamento = mysqli_fetch_array( $cmetodo ) ) {

                        $idpagamento = $linhapagamento[ 'idpagamento' ];
                        $nomepagamento = $linhapagamento[ 'nomepagamento' ];
                        $taxas = $linhapagamento[ 'taxas' ];
                        $status = $linhapagamento[ 'status' ];
                        $x = 'pagamento';
                        if ( $status == '0' ) {
                          $icon = 'Desativado';
                        } else if ( $status == '1' ) {
                          $icon = 'Ativado';
                        }
                        $qtdvendaspagamento = mysqli_query( $link, "SELECT * FROM pedido WHERE metodopagamento = '$idpagamento' AND status = '0' AND datapedido between '$dtinicio' and '$dtfim'" );
                        $qtdvendas = mysqli_num_rows( $qtdvendaspagamento );
                        $csomapagamento = mysqli_query( $link, "SELECT SUM(valorpedido) as vtotal FROM pedido WHERE metodopagamento = '$idpagamento' AND status = '0' AND datapedido between '$dtinicio' and '$dtfim'" );
                        $lsp = mysqli_fetch_assoc( $csomapagamento );
                        $valorpagamento = $lsp[ 'vtotal' ];
                        $taxa = 'R$ ' . number_format( ( $valorpagamento * $taxas / 100 ), 2 );
						$valortaxastotal=$valortaxastotal+($valorpagamento * ($taxas / 100));
                        if ( $taxa == 'R$ 0.00' ) {
                          $taxa = '';
                        }
                       $resposta.=' 
                      <tr align="center">
                        <td  align="center">'.$nomepagamento.'</td>
                        <td  align="center">'.$qtdvendas.'</td>
                        <td  align="center">R$
                          '.number_format($valorpagamento,2).'</td>
                        <td  align="center">'.$taxas.'
                          %</td>
                        <td  align="center"><strong>
                          '.$taxa.'
                          </strong></td>
						  
                      </tr>';
                      
                      }
                      $resposta.='
					  <tr align="center">
                        <td  align="center" colspan="4" bgcolor="#F1C6C6"><strong>Ifood Taxas Pedidos/Mensalidade</strong></td>
						<td  align="center"><strong>R$ '.number_format($mensalidadeifood+$valorplataforma,2).'</strong></td>
					
				  
                      </tr><tr align="center"><td align="center" colspan="5"><B>Valor total das taxas - R$ '.number_format($valortaxastotal+$mensalidadeifood+$valorplataforma,2).' <B></td></tr>
                    </tbody>
                  </table>
                </div>
				<BR>
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


  $cvalorcompra = mysqli_query( $link, "SELECT SUM(valor) AS total FROM compras WHERE data between '$dtinicio' and '$dtfim'" );
  $cqtdcompra = mysqli_query( $link, "SELECT * FROM compras WHERE data between '$dtinicio' and '$dtfim'" );
  $qtdcompras = mysqli_num_rows( $cqtdcompra );
  $lvalorcompras = mysqli_fetch_assoc( $cvalorcompra );
  $valorcompras = $lvalorcompras[ 'total' ];

  $balanTotal = $valorpedidos2 - $valorcompras - $valortaxastotal - $mensalidadeifood - $valorplataforma;
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
					</div>';
					  
					  

  $retorno[ 'data' ] = $dtinivis;
  $retorno[ 'datafim' ] = $dtfimvis;
  $retorno[ 'resposta' ] = $resposta;
  $retorno[ 'status' ] = 'success';
  echo json_encode( $retorno );
}

?>