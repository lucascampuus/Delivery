<?php
include "../connect/conexaomysql.php";
date_default_timezone_set("Brazil/East");
if($_POST['ifood']=='1')
{	
$monday = strtotime("last monday");
$monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
$sunday = strtotime(date("Y-m-d",$monday)." +7 days");	
$monday = date("Y-m-d",$sunday);	
$hoje= date("Y-m-d");
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
	

	$resposta='
<div class="card shadow mb-4 border-3"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Vendas</h6>
              </div><div class="table-responsive">
                  <table class="table table-bordered" id="tabelavendas" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Pedidos</th>
                        <th align="center">Total</th>
						<th align="center">Via Loja</th>
						<th align="center">Via Ifood</th>
                        <th align="center" bgcolor="#ECACA3">Taxas</th>
						<th align="center" bgcolor="#B7ECD1">Receber(Previsto)</th>
                      </tr>
                    </thead>
                    <tbody>';
                      				
                       $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE plataforma = '2' AND datapedido between '$monday' and '$hoje'" );
                      $npedidos = mysqli_num_rows( $cpedidos );
                      $qtdbatatas = '0';
					  $ctaxaplataforma=mysqli_query($link,"SELECT * FROM plataforma WHERE idplataforma='2'");
					  $lctp=mysqli_fetch_assoc($ctaxaplataforma);
					  $taxaplataforma=$lctp['taxas'];
					  $ctaxapag=mysqli_query($link,"SELECT * FROM pagamento WHERE idpagamento='4'");
					  $lctpag=mysqli_fetch_assoc($ctaxapag);
					  $taxapagamento=$lctpag['taxas'];	 
						 
                      while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
                        $pedido = $lpedidos[ 'pedido' ];
                        $cqtdbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '0'" );
                        $lqtdbatatas = mysqli_num_rows( $cqtdbatatas );
                        $qtdbatatas = $lqtdbatatas + $qtdbatatas;

                      }
						 					 
						 
					  $cpagifood = mysqli_query( $link, "SELECT SUM(valorpedido) as totalviaifood FROM pedido WHERE metodopagamento = '4' AND datapedido between '$monday' and '$hoje'");
                      $lpagifood=mysqli_fetch_assoc($cpagifood);
					  $valorpagamentoifoodt=$lpagifood['totalviaifood'];
					  $taxapagifood = ( $valorpagamentoifoodt * $taxapagamento / 100 );
					  $valorpagamentoifood=$valorpagamentoifoodt-$taxapagifood;	 
						 
                      $cvalorpedido = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE plataforma = '2' AND datapedido between '$monday' and '$hoje'" );
                      $lvalorpedidos = mysqli_fetch_assoc( $cvalorpedido );
                      $valorpedidost = $lvalorpedidos[ 'total' ];
                      
	                  $vialoja=$valorpedidost-$valorpagamentoifoodt;
                      $taxapagplataforma = ( $valorpedidost * $taxaplataforma / 100 );
                      $valorpedidos = $valorpedidost - $taxapagplataforma;
					  $resultado=$valorpagamentoifood-$taxapagplataforma;
	
					  $taxas=$taxapagifood+$taxapagplataforma;
					  //$valorpagamentoifood=$valorpagamentoifoodt-$taxas;
					  //$valorpedidost=$valorpedidost-$valorpagamentoifoodt;


                      
                      $resposta.= '<tr align="center">
                        <td  align="center">'.$npedidos.'</td>
                        <td  align="center">RS '.$valorpedidost.'</td>
						 <td  align="center">RS '.$vialoja.'</td>
						<td  align="center">RS '.$valorpagamentoifoodt.'</td>
						<td  align="center">RS '.$taxas.'</td>
                        <td align="center">R$ <b>'.number_format($resultado,1).'</b></td>
                      </tr></tbody>
                  </table>
                </div>
				</div>';
}

$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
$retorno['dtini'] = $dtinicio;	
$retorno['dtfim'] = $dtfim;	
echo json_encode( $retorno );	

?>