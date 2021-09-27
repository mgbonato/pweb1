<?php 
$conn = mysqli_connect('localhost', 'super', '123456', 'db_show');
if(!$conn){
    echo 'Erro na conexão: '.mysqli_connect_error();
}
?>