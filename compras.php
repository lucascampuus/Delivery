<!DOCTYPE html>
<?php
session_start();
$session = session_id();
date_default_timezone_set("Brazil/East");
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
        <div class="d-sm align-items-center justify-content-between mb-4"> <a href="#" onClick="addcompras();" class="btn btn-sm-inline btn-success shadow-sm"><i class="fas fa-more fa-sm text-white-50"></i>Adicionar Compra</a> &nbsp&nbsp <a href="#" onClick="addmaterial();" class="btn btn-sm-inline btn-primary shadow-sm"><i class="fas fa-more fa-sm text-white-50"></i>Adicionar Material</a> &nbsp&nbsp <a href="#" onClick="addfornecedor();" class="btn btn-sm-inline btn-warning shadow-sm"><i class="fas fa-more fa-sm text-white-50"></i>Adicionar Fornecedor</a> </div>
        
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Compras</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>Compra</th>
                    <th>Produto</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                    <th>Local</th>
                    <th>Data</th>
                  </tr>
                </thead>
                <tbody>
                  <?php               
                  $compras = mysqli_query( $link, "SELECT * FROM `compras`" )or die( "ERRO AO BUSCAR COMPRAS" );
                  while ( $linhacompras = mysqli_fetch_array( $compras ) ) {

                    $idcompra = $linhacompras[ 'idcompra' ];
                    $compra = $linhacompras[ 'compra' ];
                    $valor = $linhacompras[ 'valor' ];
                    $tipo = $linhacompras[ 'tipo' ];
                    $fornecedor = $linhacompras[ 'fornecedor' ];
                    $data = $linhacompras[ 'data' ];
                    $data = explode( "-", $data );
                    $dia = $data[ 2 ];
                    $mes = $data[ 1 ];
                    $ano = $data[ 0 ];
                    $data = $dia;
                    $data .= '/';
                    $data .= $mes;
                    $data .= '/';
                    $data .= $ano;
					$cfor=mysqli_query($link,"SELECT * FROM fornecedores WHERE idfornecedor = '$fornecedor'")or die("ERRO AO BUSCAR FORNECEDOR");
					  $lfor=mysqli_fetch_assoc($cfor);
					  	$nomefornecedor=$lfor['fornecedor'];  

                    ?>
                  <tr align="center">
                    <td  align="center"><?=$idcompra?></td>
                    <td  align="center"><?=$compra?></td>
                    <td  align="center">R$ <B>
                      <?=number_format($valor,2)?>
                      </B></td>
                    <td  align="center"><?=$tipo?></td>
                    <td  align="center"><?=$nomefornecedor?></td>
                    <td  align="center"><?=$data?></td>
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
<div class="modal fade" id="cadastrocompras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Compras</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label>Produtos </label>
            <select class="form-control" id="material" onChange="fornecedor(this)" autofocus>
              <option value="0">Selecione</option>
              <?php
              $materiais = mysqli_query( $link, "SELECT * FROM material WHERE status = '1' ORDER BY material ASC" )or die( "ERRO AO BUSCAR MATERIAL" );
              while ( $lmat = mysqli_fetch_array( $materiais ) ) {
                $idmaterial = $lmat[ 'idmaterial' ];
                $material = $lmat[ 'material' ];

                echo '<option value="' . $idmaterial . '">' . $material . '</option>';

              }
              ?>
            </select>
          </div>
          <div class="form-group" id="form_produtos" hidden>
            <div id="bodymateriais"></div>
          </div>
          <BR>
          <div class="form-group" id="vp1" hidden>          
            <label>Valor Kg</label>
            <input class="form-control" id="valorpesound" onKeyUp="substituiPonto(this)"> 
            <input type='hidden' id="desc"/>   
          </div>
          
          <div class="form-group" id="vp5" hidden>
            <label>Valor</label>
            <input class="form-control" id="valorcompra" onKeyUp="substituiPonto(this)">
          </div>
          
          <div class="form-group" id="vp2" hidden>
            <label>Peso</label>
            <input class="form-control" id="qtdpesound" readonly>
          </div>
          
          <div class="form-group" id="vp3" hidden>          
            <label>Valor Unidade</label>
            <input class="form-control" id="valorpesound2" onKeyUp="substituiPonto3(this)">   
          </div>
          
          <div class="form-group" id="vp4" hidden>
            <label>Quantidade</label>
            <input class="form-control" id="qtdpesound2" onKeyUp="substituiPonto2(this)">
          </div>
          
          <div class="form-group" id="vp6" hidden>
            <label>Valor</label>
            <input class="form-control" id="valorcompra2" readonly>
          </div>
            <label>Data</label>
            <input class="form-control" id="datacompra" value="<?=date("d/m/Y")?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnCompras">Cadastrar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cadastrofornecedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Fornecedor</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label>Fornecedor</label>
            <input class="form-control" id="nome_fornecedor">
          </div>
          <div class="form-group">
            <label>Contato</label>
            <input class="form-control" id="contato_fornecedor">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnCadastroFornecedor">Cadastrar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cadastromaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produto</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label>Produto</label>
            <input class="form-control" id="nome_material">
          </div>
		<div class="form-group">
            <label>Qtd Fornecedores</label>
            <input class="form-control" id="qtd_fornecedor" onChange="qtdfornecedor(this)">
          </div>
		 <div id="formqtdfornecedor"></div>	      
          <div class="form-group">
            <label>Tipo</label>
            <select class="form-control" id="tipo_material">
              <option value="Selecione">Selecione</option>
              <option value="Matéria Prima">Matéria Prima</option>
			  <option value="Produto">Produto</option>	
              <option value="Embalagem">Embalagem</option>
              <option value="Motoboy">Motoboy</option>
              <option value="Ads">Ads</option>
              <option value="Gerais">Gerais</option>
            </select>
          </div>
          <div class="form-group">
            <label>Descrição</label>
            <select class="form-control" id="desc_material">
              <option value="Selecione">Selecione</option>
              <option value="und">Unidade</option>
              <option value="peso">Peso</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnCadastroMaterial">Cadastrar</button>
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
<script src="js/compras.js"></script>  
</body>
</html>