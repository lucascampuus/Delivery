<?php
include "../connect/conexaomysql.php";
date_default_timezone_set("Brazil/East");
$datahoje = date("d/m/Y");
if($_POST['qtd'])
{
$resposta='';	
$qtd=$_POST['qtd'];
$tipo_produto= $_POST['tipo_produto'];	
for($i=0;$i<$qtd;$i++)
{
	$resposta.='<div class="form-group" >
            <select class="form-control" id="qtdbatata'.$i.'">
              <option value="0" selected>Selecione o Produto</option>';
	$consultaproduto = mysqli_query( $link, "SELECT * FROM produto WHERE tipo = '$tipo_produto'" );
    while ( $linhaproduto = mysqli_fetch_array( $consultaproduto ) ) {	
	$idproduto = $linhaproduto[ 'idproduto' ];
    $nomeproduto = $linhaproduto[ 'produto' ];		
	$resposta.=' <option value="' . $idproduto . '">' . $nomeproduto . '</option>';
}
	$resposta.='  </select>
          </div>';
}
}
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	

?>