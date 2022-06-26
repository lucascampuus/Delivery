<?php
session_start();
include "../connect/conexaomysql.php";

/////////////////////////////////////////////////////////// CONSULTA CARRINHO
if ( isset( $_POST[ 'consultapedido' ] ) ) {
  $session = $_POST[ 'pedido' ];
  $idcliente = $_POST[ 'cliente' ];
  $consultafrete = mysqli_query( $link, "SELECT * FROM `cliente` WHERE idcliente = '$idcliente'" )or die( "ERRO AO BUSCAR FRETE" );
  while ( $linhaconsultafrete = mysqli_fetch_array( $consultafrete ) ) {
    $endereco = $linhaconsultafrete[ 'endereco' ];
    $bairro = $linhaconsultafrete[ 'bairro' ];

  }
  $consultafrete = mysqli_query( $link, "SELECT * FROM `produto` WHERE idproduto = '$bairro'" )or die( "ERRO AO BUSCAR FRETE 234" );
  if ( mysqli_num_rows( $consultafrete ) > 0 ) {
    $lbairro = mysqli_fetch_assoc( $consultafrete );
    $bairro = $lbairro[ 'produto' ];
  } else {
    $bairro = 'Não Cadastrado';
  }
  $valortotal = 0;

  $resposta = '<div class="table-responsive">
                        <table class="table table-bordered" id="tabelabatatas" width="100%" cellspacing="0">
                          <thead>
                            <tr align="center">
								<th align="center">Tipo</th>
								<th align="center">Produto</th>
                              <th align="center">Valor</th>
                              
                            </tr>
                          </thead>
                          <tbody>';
  $carrinho = mysqli_query( $link, "SELECT * FROM `carrinho` WHERE pedido = '$session'" )or die( "ERRO AO BUSCAR Carrinho" );
  while ( $linhacarrinho = mysqli_fetch_array( $carrinho ) ) {


    $nomeproduto = $linhacarrinho[ 'produto' ];
	$tipoproduto= $linhacarrinho['tipo'];
    $valor = $linhacarrinho[ 'valor' ];
	if($tipoproduto == '0'){$tipoproduto="Batata Recheada";}
	if($tipoproduto == '1'){$tipoproduto="Adicional";}
	if($tipoproduto == '2'){$tipoproduto="Porção";}
	if($tipoproduto == '3'){$tipoproduto="Frete";}
	if($tipoproduto == '4'){$tipoproduto="Bebida";}
	if($tipoproduto == '6'){$tipoproduto="Cupom";}
	if($tipoproduto == '7'){$tipoproduto="Alaminuta";}
	if($tipoproduto == '8'){$tipoproduto="Massa";}
	

    $resposta .= "<tr align='center'><td align='center'>$tipoproduto</td><td align='center'>$nomeproduto</td><td  align='center'>R$$valor</td></tr>";


  }
  $pedido = mysqli_query( $link, "SELECT * FROM `pedido` WHERE pedido = '$session'" )or die( "ERRO AO BUSCAR Carrinho" );
  while ( $linhapedido = mysqli_fetch_array( $pedido ) ) {

    $valortotal = $linhapedido[ 'valorpedido' ];
    $tipopedido = $linhapedido[ 'tipopedido' ];

    $metodo = $linhapedido[ 'metodopagamento' ];
    $cmetodo = mysqli_query( $link, "SELECT * FROM `pagamento` WHERE idpagamento='$metodo'" )or die( "ERRO AO BUSCAR pagamento" );
    while ( $linhapagamento = mysqli_fetch_array( $cmetodo ) ) {
      $nomepagamento = $linhapagamento[ 'nomepagamento' ];
    }
	  $plataforma = $linhapedido['plataforma'];
					 $cplataformas = mysqli_query( $link, "SELECT * FROM `plataforma` WHERE idplataforma='$plataforma'" )or die( "ERRO AO BUSCAR PLATAFORMA" );
                      while ( $linhaplataforma = mysqli_fetch_array( $cplataformas ) ) {
                        $nomeplataforma = $linhaplataforma[ 'plataforma' ];
					  
					  }
  }

  if ( $tipopedido != 'Normal' ) {
    $resposta .= '<tr><td colspan="3">Desconto pedido <B>' . $tipopedido . '<BR></td></tr>';

  }
  $consultaentrega=mysqli_query($link,"SELECT * FROM entrega WHERE pedido = '$session'");
	 if(mysqli_num_rows($consultaentrega)>0)
  {
  $lce=mysqli_fetch_assoc($consultaentrega);
  $identregador=$lce['entregador_identregador'];
  $consultaentregador=mysqli_query($link,"SELECT * FROM entregador WHERE identregador = '$identregador'");
 
  $lcd=mysqli_fetch_assoc($consultaentregador);
  $entregador=$lcd['nomeentregador'];
  $entregador= 'Entregue por   '.$entregador.' ';		 
  }
   else
   {
	  $entregador='Retirada';
   }
  $resposta .= '<tr><td colspan="3">Valor total do Pedido <B>R$' .$valortotal. '</B> <BR><B>Plataforma</B> ( ' .$nomeplataforma. ' ) / <B>Pagamento</B> ( '.$nomepagamento.' )</td><input type="hidden" id="valortotalpedido"/><tr/></tbody></table></div>
  <div class="card shadow mb-4"> 
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Entrega</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body border-left-dark">
                <div class="form-group"> ' . $endereco . ' - ' . $bairro . ' <br><B>Metodo</B> ('.$entregador.' )</div>
				
              </div>
            </div>
  
  
  
  ';


  $retorno[ 'status' ] = 'success';
  $retorno[ 'resposta' ] = $resposta;
  $retorno[ 'valor' ] = $valortotal;

  //session_regenerate_id();
  echo json_encode( $retorno );
}

ob_end_flush();
?>
