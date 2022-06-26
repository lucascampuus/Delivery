<?php
include "../connect/conexaomysql.php";
date_default_timezone_set("Brazil/East");
$datahoje = date("d/m/Y");
if($_POST['qtdfornecedor'] == 1)
{
$resposta='';	
$qtd=$_POST['qtd'];	
for($i=0;$i<$qtd;$i++)
{
	$resposta.='<div class="form-group" >
            <select class="form-control" id="qtdfornecedor'.$i.'">
              <option value="0" selected>Selecione o Fornecedor</option>';
	$consultafornecedor = mysqli_query( $link, "SELECT * FROM fornecedores WHERE status = '1'" );
    while ( $linhafornecedor = mysqli_fetch_array( $consultafornecedor ) ) {	
	$idfornecedor = $linhafornecedor[ 'idfornecedor' ];
    $nomefornecedor = $linhafornecedor[ 'fornecedor' ];		
	$resposta.=' <option value="' . $idfornecedor . '">' . $nomefornecedor . '</option>';
}
	$resposta.='  </select>
          </div>';
}
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );		
}


if($_POST['consultamaterial'] == 1)
{		
		$idmaterial=$_POST['idmaterial'];
		$resposta='<div class="form-group" >
            <select class="form-control" id="fornecedor">
              <option value="0" selected>Selecione o Fornecedor</option>';
	$cmaterial=mysqli_query($link,"SELECT * FROM material WHERE  idmaterial = '$idmaterial'")or die("sdsdf");
	$cmaterial2=mysqli_query($link,"SELECT * FROM material WHERE  idmaterial = '$idmaterial'")or die("sdsdf");
	$selectmaterial=mysqli_fetch_array($cmaterial2);
	$selectmaterial=$selectmaterial['desc'];
	if(mysqli_num_rows($cmaterial)>0)
	{
	$lcm=mysqli_fetch_assoc($cmaterial);
	$fornecedores= explode("/",$lcm['fornecedor']);
	$c=0;
	foreach($fornecedores as $y){$c++;}
	for($i=0;$i<$c;$i++)
	{
	$consultafornecedor = mysqli_query( $link, "SELECT * FROM fornecedores WHERE idfornecedor = '$fornecedores[$i]' AND status = '1'" );
    while ( $linhafornecedor = mysqli_fetch_array( $consultafornecedor ) ) {	
	$idfornecedor = $linhafornecedor[ 'idfornecedor' ];
    $nomefornecedor = $linhafornecedor[ 'fornecedor' ];		
	$resposta.=' <option value="' . $idfornecedor . '">' . $nomefornecedor . '</option>';
}
	}
	$resposta.='  </select>
          </div>';

$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	

$retorno['material']= $selectmaterial;
}
else{
	$retorno['status'] = 'error';
}	
echo json_encode( $retorno );	
}
?>