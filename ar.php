<?php
include "conexaomysql.php";
date_default_timezone_set("Brazil/East");

$consultacliente = mysqli_query($link,"SELECT * FROM `cliente` WHERE `dtultimopedido` LIKE '%/%'")or die("ERRO AQUI");
while($lcliente=mysqli_fetch_array($consultacliente))
{
$dtultimopedido=explode("/",$lcliente['dtultimopedido']);
$idcliente=$lcliente['idcliente'];
$dia=$dtultimopedido[0];
$mes=$dtultimopedido[1];
$ano=$dtultimopedido[2];
$dtultimopedido=$ano.'-'.$mes.'-'.$dia;
$alteracliente=mysqli_query($link,"UPDATE `cliente` SET `dtultimopedido` = '$dtultimopedido' WHERE `cliente`.`idcliente` = '$idcliente'")or die("ERRO AQUI2");
echo "UPDATE `cliente` SET `dtultimopedido` = '$dtultimopedido' WHERE `cliente`.`idcliente` = '$idcliente'";
echo "<BR>";



	
}
	
?>