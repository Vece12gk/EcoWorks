<?php
include("php/db.php");
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
$id = $_SESSION['user_id'];

include("../private/missoes.php");

$sql = "SELECT nome, pontos FROM usuarios WHERE id='$id'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = ['nome' => 'Usuário', 'pontos' => 0];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel - EcoTarefas</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <script defer>
    // Função JavaScript para concluir a missão
    function completarMissao(id) {
      const missao = document.getElementById('missao-' + id);
      missao.style.transition = 'opacity 0.4s';
      missao.style.opacity = '0';

      setTimeout(() => {
        missao.remove();
        alert('🎉 Missão concluída! Você ganhou pontos!');
      }, 400);

      // Envia requisição AJAX para atualizar no banco
      fetch('../private/concluir_missao.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
      })
      .then(response => response.text())
      .then(data => {
        if (data.trim() === 'ok') {
          missao.style.transition = 'opacity 0.4s';
          missao.style.opacity = '0';
          setTimeout(() => {
            missao.remove();
            alert('🎉 Missão concluída! Você ganhou pontos!');
          }, 400);
        } else {
          alert('Erro ao concluir missão!');
        }
      });
    }
  </script>
</head>

<body>
  <!-- Navbar -->
  <nav>
  <div class="logo">🌿 EcoTarefas</div>
  <ul>
    <li><a href="index.php">Início</a></li>
    <li><a href="dashboard.php">Missões</a></li>
    <li><a href="ranking.php">Ranking</a></li>
    <li><a href="profile.php">Perfil</a></li>
    <li><a href="php/logout.php">Logout</a></li>
  </ul>
</nav>

  <header>
    <h1>Bem-vindo, <?php echo $user['nome']; ?>!</h1>
    <p>Seus pontos: <strong><?php echo $user['pontos']; ?></strong></p>
  </header>

  <section class="missoes-container">
    <h2>🌱 Missões do dia</h2>
    <div class="content-wrapper">
    <main class="main-content">
      <!-- Mensagens / missões centralizadas -->
      <?php if ($missoes && $missoes->num_rows > 0) { ?>
          <?php while ($m = $missoes->fetch_assoc()) { ?>
            <div class="missao" id="missao-<?php echo $m['missoes_id']; ?>">
              <p><?php echo htmlspecialchars($m['descricao']); ?></p>
              <button class="botao" onclick="completarMissao(<?php echo $m['missoes_id']; ?>)">Concluir missão</button>
            </div>
          <?php } ?>
      <?php } else { ?>
        <p class="todas-concluidas">🎉 Todas as missões de hoje foram concluídas! Parabéns!</p>
      <?php } ?>
    </main>

    <aside class="right">
      <div class="aside-inner">
        
        
        <h4> Dicas para Aproveitar ao Máximo:</h4>
        <ul>
          <li>1. Entre todos os dias</li>
          <li>2. Complete e registre suas missões</li>
          <li>3. Acompanhe seu progresso</li>
          <li>4. Inspire outras pessoas</li>
          <li>5. Colecione selos e suba de nível</li>
          <li>6. Volte sempre!</li>
          <li>No EcoTarefas, o seu compromisso com o meio ambiente é reconhecido, recompensado e compartilhado.</li>
          <li>Cada clique, cada missão, cada ponto... é uma semente plantada em prol de um mundo mais verde e consciente.</li>
          <li>“Pequenas ações, quando somadas, transformam o mundo.”</li>
        </ul>
      </div>
    </aside>
  </div>

    <?php if ($missoes && $missoes->num_rows > 0) { ?>
    <?php while ($m = $missoes->fetch_assoc()) { ?>
      <div class="missao" id="missao-<?php echo $m['missoes_id']; ?>">
        <p><?php echo $m['descricao']; ?></p>
        <button class="botao" onclick="completarMissao(<?php echo $m['missoes_id']; ?>)">Concluir missão</button>
      </div>
    <?php } ?>
  <?php } else { ?>
    <p>🎉 Todas as missões de hoje foram concluídas! Parabéns!</p>
  <?php } ?>
  </section>
  <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>🌎 Sobre o EcoTarefas</h4>
                <p>Somos uma plataforma de gamificação que transforma o cuidado com o meio ambiente em uma experiência divertida e recompensadora. Junte-se a nós!</p>
            </div>
            
            <div class="footer-section">
                <h4>🔗 Links Rápidos</h4>
                <ul>
                    <li><a href="dashboard.php">Missões</a></li>
                    <li><a href="ranking.php">Ranking</a></li>
                    <li><a href="profile.php">Meu Perfil</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>📞 Contato</h4>
                <p>Email: contato@ecotarefas.com</p>
                <p>Siga-nos: <a href="https://www.instagram.com/pauloh_1808/">pauloh_1808</a> | <a href="https://www.instagram.com/natanvece/">natanvece</a></p>
                <p>Localização: São Paulo, Brasil</p>
            </div>
            
            <div class="footer-bottom">
                &copy; <?php echo date("Y"); ?> EcoTarefas. Todos os direitos reservados. | Desenvolvido com amor pelo Planeta.
            </div>
        </div>
    </footer>
</body>
</html>
