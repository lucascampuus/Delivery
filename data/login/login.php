<?php
session_start();
include "../connect/conexaomysql.php";
date_default_timezone_set( "Brazil/East" );
if ( $_POST[ 'login' ] == '1'  ) {
$pswd=$_POST['pswd'];	
$consultalogin = mysqli_query( $link, "SELECT * FROM user WHERE pswd = '$pswd'");
if(mysqli_num_rows($consultalogin)>0)
{
while($luser=mysqli_fetch_array($consultalogin))
{
$user=$luser['user'];
$iduser=$luser['iduser'];	
$alterarlogin = mysqli_query( $link, "UPDATE user SET status = '1' WHERE iduser = '$iduser'");
}
$retorno['user']=$iduser;
$retorno['status']='success';
}
else
{
$retorno['status']='error';	
}
}
if($_POST['logout'] == '1')
{
$pswd=$_POST['pswd'];
$alterarlogin = mysqli_query( $link, "UPDATE user SET status = '0' WHERE status = '1'");	
$retorno['status']=	'success';
}
if($_POST['logon'] == '1')
{
$pswd=$_POST['pswd'];
$conslutalogin = mysqli_query( $link, "SELECT * FROM user WHERE status = '1'");	
if(mysqli_num_rows($conslutalogin)>0)
{
$retorno['status']=	'success';
}
else
{
$retorno['status']='error';	
}
}
echo json_encode( $retorno );
?>
