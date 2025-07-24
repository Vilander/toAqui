<?php
/**
 * Script para limpeza automática de anúncios antigos
 * - Exclui registros com mais de 90 dias no banco de dados
 * - Gera log da execução
 * - Proteção com senha via URL (para evitar execução por terceiros)
 */

// === CONFIGURAÇÃO DE SEGURANÇA ===
// Defina uma senha simples para acessar o script
$senhaCorreta = "minhaSenha123"; // Troque por algo seguro

// Verifica se a senha foi enviada na URL (ex: limpar_anuncios.php?senha=minhaSenha123)
if (!isset($_GET['senha']) || $_GET['senha'] !== $senhaCorreta) {
    die("Acesso negado: senha inválida.");
}

// === INCLUINDO CONEXÃO COM BANCO ===
include 'conexao.php';

// === COMANDO SQL PARA EXCLUIR ANÚNCIOS COM MAIS DE 90 DIAS ===
$sql = "DELETE FROM produtos WHERE criado_em < NOW() - INTERVAL 90 DAY";

// Executa a query
if ($conn->query($sql) === TRUE) {
    $mensagem = "✅ " . date('d/m/Y H:i:s') . " - Anúncios antigos removidos com sucesso.\n";
    echo "Anúncios antigos removidos com sucesso!";
} else {
    $mensagem = "❌ " . date('d/m/Y H:i:s') . " - Erro ao remover: " . $conn->error . "\n";
    echo "Erro ao remover anúncios: " . $conn->error;
}

// Fecha a conexão
$conn->close();

// === REGISTRANDO LOG ===
// Caminho do arquivo de log
$arquivoLog = __DIR__ . '/logs/limpeza.log';

// Cria a pasta logs caso não exista
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0777, true);
}

// Escreve a mensagem no arquivo de log
file_put_contents($arquivoLog, $mensagem, FILE_APPEND);
?>
