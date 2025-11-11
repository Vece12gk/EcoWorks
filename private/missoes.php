<?php
    
    include("../public/php/db.php");
    
    if (!isset($_SESSION['user_id'])) {
        exit;
    }   

    $user_id = $_SESSION['user_id'] ?? null;
    $missoes_id = $_GET['missoes_id'] ?? null;
    $pendencia = $_GET['pendencia'] ?? null;
    $data_mis = date('Y-m-d');
    $missoes = null;
    $sql = "SELECT * FROM usuario_missoes WHERE usuario_id = $user_id
    AND data_mis = CURDATE()";
    $result = $conn->query($sql);
    
    $sql_check = "SELECT um.*, m.descricao
        FROM usuario_missoes um
        JOIN missoes m ON um.missoes_id = m.id
        WHERE um.usuario_id = $user_id
            AND um.data_mis = CURDATE()
            AND (um.pendencia IS NULL OR um.pendencia != 'concluida')";
    $result = $conn->query($sql_check);

    if ($result && $result->num_rows > 0) {
    $missoes = $result; // já tem missões hoje
    } else {
    // verifica se já existem missões (concluídas ou não)
    $check_all = $conn->query("SELECT COUNT(*) AS total FROM usuario_missoes WHERE usuario_id = $user_id AND data_mis = CURDATE()");
    $count = $check_all->fetch_assoc()['total'];

    if ($count == 0) { // só cria se ainda não houver nenhuma
        $sql_missoes = "SELECT * FROM missoes ORDER BY RAND() LIMIT 3";
        $novas = $conn->query($sql_missoes);

        if ($novas && $novas->num_rows > 0) {
            while ($row = $novas->fetch_assoc()) {
                $missao_id = $row['id'];
                $insert_sql = "INSERT INTO usuario_missoes (usuario_id, missoes_id, pendencia, data_mis)
                               VALUES ($user_id, $missao_id, 'pendente', CURDATE())";
                $conn->query($insert_sql);
            }
        }
    }

    // busca novamente as missões de hoje
    $sql_reload = "SELECT um.*, m.descricao 
                   FROM usuario_missoes um
                   JOIN missoes m ON um.missoes_id = m.id
                   WHERE um.usuario_id = $user_id
                   AND um.data_mis = CURDATE()
                   AND (um.pendencia IS NULL OR um.pendencia != 'concluida')";
    $missoes = $conn->query($sql_reload);
}


?>
