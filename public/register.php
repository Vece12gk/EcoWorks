<?php
include('php/db.php'); // conexão com o banco
session_start();

$erro = '';
$sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega e valida os dados do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($nome === '' || $email === '' || $senha === '') {
        $erro = "Por favor, preencha todos os campos!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido!";
    } else {
        // Verifica se o e-mail já existe (prepared statement)
        if ($check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?")) {
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $erro = "Este e-mail já está cadastrado!";
                $check->close();
            } else {
                $check->close();

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                if ($stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, pontos) VALUES (?, ?, ?, 0)")) {
                    $stmt->bind_param("sss", $nome, $email, $senhaHash);
                    if ($stmt->execute()) {
                        // Cadastro OK — redireciona para login imediatamente
                        $stmt->close();
                        $conn->close();
                        header("Location: login.php");
                        exit;
                    } else {
                        $erro = "Erro ao cadastrar: " . $stmt->error;
                        $stmt->close();
                    }
                } else {
                    $erro = "Erro na preparação da query: " . $conn->error;
                }
            }
        } else {
            $erro = "Erro na preparação da verificação: " . $conn->error;
        }
    }

    // Fecha conexão se ainda aberta
    if ($conn) $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - EcoTarefas</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container-form">
        <h1>Cadastre-se no EcoTarefas 🌱</h1>

        <?php if ($erro) echo "<p class='erro'>$erro</p>"; ?>
        <?php if ($sucesso) echo "<p class='sucesso'>$sucesso</p>"; ?>

        <form method="POST" action="">
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit" class="botao">Cadastrar</button>
        </form>

        <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </div>
</body>
</html>
