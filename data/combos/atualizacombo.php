<?php
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
$data = date( 'Y-m-d' );
$diasemana_numero = date( 'w', strtotime( $data ) );
$consulta = mysqli_query( $link, "SELECT * FROM combo WHERE dia != 'todos'" );
while ( $lc = mysqli_fetch_array( $consulta ) ) {
  $idcombo = $lc[ 'idcombo' ];
  $dia = $lc[ 'dia' ];
  if ( $dia == $diasemana_numero ) {
    //$upg = mysqli_query( $link, "UPDATE combo SET status = '1' WHERE idcombo = '$idcombo'" );
  }
	else
	{
	//$upg = mysqli_query( $link, "UPDATE combo SET status = '0' WHERE idcombo = '$idcombo'" );
	}
}

?>