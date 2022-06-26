<?php
session_start();
include "../connect/conexaomysql.php";
if ( isset( $_POST[ 'inserirmaterial' ] ) == '1') {
  $nomematerial = $_POST[ 'nomematerial' ];
  $tipomaterial = $_POST[ 'tipomaterial' ];
  $desc = $_POST[ 'desc' ];
  $nomefornecedor = $_POST['nomefornecedor'];
	


  $inserirmaterial = mysqli_query( $link,"INSERT INTO `material`(`idmaterial`, `fornecedor`, `material`, `tipomaterial`, `desc`, `valormedio`, `status`) VALUES ('','$nomefornecedor','$nomematerial','$tipomaterial','$desc','0','1')" )or die( "Erro ao Cadastrar fornecedor" );

  if ( $inserirmaterial ) {
    $retorno[ 'status' ] = 'success';
	$retorno['material'] = $nomematerial;  
  } else {
    $retorno[ 'status' ] = 'error';
  }
  echo json_encode( $retorno );
}
