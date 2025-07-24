<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Script para limpeza de anúncios
 * - Remove anúncios de ontem (padrão para teste)
 * - Inclui opção comentada para 90 dias
 * - Proteção com senha via URL
 * - Gera log de execução
 */

// === SENHA DE ACESSO ===
$senhaCorreta = "minhaSenha123";

// Verifica senha enviada na URL
if (!isset($_GET['senha']) || $_GET['senha'] !== $senhaCorreta) {
    die("Acesso negado: senha inválida.");
}

// Inclui a conexão PDO
include __DIR__ . '/conexao.php';

// === COMANDO SQL ===
// ATUAL: Exclui anúncios criados ONTEM
$sql = "DELETE FROM produtos WHERE DATE(criado_em) = CURDATE() - INTERVAL 1 DAY";

// ALTERNATIVA (comente acima e descomente esta linha para 90 dias):
// $sql = "DELETE FROM produtos WHERE criado_em < NOW() - INTERVAL 90 DAY";

try {
    // Executa a exclusão
    $linhasAfetadas = $pdo->exec($sql);

    if ($linhasAfetadas !== false) {
        $mensagem = "✅ " . date('d/m/Y H:i:s') . " - Limpeza concluída. $linhasAfetadas anúncios excluídos.\n";
        echo "Limpeza concluída. $linhasAfetadas anúncios excluídos.";
    } else {
        $mensagem = "❌ " . date('d/m/Y H:i:s') . " - Nenhum anúncio encontrado para exclusão.\n";
        echo "Nenhum anúncio encontrado para exclusão.";
    }
} catch (PDOException $e) {
    $mensagem = "❌ " . date('d/m/Y H:i:s') . " - Erro: " . $e->getMessage() . "\n";
    echo "Erro: " . $e->getMessage();
}

// Fecha a conexão PDO
$pdo = null;

// === LOG ===
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
file_put_contents($logDir . '/limpeza.log', $mensagem, FILE_APPEND);
?>
