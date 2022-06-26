<?php
session_start();
include "../connect/conexaomysql.php";


if ( isset( $_POST[ 'inserircupom' ] ) ) {
$session= session_id();	
$cupom=$_POST['cupom'];	
$consultacupom=mysqli_query($link,"SELECT * FROM cupom WHERE cupom= '$cupom'");
$lc=mysqli_fetch_assoc($consultacupom);
$valor=$lc['valor'];
$inserircarrinho = mysqli_query( $link, "INSERT INTO `carrinho`(`idcarrinho`, `produto_idproduto`, `produto`, `tipo`, `valor`,`qtdproduto`, `pedido`, `status`) VALUES ('','53','Cupom Desconto','6','-$valor','1','$session','1')" )or die( "Erro ao Inserir Carrinho" );

$alterarcupom=mysqli_query($link,"UPDATE cupom SET pedido = '$session', status = '1' WHERE cupom='$cupom'");		
}
$retorno['status']='success';
$retorno['cupom']=$cupom;
echo json_encode( $retorno );

?>

