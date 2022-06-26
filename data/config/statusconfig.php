<?php
session_start();
include "../connect/conexaomysql.php";
if ( $_POST[ 'x' ]) {
$status = $_POST['status'];
$id = $_POST['id'];
$x=$_POST['x'];	
if($status == 'Desativado')
{
	$status = 1;
	$resposta = $x.' Ativado';
}
if($status == 'Ativado')
{
	$status = '0';
	$resposta = $x.' Desativado';
}
$alterarstatus = mysqli_query($link,"UPDATE $x SET status = '$status' WHERE id$x = '$id'");
	
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	


}

/*else if($_POST['x'] == 'plataforma')
{
$status = $_POST['status'];
$id = $_POST['id'];
if($status == 'Desativado')
{
	$status = 1;
	$resposta = 'Ativado';
}
if($status == 'Ativado')
{
	$status = '0';
	$resposta = 'Desativado';
}
$alterarstatus = mysqli_query($link,"UPDATE combo SET status = '$status' WHERE idcombo = '$idcombo'");
	
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	
}*/
?>




