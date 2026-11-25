<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexao.php';

// Pega os dados da pesquisa (se não existirem, ficam vazios)
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'id_produto';

// Monta a ordenação correta (Segurança contra SQL Injection)
$orderBy = "p.id_produto ASC"; // Padrão
if ($ordem == 'nome') { $orderBy = "p.nome ASC"; }
elseif ($ordem == 'preco') { $orderBy = "p.preco_venda DESC"; }
elseif ($ordem == 'estoque') { $orderBy = "p.quantidade_estoque DESC"; }

// Monta a consulta base
$sql = "SELECT p.id_produto, p.codigo, p.nome, p.quantidade_estoque, p.preco_venda, c.nome AS categoria 
        FROM produtos p 
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria";

// Se o usuário digitou algo na busca, adiciona o filtro WHERE
if (!empty($busca)) {
    // O LIKE busca qualquer parte do nome ou do código
    $sql .= " WHERE p.nome LIKE ? OR p.codigo LIKE ?";
}

$sql .= " ORDER BY $orderBy";

// Prepara a query
$stmt = $conn->prepare($sql);

if (!empty($busca)) {
    $termo = "%" . $busca . "%";
    $stmt->bind_param("ss", $termo, $termo);
}

$stmt->execute();
$resultado = $stmt->get_result();

require '../includes/header.php';
?>

<div class="page-title-bar">Controle de Estoque</div>

<!-- Barra de Pesquisa e Ordenação -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap;">
    <a href="criar.php" class="btn-primary" style="margin-bottom: 0;">+ Novo Produto</a>
    
    <form action="index.php" method="GET" style="display: flex; gap: 10px; margin: 0;">
        <!-- Campo de Busca -->
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar por nome ou código..." style="padding: 10px 15px; border: 1px solid #D9D9D9; border-radius: 20px; width: 250px; outline: none;">
        
        <!-- Select de Ordenação -->
        <select name="ordem" style="padding: 10px 15px; border: 1px solid #D9D9D9; border-radius: 20px; outline: none; background: white; cursor: pointer;">
            <option value="id_produto" <?= $ordem == 'id_produto' ? 'selected' : '' ?>>Ordenar por ID</option>
            <option value="nome" <?= $ordem == 'nome' ? 'selected' : '' ?>>Nome (A-Z)</option>
            <option value="preco" <?= $ordem == 'preco' ? 'selected' : '' ?>>Maior Preço</option>
            <option value="estoque" <?= $ordem == 'estoque' ? 'selected' : '' ?>>Maior Estoque</option>
        </select>

        <button type="submit" style="background: #073076; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold;">
            <i class="fa-solid fa-search"></i> Filtrar
        </button>
        
        <?php if(!empty($busca) || $ordem != 'id_produto'): ?>
            <a href="index.php" style="display: flex; align-items: center; color: #dc3545; text-decoration: none; font-weight: bold; padding: 0 10px;">Limpar</a>
        <?php endif; ?>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Qtd. em Estoque</th>
            <th>Preço Unitário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while($produto = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $produto['id_produto'] ?></td>
                    <td>
                        <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                        <small style="color: #666;"><?= htmlspecialchars($produto['codigo']) ?> | <?= htmlspecialchars($produto['categoria']) ?></small>
                    </td>
                    <td><?= $produto['quantidade_estoque'] ?></td>
                    <td>R$ <?= number_format($produto['preco_venda'], 2, ',', '.') ?></td>
                    <td>
                        <a href="editar.php?id=<?= $produto['id_produto'] ?>" style="color: #159AE3; text-decoration: none; margin-right: 10px;">Editar</a>
                        <a href="deletar.php?id=<?= $produto['id_produto'] ?>" style="color: #dc3545; text-decoration: none;" onclick="return confirm('Excluir este produto?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color: #666;">
                    Nenhum produto encontrado com esses filtros.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require '../includes/footer.php'; ?>