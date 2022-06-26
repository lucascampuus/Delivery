<?php
session_start();
include "../connect/conexaomysql.php";
if ( $_POST[ 'addcusto' ] == '1') {
  $material = $_POST[ 'material' ];
  $qtdmaterial = $_POST[ 'qtdmaterial' ];
  $customaterial = $_POST[ 'customaterial' ];  
  $tipomaterial = $_POST[ 'tipomaterial' ];
 $nomecusto = $_POST[ 'nomecusto' ];	
  if($tipomaterial == 'peso')
  {
	  $qtdmaterial = $qtdmaterial * 1000;
  }

  
  $inserircusto = mysqli_query( $link, "INSERT INTO `custoproduto`(`idcusto`, `custo`,`material_idmaterial`, `qtdmaterial`, `valorcusto`, `desc`, `status`) VALUES ('','$nomecusto','$material','$qtdmaterial','$customaterial','$tipomaterial','1')" )or die( "Erro ao Cadastrar custo" );

  if ( $inserircusto ) {
    $retorno[ 'status' ] = 'success';
  } else {
    $retorno[ 'status' ] = 'error';
  }
	echo json_encode( $retorno );

}

else if($_POST['alterarstatus'] == 1)
{
$status = $_POST['status'];
$idcusto = $_POST['idcusto'];
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
$alterarstatus = mysqli_query($link,"UPDATE custoproduto SET status = '$status' WHERE idcusto = '$idcusto'");
	
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	
}

else if($_POST['consultamaterial'] == 1)
{
$idmaterial = $_POST['idmaterial'];
$consultamaterial = mysqli_query($link,"SELECT * FROM material WHERE idmaterial = '$idmaterial'");
$linhamaterial=mysqli_fetch_array($consultamaterial);
$valormedio=$linhamaterial['valormedio'];
$desc=$linhamaterial['desc'];	
$retorno['valormedio']=$valormedio;
$retorno['desc']=$desc;	
$retorno['status'] = 'success';	
echo json_encode( $retorno );	
}




