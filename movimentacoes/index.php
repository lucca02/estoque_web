<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexao.php';

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'recente';

// Padrão é a mais recente primeiro
$orderBy = "m.data_movimentacao DESC, m.id_movimentacao DESC"; 
if ($ordem == 'antiga') { 
    $orderBy = "m.data_movimentacao ASC, m.id_movimentacao ASC"; 
}

$sql = "SELECT m.id_movimentacao, p.nome AS produto, u.nome AS usuario, 
               m.tipo, m.quantidade, m.preco_unitario, m.data_movimentacao, m.observacao 
        FROM movimentacoes m 
        INNER JOIN produtos p ON m.id_produto = p.id_produto 
        INNER JOIN usuarios u ON m.id_usuario = u.id_usuario";

if (!empty($busca)) {
    $sql .= " WHERE u.nome LIKE ?";
}

$sql .= " ORDER BY $orderBy";

$stmt = $conn->prepare($sql);
if (!empty($busca)) {
    $termo = "%" . $busca . "%";
    $stmt->bind_param("s", $termo);
}
$stmt->execute();
$resultado = $stmt->get_result();

require '../includes/header.php';
?>

<div class="page-title-bar">Histórico de Movimentações</div>

<!-- Barra de Pesquisa e Ordenação -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap;">
    <a href="criar.php" class="btn-primary" style="margin-bottom: 0;">+ Nova Movimentação</a>
    
    <form action="index.php" method="GET" style="display: flex; gap: 10px; margin: 0;">
        <!-- Busca por nome do funcionário -->
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar por funcionário..." style="padding: 10px 15px; border: 1px solid #D9D9D9; border-radius: 20px; width: 220px; outline: none;">
        
        <!-- Ordenação por Data -->
        <select name="ordem" style="padding: 10px 15px; border: 1px solid #D9D9D9; border-radius: 20px; outline: none; background: white; cursor: pointer;">
            <option value="recente" <?= $ordem == 'recente' ? 'selected' : '' ?>>Mais Recentes</option>
            <option value="antiga" <?= $ordem == 'antiga' ? 'selected' : '' ?>>Mais Antigas</option>
        </select>

        <button type="submit" style="background: #073076; color: white; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold;">
            <i class="fa-solid fa-search"></i> Filtrar
        </button>
        
        <?php if(!empty($busca) || $ordem != 'recente'): ?>
            <a href="index.php" style="display: flex; align-items: center; color: #dc3545; text-decoration: none; font-weight: bold; padding: 0 10px;">Limpar</a>
        <?php endif; ?>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Produto</th>
            <th>Tipo</th>
            <th>Qtd.</th>
            <th>Preço Unit.</th>
            <th>Responsável</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while($mov = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $mov['id_movimentacao'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($mov['data_movimentacao'])) ?></td>
                    <td><strong><?= htmlspecialchars($mov['produto']) ?></strong></td>
                    <td>
                        <span class="<?= $mov['tipo'] == 'entrada' ? 'badge-entrada' : 'badge-saida' ?>">
                            <?= strtoupper($mov['tipo']) ?>
                        </span>
                    </td>
                    <td><?= $mov['quantidade'] ?></td>
                    <td>R$ <?= number_format($mov['preco_unitario'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($mov['usuario']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #666;">Nenhuma movimentação encontrada para este funcionário.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require '../includes/footer.php'; ?>