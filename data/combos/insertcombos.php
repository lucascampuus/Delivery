<?php
session_start();
include "../connect/conexaomysql.php";
if ( $_POST[ 'addcombo' ] == '1') {
  $nomebatata = $_POST[ 'nomebatata' ];
	$nomecombo = $_POST[ 'nomecombo' ];
  $valorcombo = $_POST[ 'valorcombo' ];
  $valorbatata = $_POST[ 'valorbatata' ];
$dia=$_POST['dia'];	
  
  $inserircombo = mysqli_query( $link, "INSERT INTO `combo`(`idcombo`, `combo`, `dia`, `valor`, `valorbatata`, `batatas`, `status`) VALUES ('','$nomecombo','$dia','$valorcombo','$valorbatata','$nomebatata','1')")or die( "Erro ao Cadastrar combo" );

  if ( $inserircombo ) {
    $retorno[ 'status' ] = 'success';
	$retorno['combo']   = $nomecombo;
  } else {
    $retorno[ 'status' ] = 'error';
  }
	echo json_encode( $retorno );

}

else if($_POST['alterarstatus'] == 1)
{
$status = $_POST['status'];
$idcombo = $_POST['idcombo'];
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
if($status == 'excluir')
{
$delcombo=mysqli_query($link,"DELETE FROM combo WHERE idcombo='$idcombo'");
$resposta= 'Excluido';	
}
$alterarstatus = mysqli_query($link,"UPDATE combo SET status = '$status' WHERE idcombo = '$idcombo'");
	
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	
}




