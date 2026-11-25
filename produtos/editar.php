<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: ../login.php"); exit(); }
require '../config/conexao.php';

if (!isset($_GET['id'])) { header("Location: index.php"); exit(); }
$id = $_GET['id']; $mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo']; $nome = $_POST['nome']; $id_categoria = $_POST['id_categoria'];
    $quantidade = $_POST['quantidade_estoque']; $preco = $_POST['preco_venda'];

    try {
        $stmt = $conn->prepare("UPDATE produtos SET codigo=?, nome=?, id_categoria=?, quantidade_estoque=?, preco_venda=? WHERE id_produto=?");
        $stmt->bind_param("ssiidi", $codigo, $nome, $id_categoria, $quantidade, $preco, $id);
        $stmt->execute();
        
        $mensagem = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Produto atualizado com sucesso!</div>"; 
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro: O código (" . htmlspecialchars($codigo) . ") já pertence a outro produto.</div>";
        } else {
            $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro ao atualizar: " . $e->getMessage() . "</div>";
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id_produto = ?");
$stmt->bind_param("i", $id); $stmt->execute();
$produto = $stmt->get_result()->fetch_assoc();
if (!$produto) { die("Produto não encontrado."); }
$categorias = $conn->query("SELECT id_categoria, nome FROM categorias ORDER BY nome");

require '../includes/header.php';
?>

<div class="page-title-bar">Editar Produto</div>

<div class="form-card">
    <?= $mensagem ?>
    <form action="editar.php?id=<?= $id ?>" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>Código do Produto:</label>
                <input type="text" name="codigo" required value="<?= htmlspecialchars($produto['codigo']) ?>">
            </div>
            <div class="form-group">
                <label>Categoria:</label>
                <select name="id_categoria" required>
                    <?php while($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?= $cat['id_categoria'] ?>" <?= ($cat['id_categoria'] == $produto['id_categoria']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nome']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Nome do Produto:</label>
            <input type="text" name="nome" required value="<?= htmlspecialchars($produto['nome']) ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Qtd. em Estoque:</label>
                <input type="number" name="quantidade_estoque" required min="0" value="<?= $produto['quantidade_estoque'] ?>">
            </div>
            <div class="form-group">
                <label>Preço de Venda (R$):</label>
                <input type="number" name="preco_venda" required step="0.01" min="0" value="<?= $produto['preco_venda'] ?>">
            </div>
        </div>

        <button type="submit" class="btn-primary">Atualizar Produto</button>
        <a href="index.php" class="btn-secundario">Cancelar</a>
    </form>
</div>

<?php require '../includes/footer.php'; ?>