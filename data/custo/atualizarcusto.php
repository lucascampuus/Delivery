<?php
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( $_POST[ 'atualizarcusto' ] == 1 ) {
  $consultavalormedio = mysqli_query( $link, "SELECT * FROM material" )or die( "ERRO AO CONSULTAR MATERIAL" );
  while ( $lcvm = mysqli_fetch_array( $consultavalormedio ) ) {
    $idmaterial = $lcvm[ 'idmaterial' ];
    $valormedio = $lcvm[ 'valormedio' ];
    $consultacusto = mysqli_query( $link, "SELECT * FROM custoproduto WHERE material_idmaterial = '$idmaterial'" )or die( "ERRO CONSULTAR CUSTO PRODUTO" );
	if(mysqli_num_rows($consultacusto)>0)
	{
    $lcc = mysqli_fetch_assoc( $consultacusto );
	$idcusto=$lcc['idcusto'];	
    $qtdmaterial = $lcc[ 'qtdmaterial' ];
    $desc = $lcc[ 'desc' ];
    if ( $desc == 'peso' ) {
      $valorcustoreal = ( $qtdmaterial * $valormedio ) / 1000;
    } else if ( $desc == 'und' ) {
      $valorcustoreal = $qtdmaterial * $valormedio;
    }
	$valorcustoreal= number_format($valorcustoreal,2);	
	$atualizarcusto=mysqli_query($link,"UPDATE custoproduto SET valorcusto = '$valorcustoreal' WHERE idcusto= '$idcusto'");
  }
  }
  $retorno[ 'custo' ] = $valorcustoreal;
  $retorno[ 'status' ] = 'success';
  echo json_encode( $retorno );
}
?>