<?php
    ///// FUNÇÃO PARA CONECTAR COM O BANCO DE DADOS 
    function ConexaoBanco(){
        $conexao = mysql_connect('localhost', 'root', 'bcd127');
        mysql_select_db('dbcontatos');
    }
?>