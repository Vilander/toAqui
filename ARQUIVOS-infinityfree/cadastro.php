<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = htmlspecialchars($_POST['produto']);
    $descricao = htmlspecialchars($_POST['descricao']);
    $categoria = htmlspecialchars($_POST['categoria']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $link = htmlspecialchars($_POST['link']);

    // Upload da imagem (opcional)
    $imagem = '';
    if (!empty($_FILES['imagem']['name'])) {
        $diretorio = 'uploads/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }
        $nomeArquivo = uniqid() . '_' . basename($_FILES['imagem']['name']);
        $caminho = $diretorio . $nomeArquivo;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $imagem = $caminho;
        }
    }

    // Insert no banco
    $sql = "INSERT INTO produtos (produto, descricao, categoria, telefone, link, imagem) 
            VALUES (:produto, :descricao, :categoria, :telefone, :link, :imagem)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':produto', $produto);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':link', $link);
    $stmt->bindParam(':imagem', $imagem);

    if ($stmt->execute()) {
        echo "<p style='color:green; text-align:center;'>Produto cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Erro ao cadastrar produto.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagens/favicon.ico" type="image/x-icon">
    <title>ToAqui - Senac</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <img src="imagens/Senac_logo.png" alt="Senac" class="logo">
    <p class="slogan">Seu canal para divulgar e encontrar produtos e serviços</p>
</header>

<main class="form-cadastro">
    <div class="cadastro-card">
        <h2>Cadastrar Produto</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Produto:
                <input type="text" name="produto" placeholder="Nome do produto" required>
            </label>
            <label>Descrição:
                <textarea name="descricao" placeholder="Descrição" required></textarea>
            </label>
            <label>Categoria:
                <select name="categoria" required>
                    <option value="">Selecione a categoria</option>
                    <option value="moda">Moda e Acessórios</option>
                    <option value="beleza">Beleza, Cosméticos, Saúde e Bem-estar</option>
                    <option value="eletronicos">Eletrônicos</option>
                    <option value="informatica">Informática e Tecnologia</option>
                    <option value="casa">Casa e Decoração</option>
                    <option value="alimentos">Alimentos e Bebidas</option>
                    <option value="esporte">Esporte e Lazer</option>
                    <option value="pets">Pets</option>
                    <option value="livros">Livros e Papelaria</option>
                    <option value="auto">Serviços Automotivos</option>
                    <option value="construcao">Construção e Reformas</option>
                    <option value="eventos">Eventos</option>
                    <option value="educacao">Educação</option>
                    <option value="delivery">Delivery e Transporte</option>
                    <option value="domesticos">Serviços Domésticos</option>
                    <option value="consultoria">Consultoria</option>
                </select>
            </label>
            <label>Telefone:
                <input type="text" name="telefone" placeholder="Telefone (opcional)">
            </label>
            <label>Link:
                <input type="url" name="link" placeholder="Link do produto (opcional)">
            </label>
            <label>Imagem:
                <input type="file" name="imagem" accept="image/*">
            </label>
            <button type="submit" class="btn-publicar">Publicar</button>
        </form>
    </div>
</main>

<footer>
    <a href="index.php">
        <button>VOLTAR</button>
    </a>
    <p><a href="termos.php" class="termos-link">Termos de serviço</a></p>
    <p class="footer-email">
        <svg class="email-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#F7941D" viewBox="0 0 24 24">
            <path d="M2 4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h20c1.103 0 2-.897 
            2-2V6c0-1.103-.897-2-2-2H2zm0 2h20l-10 7L2 6zm0 12V8.236l10 7.5 
            10-7.5V18H2z"/>
        </svg>
        Dúvidas, reclamações, sugestões ou solicitações:
        <a href="mailto:toaqui@senacsp.edu.br">toaqui@senacsp.edu.br</a>
    </p>
</footer>
</body>
</html>
