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
        
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-center text-primary alig">Métricas Batattos</h6>
          </div>
			
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead align="center">
                  <tr>
                    <th>Batata</th>
                    <th>Vendas</th>
                    <th>Valor Venda</th>
                    <th>Valor Médio</th>
                    <th>Custo Geral</th>
                  </tr>
                </thead>
                <tbody align="center">
                  <?php
                  $viewv = 0;
				  $c=$_GET['c'];
                  $produto = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '$c'  AND status = '1' ORDER BY produto ASC" )or die( "ERRO AO BUSCAR BATATAS" );
                  while ( $lprod = mysqli_fetch_array( $produto ) ) {

                    $idproduto = $lprod[ 'idproduto' ];
                    $nomeproduto = $lprod[ 'produto' ];
                    $material_idmaterial = explode( "/", $lprod[ 'custoproduto' ] );
                    $cqtdvendas = mysqli_query( $link, "SELECT * FROM carrinho WHERE produto_idproduto = '$idproduto'" )or die( "ERRO AO BUSCAR QTD PRODUTO" );
                    $qtdvenda = mysqli_num_rows( $cqtdvendas );
                    $valorvenda = $lprod[ 'valor' ];
                    $vesper = $valorvenda * $qtdvenda;
                    $cvreal = mysqli_query( $link, "SELECT SUM(valor) as valorvenda FROM carrinho WHERE produto_idproduto = '$idproduto'" )or die( "ERRO AO BUSCAR QTD PRODUTO" );
                    $lvenda = mysqli_fetch_assoc( $cvreal );
                    $vreal = $lvenda[ 'valorvenda' ];
					if(mysqli_num_rows($cqtdvendas)>0)
					{
                    $valorvendareal = $lvenda[ 'valorvenda' ] / $qtdvenda;
					}
					  else
					  {
						  $valorvendareal = '0';
					  }

                    //DIFERENÇA DO VALOR TOTAL REAL - FIXO  
                    $viewv = $viewv - ( $vesper - $vreal );
                    if ( $vesper > $vreal ) {
                      $bg = '#F5CBCD';
                      $dif = $vesper - $vreal;
                    } else {
                      $bg = '#CAF8D9';
                      $dif = $vreal - $vesper;
                    }
                    $valortotal = 0;
                    $valortotal2 = 0;
                    $c = 0;
                    foreach ( $material_idmaterial as $y ) {
                      $c++;
                    }
                    for ( $i = 0; $i < $c; $i++ ) {
                      $cvalor = mysqli_query( $link, "SELECT SUM(valorcusto) AS tvalor FROM custoproduto WHERE idcusto = '$material_idmaterial[$i]'" );
                      $linhavalor = mysqli_fetch_assoc( $cvalor );
                      $valortotal = $valortotal + $linhavalor[ 'tvalor' ];
                    }

                    $valormedio = number_format( $valortotal, 2 );
                    ?>
                  <tr align="center">
                    <td  align="center"><?=$nomeproduto?></td>
                    <td  align="center"><?=$qtdvenda?></td>
                    <td  align="center">R$ <strong>
                      <?=$valorvenda?>
                      </strong></td>
                    <td  align="center" bgcolor="<?=$bg?>" title="<?=number_format($dif,2)?>">R$ <strong>
                      <?=number_format($valorvendareal,2)?>
                      </strong></td>
                    <td  align="center">R$ <strong>
                      <?=$valormedio?>
                      </strong></td>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
            </di>
          </div>
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
  
  <!-- Scroll to Top Button--> 
  <a class="scroll-to-top rounded" href="#page-top"> <i class="fas fa-angle-up"></i> </a> 
  
  <!-- Logout Modal-->
  <div class="modal fade" id="relatorioproduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Relatório Produto</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <div id="bodyrproduto"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btnCompras">Cadastrar</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
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
<script>
function escondevalores(){}
</script>
</body>
</html>