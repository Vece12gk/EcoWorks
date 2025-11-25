<?php
include(__DIR__ . "/php/db.php");

session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$id = (int) $_SESSION['user_id'];
$userStmt = $conn->prepare("SELECT nome, pontos FROM usuarios WHERE id = ?");
$userStmt->bind_param("i", $id);
$userStmt->execute();
$userRes = $userStmt->get_result();
$user = $userRes->fetch_assoc();
$userStmt->close();

if (!$user) {
  // Usuário não encontrado (fallback)
  header("Location: logout.php");
  exit;
}

// Define o nível com base nos pontos
$pontos = (int)$user['pontos'];
if ($pontos < 100) {
  $nivel = "Verde Iniciante 🍃";
} elseif ($pontos < 300) {
  $nivel = "Protetor Ambiental 🌿";
} elseif ($pontos < 600) {
  $nivel = "Herói da Terra 🌎";
} else {
  $nivel = "Guardião do Planeta 🌳";
}

/*
  Detecta automaticamente qual tabela de histórico existe no banco
  e monta a query apropriada. Isso evita erros se o nome da tabela
  for "missoes_concluidas", "missoes_concluida" ou "historico".
*/
$tableCandidates = [
  'missoes_concluidas' => [ 'usuario_col' => 'usuario_id', 'missao_col' => 'missao_id', 'date_col' => 'data_conclusao' ],
  'missoes_concluida'  => [ 'usuario_col' => 'usuario_id', 'missao_col' => 'missao_id', 'date_col' => 'data_conclusao' ],
  'historico'          => [ 'usuario_col' => 'id_usuario',   'missao_col' => 'id_missao',   'date_col' => 'data_conclusao' ]
];

$historicoResult = false;
$foundTable = null;

foreach ($tableCandidates as $tname => $cols) {
  $escaped = $conn->real_escape_string($tname);
  $check = $conn->query("SHOW TABLES LIKE '$escaped'");
  if ($check && $check->num_rows > 0) {
    $foundTable = $tname;
    $usuario_col = $cols['usuario_col'];
    $missao_col = $cols['missao_col'];
    $date_col = $cols['date_col'];
    break;
  }
}

if ($foundTable) {
  $sql = "
     SELECT 
      COALESCE(m.descricao, 'Sem descrição disponível') AS descricao,
      um.data_mis AS data_mis
    FROM usuario_missoes um
    LEFT JOIN missoes m ON m.id = um.missoes_id
    WHERE um.usuario_id = ?
    ORDER BY um.data_mis DESC
  ";

  $stmt = $conn->prepare($sql);

  if (!$stmt) {
    // Exibe erro real, mas sem interromper o site
    echo "<div style='color:red; padding:10px;'>
            ⚠️ Erro ao preparar consulta de histórico:<br>"
            . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') . 
          "</div>";
    $historicoResult = false;
  } else {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $historicoResult = $stmt->get_result();
    $stmt->close();
  }
} else {
  echo "<div style='color:red; padding:10px;'>⚠️ Nenhuma tabela de histórico encontrada.</div>";
  $historicoResult = false;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Meu Perfil - EcoTarefas</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/profile.css">
</head>
<style>
  /* Estilo do footer */
        footer {
            background-color: #388E3C; /* Verde escuro */
            color: white;
            padding: 30px 0;
            margin-top: 40px;
            border: 2px solid #A5D6A7; /* Borda visível */
            box-shadow: 
                0 0 5px #C8E6C9,
                0 0 10px #C8E6C9,
                0 0 20px #81C784,
                0 0 40px #66BB6A;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 0 20px;
        }

        .footer-section {
            width: 30%;
            margin-bottom: 20px;
        }
        
        .footer-section h4 {
            color: #C8E6C9; /* Verde claro */
            margin-bottom: 15px;
            font-size: 1.1em;
            border-bottom: 2px solid #66BB6A;
            padding-bottom: 5px;
        }

        .footer-section p, .footer-section ul {
            font-size: 0.9em;
            line-height: 1.6;
        }
        
        .footer-section a {
            color: #E8F5E9;
            text-decoration: none;
        }
        
        .footer-section a:hover {
            text-decoration: underline;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #66BB6A;
            margin-top: 15px;
            font-size: 0.8em;
            width: 100%;
        }
</style>
<body>
  <!-- Navbar -->
  <nav>
    <div class="logo">🌿 EcoTarefas</div>
    <ul>
      <li><a href="index.php">Início</a></li>
      <li><a href="dashboard.php">Missões</a></li>
      <li><a href="ranking.php">Ranking</a></li>
      <li><a href="perfil.php">Perfil</a></li>
      <li><a href="php/logout.php">Logout</a></li>
    </ul>
  </nav>

  <header>
    <h1>Perfil de <?php echo htmlspecialchars($user['nome'], ENT_QUOTES, 'UTF-8'); ?></h1>
  </header>

  <section class="perfil">
    <div class="info">
      <h2>Pontos: <?php echo $pontos; ?></h2>
      <h3>Nível atual: <?php echo $nivel; ?></h3>
    </div>

    <div class="selos">
      <h2>🏅 Conquistas</h2>
      <div class="badges">
        <?php
        if ($pontos >= 50) echo "<div class='badge verde'>🌱 Primeiros Passos</div>";
        if ($pontos >= 200) echo "<div class='badge marrom'>🌿 Sustentável Ativo</div>";
        if ($pontos >= 400) echo "<div class='badge verde-escuro'>🌳 Herói Verde</div>";
        if ($pontos >= 700) echo "<div class='badge dourado'>🏆 Guardião Supremo</div>";
        ?>
      </div>
    </div>

    <div class="historico">
      <h2>📜 Histórico de Missões</h2>
      <ul>
        <?php
        
          if ($historicoResult && $historicoResult->num_rows > 0) {
            while ($row = $historicoResult->fetch_assoc()) {
              $desc = htmlspecialchars($row['descricao'], ENT_QUOTES, 'UTF-8');
              $data = date("d/m/Y", strtotime($row['data_mis']));
              echo "<li>$desc <span>$data</span></li>";
            }
          } else {
            echo "<p>Nenhuma missão concluída ainda.</p>";
          }

        ?>
      </ul>
    </div>
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
