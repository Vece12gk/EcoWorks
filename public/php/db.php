<?php
$host = "sql100.infinityfree.com";
$user = "if0_40392783";
$pass = "2DRgtPe92Q";
$dbname = "if0_40392783_ecotarefas";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
