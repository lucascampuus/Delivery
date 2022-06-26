<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( isset( $_POST[ 'inserircompra' ] ) ) {
  $material = $_POST[ 'material' ];
  $valorcompra = $_POST[ 'valorcompra' ];
  $undpeso = $_POST[ 'undpeso' ];
  $valorundpeso = $_POST[ 'valorundpeso' ];
$fornecedor = $_POST['fornecedor'];	
  $datacompra = $_POST[ 'datacompra' ];
  $data = explode( "/", $datacompra );
  $dia = $data[ 0 ];
  $mes = $data[ 1 ];
  $ano = $data[ 2 ];
  $data = $ano;
  $data .= '-';
  $data .= $mes;
  $data .= '-';
  $data .= $dia;
$cmat=mysqli_query($link,"SELECT * FROM material WHERE idmaterial = '$material'")or die("ERRO AO BUSCAR MATERIAL");
while($lmat=mysqli_fetch_array($cmat)){
$nomematerial=$lmat['material'];
$tipomaterial=$lmat['tipomaterial'];
}
	

  $insCompra = mysqli_query( $link, "INSERT INTO `compras`(`idcompra`, `material_idmaterial`, `compra`, `tipo`, `fornecedor`, `valor`, `und_peso`, `valor_und_peso`, `data`) VALUES ('','$material','$nomematerial','$tipomaterial','$fornecedor','$valorcompra','$undpeso','$valorundpeso','$data')" )or die( "Erro cadastro Compra" );

  if ( $insCompra ) {
    $retorno[ 'status' ] = 'success';
  } else {
    $retorno[ 'status' ] = 'error';
  }
	
$cvalor=mysqli_query($link,"SELECT SUM(valor) AS tvalor FROM compras WHERE material_idmaterial = '$material'");
$cundpeso=mysqli_query($link,"SELECT SUM(und_peso) AS tpeso FROM compras WHERE material_idmaterial = '$material'");

$linhapeso=mysqli_fetch_assoc($cundpeso);
$qtdtotal=$linhapeso['tpeso'];
$linhavalor= mysqli_fetch_assoc($cvalor);	
$valortotal=$linhavalor['tvalor'];	
	
	
	
if($qtdtotal != null && $valortotal != null)
{
$valormedio= number_format($valortotal / $qtdtotal,2);	
$atualizar=mysqli_query($link,"UPDATE material SET valormedio = '$valormedio' WHERE idmaterial ='$material'");
}
	
  echo json_encode( $retorno );
}