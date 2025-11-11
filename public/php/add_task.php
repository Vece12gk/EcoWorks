<?php
session_start();
include(__DIR__ . '/db.php'); // Garante o caminho correto do arquivo de conexão

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

// Verifica se foi enviada uma descrição
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['descricao'])) {
    $descricao = trim($_POST['descricao']);
    $usuario_id = $_SESSION['usuario_id'];

    // Usa prepared statements para evitar SQL Injection
    $stmt = $conn->prepare("INSERT INTO tarefas (descricao, usuario_id, data) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $descricao, $usuario_id);

    if ($stmt->execute()) {
        // Redireciona de volta ao painel após adicionar a tarefa
        header("Location: dashboard.php?msg=add_sucesso");
        exit();
    } else {
        echo "Erro ao adicionar tarefa: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Descrição da tarefa não enviada.";
}

$conn->close();
?>

