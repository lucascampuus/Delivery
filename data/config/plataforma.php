<?php
include "../connect/conexaomysql.php";
setlocale( LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese' );
date_default_timezone_set( 'America/Sao_Paulo' );
if ( $_POST[ 'mes' ] ) {		
  $mes = $_POST[ 'mes' ];
  $dataini=date("Y-$mes-01");
  $datafim=date("Y-$mes-t");
  $mm=1;	
  if($mes == '00')
  {
  $dataini=date("2021-04-01");
  $datafim=date("Y-m-d");
  $m=explode("-",$dataini);
  $mi=$m[1];
  $m2=explode("-",$datafim);
  $mf=$m2[1];
  $mm=($mf-$mi)+1;	     
  }
 $xpedidos=mysqli_query($link,"SELECT * FROM pedido WHERE datapedido between '$dataini' and '$datafim'");
 $cpedidos=mysqli_num_rows($xpedidos);
if($cpedidos>0)
{
		$resposta= '<div class="table-responsive">
                  <table class="table table-bordered" id="tabelaporcao" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th align="center">Plataforma</th>
                        <th align="center">Qtd Vendas</th>
                        <th align="center">Valor Vendas</th>
						<th align="center">Taxas</th>
						<th align="center">Mensalidade</th>
						<th align="center">Valor Taxas</th>  
						<th align="center">Status</th>  
                      </tr>
                    </thead>
                    <tbody>';
                      
                      $cplataformas = mysqli_query( $link, "SELECT * FROM `plataforma`" )or die( "ERRO AO BUSCAR PLATAFORMA" );
                      while ( $linhaplataforma = mysqli_fetch_array( $cplataformas ) ) {

                        $idplataforma = $linhaplataforma[ 'idplataforma' ];
                        $nomeplataforma = $linhaplataforma[ 'plataforma' ];
						$taxas = $linhaplataforma[ 'taxas' ];  
                        $status = $linhaplataforma[ 'status' ];
						$mensalidadev= $linhaplataforma[ 'mensalidade' ] * $mm;
						$mensalidade = 'R$ '.$mensalidadev;
						$x='plataforma';  
						 if ( $status == '0' ) {
                      $icon = 'Desativado';
                    } else if ( $status == '1' ) {
                      $icon = 'Ativado';
                    }
					$qtdvendasplataforma=mysqli_query($link,"SELECT * FROM pedido WHERE plataforma = '$idplataforma' AND datapedido between '$dataini' and '$datafim'");
					$qtdvendas=mysqli_num_rows($qtdvendasplataforma);	  
					$csomaplataforma=mysqli_query($link,"SELECT SUM(valorpedido) as vtotal FROM pedido WHERE plataforma = '$idplataforma' AND datapedido between '$dataini' and '$datafim'");	
					$lsp=mysqli_fetch_assoc($csomaplataforma);
					$valorplataforma= $lsp['vtotal'];					
					$taxa = 'R$ '.number_format(( ($valorplataforma * $taxas / 100)+$mensalidadev ),2);
					if($taxa == 'R$ 0.00')
					{
						$taxa= '';
					}
					if($mensalidade == 'R$ 0')
					{
						$mensalidade= '';
					}	  
					$valorplataforma= number_format($valorplataforma,2);	  
                       
                      $resposta.="<tr align='center'>
                        <td  align='center'>$nomeplataforma</td>
                        <td  align='center'>$qtdvendas</td>
						<td  align='center'>R$ $valorplataforma</td>
						<td  align='center'>$taxas %</td>
						<td  align='center'>$mensalidade</td>
						  <td  align='center'><strong>$taxa</strong></td> 
                        <td align='center'><a href='#' onclick='status($idplataforma,\"$icon\",\"$x\");'>$icon</a></td>
                      </tr>";
                      
                      }
                      
                $resposta.="</tbody></table></div>";	


    $retorno[ 'mes' ] = $mes;
    $retorno[ 'resposta' ] = $resposta;
	$retorno[ 'status' ] = 'success';
  }
	
else 
{
    $retorno[ 'status' ] = 'error';

  }

}
  echo json_encode( $retorno );

?>