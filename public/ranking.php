<?php
include("php/db.php");
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$result = $conn->query("SELECT nome, pontos FROM usuarios ORDER BY pontos DESC LIMIT 20");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>🏆 Ranking - EcoTarefas</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to bottom, #d8f3dc, #b7e4c7);
      margin: 0;
      min-height: 100vh;
    }

    /* Navbar */
    nav {
      width: 100vw; /* cobre 100% da viewport horizontal */
      background-color: #2d6a4f;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 30px;
      color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      position: relative;
      left: 0;
      top: 0;
    }

    nav .logo {
      font-size: 1.5em;
      font-weight: bold;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
      margin: 0;
      padding: 0;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    nav ul li a:hover {
      color: #95d5b2;
    }

    header {
      text-align: center;
      padding: 40px 10px 10px;
      color: #1b4332;
    }

    header h1 {
      font-size: 2em;
      margin-bottom: 15px;
    }

    /* Tabela */
    .ranking {
      display: flex;
      justify-content: center;
      padding: 20px;
    }

    table {
      border-collapse: collapse;
      width: 80%;
      max-width: 700px;
      background: #ffffff;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #52b788;
      color: white;
      font-size: 16px;
    }

    tr:nth-child(even) {
      background-color: #f3fdf6;
    }

    tr:hover {
      background-color: #eaf9ee;
      transition: 0.2s;
    }

    /* Medalhas */
    .ouro { color: #FFD700; font-weight: bold; }
    .prata { color: #C0C0C0; font-weight: bold; }
    .bronze { color: #CD7F32; font-weight: bold; }

    /* Botão (caso queira fora do nav) */
    .botao {
      padding: 10px 15px;
      background: linear-gradient(to right, #52b788, #40916c);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      transition: 0.3s;
    }

    .botao:hover {
      background: linear-gradient(to right, #74c69d, #2d6a4f);
      transform: scale(1.03);
    }

  </style>
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
    <h1>🏆 Ranking dos 20 Melhores</h1>
    <p>Veja quem mais se destacou nas missões ecológicas!</p>
  </header>

  <section class="ranking">
    <table>
      <tr>
        <th>Posição</th>
        <th>Usuário</th>
        <th>Pontos</th>
      </tr>
      <?php
      $pos = 1;
      while ($row = $result->fetch_assoc()) {
        $classe = '';
        if ($pos == 1) $classe = 'ouro';
        elseif ($pos == 2) $classe = 'prata';
        elseif ($pos == 3) $classe = 'bronze';

        echo "<tr class='$classe'>
                <td>$pos</td>
                <td>{$row['nome']}</td>
                <td>{$row['pontos']}</td>
              </tr>";
        $pos++;
      }
      ?>
    </table>
  </section>
</body>
</html>
