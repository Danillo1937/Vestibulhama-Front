<?php
$s = "localhost";
$u = "root";
$p = "";
$bd = "tcc";   //Colocar aqui o nome do seu B.D.

//Conexão com o B.D.
$conexao = mysqli_connect($s, $u, $p, $bd);

//Mensagem de erro
if(!$conexao){
    die("Falha na conexão.");
}



?>