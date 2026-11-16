<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexao.php';

$sql = "SELECT m.id_movimentacao, p.nome AS produto, u.nome AS usuario, 
               m.tipo, m.quantidade, m.preco_unitario, m.data_movimentacao, m.observacao 
        FROM movimentacoes m 
        INNER JOIN produtos p ON m.id_produto = p.id_produto 
        INNER JOIN usuarios u ON m.id_usuario = u.id_usuario 
        ORDER BY m.data_movimentacao DESC, m.id_movimentacao DESC";
$resultado = $conn->query($sql);

require '../includes/header.php';
?>

<div class="page-title-bar">Histórico de Movimentações</div>
<a href="criar.php" class="btn-primary">+ Nova Movimentação</a>

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
    </tbody>
</table>

<?php require '../includes/footer.php'; ?>