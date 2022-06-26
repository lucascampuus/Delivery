<?php
session_start();
include "../connect/conexaomysql.php";
if ( isset( $_POST[ 'inserircliente' ] ) == '1') {
  $nomecliente = $_POST[ 'nomecliente' ];
  $apelido = $_POST[ 'apelido' ];
  $contato = $_POST[ 'contato' ];
  $endereco = $_POST[ 'endereco' ];
  $bairro = $_POST[ 'bairro' ];
	if($endereco == '')
	{
		$endereco = 'Não Cadastrado';
	}
	if($bairro == 0)
	{
		$bairro = 'Não Cadastrado';
	}

  $inserircliente = mysqli_query( $link, "INSERT INTO `cliente`(`idcliente`, `nomecliente`,`apelido`, `contatocliente`, `endereco`, `bairro`, `qtdpedido`,`dtultimopedido`, `status`) VALUES ('','$nomecliente','Cliente $apelido','$contato','$endereco','$bairro','0','SEM PEDIDO','1');" )or die( "Erro ao Cadastrar" );

  if ( $inserircliente ) {
    $retorno[ 'status' ] = 'success';
	$retorno['cliente'] = $apelido;
	$retorno['nomecliente'] = $nomecliente;    
	$retorno['apelido'] = 'Cliente '.$apelido;    
	$retorno['session'] = session_id();    
  } else {
    $retorno[ 'status' ] = 'error';
  }
  echo json_encode( $retorno );
}
if ( isset( $_POST[ 'editarcliente' ] ) == '1') {
$idcliente = $_POST['idcliente'];
  $nomecliente = $_POST[ 'nome' ];
  $apelido = $_POST[ 'apelido' ];
  $contato = $_POST[ 'contato' ];
  $endereco = $_POST[ 'endereco' ];
  $bairro = $_POST[ 'bairro' ];

  $alterarcliente = mysqli_query( $link, "UPDATE cliente SET nomecliente='$nomecliente',contatocliente='$contato',endereco='$endereco',bairro='$bairro' WHERE idcliente = '$idcliente';" )or die( "Erro ao editar cliente");

  if ( $alterarcliente ) {
    $retorno[ 'status' ] = 'success';
	$retorno['cliente'] = $nomecliente;
  } else {
    $retorno[ 'status' ] = 'error';
  }
  echo json_encode( $retorno );
}
