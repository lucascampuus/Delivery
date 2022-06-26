<?php
include "../connect/conexaomysql.php";
date_default_timezone_set("Brazil/East");
$datahoje = date("d/m/Y");
if($_POST['qtd'])
{
$resposta='';	
$qtd=$_POST['qtd'];	
for($i=0;$i<$qtd;$i++)
{
	$resposta.='<div class="form-group" >
            <select class="form-control" id="ecusto_idcusto'.$i.'">
              <option value="0" selected>Selecione o custo</option>';
	$consultacusto = mysqli_query( $link, "SELECT * FROM custoproduto" );
    while ( $linhacusto = mysqli_fetch_array( $consultacusto ) ) {	
	$idcusto = $linhacusto[ 'idcusto' ];
    $nomecusto = $linhacusto[ 'material_idmaterial' ];	
	$consultamaterial=mysqli_query($link,"SELECT * FROM material WHERE idmaterial = '$nomecusto' ORDER BY material");
	$lcm=mysqli_fetch_assoc($consultamaterial);
	$nomecusto=$lcm['material'];	
	$resposta.='
	
              
              
                
                <option value="' . $idcusto . '">' . $nomecusto . '</option>
              
             
          
	
	
	';
}
	$resposta.='  </select>
          </div>';
}
}
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';	
echo json_encode( $retorno );	

?>