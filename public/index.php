<?php
  session_start();
  
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>EcoWorks 🌱 | Pequenas Ações, Grandes Mudanças</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <header>
    <h1>EcoWorks 🌿</h1>
    <p>Transformando atitudes em impacto positivo. Junte-se ao movimento!</p>
    <div class="botoes">
      <?php if (isset($_SESSION['user_id'])) { ?>
        <a href="dashboard.php" class="botao">Ir para o Dashboard</a>
      <?php } else  {?>
      <a href="login.php" class="botao">Entrar</a>
      <a href="register.php" class="botao marrom">Registrar</a>
      <?php } ?>
    </div>
  </header>

  <section class="intro">
    <h2>Nosso Propósito 💚</h2>
    <p>O <strong>EcoWorks</strong> nasceu com o objetivo de incentivar hábitos sustentáveis por meio de pequenas ações diárias.  
    Acreditamos que cada gesto conta — seja economizando água, separando o lixo ou plantando uma árvore — e, juntos, podemos criar um futuro mais verde e equilibrado.</p>
  </section>

  <section class="pilares">
    <div class="card">
      <h3>🌱 Educação Ambiental</h3>
      <p>Aprenda com cada missão como contribuir com o planeta e adote hábitos mais conscientes no seu dia a dia.</p>
    </div>

    <div class="card">
      <h3>🌎 Comunidade Sustentável</h3>
      <p>Junte-se a pessoas que compartilham o mesmo propósito e suba no ranking dos protetores ambientais.</p>
    </div>

    <div class="card">
      <h3>💧 Ação e Recompensa</h3>
      <p>Conclua missões, acumule pontos e alcance novos níveis. Pequenas atitudes geram grandes resultados.</p>
    </div>
  </section>

  <footer>
    <p>© 2025 EcoWorks | Desenvolvido com propósito e sustentabilidade 🌍</p>
  </footer>
</body>
</html>
