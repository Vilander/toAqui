<?php
$host = "sql105.infinityfree.com";      // Host do banco
$dbname = "if0_39545740_quadro";        // Nome do banco correto
$user = "if0_39545740";                 // Usuário do banco
$pass = "S3n4cAm3";                     // Senha definida no painel

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Conexão OK!"; 
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}
?>
