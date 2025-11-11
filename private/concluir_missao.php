<?php
    include("../public/php/db.php");
    session_start();

    if (!isset($_SESSION['user_id'])) {
        exit;
    }

    $user_id = $_SESSION['user_id'] ?? null;    
    $missoes_id = $_POST['id'] ?? null;
    $pendencia = $_GET['pendencia'] ?? null;
    $data_mis = date('Y-m-d');

    if($missoes_id){
        $sql = "UPDATE usuario_missoes
                SET pendencia = 'concluida'
                WHERE usuario_id = $user_id
                AND missoes_id = $missoes_id
                AND data_mis = CURDATE()";
         if($conn->query($sql) === TRUE){
            // Atualiza pontos do usuário
            $pontos_ganhos = 10; // Defina quantos pontos o usuário ganha por missão concluída
            $update_pontos_sql = "UPDATE usuarios
                                  SET pontos = pontos + $pontos_ganhos
                                  WHERE id = $user_id";
            $conn->query($update_pontos_sql);

            echo "ok";
         }else{
            echo 'erro_sql';
         }
    }else{
        echo 'sem_id';
    }

?>
