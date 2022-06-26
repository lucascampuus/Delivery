<?php
session_start();
include "../connect/conexaomysql.php";
if ( isset( $_POST[ 'inserirfornecedor' ] ) == '1') {
  $nomefornecedor = $_POST[ 'nomefornecedor' ];
  $contato = $_POST[ 'contato' ];


  $inserirfornecedor = mysqli_query( $link,"INSERT INTO `fornecedores`(`idfornecedor`, `fornecedor`, `contato`, `status`) VALUES ('','$nomefornecedor','$contato','1')" )or die( "Erro ao Cadastrar fornecedor" );

  if ( $inserirfornecedor ) {
    $retorno[ 'status' ] = 'success';
  } else {
    $retorno[ 'status' ] = 'error';
  }
  echo json_encode( $retorno );
}
