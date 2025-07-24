<?php
// Inclui o arquivo de conexão
include 'conexao.php';

// Categorias
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

// Parâmetros
$categoriaFiltro = isset($_GET['categoria']) ? htmlspecialchars($_GET['categoria']) : '';
$busca = isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '';
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 6; // 6 itens por página
$offset = ($paginaAtual - 1) * $limite;

// Monta SQL com filtros
$sqlBase = "FROM produtos WHERE 1";
$params = [];

if ($categoriaFiltro) {
    $sqlBase .= " AND categoria = :categoria";
    $params[':categoria'] = $categoriaFiltro;
}
if ($busca) {
    $sqlBase .= " AND produto LIKE :busca";
    $params[':busca'] = "%$busca%";
}

// Conta total para paginação
$sqlCount = "SELECT COUNT(*) " . $sqlBase;
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute($params);
$totalRegistros = $stmtCount->fetchColumn();
$totalPaginas = ceil($totalRegistros / $limite);

// Busca produtos
$sql = "SELECT * " . $sqlBase . " ORDER BY id DESC LIMIT :limite OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $chave => $valor) {
    $stmt->bindValue($chave, $valor);
}
$stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagens/favicon.ico" type="image/x-icon">
    <title>ToAqui - Senac</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .busca-categoria {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .busca-categoria form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .busca-categoria input[type="text"], .busca-categoria select {
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .busca-categoria button {
            padding: 10px 20px;
            background: #004A8D;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        .busca-categoria button:hover {
            background: #F7941D;
        }
        .paginacao {
            text-align: center;
            margin: 20px;
        }
        .paginacao a {
            display: inline-block;
            margin: 0 5px;
            padding: 8px 12px;
            background: #004A8D;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .paginacao a:hover {
            background: #F7941D;
        }
        .paginacao .ativo {
            background: #F7941D;
        }
    </style>
</head>
<body>
<header>
    <img src="imagens/Senac_logo.png" alt="Senac" class="logo">
    <p class="slogan">Seu canal para divulgar e encontrar produtos e serviços</p>
</header>

<main class="principal">
    <div class="busca-categoria">
        <form method="GET" action="">
            <input type="text" name="busca" placeholder="Buscar produto..." value="<?= $busca ?>">
            <select name="categoria">
                <option value="">Todas as Categorias</option>
                <?php foreach ($categorias as $valor => $nome): ?>
                    <option value="<?= $valor ?>" <?= ($valor == $categoriaFiltro) ? 'selected' : '' ?>>
                        <?= $nome ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <section id="product-list">
        <?php if ($totalRegistros > 0): ?>
            <?php foreach ($produtos as $p): ?>
                <div class="card">
                    <img src="<?= !empty($p['imagem']) ? $p['imagem'] : 'imagens/no-image.png' ?>" alt="<?= htmlspecialchars($p['produto']) ?>">
                    <p class="category"><?= $categorias[$p['categoria']] ?? 'Outros' ?></p>
                    <h3 class="product-title"><?= htmlspecialchars($p['produto']) ?></h3>
                    <p class="description"><?= htmlspecialchars($p['descricao']) ?></p>
                    <?php if (!empty($p['telefone'])): ?>
                        <p class="phone">📞 <?= htmlspecialchars($p['telefone']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($p['link'])): ?>
                        <a href="<?= htmlspecialchars($p['link']) ?>" target="_blank">Ver Mais</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; font-size:18px;">Nenhum produto ou serviço encontrado.</p>
        <?php endif; ?>
    </section>

    <?php if ($totalPaginas > 1): ?>
        <div class="paginacao">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <a href="?pagina=<?= $i ?>&busca=<?= urlencode($busca) ?>&categoria=<?= urlencode($categoriaFiltro) ?>" 
                   class="<?= ($i == $paginaAtual) ? 'ativo' : '' ?>">
                   <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</main>

<footer>
    <a href="cadastro.php">
        <button>QUERO DIVULGAR</button>
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
