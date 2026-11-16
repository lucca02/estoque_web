<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexao.php';

$sql = "SELECT c.id_categoria, c.nome, COUNT(p.id_produto) AS total_produtos 
        FROM categorias c 
        LEFT JOIN produtos p ON c.id_categoria = p.id_categoria 
        GROUP BY c.id_categoria 
        ORDER BY c.id_categoria";
$resultado = $conn->query($sql);

require '../includes/header.php';
?>

<div class="page-title-bar">Gerenciamento de Categorias</div>
<a href="criar.php" class="btn-primary">+ Nova Categoria</a>

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
    </tbody>
</table>

<?php require '../includes/footer.php'; ?>