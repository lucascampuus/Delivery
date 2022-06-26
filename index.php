<!DOCTYPE html>
<?php
session_start();
$session = session_id();
include "data/connect/conexaomysql.php";
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
        <?php
        date_default_timezone_set( "Brazil/East" );
        $datahoje = date( "Y-m-d" );
        $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido = '$datahoje' AND status = '0'" );
		$cpedidos2 = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido = '$datahoje' AND status = '0'" );
		$cpedidos3 = mysqli_query( $link, "SELECT * FROM pedido WHERE datapedido = '$datahoje' AND status = '0'" );
        $npedidos = mysqli_num_rows( $cpedidos );
        $qtdbatatas = '0';
		$qtdalaminuta='0';
		$qtdmassa='0';
        while ( $lpedidos = mysqli_fetch_array( $cpedidos ) ) {
          $pedido = $lpedidos[ 'pedido' ];
          $cqtdbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '0'" );
          $lqtdbatatas = mysqli_num_rows( $cqtdbatatas );
          $qtdbatatas = $lqtdbatatas + $qtdbatatas;

        }
		while ( $lpedidosalaminuta = mysqli_fetch_array( $cpedidos2 ) ) {
          $pedidox = $lpedidosalaminuta[ 'pedido' ];
          $cqtdalaminuta = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedidox' AND tipo = '7'" );
          $lqtdalaminuta = mysqli_num_rows( $cqtdalaminuta );
          $qtdalaminuta = $lqtdalaminuta + $qtdalaminuta;

        }
		while($lpedidosmassas=mysqli_fetch_array($cpedidos3)){
		  $pedidomassa=$lpedidosmassas['pedido'];
		  $cqtdmassa = mysqli_query( $link, "SELECT * FROM carrinho WHERE pedido = '$pedidomassa' AND tipo = '8'" );
		  $lqtdmasa = mysqli_num_rows( $cqtdmassa );
          $qtdmassa = $lqtdmasa + $qtdmassa;
		}

        $cqtdbatatastotal = mysqli_query( $link, "SELECT * FROM carrinho WHERE tipo = '7'" );
        $qtdbatatastotal = mysqli_num_rows( $cqtdbatatastotal );
		
        $cvalorpedido = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE datapedido = '$datahoje' AND status = '0'" );
        $lvalorpedidos = mysqli_fetch_assoc( $cvalorpedido );
        $valorpedidos = $lvalorpedidos[ 'total' ];

        $cvalorcompra = mysqli_query( $link, "SELECT SUM(valor) AS total FROM compras WHERE data = '$datahoje'" );
        $cqtdvalorcompra = mysqli_query( $link, "SELECT * FROM compras WHERE data = '$datahoje'" );
        $qtdcompra = mysqli_num_rows( $cqtdvalorcompra );
        $lvalorcompra = mysqli_fetch_assoc( $cvalorcompra );
        $valorcompras = $lvalorcompra[ 'total' ];

        $cvalorpedidototal = mysqli_query( $link, "SELECT SUM(valor) AS total FROM carrinho WHERE tipo = '7'" );
        $lvalorpedidostotal = mysqli_fetch_assoc( $cvalorpedidototal );
        $valorpedidostotal = $lvalorpedidostotal[ 'total' ];

        $mpedidosvalor = $valorpedidostotal / $qtdbatatastotal;
        $dt1 = date_create( '2021-05-26' );
        $dt2 = date_create( 'today' );
        $datacs = date_diff( $dt1, $dt2 );
        $mqtdbatatadia = $qtdbatatastotal / ( $datacs->format( "%a" ) );


        $cvalorgeral = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido" );
        $lvalorgeral = mysqli_fetch_assoc( $cvalorgeral );
        $valorgeral = $lvalorgeral[ 'total' ];

        $balanchoje = $valorpedidos - $valorcompras;
        if ( $balanchoje < 0 ) {
          $text = 'danger';
        } else {
          $text = 'primary';
        }


        ?>
        <div class="row"> 
        <input type="hidden" id="userlogged"/> 
          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Pedidos Hoje</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"> <a href="#" onClick="pedidoshoje();">
                      <?=$npedidos?>
                      </a> </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-calendar fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Valor Hoje</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="valorhoje" style="display: none">R$ <strong>
                      <?=number_format($valorpedidos,1)?>
                      </strong> </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Batatas  - Alaminutas - Massas</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?=$qtdbatatas?> - <?=$qtdalaminuta?> - <?=$qtdmassa?>
                    </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-comments fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Media Alaminuta por Dia</div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="valormes" style="display: none"><strong>
                          <?=number_format($mqtdbatatadia,1)?>
                          </strong> </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-clipboard-list fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"> Compras</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                     <a href="#" onClick="comprashoje();">
                      <?=$qtdcompra?>
                      </a> 
                    </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"> Valor Compras</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="valorcompras" style="display: none">R$ <strong>
                      <?=number_format($valorcompras,1)?>
                      </strong> </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-<?=$text?> shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-<?=$text?> text-uppercase mb-1"> Balanço</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="valorbalanco" style="display: none">R$ <b>
                      <?=number_format($balanchoje,1)?>
                      </b> </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> Média por Alaminuta</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">R$
                      <?=number_format($mpedidosvalor,1)?>
                    </div>
                  </div>
                  <div class="col-auto"> <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row"> 
          
          <!-- Content Column -->
          <div class="col-lg-6 mb-8"> 
            
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3 bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Batatas Recheadas</h6>
              </div>
              <div class="card-body border-left-dark">
                <?php


                $consultatotalbatatas = mysqli_query( $link, "SELECT * FROM carrinho WHERE tipo =  '0'" );
                $ntotalbatatas = mysqli_num_rows( $consultatotalbatatas );

                $consultaproduto1 = mysqli_query( $link, "SELECT * FROM produto WHERE tipo= '0' AND status = '1' ORDER BY produto ASC" );
                while ( $lcproduto1 = mysqli_fetch_array( $consultaproduto1 ) ) {
                  $idproduto1 = $lcproduto1[ 'idproduto' ];
                  $nomeproduto1 = $lcproduto1[ 'produto' ];
                  $cbatata = mysqli_query( $link, "SELECT * FROM carrinho WHERE produto_idproduto = '$idproduto1'" );
                  $qtdbatata = mysqli_num_rows( $cbatata );
                  if ( $qtdbatata > 24 ) {
                    $pcbatata = ( $qtdbatata * 100 ) / $ntotalbatatas;


                    ?>
                <h4 class="small font-weight-bold">
                  <?=$nomeproduto1?>
                  -
                  <?=$qtdbatata?>
                  <span class="float-right">
                  <?=number_format($pcbatata,0)?>
                  %</span></h4>
                <div class="progress mb-4">
                  <div class="progress-bar bg-dark" role="progressbar" style="width: <?=$pcbatata?>%" aria-valuenow="<?=$pcbatata?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <?php
                }
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-8"> 
            
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3 bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Alaminutas</h6>
              </div>
              <div class="card-body border-left-dark">
                <?php


                $consultatotalalaminutas = mysqli_query( $link, "SELECT * FROM carrinho WHERE tipo =  '7'" );
                $ntotalalaminutas = mysqli_num_rows( $consultatotalalaminutas );

                $consultaproduto2 = mysqli_query( $link, "SELECT * FROM produto WHERE tipo= '7' AND status = '1' ORDER BY produto ASC" );
                while ( $lcproduto2 = mysqli_fetch_array( $consultaproduto2 ) ) {
                  $idproduto2 = $lcproduto2[ 'idproduto' ];
                  $nomeproduto2 = $lcproduto2[ 'produto' ];
                  $calaminuta = mysqli_query( $link, "SELECT * FROM carrinho WHERE produto_idproduto = '$idproduto2'" );
                  $qtdalaminuta = mysqli_num_rows( $calaminuta );
                  if ( $qtdalaminuta > 10 ) {
                    $pcalaminuta = ( $qtdalaminuta * 100 ) / $ntotalalaminutas;


                    ?>
                <h4 class="small font-weight-bold">
                  <?=$nomeproduto2?>
                  -
                  <?=$qtdalaminuta?>
                  <span class="float-right">
                  <?=number_format($pcalaminuta,0)?>
                  %</span></h4>
                <div class="progress mb-4">
                  <div class="progress-bar bg-dark" role="progressbar" style="width: <?=$pcalaminuta?>%" aria-valuenow="<?=$pcalaminuta?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <?php
                }
                }
                ?>
              </div>
            </div>
          </div>  
          <div class="col-lg-6 mb-8"> 
            
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3 bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Massas</h6>
              </div>
              <div class="card-body border-left-dark">
                <?php


                $consultatotalmassas = mysqli_query( $link, "SELECT * FROM carrinho WHERE tipo =  '8'" );
                $ntotalmassas = mysqli_num_rows( $consultatotalmassas );

                $consultaproduto3 = mysqli_query( $link, "SELECT * FROM produto WHERE tipo= '8' AND status = '1' ORDER BY produto ASC" );
                while ( $lcproduto3 = mysqli_fetch_array( $consultaproduto3 ) ) {
                  $idproduto3 = $lcproduto3[ 'idproduto' ];
                  $nomeproduto3 = $lcproduto3[ 'produto' ];
                  $cmassa = mysqli_query( $link, "SELECT * FROM carrinho WHERE produto_idproduto = '$idproduto3'" );
                  $qtdmassa = mysqli_num_rows( $cmassa );
                  if ( $qtdmassa > 1 ) {
                    $pcmassa = ( $qtdmassa * 100 ) / $ntotalmassas;


                    ?>
                <h4 class="small font-weight-bold">
                  <?=$nomeproduto3?>
                  -
                  <?=$qtdmassa?>
                  <span class="float-right">
                  <?=number_format($pcmassa,0)?>
                  %</span></h4>
                <div class="progress mb-4">
                  <div class="progress-bar bg-dark" role="progressbar" style="width: <?=$pcmassa?>%" aria-valuenow="<?=$pcmassa?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <?php
                }
                }
                ?>
              </div>
            </div>
          </div>        
          <!-- Color System -->
          
          <div class="col-lg-6 mb-8">
            <div class="card shadow mb-4 border-3"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Filtrar Lançamentos Por Data</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-dark">
                <div class="form-group form-inline">
                  <label>De &nbsp;</label>
                  <input class="form-control" id="datapesquisa" placeholder="Data...">
                  &nbsp;&nbsp;
                  <button class="btn btn-dark" type="button" id="btnBuscarData" onClick="buscarData();" hidden="true">Filtrar</button>
                </div>
              </div>
            </div>
            <div class="card shadow mb-8"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Filtrar Lançamentos Entre Datas</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-dark">
                <div class="form-group form-inline">
                  <label>De &nbsp;</label>
                  <input class="form-control" id="dtinicio" placeholder="Data Início..." value="<?=date("01/m/Y")?>">
                  <label>&nbsp; Até &nbsp;</label>
                  <input class="form-control" id="dtfim" placeholder="Data Final..." value="<?=date("d/m/Y")?>">
                  &nbsp;&nbsp;
                  <button class="btn btn-dark" type="button" id="btnBuscarEntreDatas" onClick="buscarEntreData();" hidden="true">Filtrar</button>
                </div>
              </div>
            </div>
            <div class="card shadow mb-4"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Filtrar Lançamentos Mês</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-dark">
                <div class="form-group">
                  <select class="form-control" id="selectSpan">
                    <option selected>Selecione</option>
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
              </div>
            </div>
            
            <!-- Approach 
            <!-- <div class="card shadow mb-4 bg-danger-200" id="mostrarifood" hidden="true">
              <div class="card-header py-3 bg-danger">
                <h6 class="m-0 font-weight-bold text-white">Ifood</h6>
              </div>
              <div class="card-body border-left-danger" >
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelaifood" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Pedidos</th>
                        <th align="center">Batatas</th>
                        <th align="center">Via Loja</th>
						 <th align="center">Via Ifood</th> 
                        <th align="center">Taxas</th>
                        <th align="center">Repasse</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $cpedidos = mysqli_query( $link, "SELECT * FROM pedido WHERE plataforma = '2'" );
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
						 					 
						 
					  $cpagifood = mysqli_query( $link, "SELECT SUM(valorpedido) as totalviaifood FROM pedido WHERE metodopagamento = '4'");
                      $lpagifood=mysqli_fetch_assoc($cpagifood);
					  $valorpagamentoifoodt=$lpagifood['totalviaifood'];
					  $taxapagifood = ( $valorpagamentoifoodt * $taxapagamento / 100 );
					  $valorpagamentoifood=$valorpagamentoifoodt-$taxapagifood;	 
						 
                      $cvalorpedido = mysqli_query( $link, "SELECT SUM(valorpedido) AS total FROM pedido WHERE plataforma = '2'" );
                      $lvalorpedidos = mysqli_fetch_assoc( $cvalorpedido );
                      $valorpedidost = $lvalorpedidos[ 'total' ];
                      
                      $taxapagplataforma = ( $valorpedidost * $taxaplataforma / 100 );
                      $valorpedidos = $valorpedidost - $taxapagplataforma;
					  $resultado=$valorpedidos-$valorpagamentoifood;
					  $taxas=$taxapagifood+$taxapagplataforma;	 
					  $valorpedidost=$valorpedidost-$valorpagamentoifoodt;	 
                      ?>
                      <tr align="center">
                        <td  align="center"><a href="#" onClick="repasseifood();">
                      <?=$npedidos?>
                      </a> </td>
                        <td  align="center"><?=$qtdbatatas?></td>
                        <td  align="center">R$<?=number_format($valorpedidost,2)?></td>
						<td  align="center">R$<?=number_format($valorpagamentoifoodt,2)?></td>
                        <td  align="center" class="text-danger">- R$<?=number_format($taxas,2)?></td>
                        <td align="center">R$<b><?=number_format($resultado,1)?></b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>-->
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

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto"> <span>Copyright &copy; Batattos 2021</span> </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

</div>
<div class="modal fade" id="pedidoshoje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pedidos Hoje</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="form-group col-xl-6 col-lg-6"> <br>
        <input class="form-control text-center" value="<?=date("d/m/Y")?>" readonly>
		<input class="form-control text-center text-success" id="caixa" readonly>
		<input class="form-control text-center text-primary" id="mercadopago" readonly>
		<input class="form-control text-center text-danger" id="ifoodmetodo" readonly>   
		  </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div id="bodypedidoshoje"> </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="comprashoje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Compras Hoje</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
		        <div class="form-group col-xl-6 col-lg-6"> <br>
        <input class="form-control text-center" value="<?=date("d/m/Y")?>" readonly>
      </div>
        <div class="table-responsive">
          <div id="bodycomprashoje"> </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="consultaqtdproduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Relátorio Por Produtos</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="form-group col-xl-6 col-lg-6"> <br>
        <input class="form-control" id="dataQtdproduto" readonly>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div id="tbodyqtdproduto"> </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="$('#entradadata').modal('show'); ">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="entradames" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Consulta por Mês</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="form-group col-xl-6 col-lg-6"> <br>
        <input class="form-control" id="mesRelativo" readonly>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div id="bodymes"> </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="fazerbackup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Backup</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body"> Backup do dia
        <?=date("d/m/Y")?>
        não efetuado! </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="button" id="btnfazerbackup">Fazer Backup</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
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
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="pedidoshoje()">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="repasseifood" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="idcliente"></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
		  <div class="form-group col-xl-6 col-lg-6"> <br>
        <input class="form-control" id="datarepasse" readonly>
      </div>
        <div id="bodyrepasseifood"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pedidoscliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pedidosClientes">Pedidos</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      
      <div class="modal-body">
		  <div class="form-group col-lg-12"> <br>
        <input class="form-control text-center" id="nomeclientepedido" readonly><br>
        <input class="form-control text-center text-success" id="valortotal" readonly>
      </div>
        <div class="table-responsive">
          <div id="bodypedidoscliente"> </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="pedidoshoje()">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="entradadata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Consulta por Data</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  </div>
  <div class="form-group col-xl-6 col-lg-6"> <br>
    <input class="form-control" id="dataRelativa" readonly>
  </div>
  <div class="modal-body">
    <div class="table-responsive">
      <div id="bodydata"> </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
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
<script src="js/login.js"></script>
<script src="js/index.js"></script>
</html>