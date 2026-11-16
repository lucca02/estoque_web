<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexao.php';

$sql = "SELECT p.id_produto, p.codigo, p.nome, p.quantidade_estoque, p.preco_venda, c.nome AS categoria 
        FROM produtos p 
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
        ORDER BY p.id_produto";
$resultado = $conn->query($sql);

// Inclui o header (caminho sobe um nível pois estamos na pasta produtos)
require '../includes/header.php';
?>

<div class="page-title-bar">Controle de Estoque</div>

<a href="criar.php" class="btn-primary">+ Novo Produto</a>

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
        <?php while($produto = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $produto['id_produto'] ?></td>
                <td>
                    <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                    <small style="color: #666;"><?= htmlspecialchars($produto['categoria']) ?></small>
                </td>
                <td><?= $produto['quantidade_estoque'] ?></td>
                <td>R$ <?= number_format($produto['preco_venda'], 2, ',', '.') ?></td>
                <td>
                    <a href="editar.php?id=<?= $produto['id_produto'] ?>" style="color: #159AE3; text-decoration: none; margin-right: 10px;">Editar</a>
                    <a href="deletar.php?id=<?= $produto['id_produto'] ?>" style="color: #dc3545; text-decoration: none;" onclick="return confirm('Excluir este produto?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
// Inclui o footer
require '../includes/footer.php';
?>