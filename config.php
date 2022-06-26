<!DOCTYPE html>
<?php
session_start();
$session = session_id();
include "data/connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Batattos</title>
<link rel="shortcut icon" href="img/potato.png" type="image/x-icon" />
<!-- Custom fonts for this template-->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

<!-- Custom styles for this template-->
<link href="css/sb-admin-2.min.css" rel="stylesheet">

<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
  <?php include_once("sidebar.php");?>
  
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column"> 
    
    <!-- Main Content -->
    <div id="content">
      <?php include_once("header.php")?>
      
      <!-- Begin Page Content -->
      <div class="container-fluid"> 
	  <div class="row"> 
          <!-- Content Column -->
          <div class="col-lg-6 mb-8">
            <div class="card shadow mb-4"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                <h6 class="m-0 font-weight-bold text-white">Plataformas</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-primary" id="vplat">
                <div class="form-group">
                  <select class="form-control" id="selectSpan">
                    <option value='00'>Total</option>
                    <option value='01'>Janeiro</option>
                    <option value='02'>Fevereiro</option>
                    <option value='03'>Março</option>
                    <option value='04'>Abril</option>
                    <option value='05'>Maio</option>
                    <option value='06'>Junho</option>
                    <option value='07'>Julho</option>
                    <option value='08'>Agosto</option>
                    <option value='09'>Setembro</option>
                    <option value='10'>Outubro</option>
                    <option value='11'>Novembro</option>
                    <option value='12'>Dezembro</option>
                  </select>
                </div>
                <div id="bodymes"></div>
              </div>
            </div>
            <div class="card shadow mb-4"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success">
                <h6 class="m-0 font-weight-bold text-white">Metodo Pagamento</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-success" id="vpag">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelaporcao" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Metodo</th>
                        <th align="center">Qtd Vendas</th>
                        <th align="center">Valor Vendas</th>
                        <th align="center">Taxas</th>
                        <th align="center">Valor Taxas</th>
                        <th align="center">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $cmetodo = mysqli_query( $link, "SELECT * FROM `pagamento`" )or die( "ERRO AO BUSCAR pagamento" );
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
                        $qtdvendaspagamento = mysqli_query( $link, "SELECT * FROM pedido WHERE metodopagamento = '$idpagamento'" );
                        $qtdvendas = mysqli_num_rows( $qtdvendaspagamento );
                        $csomapagamento = mysqli_query( $link, "SELECT SUM(valorpedido) as vtotal FROM pedido WHERE metodopagamento = '$idpagamento'" );
                        $lsp = mysqli_fetch_assoc( $csomapagamento );
                        $valorpagamento = $lsp[ 'vtotal' ];
                        $taxa = 'R$ ' . number_format( ( $valorpagamento * $taxas / 100 ), 2 );
                        if ( $taxa == 'R$ 0.00' ) {
                          $taxa = '';
                        }
                        ?>
                      <tr align="center">
                        <td  align="center"><?=$nomepagamento?></td>
                        <td  align="center"><?=$qtdvendas?></td>
                        <td  align="center">R$
                          <?=number_format($valorpagamento,2)?></td>
                        <td  align="center"><?=$taxas?>
                          %</td>
                        <td  align="center"><strong>
                          <?=$taxa?>
                          </strong></td>
                        <td align="center"><a href="#" onclick="status(<?=$idpagamento?>,'<?=$icon?>','<?=$x?>');">
                          <?=$icon?>
                          </a></td>
                      </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-8">
            <div class="card shadow mb-4 border-3">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-warning">
                <h6 class="m-0 font-weight-bold text-white">Cupons</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-warning" id="vcupom">
        <a href="#" class="btn btn-warning btn-icon-split" onClick="cadastroCupom();"> <span class="icon text-white-50"> <i class="fas fa-check"></i> </span> <span class="text">Adicionar Cupom</span> </a>
        <div class="my-4"></div>
        <div class="my-4"></div>
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Código</th>
                        <th align="center">Valor</th>
                        <th align="center">Cliente</th>
                        <th align="center">Validade</th>
                        <th align="center">Status</th>
                        <th align="center">Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ccupom = mysqli_query( $link, "SELECT * FROM `cupom`" )or die( "ERRO AO BUSCAR cupom" );
                      while ( $linhacupom = mysqli_fetch_array( $ccupom ) ) {

                        $idcupom = $linhacupom[ 'idcupom' ];
                        $codigo = $linhacupom[ 'cupom' ];
                        $valor = $linhacupom[ 'valor' ];
                        $cliente = $linhacupom[ 'cliente_idcliente' ];
                        $consulta_cliente = mysqli_query( $link, "SELECT nomecliente FROM cliente WHERE idcliente='$cliente'" );
                        $lcliente = mysqli_fetch_assoc( $consulta_cliente );
                        $nomecliente = $lcliente[ 'nomecliente' ];
                        $status = $linhacupom[ 'status' ];
                        $pedido = $linhacupom[ 'pedido' ];
                        $validadec = date( 'Y-m-d', strtotime( "+1 days", strtotime( $linhacupom[ 'validade' ] ) ) );
                        $validade = explode( "-", $linhacupom[ 'validade' ] );
                        $dia = $validade[ 2 ];
                        $mes = $validade[ 1 ];
                        $ano = $validade[ 0 ];
                        $hoje = date( "Y-m-d" );
                        $validade = $dia . '/' . $mes . '/' . $ano;
                        if ( $status == '0' ) {
                          if ( strtotime( $validadec ) < strtotime( $hoje ) ) {
                            $altcupom = mysqli_query( $link, "UPDATE cupom SET status='2' WHERE idcupom='$idcupom'" );
                          }
                        }

                        if ( $status == '0' ) {
                          $icon = 'Disponivel';
                          $btn = $icon;
						  $btndel="<a href='#' onClick='delcupom($idcupom);'><i class='fa fa-trash fa-fw'></i></a>";
                        } else if ( $status == '1' ) {
                          $icon = 'Ultilizado';
                          $btn = "<a href='#' onClick='btnPedidoCupom(\"$pedido\",$cliente);' class='btn btn-success'>$icon</a>";
						  $btndel="<i class='fa fa-check fa-fw'></i>";

                        } else if ( $status == '2' ) {
                          $icon = 'Vencido';
                          $btn = $icon;
						  $btndel = "<a href='#' onClick='delcupom($idcupom);'><i class='fa fa-check fa-fw'></i></a>";
                        }
						


                        ?>
                      <tr align="center">
                        <td  align="center"><?=$codigo?></td>
                        <td  align="center">R$
                          <?=number_format($valor,2)?></td>
                        <td  align="center"><?=$nomecliente?></td>
                        <td  align="center"><?=$validade?></td>
                        <td align="center"><?=$btn?></td>
                        <td align="center"><?=$btndel?></td>
                      </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="card shadow mb-4"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-danger">
                <h6 class="m-0 font-weight-bold text-white">Repasses Ifood - Semanal</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-danger" id="vifood">
                <?php
                $monday = strtotime( "last monday" );
                $monday = date( 'W', $monday ) == date( 'W' ) ? $monday - 7 * 86400 : $monday;
                $sunday = strtotime( date( "Y-m-d", $monday ) . " +7 days" );
                $monday = date( "Y-m-d", $sunday );
                $hoje = date( "Y-m-d" );
                $dtinicio = explode( "-", $monday );
                $anoi = $dtinicio[ 2 ];
                $mesi = $dtinicio[ 1 ];
                $diai = $dtinicio[ 0 ];
                $dtinicio = $anoi;
                $dtinicio .= '/';
                $dtinicio .= $mesi;
                $dtinicio .= '/';
                $dtinicio .= $diai;

                $dtfim = explode( "-", $hoje );
                $anof = $dtfim[ 2 ];
                $mesf = $dtfim[ 1 ];
                $diaf = $dtfim[ 0 ];
                $dtfim = $anof;
                $dtfim .= '/';
                $dtfim .= $mesf;
                $dtfim .= '/';
                $dtfim .= $diaf;

                ?>
                <div class="card shadow border-left-danger"> 
                  <!-- Card Header - Dropdown -->
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-danger">
                    <h6 class="m-0 font-weight-bold text-white text-center">Vendas (
                      <?=$dtinicio?>
                      ) Até (
                      <?=$dtfim?>
                      )</h6>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="tabelavendas" width="100%" cellspacing="0">
                      <thead>
                        <tr align="center">
                          <th align="center">Pedidos</th>
                          <th align="center">Total</th>
                          <th align="center">Via Loja</th>
                          <th align="center">Via Ifood</th>
                          <th align="center" bgcolor="#ECACA3">Taxas</th>
							<th align="center" bgcolor="#ECACA3">Entrega Parceira</th>
                          <th align="center" bgcolor="#B7ECD1">Receber(Previsto)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE plataforma = '2' AND datapedido between '$monday' and '$hoje'" );
                        $npedidos = mysqli_num_rows( $cpedidos );
                        $qtdbatatas = '0';
                        $ctaxaplataforma = mysqli_query( $link, "SELECT * FROM plataforma WHERE idplataforma='2'" );
                        $lctp = mysqli_fetch_assoc( $ctaxaplataforma );
                        $taxaplataforma = $lctp[ 'taxas' ];
                        $ctaxapag = mysqli_query( $link, "SELECT * FROM pagamento WHERE idpagamento='4'" );
                        $lctpag = mysqli_fetch_assoc( $ctaxapag );
                        $taxapagamento = $lctpag[ 'taxas' ];

                        while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
                          $pedido = $lpedidos[ 'pedido' ];
                          $cqtdbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '0'" );
                          $lqtdbatatas = mysqli_num_rows( $cqtdbatatas );
                          $qtdbatatas = $lqtdbatatas + $qtdbatatas;

                        }
						$valorfreteifood=0;
						 $centregaifood = mysqli_query( $link, "SELECT sum(valor) as totalentregaifood FROM entrega WHERE entregador_identregador = '4' AND dataentrega between '$monday' and '$hoje'" ); 
						$lentrega=mysqli_fetch_assoc($centregaifood);
						$valorfreteifood=$lentrega['totalentregaifood'];	 						
                        


                        $cpagifood = mysqli_query( $link, "SELECT SUM(valorpedido) as totalviaifood FROM pedido WHERE metodopagamento = '4' AND datapedido between '$monday' and '$hoje'" );
                        $lpagifood = mysqli_fetch_assoc( $cpagifood );
                        $valorpagamentoifoodt = $lpagifood[ 'totalviaifood' ];
                        $taxapagifood = ( $valorpagamentoifoodt * $taxapagamento / 100 );
                        $valorpagamentoifood = $valorpagamentoifoodt - $taxapagifood;

                        $cvalorpedido = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE plataforma = '2' AND datapedido between '$monday' and '$hoje'" );
                        $lvalorpedidos = mysqli_fetch_assoc( $cvalorpedido );
                        $valorpedidost = $lvalorpedidos[ 'total' ];

                        $vialoja = $valorpedidost - $valorpagamentoifoodt;
                        $taxapagplataforma = ( $valorpedidost * $taxaplataforma / 100 );
                        $valorpedidos = $valorpedidost - $taxapagplataforma;
                        $resultado = $valorpagamentoifood - $taxapagplataforma - $valorfreteifood;

                        $taxas = $taxapagifood + $taxapagplataforma;
                        //$valorpagamentoifood=$valorpagamentoifoodt-$taxas;
                        //$valorpedidost=$valorpedidost-$valorpagamentoifoodt;

                        ?>
                        <tr align="center">
                          <td  align="center"><a href='#' onClick='btnIfood(1)'>
                            <?=$npedidos?>
                            </a></td>
                          <td  align="center">RS
                            <?=$valorpedidost?></td>
                          <td  align="center">RS
                            <?=$vialoja?></td>
                          <td  align="center">RS
                            <?=$valorpagamentoifoodt?></td>
                          <td  align="center">RS
                            <?=number_format($taxas,2)?></td>
							<td  align="center">RS
                            <?=number_format($valorfreteifood,2)?></td>
                          <td align="center">R$ <b>
                            <?=number_format($resultado,1)?>
                            </b></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
				<?php
                $mondaypass = strtotime( "last monday" );
                $mondaypass = date( 'W', $mondaypass ) == date( 'W' ) ? $mondaypass - 7 * 86400 : $mondaypass;
                $mondaypass = date( "Y-m-d", $mondaypass );
                $dom = strtotime( "last monday" );
                $dom = date( 'W', $dom ) == date( 'W' ) ? $dom - 7 * 86400 : $dom;
                $dom = strtotime( date( "Y-m-d", $dom ) . " +6 days" );
                $dom = date( "Y-m-d", $dom );
                $dtinicio = explode( "-", $mondaypass );
                $anoi = $dtinicio[ 2 ];
                $mesi = $dtinicio[ 1 ];
                $diai = $dtinicio[ 0 ];
                $dtinicio = $anoi;
                $dtinicio .= '/';
                $dtinicio .= $mesi;
                $dtinicio .= '/';
                $dtinicio .= $diai;

                $dtfim = explode( "-", $dom );
                $anof = $dtfim[ 2 ];
                $mesf = $dtfim[ 1 ];
                $diaf = $dtfim[ 0 ];
                $dtfim = $anof;
                $dtfim .= '/';
                $dtfim .= $mesf;
                $dtfim .= '/';
                $dtfim .= $diaf;
                ?>
              
              <BR>
              <div class="card shadow border-left-danger"> 
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-danger">
                  <h6 class="m-0 font-weight-bold text-white text-center">Vendas Semana Passada (
                    <?=$dtinicio?>
                    ) Até (
                    <?=$dtfim?>
                    )</h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelavendas" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Pedidos</th>
                        <th align="center">Total</th>
                        <th align="center">Via Loja</th>
                        <th align="center">Via Ifood</th>
                        <th align="center" bgcolor="#ECACA3">Taxas</th>
						  <th align="center" bgcolor="#ECACA3">Entrega Parceira</th>
						 <th align="center" bgcolor="#B7ECD1">Receber(Previsto)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE plataforma = '2' AND datapedido between '$mondaypass' and '$dom'" );
                      $npedidos = mysqli_num_rows( $cpedidos );
                      $qtdbatatas = '0';
                      $ctaxaplataforma = mysqli_query( $link, "SELECT * FROM plataforma WHERE idplataforma='2'" );
                      $lctp = mysqli_fetch_assoc( $ctaxaplataforma );
                      $taxaplataforma = $lctp[ 'taxas' ];
                      $ctaxapag = mysqli_query( $link, "SELECT * FROM pagamento WHERE idpagamento='4'" );
                      $lctpag = mysqli_fetch_assoc( $ctaxapag );
                      $taxapagamento = $lctpag[ 'taxas' ];

                      while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
                        $pedido = $lpedidos[ 'pedido' ];
                        $cqtdbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '0'" );
                        $lqtdbatatas = mysqli_num_rows( $cqtdbatatas );
                        $qtdbatatas = $lqtdbatatas + $qtdbatatas;

                      }
					  $valorfreteifood=0;
						 $centregaifood = mysqli_query( $link, "SELECT sum(valor) as totalentregaifood FROM entrega WHERE entregador_identregador = '4' AND dataentrega between '$mondaypass' and '$dom'" ); 
						$lentrega=mysqli_fetch_assoc($centregaifood);
						$valorfreteifood=$lentrega['totalentregaifood'];


                      $cpagifood = mysqli_query( $link, "SELECT SUM(valorpedido) as totalviaifood FROM pedido WHERE metodopagamento = '4' AND datapedido between '$mondaypass' and '$dom'" );
                      $lpagifood = mysqli_fetch_assoc( $cpagifood );
                      $valorpagamentoifoodt = $lpagifood[ 'totalviaifood' ];
                      $taxapagifood = ( $valorpagamentoifoodt * $taxapagamento / 100 );
                      $valorpagamentoifood = $valorpagamentoifoodt - $taxapagifood - $valorfreteifood;

                      $cvalorpedido = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE plataforma = '2' AND datapedido between '$mondaypass' and '$dom'" );
                      $lvalorpedidos = mysqli_fetch_assoc( $cvalorpedido );
                      $valorpedidost = $lvalorpedidos[ 'total' ];

                      $vialoja = $valorpedidost - $valorpagamentoifoodt;
                      $taxapagplataforma = ( $valorpedidost * $taxaplataforma / 100 );
                      $valorpedidos = $valorpedidost - $taxapagplataforma;
                      $resultado = $valorpagamentoifood - $taxapagplataforma;

                      $taxas = $taxapagifood + $taxapagplataforma;
                      //$valorpagamentoifood=$valorpagamentoifoodt-$taxas;
                      //$valorpedidost=$valorpedidost-$valorpagamentoifoodt;

                      ?>
                      <tr align="center">
                        <td  align="center"><a href='#' onClick='btnIfood(0)'>
                          <?=$npedidos?>
                          </a></td>
                        <td  align="center">RS
                          <?=$valorpedidost?></td>
                        <td  align="center">RS
                          <?=$vialoja?></td>
                        <td  align="center">RS
                          <?=$valorpagamentoifoodt?></td>
                        <td  align="center">RS
                          <?=number_format($taxas,2)?></td>
						  <td  align="center">RS
                          <?=number_format($valorfreteifood,2)?></td>
                        <td align="center">R$ <b>
                          <?=number_format($resultado,1)?>
                          </b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div
				
				
            ></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- DataTales Example --> 
  
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto"> <span>Copyright &copy; Batattos 2021</span> </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<div class="modal fade" id="consultapedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="idcliente"></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body" id="consultapedido">
        <div id="tbody"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="$('#consultapedidoifood').modal('show');">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="consultapedidocupom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="idcliente"></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body" id="consultapedido">
        <div id="tbodycupom"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="consultapedidoifood" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="idcliente"></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body" id="consultapedido">
        <div id="tbodyifood"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>
	  <div class="modal fade" id="cadastrocupom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastro Cupom</h5>
      </div>
      <div class="modal-body">
		<select class="form-control" id="plataforma" onChange="platCupom(this)">
			<option value="0" selected>Selecione a Plataforma</option>
			<option value="1">Batattos</option>
			<option value="2">Ifood</option>			
		  </select>
		  <BR>
        <div class="form-group">
            <label>Cupom</label>
            <input class="form-control" id="cupomid" readonly>
         </div>
		   <select class="form-control" id="clientecupom">
              <option value="0">Selecione o Cliente</option>
              <?php
              $cliente = mysqli_query( $link, "SELECT * FROM cliente WHERE status = '1' ORDER BY nomecliente ASC" )or die( "ERRO AO BUSCAR Cliente" );
              while ( $lcliente = mysqli_fetch_array( $cliente ) ) {
                $idcliente = $lcliente[ 'idcliente' ];
                $nomecliente = $lcliente[ 'nomecliente' ];

                echo '<option value="' . $idcliente . '">'.$nomecliente.' - '.$idcliente.'</option>';

              }
              ?>
            </select>
			 <BR> 
		  <div class="form-group">
            <label>Valor</label>
            <input class="form-control" id="valorcupom" onKeyUp="substituiPonto(this)">
         </div>
		  <div class="form-group">
            <label>Validade</label>
            <input class="form-control" id="validadecupom" value="<?=date('d/m/Y', strtotime('+1 month'));?>" readonly>
         </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="valortotalpedido"/>
        <button type="button" class="btn btn-success" id="btncadcupom">Cadastrar Cupom</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript--> 
<script src="vendor/jquery/jquery.min.js"></script> 
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 

<!-- Core plugin JavaScript--> 
<script src="vendor/jquery-easing/jquery.easing.min.js"></script> 

<!-- Custom scripts for all pages--> 
<script src="js/sb-admin-2.min.js"></script> 

<!-- Page level plugins --> 
<script src="vendor/chart.js/Chart.min.js"></script> 
<script src="vendor/datatables/jquery.dataTables.min.js"></script> 
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script> 

<!-- Page level custom scripts --> 
<script src="js/demo/chart-area-demo.js"></script> 
<script src="js/demo/chart-pie-demo.js"></script> 
<script src="js/demo/datatables-demo.js"></script>
<script src="js/config.js"></script> 	  
<script src="js/login.js"></script> 


</html>