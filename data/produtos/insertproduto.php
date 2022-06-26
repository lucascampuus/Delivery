<?php
session_start();
include "../connect/conexaomysql.php";
if ( $_POST[ 'addproduto' ] == '1') {
  $nome_produto = $_POST[ 'nome_produto' ];
  $tipo_produto = $_POST[ 'tipo_produto' ];
  $valor_produto = $_POST[ 'valor_produto' ];  
  $nomecusto = $_POST[ 'nomecusto' ];


  
  $inserirproduto = mysqli_query( $link, "INSERT INTO `produto`(`idproduto`, `produto`, `custoproduto`, `tipo`, `valor`, `status`) VALUES ('','$nome_produto','$nomecusto','$tipo_produto','$valor_produto','1')" )or die( "Erro ao Cadastrar produto" );

  if ( $inserirproduto ) {
    $retorno[ 'status' ] = 'success';
	$retorno[ 'produto' ] = $nome_produto;  
  } else {
    $retorno[ 'status' ] = 'error';
  }
	echo json_encode( $retorno );

}

else if($_POST['alterarstatus'] == 1)
{
$status = $_POST['status'];
$idproduto = $_POST['idproduto'];
if($status == 'Desativado')
{
	$status = 1;
	$resposta = 'Ativado';
}
if($status == 'Ativado')
{
	$status = '0';
	$resposta = 'Desativado';
}
$alterarstatus = mysqli_query($link,"UPDATE produto SET status = '$status' WHERE idproduto = '$idproduto'");
	
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	
}





