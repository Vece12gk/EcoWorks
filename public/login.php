<?php
include("php/db.php");
session_start();

$error = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';

  // usando prepared statement para evitar SQL Injection
  if ($stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?")) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
      $user = $result->fetch_assoc();
      if (password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
      } else {
        $error = "Senha incorreta!";
      }
    } else {
      $error = "Usuário não encontrado!";
    }
    $stmt->close();
  } else {
    $error = "Erro no banco: " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - EcoTarefas</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <header><h1>Entrar no EcoTarefas</h1></header>

  <form method="POST" class="formulario" novalidate>
    <?php if (!empty($error)): ?>
      <div class="error-msg"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit" class="botao">Entrar</button>

    <div class="help-row">
      Não tem uma conta?
      <a class="register-link" href="register.php">Cadastre-se aqui</a>
    </div>
  </form>
</body>
</html>
