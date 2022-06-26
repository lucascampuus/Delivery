<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( isset( $_POST[ 'inserircupom' ] ) ) {
$cupom=$_POST['cupomid'];
$valor=$_POST['valorcupom'];
$cliente=$_POST['clientecupom'];
$validade=explode("/",$_POST['validadecupom']);
$validade=$validade[2].'-'.$validade[1].'-'.$validade[0];	
	
$inserircarrinho = mysqli_query( $link, "INSERT INTO `cupom`(`idcupom`, `cupom`, `cliente_idcliente`, `pedido`, `valor`, `validade`, `status`) VALUES ('','$cupom','$cliente','','$valor','$validade','0')" )or die( "Erro ao Inserir cupom" );

$retorno['status']='success';
$retorno['cupom']=$cupom;
echo json_encode( $retorno );
}
?>

