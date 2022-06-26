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
        <div class="my-4"></div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Clientes</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead align="center">
                  <tr>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Endereço</th>
                    <th>Pedidos</th>
                    <th>Ultimo Pedido</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $clientes = mysqli_query( $link, "SELECT * FROM `cliente`" )or die( "ERRO AO BUSCAR CLIENTES" );
                  while ( $linhacliente = mysqli_fetch_array( $clientes ) ) {

                    $idcliente = $linhacliente[ 'idcliente' ];
                    $nomecliente = $linhacliente[ 'nomecliente' ];
                    $apelido = $linhacliente[ 'apelido' ];
                    $contato = $linhacliente[ 'contatocliente' ];
                    $endereco = $linhacliente[ 'endereco' ];
                    $bairroid = $linhacliente[ 'bairro' ];
                    $status = $linhacliente[ 'status' ];
                    $enderecocliente = $linhacliente[ 'endereco' ];
                    $qtdpedidos = $linhacliente[ 'qtdpedido' ];
					$dtultimopedido = $linhacliente['dtultimopedido'];
					if($dtultimopedido != 'SEM PEDIDO')
					{
					$dtultimopedido = explode("-",$linhacliente[ 'dtultimopedido' ]);
					$dtultimopedido=$dtultimopedido[2].'/'.$dtultimopedido[1].'/'.$dtultimopedido[0];
					}
                    
                    $frete = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '3' AND idproduto = '$bairroid' order by produto ASC" )or die( "ERRO AO BUSCAR BAIRRO" );
                    while ( $linhafrete = mysqli_fetch_array( $frete ) ) {

                      $bairro = $linhafrete[ 'produto' ];
                    }

                    if ( $status == '0' ) {
                      $icon = 'check';
                    } else if ( $status == '1' ) {
                      $icon = 'trash';
                    }
                    ?>
                  <tr align="center">
                    <td  align="center"><?=$nomecliente?></td>
                    <td  align="center"><?=$contato?></td>
                    <td  align="center"><?=$enderecocliente?>
                      -
                      <?=$bairro?></td>
                    <td  align="center"><a href="#" onClick="pedidoscliente(<?=$idcliente?>);" class="btn btn-success"><?=$qtdpedidos?></i></a></td>
                    <td  align="center"><?=$dtultimopedido?></td>
                    <td align="center"><a href="#" onClick="editarCliente(<?=$idcliente?>,'<?=$nomecliente?>','<?=$apelido?>','<?=$contato?>','<?=$endereco?>','<?=$bairroid?>')"><i class="fa fa-eraser fa-fw"></i><a href="#" onclick="delcliente(<?=$idcliente?>,<?=$status?>);"><i class="fa fa-<?=$icon?> fa-fw"></i></a></td>
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
<div class="modal fade" id="editarcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content" >
      <div class="modal-header"> </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editarCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cadastro</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label>Nome</label>
			  <input class="form-control" id="edit_nome">
            <input class="form-control" type="hidden" id="edit_id">
          </div>
          <div class="form-group">
            <label>Apelido</label>
            <input class="form-control" id="edit_apelido" readonly>
          </div>
          <div class="form-group">
            <label>Contato</label>
            <input class="form-control" id="edit_contato">
          </div>
          <div class="form-group">
            <label>Endereço</label>
            <input class="form-control" id="edit_endereco">
          </div>
          <div class="form-group">
            <label>Bairro</label>
            <select class="form-control" id="edit_bairro">
              <?php
              $frete = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '3' AND status = '1' order by produto ASC" )or die( "ERRO AO BUSCAR BAIRRO" );
              while ( $linhafrete = mysqli_fetch_array( $frete ) ) {
                echo '<option value="' . $linhafrete[ 'idproduto' ] . '">' . $linhafrete[ 'produto' ] . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnEditarCliente">Editar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pedidoscliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pedidos</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="form-group col-lg-12"> <br>
        <input class="form-control text-center" id="nomeclientepedido" readonly><br>
        <input class="form-control text-center text-success" id="valortotal" readonly>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div id="bodypedidoscliente"> </div>
        </div>
      </div>
      <div class="modal-footer">
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
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="pedidoscliente()">Voltar</button>
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
<script src="js/clientes.js"></script>  
</body>
</html>