<?php
session_start();

$host = 'localhost';
$dbname = 'quadro';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

// Recebe dados do formulário
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$produto = $_POST['produto'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$link = $_POST['link'] ?? '';

// Caminho padrão
$imagem = 'imagens/no-image.png';

// Verifica se enviou arquivo
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($ext, $permitidas)) {
        $novoNome = uniqid() . '.' . $ext;
        $destino = 'uploads/' . $novoNome;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $imagem = $destino; // Atualiza caminho da imagem
        }
    }
}

// Inserir no banco
$sql = "INSERT INTO produtos (nome, email, telefone, categoria, produto, descricao, link, imagem) 
        VALUES (:nome, :email, :telefone, :categoria, :produto, :descricao, :link, :imagem)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':telefone', $telefone);
$stmt->bindParam(':categoria', $categoria);
$stmt->bindParam(':produto', $produto);
$stmt->bindParam(':descricao', $descricao);
$stmt->bindParam(':link', $link);
$stmt->bindParam(':imagem', $imagem);

if ($stmt->execute()) {
    $_SESSION['sucesso'] = "Cadastro realizado com sucesso!";
} else {
    $_SESSION['erro'] = "Erro ao salvar o cadastro!";
}

header("Location: cadastro.php");
exit;
