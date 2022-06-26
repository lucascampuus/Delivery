<?php
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( $_POST[ 'editarprodutos' ] = '1' ) {
	
$idproduto=$_POST['idproduto'];
$nome_produto=$_POST['nome_produto'];
$tipo_produto=$_POST['tipo_produto'];
$valor_produto=$_POST['valor_produto'];
$nomecusto=$_POST['nomecusto'];
$updproduto=mysqli_query($link,"UPDATE produto SET produto = '$nome_produto', tipo = '$tipo_produto', valor = '$valor_produto', custoproduto = '$nomecusto' WHERE idproduto = '$idproduto'")or die("Erro ao alterar produto");
$retorno['status']='success';
$retorno['produto']=$nome_produto;
	
}
echo json_encode( $retorno );
?>