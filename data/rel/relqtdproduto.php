<?php
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( $_POST[ 'consultaproduto' ] = 'sim' ) {
  $tipo_produto = $_POST[ 'tipo' ];
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
                        <th align="center">Produto</th>
                        <th align="center">Qtd</th>
                        <th align="center">Valor Vendas</th>
                      </tr>
                    </thead>
                    <tbody>';
  $qtdtotal=0;
  $valorx=0;
  $valory=0;	
  $cprodutos = mysqli_query( $link, "SELECT * FROM produto WHERE tipo = '$tipo_produto' AND status = '1'" )or die( "2" );
  while ( $lproduto = mysqli_fetch_array( $cprodutos ) ) {
    $produto = $lproduto[ 'idproduto' ];
    $nomeproduto = $lproduto[ 'produto' ];
    $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE status = '0' AND datapedido between '$dtinicio' and '$dtfim'" )or die( "1" );
    while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
      $pedido = $lpedidos[ 'pedido' ];


      $cqtdprodutos = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '$tipo_produto' AND status = '1' AND produto_idproduto = '$produto'" )or die( "3" );
      $qtdproduto = mysqli_num_rows( $cqtdprodutos );
	  $qtdtotal=$qtdtotal+$qtdproduto;	
      $csomavalorproduto = mysqli_query( $link, "SELECT sum(valor) as valorproduto FROM carrinho WHERE pedido = '$pedido' AND tipo = '$tipo_produto' AND status = '1' AND produto_idproduto = '$produto'" );
      $valortotal = mysqli_fetch_assoc( $csomavalorproduto );
      $valortotal = $valortotal[ 'valorproduto' ];
      $valorx=$valorx+$valortotal;
	  $valory=$valory+$valortotal;	
    }
	if($qtdtotal>0)
	{

    $resposta .= '<tr align="center">
                        <td  align="center">' . $nomeproduto . '</td>
                        <td  align="center">' . $qtdtotal . '</td>
                        <td  align="center"><strong>R$ ' . number_format($valorx,2) . '</strong></td>
                      </tr>';
	$qtdtotal=0;
	$valorx=0;
	}

  }
  $resposta .= '<tr align="center"><td align="center" colspan="3" bgcolor="#C4E8C8"><strong>R$ '.number_format($valory,2).'</strong></td></tr></tbody>
                  </table>
                </div>
				</div>';
$retorno[ 'datainicio' ] = $dtinivis;
  $retorno[ 'datafim' ] = $dtfimvis;	
  $retorno[ 'resposta' ] = $resposta;
  $retorno[ 'status' ] = 'success';
  echo json_encode( $retorno );
}

?>