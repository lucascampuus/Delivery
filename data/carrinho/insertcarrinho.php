<?php
session_start();
include "../connect/conexaomysql.php";

////////////////////////////////////////////////////// INSERINDO PRODUTO NO CARRINHO
if ( isset( $_POST[ 'inserircarrinho' ] ) ) {
  $idproduto = $_POST[ 'idproduto' ];
  $session = $_POST[ 'session' ];
  $nomeproduto = $_POST[ 'nomeproduto' ];
  $valorproduto = $_POST[ 'valorproduto' ];
	$tipoproduto = $_POST['tipoproduto'];	

  $inserircarrinho = mysqli_query( $link, "INSERT INTO `carrinho`(`idcarrinho`, `produto_idproduto`, `produto`,`tipo`,`valor`,`qtdproduto`, `pedido`, `status`) VALUES ('','$idproduto','$nomeproduto','$tipoproduto','$valorproduto','1','$session','1')" )or die( "Erro ao Inserir Carrinho" );

  if ( $inserircarrinho ) {
    $retornocarrinho[ 'status' ] = 'success';
    $retornocarrinho[ 'produto' ] = $nomeproduto;

  } else {
    $retornocarrinho[ 'status' ] = 'error';
  }
  echo json_encode( $retornocarrinho );
}
//////////////////////////////////////////////////// INSERIRNDO FRETE NO CARRINHO
if ( isset( $_POST[ 'inserirfrete' ] ) ) {
  $idcliente = $_POST[ 'idcliente' ];
  $session = session_id();

  $consultacliente = mysqli_query( $link, "SELECT * FROM `cliente` WHERE idcliente = '$idcliente'" )or die( "ERRO AO BUSCAR FRETE CLIENTE" );
  while ( $linhacliente = mysqli_fetch_array( $consultacliente ) ) {
  $nomecliente=$linhacliente['nomecliente'];	  
	
	 $consultacupom=mysqli_query($link,"SELECT * FROM cupom WHERE cliente_idcliente= '$idcliente' AND status = '0'");
	 if(mysqli_num_rows($consultacupom)>0)
	 { 
	 $retorno['cupom']='1';
	 $lc=mysqli_fetch_assoc($consultacupom);
	  $cupom=$lc['cupom'];
	  $valor=$lc['valor'];
	  $status=$lc['status'];
	if ( $status == '0' ) {
                      $icon = 'Disponivel';
                    } else if ( $status == '1' ) {
                      $icon = 'Ultilizado';
                    } else if ( $status == '2' ) {
                      $icon = 'Vencido';
                    }	 
     $resposta='<div class="card shadow mb-4 border-3"> 
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                <h6 class="m-0 font-weight-bold text-white">Cupom</h6>
              </div><div class="table-responsive">
                  <table class="table table-bordered" id="tabelavendas" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Valor</th>
						<th align="center">Status</th>
                      </tr>
                    </thead>
                    <tbody>
					<tr align="center">
                        <td  align="center">RS '.$valor.'</td>
						 <td  align="center">'.$icon.'</td>
                      </tr></tbody>
                  </table>
                </div>
				</div>';		 
	 $retorno['resposta']=$resposta;
	 $retorno['codigo']=$cupom;
	 $retorno['cliente']=$nomecliente;	 
	 }
	 else
	 {
	$retorno['cupom']='0';
    $retorno['cliente']=$nomecliente;		 
	 }

    $bairro = $linhacliente[ 'bairro' ];
    $fretecliente = mysqli_query( $link, "SELECT * FROM `produto` WHERE tipo='3' AND idproduto = '$bairro'" )or die( "ERRO AO BUSCAR FRETE CLIENTE" );
    while ( $linhafretecliente = mysqli_fetch_array( $fretecliente ) ) {

      $bairrofrete = $linhafretecliente[ 'produto' ];
      $valor = $linhafretecliente[ 'valor' ];
      $idfrete = $linhafretecliente[ 'idproduto' ];
      $valor = $linhafretecliente[ 'valor' ];
		$tipoproduto = $linhafretecliente[ 'tipo' ];


      $inserircarrinho = mysqli_query( $link, "INSERT INTO `carrinho`(`idcarrinho`, `produto_idproduto`, `produto`, `tipo`, `valor`,`qtdproduto`, `pedido`, `status`) VALUES ('','$idfrete','$bairrofrete','$tipoproduto','$valor','1','$session','1')" )or die( "Erro ao Inserir Carrinho" );


    }
  }
	echo json_encode( $retorno );	
}
////////////////////////////////////////////////////// ESVAZIA CARRINHO
if ( isset( $_POST[ 'esvaziacarrinho' ] ) ) {
  $session = session_id();
  $delcarrinho = mysqli_query( $link, "DELETE FROM `carrinho` WHERE pedido = '$session'" )or die( "ERRO AO esvaziar Carrinho $session" );

  if ( $delcarrinho ) {
    $retorno[ 'status' ] = 'success';
    echo json_encode( $retorno );
  }

}

