<?php
session_start();
include "../connect/conexaomysql.php";
if ( $_POST[ 'addentregador' ] == '1') {
  $nomeentregador = $_POST[ 'nomeentregador' ];


  $inserirentregador = mysqli_query( $link, "INSERT INTO `entregador`(`identregador`, `nomeentregador`, `qtdentregas`, `status`) VALUES ('','$nomeentregador','0','1')" )or die( "Erro ao Cadastrar entregador" );

  if ( $inserirentregador ) {
    $retorno[ 'status' ] = 'success';
	$retorno['entregador']   = $nomeentregador;
  } else {
    $retorno[ 'status' ] = 'error';
  }
	echo json_encode( $retorno );

}

else if($_POST['alterarstatus'] == 1)
{
$status = $_POST['status'];
$identregador = $_POST['identregador'];
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
$alterarstatus = mysqli_query($link,"UPDATE entregador SET status = '$status' WHERE identregador = '$identregador'");
	
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	
}




