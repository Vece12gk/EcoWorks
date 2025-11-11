<?php
include("php/db.php");
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Erro: usuário não logado.");
}

// Verifica se o ID da missão foi informado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit("Erro: missão inválida.");
}

$idUsuario = $_SESSION['user_id'];
$idMissao = (int)$_GET['id'];

// Busca os pontos da missão com prepared statement
$stmt = $conn->prepare("SELECT pontos FROM missoes WHERE id = ?");
$stmt->bind_param("i", $idMissao);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    exit("Erro: missão não encontrada.");
}

$missao = $result->fetch_assoc();
$pontos = (int)$missao['pontos'];

$stmt->close();

// Atualiza pontos do usuário
$update = $conn->prepare("UPDATE usuarios SET pontos = pontos + ? WHERE id = ?");
$update->bind_param("ii", $pontos, $idUsuario);
$update->execute();
$update->close();

// Registra no histórico
$insert = $conn->prepare("INSERT INTO historico (id_usuario, id_missao, data_conclusao) VALUES (?, ?, NOW())");
$insert->bind_param("ii", $idUsuario, $idMissao);
$insert->execute();
$insert->close();

// Resposta final
echo "Missão concluída! Você ganhou $pontos pontos 🌿";

$conn->close();
?>
