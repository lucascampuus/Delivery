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
        <!-- Page Heading -->
		  <div class="my-4"></div>
        <a href="#" class="btn btn-success btn-icon-split" onClick="addentregador();"> <span class="icon text-white-50"> <i class="fas fa-check"></i> </span> <span class="text">Adicionar Motoboy</span> </a>
        <div class="my-4"></div>
        <div class="my-4"></div>
        
        <div class="row">
          <div class="col-lg-12 mb-4">
			  <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Entregadores</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead align="center">
                  <tr>
                    <th>Nome</th>
                    <th>Qtd Entregas</th>
                    <th>Em Aberto</th>
                    <th>Pago</th>
					<th>Valor Total</th> 
					<th>Ações</th>  
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $entregadors = mysqli_query( $link, "SELECT * FROM `entregador`" )or die( "ERRO AO BUSCAR ENTREGADORES" );
                  while ( $linhaentregador = mysqli_fetch_array( $entregadors ) ) {

                    $identregador = $linhaentregador[ 'identregador' ];
                    $nomeentregador = $linhaentregador[ 'nomeentregador' ];
                    $qtdentregas = $linhaentregador[ 'qtdentregas' ];
                    $status = $linhaentregador[ 'status' ];
					  
                    $entregas = mysqli_query( $link, "SELECT SUM(valor) AS vtotal FROM `entrega` WHERE entregador_identregador = '$identregador'" )or die( "ERRO AO BUSCAR ENTREGAS" );
                    $linhaentrega = mysqli_fetch_assoc( $entregas );
				    $vtotal = $linhaentrega[ 'vtotal' ];
					  
					$entregas_aberto=mysqli_query($link,"SELECT * FROM entrega WHERE entregador_identregador = '$identregador' AND status = 'ABERTO'");  
                    $qtdaberto=mysqli_num_rows($entregas_aberto);
					 
					$entregas_pago=mysqli_query($link,"SELECT * FROM entrega WHERE entregador_identregador = '$identregador' AND status = 'PAGO'");  
                    $qtdpago=mysqli_num_rows($entregas_pago);  

                    if ( $status == '0' ) {
                      $icon = 'Desativado';
					  $icon2='disabled';	
                    } else if ( $status == '1' ) {
                      $icon = 'Ativado';
					  $icon2='';	
                    }
					
					if($qtdaberto > 0)
					{
						$pagar='<a href="#" class="btn btn-success '.$icon2.'" onclick="pagarboy('.$identregador.');">Pagar</a>';
					}
					else
					{
						$pagar='';
					}
                    ?>
                  <tr align="center">
                    <td  align="center"><?=$nomeentregador?></td>
                    <td  align="center"><?=$qtdentregas?></td>
                    <td  align="center"><a href="#" onclick="entregador(<?=$identregador?>,'ABERTO');"><?=$qtdaberto?></a></td>
                    <td  align="center"><a href="#" onclick="entregador(<?=$identregador?>,'PAGO');"><?=$qtdpago?></a></td>
					<td  align="center">R$ <strong><?=$vtotal?></strong></td>
					<td  align="center"><?=$pagar?></td>    
                    <td align="center"><a href="#" onclick="statusentregador(<?=$identregador?>,'<?=$icon?>');"><?=$icon?></a></td>
                  </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
            <div class="modal fade" id="entregadores" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="false">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="identregador"></h5>
                  </div>
                  <div class="modal-body" id="pedido">
					<div class="form-group">
            <label>Nome </label>
            <input class="form-control" id="nomeentregador">
          </div>
                  </div>
					<div class="modal-footer">
          <button type="button" class="btn btn-success" id="entregadorbtn">Cadastrar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
                </div>
              </div>
            </div>
			  <div class="modal fade" id="entregas" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="false">
              <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="identregador"></h5>
                  </div>
                  <div class="modal-body" id="pedido">
					  <div id="bodymotoboy"></div>
                  </div>
					<div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
        </div>
                </div>
              </div>
            </div>
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
<script src="js/entregadores.js"></script>  

</html>