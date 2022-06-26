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
            <h6 class="m-0 font-weight-bold text-primary">Materiais</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead align="center">
                  <tr>
                    <th>Material</th>
                    <th>Fornecedor</th>
                    <th>Tipo Material</th>
                    <th>Valor Médio</th>
					<th>Ações</th>  
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody align="center">
                  <?php
                  $material = mysqli_query( $link, "SELECT * FROM `material`" )or die( "ERRO AO BUSCAR COMPRAS" );
                  while ( $lmat = mysqli_fetch_array( $material ) ) {

                    $idmaterial = $lmat[ 'idmaterial' ];
                    $nomematerial = $lmat[ 'material' ];
                    $tipo = $lmat[ 'tipomaterial' ];
					$desc = $lmat[ 'desc' ];  
                    $valormedio = $lmat[ 'valormedio' ];
					$status = $lmat[ 'status' ]; 
					if ( $status == '0' ) {
                      $icon = 'Desativado';
                    } else if ( $status == '1' ) {
                      $icon = 'Ativado';
                    }
					$fornecedor = explode("/",$lmat[ 'fornecedor' ]);  
					$c=0;  
					foreach($fornecedor as $ty){$c++;}
					$limite=$c-1;  
                    ?>
                  <tr align="center">
                    <td  align="center"><?=$nomematerial?></td>
					<?php
					$nomefornecedor='';	
					for($i=0;$i<$c;$i++)
					{
					$cfor=mysqli_query($link,"SELECT * FROM fornecedores WHERE idfornecedor = '$fornecedor[$i]'");
					$lfor=mysqli_fetch_assoc($cfor);	
                    $nomefornecedor.=$lfor['fornecedor'];
					if ( $i < $limite ) {


                        $nomefornecedor .= " / ";
                      }	
					}
				  	?>
					<td  align="center"><?=$nomefornecedor?></td>    
					<td  align="center"><?=$tipo. ' - ' .$desc?></td>  
                    <td  align="center">R$ <B><?=number_format($valormedio,2)?></B></td>  
					<td  align="center"><a href="#" onClick="editarmaterial()"><i class="fa fa-eraser fa-fw"></i></td>    
                    <td align="center"><a href="#" onclick="statusmaterial(<?=$idmaterial?>,'<?=$icon?>');"><?=$icon?></a></td>

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
<script>function escondevalores(){}</script> 
</body>
</html>