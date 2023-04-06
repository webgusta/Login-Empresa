<?php

if(!isset($_SESSION)){
    session_start();
}
require_once 'conexao.php';

function efetuarLogin($email, $senha){ 
    $link = abreConexao();

    $query = "select * from usuarios where email = '$email' and senha = '$senha'";
    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}

?>
