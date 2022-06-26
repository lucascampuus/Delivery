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
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
        <a href="#" class="btn btn-success btn-icon-split" onClick="cadastroCliente();"> <span class="icon text-white-50"> <i class="fas fa-check"></i> </span> <span class="text">Adicionar Cliente</span> </a>
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
                    <th>Apelido</th>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Endereço</th>
                  </tr>
                </thead>
                <tbody>
                  <?php                 
                  $clientes = mysqli_query( $link, "SELECT * FROM `cliente` " )or die( "ERRO AO BUSCAR CLIENTES" );
                  while ( $linhacliente = mysqli_fetch_array( $clientes ) ) {

                    $idcliente = $linhacliente[ 'idcliente' ];
                    $nomecliente = $linhacliente[ 'nomecliente' ];
                    $apelido = $linhacliente[ 'apelido' ];
                    $contato = $linhacliente[ 'contatocliente' ];
                    $endereco = $linhacliente[ 'endereco' ];
                    $bairro = $linhacliente[ 'bairro' ];
                    $status = $linhacliente[ 'status' ];
                    $enderecocliente = $linhacliente[ 'endereco' ];


                    $frete = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '3' AND idproduto = '$bairro' order by produto ASC" )or die( "ERRO AO BUSCAR BAIRRO AQUI" );
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
                    <td  align="center"><a href="#" onClick="pedido(<?=$idcliente?>,'<?=$nomecliente?>','<?=$apelido?>','<?=$session?>');" class="btn btn-sm btn-primary shadow-sm fa-pull-center"><i class="fas fa-more fa-sm text-white-50"></i>
                      <?=$apelido?>
                      </a></td>
                    <td  align="center"><?=$nomecliente?></td>
                    <td  align="center"><?=$contato?></td>
                    <td  align="center"><?=$enderecocliente?>
                      -
                      <?=$bairro?></td>
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
<div class="modal fade" id="cadastroCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastro de Cliente</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="form-group">
            <label>Nome </label>
            <input class="form-control" id="nome_cliente">
          </div>
          <div class="form-group">
            <label>Apelido</label>
            <?php
            $consultaidmax = mysqli_query( $link, "SELECT MAX(idcliente) AS id FROM `cliente` WHERE 1" )or die( "ERRO AO BUSCAR máximo cliente" );
            $apelidonovo = mysqli_fetch_assoc( $consultaidmax );


            $apelidonovo = $apelidonovo[ 'id' ] + 1;


            ?>
            <input class="form-control" id="apelido_cliente" value="<?=$apelidonovo?>" readonly>
          </div>
          <div class="form-group">
            <label>Contato</label>
            <input class="form-control" id="contato_cliente">
          </div>
          <div class="form-group">
            <label>Endereço</label>
            <input class="form-control" id="endereco_cliente">
          </div>
          <div class="form-group">
            <label>Bairro</label>
            <select class="form-control" id="bairro">
              <option value="0">Selecione Bairro</option>
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
          <button type="button" class="btn btn-success" id="btnCadastrar">Cadastrar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
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
          <input type="hidden" id="idcliente"/>
          <input type="hidden" id="session"/>
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
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$session?>','<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>')"><i class="fa fa-plus fa-fw"/></td>
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
          <div class="card-body"> <a href="#cardalaminutagourmet" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Alaminuta Gourmet</h6>
            </a>
            <div class="collapse hide" id="cardalaminutagourmet">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="cardalaminutagourmet" width="100%" cellspacing="0">
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
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$session?>','<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>')"><i class="fa fa-plus fa-fw"/></td>
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
          <div class="card-body"> <a href="#cardalaminutasimples" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Alaminuta Simples</h6>
            </a>
            <div class="collapse hide" id="cardalaminutasimples">
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
                      $produtos = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo = '9' AND status='1' ORDER BY produto DESC " )or die( "ERRO AO BUSCAR PRODUTOS" );
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
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$session?>','<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>')"><i class="fa fa-plus fa-fw"/></td>
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
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$session?>','<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>')"><i class="fa fa-plus fa-fw"/></td>
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
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$session?>','<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>');"><i class="fa fa-plus fa-fw"/></td>
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
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$session?>','<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>');"><i class="fa fa-plus fa-fw"/></td>
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
                        <td align="center"><a href="#" onClick="addcarrinho(<?=$idproduto?>,'<?=$session?>','<?=$nomeproduto?>','<?=$valorproduto?>','<?=$tipoproduto?>');"><i class="fa fa-plus fa-fw"/></td>
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
          <button type="button" class="btn btn-success" id="btnpedido">Continuar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="esvaziacarrinho();">Cancelar</button>
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
      <div class="modal-body" id="pedido">
        <div id="tbody"></div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="valortotalpedido"/>
        <button type="button" class="btn btn-success" id="btnFazerPedido" disabled>Fazer Pedido</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="$('#fazerpedido').modal('show'); ">Voltar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cupom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
        <div id="tcupom"></div>
		  <h6 class='m-0 font-weight-bold text-center text-primary alig'>Código Cupom</h6>
		  <input class="form-control text-center" id="codigocupom" readonly/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btnCupom">Ultilizar</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal" onClick="$('#fazerpedido').modal('show'); ">Cancelar</button>
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
<script src="js/fazerpedido.js"></script>
</body>
</html>