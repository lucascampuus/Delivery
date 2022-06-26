<?php
//======================== CONEXÃO COM BANCO DE DADOS MYSQL ============================
$link=mysqli_connect("localhost","root","","batattos") or die ("Não foi possivel estabelecer conexão ao BD");
//mysqli_set_charset($link,"utf8_unicode_ci");
mysqli_select_db($link,"batattos") or die ("<h4>Sem acesso ao Banco de dados</h4>");
?>
