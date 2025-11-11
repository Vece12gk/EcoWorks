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
        <h3>Equipe composta por:</h3>
        <ul>
          <li>04 cuidadores, os quais são técnicos de enfermagem.</li>
        </ul>

        <h4>Os responsáveis pela equipe técnica são:</h4>
        <ul>
          <li>01 Enfermeira Padrão</li>
          <li>01 Assistente Social</li>
          <li>01 Cozinheira</li>
          <li>01 Cuidador apoio aos finais de semana</li>
          <li>01 Apoio cuidador(a) das 13 as 20.30</li>
          <li>01 Auxiliar geral</li>
          <li>Quartos coletivos masculinos e femininos</li>
          <li>Banheiro masculino e banheiro feminino</li>
          <li>Área externa coberta / descoberta</li>
          <li>06 refeições diárias</li>
          <li>Visitas diárias das 13:30 as 17:30h</li>
          <li>Atendimento Humanizado e familiar.</li>
        </ul>

        <p>Para entretenimento. <a href="mariogame.htm">Clique aqui para jogar.</a></p>
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
</body>
</html>
