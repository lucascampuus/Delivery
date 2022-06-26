<?php 
include "../connect/conexaomysql.php";
$CONSULTAPEDIDOS=mysqli_query($link,"SELECT * FROM pedido WHERE datapedido between '2021-07-01' and '2021-07-14'")or die("a");
$total=0;
$c=0;
while($lp=mysqli_fetch_array($CONSULTAPEDIDOS))
{
$pedido=$lp['pedido'];
$CONSULTACARRINHO=mysqli_query($link,"SELECT * FROM carrinho WHERE pedido = '$pedido' AND tipo = '3'")or die("b");
while($lc=mysqli_fetch_array($CONSULTACARRINHO))
{
$c++;	
$valorfrete=$lc['valor'];
$total=$total+$valorfrete;	
}
}
echo $c.'<BR>';
echo $total;

?>

