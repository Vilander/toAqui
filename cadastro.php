<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto ou Serviço</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <img src="imagens/Senac_logo.png" alt="Senac" class="logo">
    <p class="slogan">Seu canal para divulgar e encontrar produtos e serviços</p>
</header>

<main class="form-cadastro">
    <div class="cadastro-card">
        <h2>Cadastre seu Produto ou Serviço</h2>

        <?php if (isset($_SESSION['sucesso'])): ?>
            <p style="color:green; font-weight:bold;"><?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></p>
        <?php elseif (isset($_SESSION['erro'])): ?>
            <p style="color:red; font-weight:bold;"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
        <?php endif; ?>

        <form action="salvar.php" method="POST" enctype="multipart/form-data">
            <label>Nome:
                <input type="text" name="nome" placeholder="Digite seu nome" required>
            </label>

            <label>Email:
                <input type="email" name="email" placeholder="Digite seu e-mail" required>
            </label>

            <label>Telefone:
                <input type="tel" name="telefone" placeholder="(99) 99999-9999">
            </label>

            <label>Categoria:
                <select name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php
                    $categorias = [
                        'moda' => 'Moda e Acessórios',
                        'beleza' => 'Beleza, Cosméticos, Saúde e Bem-estar',
                        'eletronicos' => 'Eletrônicos',
                        'informatica' => 'Informática e Tecnologia',
                        'casa' => 'Casa e Decoração',
                        'alimentos' => 'Alimentos e Bebidas',
                        'esporte' => 'Esporte e Lazer',
                        'pets' => 'Pets',
                        'livros' => 'Livros e Papelaria',
                        'auto' => 'Serviços Automotivos, Autopeças e Acessórios',
                        'construcao' => 'Construção e Reformas',
                        'eventos' => 'Eventos',
                        'educacao' => 'Educação',
                        'delivery' => 'Delivery e Transporte',
                        'domesticos' => 'Serviços Domésticos',
                        'consultoria' => 'Consultoria e Profissionais Liberais'
                    ];
                    foreach ($categorias as $valor => $nome) {
                        echo "<option value=\"$valor\">$nome</option>";
                    }
                    ?>
                </select>
            </label>

            <label>Produto/Serviço:
                <input type="text" name="produto" placeholder="Informe o produto ou serviço" required>
            </label>

            <label>Descrição:
                <textarea name="descricao" placeholder="Descreva brevemente o produto" required></textarea>
            </label>

            <label>Link:
                <input type="url" name="link" placeholder="https://">
            </label>

            <label>Imagem:
                <input type="file" name="imagem" accept="image/*">
            </label>

            <button type="submit" class="btn-publicar">PUBLICAR</button>
        </form>
    </div>
</main>

<footer>
    <a href="index.php"><button>VER PRODUTOS</button></a>
    <p><a href="termos.php" class="termos-link">Termos de serviço</a></p>
</footer>
</body>
</html>
