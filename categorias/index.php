<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexao.php';

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'id_categoria';

$orderBy = "c.id_categoria ASC"; 
if ($ordem == 'nome') { $orderBy = "c.nome ASC"; }
elseif ($ordem == 'qtd') { $orderBy = "total_produtos DESC"; }

$sql = "SELECT c.id_categoria, c.nome, COUNT(p.id_produto) AS total_produtos 
        FROM categorias c 
        LEFT JOIN produtos p ON c.id_categoria = p.id_categoria";

if (!empty($busca)) {
    $sql .= " WHERE c.nome LIKE ?";
}

$sql .= " GROUP BY c.id_categoria ORDER BY $orderBy";

$stmt = $conn->prepare($sql);
if (!empty($busca)) {
    $termo = "%" . $busca . "%";
    $stmt->bind_param("s", $termo);
}
$stmt->execute();
$resultado = $stmt->get_result();

require '../includes/header.php';
?>

<div class="page-title-bar">Gerenciamento de Categorias</div>

<!-- Barra de Pesquisa e Ordenação -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap;">
    <a href="criar.php" class="btn-primary" style="margin-bottom: 0;">+ Nova Categoria</a>
    
    <form action="index.php" method="GET" style="display: flex; gap: 10px; margin: 0;">
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar categoria..." style="padding: 10px 15px; border: 1px solid #D9D9D9; border-radius: 20px; width: 200px; outline: none;">
        
        <select name="ordem" style="padding: 10px 15px; border: 1px solid #D9D9D9; border-radius: 20px; outline: none; background: white; cursor: pointer;">
            <option value="id_categoria" <?= $ordem == 'id_categoria' ? 'selected' : '' ?>>Ordenar por ID</option>
            <option value="nome" <?= $ordem == 'nome' ? 'selected' : '' ?>>Nome (A-Z)</option>
            <option value="qtd" <?= $ordem == 'qtd' ? 'selected' : '' ?>>Mais Produtos</option>
        </select>

        <button type="submit" style="background: #073076; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold;">
            <i class="fa-solid fa-search"></i> Filtrar
        </button>
        
        <?php if(!empty($busca) || $ordem != 'id_categoria'): ?>
            <a href="index.php" style="display: flex; align-items: center; color: #dc3545; text-decoration: none; font-weight: bold; padding: 0 10px;">Limpar</a>
        <?php endif; ?>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome da Categoria</th>
            <th>Qtd. de Produtos</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while($cat = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $cat['id_categoria'] ?></td>
                    <td><strong><?= htmlspecialchars($cat['nome']) ?></strong></td>
                    <td><?= $cat['total_produtos'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $cat['id_categoria'] ?>" style="color: #159AE3; text-decoration: none; margin-right: 10px;">Editar</a>
                        <a href="deletar.php?id=<?= $cat['id_categoria'] ?>" style="color: #dc3545; text-decoration: none;" onclick="return confirm('Excluir esta categoria?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px; color: #666;">Nenhuma categoria encontrada.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require '../includes/footer.php'; ?>