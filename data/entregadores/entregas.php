<?php
session_start();
include "../connect/conexaomysql.php";
if($_POST['identregador'] != 0)
{	
	date_default_timezone_set("Brazil/East");
	$entregadorselect = $_POST['identregador'];
	$statusentrega = $_POST['statusentrega'];
	$datahoje = date("Y-m-d");
	$identregador = $_POST['pagarboy'];
						if($identregador != 0)
						{
							$consultavalor = mysqli_query($link,"SELECT SUM(valor) AS total FROM `entrega` WHERE entregador_identregador = '$identregador' AND status = 'ABERTO'");
							$lconsultavalor = mysqli_fetch_assoc($consultavalor);
							$valorpagarboy 	= $lconsultavalor['total'];
							$conEnt = mysqli_query($link, "SELECT * FROM entrega WHERE status = 'ABERTO' AND entregador_identregador = '$entregadorselect'");
							$CONTADOR = mysqli_num_rows($conEnt);
							$valorundpeso= number_format($valorpagarboy / $CONTADOR,2);
							if($identregador != 1)
							{
							$adddesesa = mysqli_query($link,"INSERT INTO `compras`(`idcompra`, `material_idmaterial`, `compra`, `tipo`, `fornecedor`, `valor`, `und_peso`, `valor_und_peso`, `data`) VALUES ('','21','Tele','Motoboy','16','$valorpagarboy','$CONTADOR','$valorundpeso','$datahoje')");
							}
							$pagarboy = mysqli_query($link,"UPDATE `entrega` SET `status`= 'PAGO' WHERE entregador_identregador = '$identregador' AND status = 'ABERTO'");
							$retorno['valor'] = $valorpagarboy;
						}
	else
						{
							$retorno['valor'] = 'false';
						}

						$valortotal = '0';
						$resposta= '<div class="card-header py-3 bg-dark">
              <h6 class="m-0 font-weight-bold text-white">Motoboy</h6>
            </div>
            <div class="card-body border-left-dark"><div class="table-responsive">
                  <table class="table table-bordered" id="tabelaboy" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Entregador</th>
						<th align="center">Tele</th>
						<th align="center">Valor</th>
						<th align="center">Data</th>
						
						</tr>
						</thead>
						<tbody>';
						
						$CONSULTAENTREGAS = mysqli_query($link, "SELECT * FROM entrega WHERE status = '$statusentrega' AND entregador_identregador = '$entregadorselect'");
						$CONTADOR = mysqli_num_rows($CONSULTAENTREGAS);
						if(mysqli_num_rows($CONSULTAENTREGAS) > 0)
						{
						while($lconsultaentrega = mysqli_fetch_array($CONSULTAENTREGAS)){
							$identrega = $lconsultaentrega['identrega'];
							$entregador = $lconsultaentrega['entregador_identregador'];
							$valorentrega = $lconsultaentrega['valor'];
							$pedido = $lconsultaentrega['pedido'];
							$dataentrega = $lconsultaentrega['dataentrega'];
							$data=explode("-",$dataentrega);
					$dia=$data[2];
					$mes=$data[1];
					$ano=$data[0];
					$data=$dia;
					$data.='/';
					$data.=$mes;
					$data.='/';
					$data.=$ano;
						$CONSULTAENTREGADOR = mysqli_query($link, "SELECT * FROM entregador WHERE identregador = '$entregador'");
						
						$lconsultaentregador = mysqli_fetch_assoc($CONSULTAENTREGADOR);	
						$nomeentregador = $lconsultaentregador['nomeentregador'];
							
						$CONSULTABAIRRO = mysqli_query($link, "SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '3'");
						$lconsultabairro = mysqli_fetch_assoc($CONSULTABAIRRO);
						if(mysqli_num_rows($CONSULTABAIRRO)>0)
						{	
						$bairroentrega = $lconsultabairro['produto'];
						}
						else
						{
							$bairroentrega='RETIRADA';
						}
						$valortotal = $valortotal + $valorentrega;	
 
                      
                     $resposta.= '<tr align="center">
                        <td  align="center">'.$nomeentregador.'</td>
						  <td  align="center">'.$bairroentrega.'</td>
						  <td  align="center">R$ '.$valorentrega.'</td>
						  <td  align="center">'.$data.'</td>
                      </tr>';
						}
						
	$resposta.= '<tr align="center">
	<td colspan="4" class="card-header py-3 bg-gray-300 text-black"><strong>Número de Entregas ( '.$CONTADOR.' )    -   Valor total R$  '.$valortotal.'</strong></td>
	</tr>
	</tbody>
                  </table>
                </div>';
							
						

}
}
$retorno['qtd'] = $CONTADOR;
$retorno['resposta'] = $resposta;
$retorno['status'] = 'success';
echo json_encode($retorno);