<?php
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( $_POST[ 'mostrar' ] = '1' ) {
  $idproduto = $_POST[ 'idproduto' ];
  $cproduto = mysqli_query( $link, "SELECT * FROM produto WHERE idproduto = '$idproduto'" )or die( "ERRO AQUI" );
  while ( $lproduto = mysqli_fetch_array( $cproduto ) ) {
    $produto = $lproduto[ 'produto' ];
    $valor = $lproduto[ 'valor' ];
    $tipo = $lproduto[ 'tipo' ];
  }
  $retorno['nome_produto']=$produto;
  $retorno['id_produto']=$idproduto;	
  $retorno['tipo_produto']=$tipo;
  $retorno['valor_produto']=$valor;	
  $retorno[ 'status' ] = 'success';
}
echo json_encode( $retorno );
?>