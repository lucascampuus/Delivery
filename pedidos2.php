<!DOCTYPE html>
<?php
session_start();
$session = session_id();
include "data/connect/conexaomysql.php";
if(isset($_GET['pedido']))
{
	$getpedido=$_GET['pedido'];
	$getcliente=$_GET['cliente'];
}
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

<body id="page-top" onLoad="btnPedido('<?=$getpedido?>',<?=$getcliente?>);">

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
            <h6 class="m-0 font-weight-bold text-primary">Pedidos</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>Pedido</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
         for($id = 1; $id<898; $id++)
		 {	
			$dados = file_get_contents('https://pokeapi.co/api/v2/pokemon/'.$id.'/');
			$pokemon = json_decode($dados);
                    ?>
                  <tr align="center">
                    <td  align="center"><?=$pokemon->name?></td>
                  </tr>
                  <?php
                //  }
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
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="fazerpedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <div class="form-group">
          <input class="form-control text-center" id="nomecliente" align="center" readonly/>		
          <input type="hidden" id="idclientepedido"/>
          <input type="hidden" id="sessionpedido"/>
        </div>
      </div>
      <div class="modal-body">
        <div class="card shadow mb-1">
          <div class="card-body"> <a href="#cardbatatas" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Batatas Recheadas</h6>
            </a>
            <div class="collapse hide" id="cardbatatas">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelabatatas" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Batata</th>
                        <th align="center">Valor</th>
                        <th align="center">Add</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $produtos = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '0' AND status='1' ORDER BY produto ASC " )or die( "ERRO AO BUSCAR PRODUTOS" );
                      while ( $linhaproduto = mysqli_fetch_array( $produtos ) ) {

                        $idproduto = $linhaproduto[ 'idproduto' ];
                        $nomeproduto = $linhaproduto[ 'produto' ];
                        $tipoproduto = $linhaproduto[ 'tipo' ];
                        $valorproduto = $linhaproduto[ 'valor' ];
                        $status = $linhaproduto[ 'status' ];

                        if ( $status == '0' ) {
                          $icon = 'check';
                        } else if ( $status == '1' ) {
                          $icon = 'trash';
                        }
                        ?>
                      <tr align="center">
                        <td  align="center"><?=$nomeproduto?></td>
                        <td  align="center"><?=$valorproduto?></td>
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>')"><i class="fa fa-plus fa-fw"/></td>
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
        </div>
		  <div class="card shadow mb-1">
          <div class="card-body"> <a href="#cardalaminuta" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Alaminutas</h6>
            </a>
            <div class="collapse hide" id="cardalaminuta">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelabatatas" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Alaminuta</th>
                        <th align="center">Valor</th>
                        <th align="center">Add</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $produtos = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '7' AND status='1' ORDER BY produto DESC " )or die( "ERRO AO BUSCAR PRODUTOS" );
                      while ( $linhaproduto = mysqli_fetch_array( $produtos ) ) {

                        $idproduto = $linhaproduto[ 'idproduto' ];
                        $nomeproduto = $linhaproduto[ 'produto' ];
                        $tipoproduto = $linhaproduto[ 'tipo' ];
                        $valorproduto = $linhaproduto[ 'valor' ];
                        $status = $linhaproduto[ 'status' ];

                        if ( $status == '0' ) {
                          $icon = 'check';
                        } else if ( $status == '1' ) {
                          $icon = 'trash';
                        }
                        ?>
                      <tr align="center">
                        <td  align="center"><?=$nomeproduto?></td>
                        <td  align="center"><?=$valorproduto?></td>
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>')"><i class="fa fa-plus fa-fw"/></td>
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
        </div>
		  <div class="card shadow mb-1">
          <div class="card-body"> <a href="#cardmassas" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Massas</h6>
            </a>
            <div class="collapse hide" id="cardmassas">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelamassas" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Massa</th>
                        <th align="center">Valor</th>
                        <th align="center">Add</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $produtos = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '8' AND status='1' ORDER BY produto ASC " )or die( "ERRO AO BUSCAR PRODUTOS" );
                      while ( $linhaproduto = mysqli_fetch_array( $produtos ) ) {

                        $idproduto = $linhaproduto[ 'idproduto' ];
                        $nomeproduto = $linhaproduto[ 'produto' ];
                        $tipoproduto = $linhaproduto[ 'tipo' ];
                        $valorproduto = $linhaproduto[ 'valor' ];
                        $status = $linhaproduto[ 'status' ];

                        if ( $status == '0' ) {
                          $icon = 'check';
                        } else if ( $status == '1' ) {
                          $icon = 'trash';
                        }
                        ?>
                      <tr align="center">
                        <td  align="center"><?=$nomeproduto?></td>
                        <td  align="center"><?=$valorproduto?></td>
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>')"><i class="fa fa-plus fa-fw"/></td>
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
        </div>
        <div class="card shadow mb-1">
          <div class="card-body"> <a href="#cardcombos" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Adicionais</h6>
            </a>
            <div class="collapse hide" id="cardcombos">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelaadicionais" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Adicional</th>
                        <th align="center">Valor</th>
                        <th align="center">add</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $produtos = mysqli_query( $link, "SELECT * FROM `produto` WHERE  tipo = '1' AND status='1' ORDER BY produto ASC " )or die( "ERRO AO BUSCAR PRODUTOS" );
                      while ( $linhaproduto = mysqli_fetch_array( $produtos ) ) {

                        $idproduto = $linhaproduto[ 'idproduto' ];
                        $nomeproduto = $linhaproduto[ 'produto' ];
                        $tipoproduto = $linhaproduto[ 'tipo' ];
                        $valorproduto = $linhaproduto[ 'valor' ];
                        $status = $linhaproduto[ 'status' ];

                        if ( $status == '0' ) {
                          $icon = 'check';
                        } else if ( $status == '1' ) {
                          $icon = 'trash';
                        }

                        ?>
                      <tr align="center">
                        <td  align="center"><?=$nomeproduto?></td>
                        <td  align="center"><?=$valorproduto?></td>
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>');"><i class="fa fa-plus fa-fw"/></td>
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
        </div>
        <div class="card shadow mb-1">
          <div class="card-body"> <a href="#cardporcao" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Porções</h6>
            </a>
            <div class="collapse hide" id="cardporcao">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelaporcao" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Porção</th>
                        <th align="center">Valor</th>
                        <th align="center">add</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $produtos = mysqli_query( $link, "SELECT * FROM `produto` WHERE  tipo = '2' AND status='1' ORDER BY produto ASC " )or die( "ERRO AO BUSCAR PRODUTOS" );
                      while ( $linhaproduto = mysqli_fetch_array( $produtos ) ) {

                        $idproduto = $linhaproduto[ 'idproduto' ];
                        $nomeproduto = $linhaproduto[ 'produto' ];
                        $tipoproduto = $linhaproduto[ 'tipo' ];
                        $valorproduto = $linhaproduto[ 'valor' ];
                        $status = $linhaproduto[ 'status' ];

                        if ( $status == '0' ) {
                          $icon = 'check';
                        } else if ( $status == '1' ) {
                          $icon = 'trash';
                        }

                        ?>
                      <tr align="center">
                        <td  align="center"><?=$nomeproduto?></td>
                        <td  align="center"><?=$valorproduto?></td>
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>');"><i class="fa fa-plus fa-fw"/></td>
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
        </div>
        <div class="card shadow mb-1">
          <div class="card-body"> <a href="#cardrefri" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Refrigerante</h6>
            </a>
            <div class="collapse hide" id="cardrefri">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tabelaporcao" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Refri</th>
                        <th align="center">Valor</th>
                        <th align="center">add</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $produtos = mysqli_query( $link, "SELECT * FROM `produto` WHERE  tipo = '4' AND status='1' ORDER BY produto ASC " )or die( "ERRO AO BUSCAR PRODUTOS" );
                      while ( $linhaproduto = mysqli_fetch_array( $produtos ) ) {

                        $idproduto = $linhaproduto[ 'idproduto' ];
                        $nomeproduto = $linhaproduto[ 'produto' ];
                        $tipoproduto = $linhaproduto[ 'tipo' ];
                        $valorproduto = $linhaproduto[ 'valor' ];
                        $status = $linhaproduto[ 'status' ];

                        if ( $status == '0' ) {
                          $icon = 'check';
                        } else if ( $status == '1' ) {
                          $icon = 'trash';
                        }

                        ?>
                      <tr align="center">
                        <td  align="center"><?=$nomeproduto?></td>
                        <td  align="center"><?=$valorproduto?></td>
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>');"><i class="fa fa-plus fa-fw"/></td>
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnpedido" onClick="pedidohide()">Continuar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="idcliente"></h5>
      </div>
      <div class="modal-body">
        <div id="tbodypedido"></div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="valortotalpedido"/>
        
        <button type="button" class="btn btn-success" id="btnFazerPedido">Editar Pedido</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="$('#fazerpedido').modal('show');" >Adicionar Itens</button>
        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
        
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
<script src="js/pedidos.js"></script>
</body>
</html>
