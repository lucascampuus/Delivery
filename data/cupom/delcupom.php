<?php
session_start();
include "../connect/conexaomysql.php";
if ( isset( $_POST[ 'delcupom' ] ) ) {
$idcupom=$_POST['idcupom'];	
$consultacupom=mysqli_query($link,"SELECT cupom FROM cupom WHERE idcupom = '$idcupom'");
$l=mysqli_fetch_assoc($consultacupom);
$cupom=$l['cupom'];
$delcupom = mysqli_query( $link, "DELETE FROM cupom WHERE idcupom = '$idcupom'");	
}
if($delcupom){
$retorno['status']='success';
$retorno['cupom']=$cupom;
}
echo json_encode( $retorno );

?>

