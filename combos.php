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
        <a href="#" class="btn btn-success btn-icon-split" onClick="cadastroCombo();"> <span class="icon text-white-50"> <i class="fas fa-check"></i> </span> <span class="text">Adicionar Combo</span> </a>
        <div class="my-4"></div>
        <div class="my-4"></div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Combos</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead align="center">
                  <tr>
                    <th>Combo</th>
					<th>Dia</th>  
                    <th>Valor</th>
                    <th>Valor Produto</th>
                    <th>Produtos</th>
                    <th>Status</th>
					<th>#</th>  
                  </tr>
                </thead>
                <tbody>
                  <?php            
                  $combo = mysqli_query( $link, "SELECT * FROM `Combo` ORDER BY combo ASC" )or die( "ERRO AO BUSCAR COMBOS" );
                  while ( $linhacombo = mysqli_fetch_array( $combo ) ) {

                    $idcombo = $linhacombo[ 'idcombo' ];
                    $nomecombo = $linhacombo[ 'combo' ];
                    $valorcombo = $linhacombo[ 'valor' ];
					$dia = $linhacombo[ 'dia' ];  
                    $valorbatata = $linhacombo[ 'valorbatata' ];
                    $batatas = explode("/",$linhacombo[ 'batatas' ]);
                    $status = $linhacombo[ 'status' ];
					if($dia == 'todos')
					{
						$dia='Todos os Dias';
					}
					  else
					  {
					$diasemana = array('Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sabado');
					$dia = $diasemana[$dia];  
					  }
                    if ( $status == '0' ) {
                      $icon = 'Desativado';
                    } else if ( $status == '1' ) {
                      $icon = 'Ativado';
                    }
                    ?>
                  <tr align="center">
                    <td  align="center"><?=$nomecombo?></td>
                    <td  align="center"><?=$dia?></td>
                    <td  align="center">R$
                      <?=$valorcombo?></td>
                    <td  align="center">R$
                      <?=$valorbatata?>
                    <?php
                    $nomebatata = '';
					  $c='';
					 foreach($batatas as $y)
					 {
						 $c++;
					 }
					  $limite= $c-1;
                    for ( $i = 0; $i < $c; $i++ ) {
                      
                      $BATATASELECT = $batatas[ $i ];
                      $consultaproduto = mysqli_query( $link, "SELECT produto FROM produto WHERE idproduto = '$BATATASELECT'" );
                      $linhabatata = mysqli_fetch_assoc( $consultaproduto );
                      $nomebatata .= $linhabatata[ 'produto' ];
					  if($i < $limite)
					  {
						  $nomebatata.= ' - ';
					  }
  
                    }
                    ?>
                    <td  align="center"><?=$nomebatata?></td>
                    <td align="center"><a href="#" onclick="statuscombo(<?=$idcombo?>,'<?=$icon?>');"><?=$icon?></a></td>
					<td align="center"><a href="#" onclick="statuscombo(<?=$idcombo?>,'excluir');"><i class="fa fa-trash fa-fw"></i></a></td>
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
<div class="modal fade" id="cadastrocombo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label>Nome do Combo</label>
            <input class="form-control" id="nomecombo">
          </div>
			<div class="form-group">
                  <select class="form-control" id="dia">
					<option value='Não Selecionado' selected>Selecione o Dia</option>  
					<option value='todos'>Todos os dias</option>  
                    <option value='1'>Segunda</option>
                    <option value='2'>Terça</option>
                    <option value='3'>Quarta</option>
                    <option value='4'>Quinta</option>
                    <option value='5'>Sexta</option>
                    <option value='6'>Sábado</option>
                    <option value='0'>Domigo</option>
                  </select>
                </div>
          <div class="form-group">
            <label>Valor Combo</label>
            <input class="form-control" id="valorcombo" onKeyUp="substituiPonto(this)" onChange="valorbatatacombo(this)">
          </div>
		  <div class="form-group">
            <label>Tipo Produto</label>
            <select class="form-control" id="tipo_produto">
				<option value="0">Selecione</option>
				<option value="7">Alaminuta</option>
                <option value="9">Marmita Simples</option>
                <option value="10">Marmita Especial</option>
                <option value="0">Batata Recheada</option>
				 <option value="8">Massas</option>
				<option value="2">Porções</option>			
	       </select>
          </div>
          <div class="form-group">
            <label>Valor Produto</label>
            <input class="form-control" id="valorbatata">
          </div>
		  <div class="form-group">
            <label>Qtd Produtos no Combo</label>
            <input class="form-control" id="qtd_batata" onChange="qtdbatata(this)">
          </div>
		 <div id="formqtdbatata"></div>	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="combosbtn">Cadastrar</button>
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
<script src="js/combos.js"></script>  
</body>
</html>