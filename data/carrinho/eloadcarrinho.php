<?php
session_start();
include "../connect/conexaomysql.php";

/////////////////////////////////////////////////////////// CONSULTA CARRINHO
if ( $_POST[ 'carregarcarrinho' ] = 'sim' ) {
  $session = $_POST['pedido'];
  $consultapedido=mysqli_query($link,"SELECT * FROM pedido WHERE pedido = '$session'");
  while($lconsultapedido=mysqli_fetch_array($consultapedido)){
	$plataformapedido=$lconsultapedido['plataforma'];
	$metodopagamentopedido=$lconsultapedido['metodopagamento']; 
	$obs=$lconsultapedido['obs']; 
	$cliente_idcliente=$lconsultapedido['cliente_idcliente']; 
  }
 $consultanomecliente=mysqli_query($link,"SELECT * FROM cliente WHERE idcliente = '$cliente_idcliente' ")or die($cliente_idcliente);
 while($cconsultanomecliente=mysqli_fetch_array($consultanomecliente))
 {
	 $nomecliente=$cconsultanomecliente['nomecliente'];
 }
  $consultaentregadorpedido=mysqli_query($link,"SELECT * FROM entrega WHERE pedido = '$session'");
  if(mysqli_num_rows($consultaentregadorpedido)>0){	
  while($lconsultaentregadorpedido=mysqli_fetch_array($consultaentregadorpedido)){
   $entregadorpedido=$lconsultaentregadorpedido['entregador_identregador'];		  
  }
  }
  else
  {
   $entregadorpedido= 'Batattos';	  
  }
  //error_reporting(0);

  $valortotal = 0;
  $idprodutoalterar = $_POST[ 'idcarrinho' ];
  $deletarproduto = $_POST[ 'idcarrinho' ];

  if ( $_POST[ 'delprodutocarrinho' ] == '1' ) {


    $delcarrinho = mysqli_query( $link, "DELETE FROM `carrinho` WHERE pedido = '$session' AND idcarrinho = '$idprodutoalterar'" )or die( "ERRO AO DELETAR PRODUTO CARRINHO" );
    $retorno[ 'delproduto' ] = $idprodutoalterar;
  }

  if ( $_POST[ 'editprodutocarrinho' ] == '1' ) {
    $valorupg = number_format($_POST[ 'valorupg' ],2);
    $alterarcarrinho = mysqli_query( $link, "UPDATE `carrinho` SET `valor`= '$valorupg' WHERE pedido = '$session' AND idcarrinho = '$idprodutoalterar'" )or die( "ERRO ALTERAR CARRINHO" );
    $retorno[ 'editproduto' ] = "CHEGOU QUI";
  }

  if ( $_POST[ 'combopromocional' ] == '1' ) {

    $idcomboselect = $_POST[ 'idcombo' ];
    $CONSULTA_COMBO = mysqli_query( $link, "SELECT * FROM combo WHERE idcombo = '$idcomboselect'" )or die( "erro a consultar combo" );
    while ( $LINHACOMBO = mysqli_fetch_array( $CONSULTA_COMBO ) ) {
	$NCOMBO = $LINHACOMBO['combo'];
      $VALOR = $LINHACOMBO[ 'valor' ];
      $BATATAS = explode("/",$LINHACOMBO[ 'batatas' ]);
      $VALOR_BATATA = $LINHACOMBO[ 'valorbatata' ];
		$c=0;
		foreach($BATATAS as $Y){$c++;}
    }
    for ( $i = 0; $i < $c; $i++ ) {
      
      $altvalorfritas = mysqli_query( $link, "UPDATE `carrinho` SET `valor`= '$VALOR_BATATA' WHERE pedido = '$session' AND produto_idproduto = '$BATATAS[$i]' " )or die( "ERRO AO ALTERAR BATATAS" );

    }
	$retorno['combo'] = $NCOMBO;  
  }


  $resposta = '<div class="table-responsive">
                        <table class="table table-bordered" id="tabelabatatas" width="100%" cellspacing="0">
                          <thead>
                            <tr align="center">
							<th align="center">Tipo</th>
								<th align="center">Produto</th>
                              <th align="center">Valor</th>
                              <th align="center">Excluir</th>
                            </tr>
                          </thead>
                          <tbody>';
  $carrinho = mysqli_query( $link, "SELECT * FROM `carrinho` WHERE pedido = '$session' ORDER BY idcarrinho DESC" )or die( "ERRO AO BUSCAR Carrinho" );
  if ( mysqli_num_rows( $carrinho ) > 0 ) {
    while ( $linhacarrinho = mysqli_fetch_array( $carrinho ) ) {
      $valorbairro = '0';
	  $idcarrinho=$linhacarrinho['idcarrinho'];
      $produto_idproduto = $linhacarrinho[ 'produto_idproduto' ];
      $nomeproduto = $linhacarrinho[ 'produto' ];
      $valor = $linhacarrinho[ 'valor' ];
      $tipoproduto = $linhacarrinho[ 'tipo' ];
      $delproduto = '1';
	  
      $valortotal = number_format($valor + $valortotal,2);
	  if($tipoproduto == '0'){$tipoproduto="Batata Recheada";}
	if($tipoproduto == '1'){$tipoproduto="Adicional";}
	if($tipoproduto == '2'){$tipoproduto="Porção";}
	if($tipoproduto == '3'){$tipoproduto="Tele-Entrega";}
	if($tipoproduto == '4'){$tipoproduto="Bebida";}
	if($tipoproduto == '6'){$tipoproduto="Cupom";}
	if($tipoproduto == '7'){$tipoproduto="Alaminuta";}
	if($tipoproduto == '8'){$tipoproduto="Massa";}
	if($tipoproduto == '9'){$tipoproduto= "Alaminuta Simples";}		

      $resposta .= "<tr align='center'><td align='center'>$tipoproduto</td><td align='center'>$nomeproduto</td><td align='center'><input class='form-control text-center' id='valorupg$idcarrinho' value='$valor' onkeyup='substituiPonto(this)' onChange='editproduto($idcarrinho,\"$session\")'/><td><a href='#' onClick='delproduto($idcarrinho,\"$session\");'><i class='fa fa-trash fa-fw'></i></a></td></tr>";  
	}

    $resposta .= "
  </tbody></table></div>&nbsp;<input class='form-control text-center' id='obs' value='$obs'/>&nbsp;";
    $frete = mysqli_query( $link, "SELECT * FROM `carrinho` WHERE pedido = '$session' AND tipo ='3'" )or die( "ERRO AO BUSCAR FRETE NO CARRINHO" );
    while ( $linhafrete = mysqli_fetch_array( $frete ) ) {
      $valorbairro = $linhafrete[ 'valor' ];
    }
    $consultacombos = mysqli_query( $link, "SELECT * FROM combo WHERE status = '1' order by idcombo ASC" )or die( "erro ao consultar combos" );
    while ( $linhacombos = mysqli_fetch_array( $consultacombos ) ) {

      $nomecombo = $linhacombos[ 'combo' ];

      $idcombo = $linhacombos[ 'idcombo' ];
      $valorcombo = number_format($linhacombos[ 'valor' ],2);
      $valorpedido = $valorcombo + $valorbairro;

      $resposta.= "<div class='checkbox'>
              
                <input type='checkbox' id='combopromocional$idcombo' name='1' onclick='myfunction(this);' value='$idcombo'>
				<input type='hidden' id='combopromocional'>$nomecombo ( <B>R$$valorcombo</B> )</div>&nbsp;";
    }
    $resposta.= "	  	<select class='form-control' aria-label='Default select example' id='plataforma' onChange='buttonvalid()'>
						<option value='Não Selecionado'>Selecione a Plataforma</option>";
						$cplataformas = mysqli_query( $link, "SELECT * FROM `plataforma` WHERE status = '1'" )or die( "ERRO AO BUSCAR PLATAFORMA" );
                      	while ( $linhaplataforma = mysqli_fetch_array( $cplataformas ) ) {
							
                        $idplataforma = $linhaplataforma[ 'idplataforma' ];
                        $nomeplataforma = $linhaplataforma[ 'plataforma' ];
						if($idplataforma==$plataformapedido)
						{
	$resposta.= "<option value='$idplataforma' selected>$nomeplataforma</option>";				
						}
						else
						{
    $resposta.= "<option value='$idplataforma'>$nomeplataforma</option>";
						}
						}
	$resposta.="		</select>
						&nbsp;&nbsp;
						<select class='form-control' aria-label='Default select example' id='metodopagamento' onChange='buttonvalid()'>
						<option value='Não Selecionado' selected>Selecione o Metodo Pagamento</option>"; 
	                    $cmetodo = mysqli_query( $link, "SELECT * FROM `pagamento` WHERE status = '1'" )or die( "ERRO AO BUSCAR PAGAMENTO" );
                      	while ( $linhapagamento = mysqli_fetch_array( $cmetodo ) ) {
                        $idpagamento = $linhapagamento[ 'idpagamento' ];
                        $nomepagamento = $linhapagamento[ 'nomepagamento' ];
						if($idpagamento==$metodopagamentopedido)
						{
					$resposta.="<option value='$idpagamento' selected>$nomepagamento</option>";
						}
						else
						{
    $resposta.="<option value='$idpagamento'>$nomepagamento</option>";
						}
						}
	$resposta.="</select>
						&nbsp;&nbsp;
						<select class='form-control' aria-label='Default select example' id='entregador' onChange='buttonvalid()'>
						<option value='Não Selecionado' selected>Selecione o Entregador</option>";
    $consultamotoboy = mysqli_query( $link, "SELECT * FROM entregador WHERE status = '1'" );
    while ( $lmotoboy = mysqli_fetch_array( $consultamotoboy ) ) {
      $identregador = $lmotoboy[ 'identregador' ];
      $nomeentregador = $lmotoboy[ 'nomeentregador' ];
	  if($identregador==$entregadorpedido)
	  {
	   $resposta .= "<option value='$identregador' selected>$nomeentregador</option>";
	  }
	  else
	  {
      $resposta .= "<option value='$identregador'>$nomeentregador</option>";
	  }
    }
    $resposta .= "	</select><br>
						  <input type='hidden'id='valorentrega' value='$valorbairro'/>						  
						   <h6 class='m-0 font-weight-bold text-center text-primary alig'>Valor Total</h6>
						  <B><input class='form-control text-center' id='valornovo' value='$valortotal'/><B>						
						  		  
						  ";
  }
  
  $retorno[ 'status' ] = 'success';
  $retorno[ 'resposta' ] = $resposta;
  $retorno[ 'valor' ] = $valortotal;
  $retorno[ 'pedido' ] = $session;
  $retorno[ 'cliente' ] = $cliente_idcliente;
  $retorno['nomecliente'] = $nomecliente;
 
  //session_regenerate_id();
  echo json_encode( $retorno );

}
ob_end_flush();
?>
