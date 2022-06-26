<?php
include "../connect/conexaomysql.php";
function delTree( $dir ) {
  $files = array_diff( scandir( $dir ), array( '.', '..' ) );
  foreach ( $files as $file ) {
    ( is_dir( "$dir/$file" ) ) ? delTree( "$dir/$file" ): unlink( "$dir/$file" );
  }
  return rmdir( $dir );
}	

date_default_timezone_set("Brazil/East");
$dataview= date("d/m/Y");
$datahoje = date("Y-m-d");
$consultabackup2=mysqli_query($link,"SELECT * FROM backup WHERE databackup != '$datahoje'") or die("Erro ao consultar Backup");
$ctdbackup = mysqli_num_rows($consultabackup2);
if(($_POST['backup'] == 1)&&($ctdbackup == '1'))
{
$consultabackup=mysqli_query($link,"SELECT * FROM backup WHERE databackup = '$datahoje'") or die("Erro ao consultar Backup");
if(mysqli_num_rows($consultabackup) == 0)	
{
$retorno['backup'] = '0';
}
}
if($_POST['fazerbackup'] == 1)
{
$ATUALIZARBACKUP=mysqli_query($link,"UPDATE backup SET databackup = '$datahoje'")or die("Erro ao atualizar backup");	
$TABELASBD=mysqli_query($link,"SHOW TABLES FROM batattos")or die("Erro ao Buscar Tabelas");
mkdir('..\\..\\backup\\'.$datahoje.'/', 0777, true);		
while($linhatabelas = mysqli_fetch_row($TABELASBD)){	
$backupFile = '..//..//htdocs//batattos//backup//'.$datahoje.'//'.$linhatabelas[0].'.sql';
$query3=mysqli_query($link,"SELECT * INTO OUTFILE '$backupFile' FROM $linhatabelas[0]")or die("Erro ao Fazer Backup");	
$path = "..\\..\\backup";
$diretorio = dir($path);	
while ( $arquivo = $diretorio->read() ) {
  if ( strtotime( $arquivo ) < strtotime( '-1 week' ) ) {
    delTree( $path . '/' . $arquivo );
  }
}
if($TABELASBD)
{	
$retorno['status'] = 'success';
$retorno['data'] = $dataview;
}
}
}

echo json_encode( $retorno );

?>