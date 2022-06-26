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
        <a href="#" class="btn btn-success btn-icon-split" onClick="cadastroproduto();"> <span class="icon text-white-50"> <i class="fas fa-check"></i> </span> <span class="text">Adicionar Produto</span> </a>
        <div class="my-4"></div>
        <div class="my-4"></div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Produtos</h6>
          </div>
          <div class="card-body">
			  <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead align="center">
                  <tr>
                  <th>Tipo</th>
                    <th>Produto</th>
                    <th>Valor</th>
					<th>Status</th>  
					<th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $produtos = mysqli_query( $link, "SELECT * FROM `produto` ORDER BY tipo ASC" )or die( "ERRO AO BUSCAR PRODUTOS" );
                  while ( $linhaprodutos = mysqli_fetch_array( $produtos ) ) {

                    $idprodutos = $linhaprodutos[ 'idproduto' ];
                    $nomeprodutos = $linhaprodutos[ 'produto' ];
                    $tipo = $linhaprodutos[ 'tipo' ];
					if($tipo == "7"){$tipo= 'Alaminuta';}
					if($tipo == "0"){$tipo= 'Batata Recheada';}
					if($tipo == "8"){$tipo= 'Massas';}
					if($tipo == "1"){$tipo= 'Adicionais';}
					if($tipo == "2"){$tipo= 'Porções';}
					if($tipo == "3"){$tipo= 'Tele-Entrega';}
					if($tipo == "4"){$tipo= 'Bebidas';}
					if($tipo == "6"){$tipo= 'Cupom Desconto';}
					if($tipo == "9"){$tipo= 'Alaminuta Simples';}
					if($tipo == "10"){$tipo= 'Marmitex Especial';}

					 $tipoid = $linhaprodutos[ 'tipo' ];
                    $valor = $linhaprodutos[ 'valor' ];
                    $status = $linhaprodutos[ 'status' ];
					 if ( $status == '0' ) {
                      $icon = 'Desativado';
                    } else if ( $status == '1' ) {
                      $icon = 'Ativado';
                    }  
					
					?>	
					<tr align="center">
                    <td  align="center"><?=$tipo?></td>
                    <td  align="center"><?=$nomeprodutos?></td>
                    <td  align="center">R$ <strong><?=$valor?></strong></td>
					<td align="center"><a href="#" onclick="statusproduto(<?=$idprodutos?>,'<?=$icon?>');"><?=$icon?></a></td>	
                    <td align="center"><a href="#" onClick="editarproduto(<?=$idprodutos?>)"><i class="fa fa-eraser fa-fw"></i></a><a href="#" onclick="delprodutos(<?=$idprodutos?>,<?=$status?>);"><i class="fa fa-<?=$icon?> fa-fw"></i></a></td>
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
<div class="modal fade" id="cadastroproduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastrar Produto</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label>Nome Produto</label>
			  <input class="form-control" id="nome_produto">
          </div>
          <div class="form-group">
            <label>Tipo</label>
            <select class="form-control" id="tipo_produto">
				<option value="7">Alaminuta</option>
                <option value="9">Marmita Simples</option>
                <option value="10">Marmita Especial</option>
                <option value="0">Batata Recheada</option>
				 <option value="8">Massas</option>
				<option value="1">Adicionais</option>
				<option value="2">Porções</option>
				<option value="3">Tele-Entrega</option>
				<option value="4">Bebida</option>
				
	       </select>
          </div>
          <div class="form-group">
            <label>Valor</label>
            <input class="form-control" id="valor_produto" onKeyUp="substituiPonto(this)">
          </div>
		  <div class="form-group">
            <label>Qtd Custo</label>
            <input class="form-control" id="qtd_custo" onChange="qtdcusto(this)">
          </div>
		 <div id="formcusto"></div>		
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnCadastrarProduto">Cadastrar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="editarproduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Produto</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
		<input type="hidden" id="eidproduto"/>	
          <div class="form-group">
            <label>Nome Produto</label>
			  <input class="form-control" id="enome_produto">
          </div>
          <div class="form-group">
            <label>Tipo</label>
            <select class="form-control" id="etipo_produto">
				<option value="7">Alaminuta</option>
                <option value="9">Marmita Simples</option>
                <option value="10">Marmita Especial</option>
                <option value="0">Batata Recheada</option>
				 <option value="8">Massas</option>
				<option value="1">Adicionais</option>
				<option value="2">Porções</option>
				<option value="3">Tele-Entrega</option>
				<option value="4">Bebida</option>
				
	       </select>
          </div>
          <div class="form-group">
            <label>Valor</label>
            <input class="form-control" id="evalor_produto" onKeyUp="substituiPonto(this)">
          </div>
		  <div class="form-group">
            <label>Qtd Custo</label>
            <input class="form-control" id="eqtd_custo" onChange="eqtdcusto(this)">
          </div>
		 <div id="eformcusto"></div>		
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnEditarProduto">Editar</button>
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
<script src="js/produtos.js"></script>  
</body>
</html>