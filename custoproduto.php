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
        <div class="my-4"></div>
        <div class="d-sm align-items-center justify-content-between mb-4">
		<a href="#" onClick="cadastrocusto();" class="btn btn-sm-inline btn-success shadow-sm"><i class="fas fa-more fa-sm text-white-50"></i>Adicionar Custo</a> &nbsp&nbsp 
		<a href="#" onClick="atualizarcusto();" class="btn btn-sm-inline btn-primary shadow-sm"><i class="fas fa-more fa-sm text-white-50"></i>Atualizar Custos</a></div>
        <div class="my-4"></div>
        <div class="my-4"></div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">custos</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead align="center">
                  <tr>
					 <th>Produto</th>
                    <th>Material</th>
                    <th>Valor Custo Un</th>
                    <th>Qtd</th>
					  <th>Descrição</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $custo = mysqli_query( $link, "SELECT * FROM `custoproduto`" )or die( "ERRO AO BUSCAR CUSTO PRODUTO" );
                  while ( $linhacusto = mysqli_fetch_array( $custo ) ) {
                    $idcusto = $linhacusto[ 'idcusto' ];      
					$nomecusto=$linhacusto['custo'];
                    $material = $linhacusto[ 'material_idmaterial' ];
                    $cmaterial = mysqli_query( $link, "SELECT material FROM material WHERE idmaterial = '$material'" );
                    $lmaterial = mysqli_fetch_assoc( $cmaterial );
                    $nomematerial = $lmaterial[ 'material' ];
                    $valorcusto = $linhacusto[ 'valorcusto' ];
                    $qtdmaterial = $linhacusto[ 'qtdmaterial' ];
                    $desc = $linhacusto[ 'desc' ];
                    $status = $linhacusto[ 'status' ];

                    if ( $status == '0' ) {
                      $icon = 'Desativado';
                    } else if ( $status == '1' ) {
                      $icon = 'Ativado';
                    }
					  if($desc == 'peso')
					  {$x='g';}else{$x='Un';}
                    ?>
				
                  <tr align="center">
					 <td  align="center"><?=$nomecusto?></td> 
                    <td  align="center"><?=$nomematerial?></td>
                    <td  align="center">R$ <?=$valorcusto?></td>
					 <td  align="center"><?=$qtdmaterial.' '.$x?></td> 
                    <td  align="center"><?=$desc?></td>
                    <td align="center"><a href="#" onclick="statuscusto(<?=$idcusto?>,'<?=$icon?>');">
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
<div class="modal fade" id="cadastrocusto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
			<div class="form-group">
            <label>Nome Custo</label>
            <input class="form-control" id="nome_custo">
          </div>
          <div class="form-group" >
            <select class="form-control" id="material_idmaterial" onChange="material(this)">
              <option value="0" selected>Selecione o Material</option>
              <?php
              $consultamaterial = mysqli_query( $link, "SELECT material, idmaterial FROM material WHERE tipomaterial != 'Gerais' AND tipomaterial != 'Motoboy' ORDER BY material ASC" );
              while ( $linhamaterial = mysqli_fetch_array( $consultamaterial ) ) {
                $idmaterial = $linhamaterial[ 'idmaterial' ];
                $nomematerial = $linhamaterial[ 'material' ];
                echo '<option value="' . $idmaterial . '">' . $nomematerial . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group" id="form_tipo_material" hidden>
            <label>Medida</label>
            <input class="form-control" id="tipo_material" readonly>
          </div>
          <div class="form-group" id="form_valormedio_material" hidden>
            <label>Valor Médio Material</label>
            <input class="form-control" id="valormedio_material" readonly>
          </div>
          <div class="form-group" id="form_qtd_material" hidden>
            <label>Qtd Material (gramas ou und)</label>
            <input class="form-control" id="qtd_material" onKeyUp="substituiPonto(this)" onChange="customaterial(this)">
          </div>
          <div class="form-group" id="form_custo_material" hidden>
            <label>Custo Material</label>
            <input class="form-control" id="custo_material" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="custosbtn">Cadastrar</button>
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
<script src="js/custoproduto.js"></script>  
</body>
</html>