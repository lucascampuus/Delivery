<?php
session_start();
include "../connect/conexaomysql.php";
if ( isset( $_POST[ 'cancelarpedido' ] ) ) {
$pedido=$_POST['pedido'];	
$alterarapedido=mysqli_query($link,"UPDATE pedido SET status = '1' WHERE pedido = '$pedido'");
$alterarcarrinho=mysqli_query($link,"UPDATE carrinho SET status = '0' WHERE pedido = '$pedido'");

if($alterarapedido){
$retorno['status']='success';
$retorno['pedido']=$pedido;
}
}
echo json_encode( $retorno );

?>

