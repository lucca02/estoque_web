<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: ../login.php"); exit(); }
require '../config/conexao.php';

$categorias = $conn->query("SELECT id_categoria, nome FROM categorias ORDER BY nome");
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo']; $nome = $_POST['nome']; $id_categoria = $_POST['id_categoria'];
    $quantidade = $_POST['quantidade_estoque']; $preco = $_POST['preco_venda'];

    try {
        // Tenta inserir no banco
        $stmt = $conn->prepare("INSERT INTO produtos (codigo, nome, id_categoria, quantidade_estoque, preco_venda) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiid", $codigo, $nome, $id_categoria, $quantidade, $preco);
        $stmt->execute();
        
        $mensagem = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Produto cadastrado com sucesso!</div>";
    } catch (mysqli_sql_exception $e) {
        // Se der erro no banco (ex: código duplicado), cai aqui e mostra uma mensagem amigável
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro: Já existe um produto cadastrado com este código (" . htmlspecialchars($codigo) . ").</div>";
        } else {
            $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
        }
    }
}
require '../includes/header.php';
?>

<div class="page-title-bar">Cadastrar Novo Produto</div>

<div class="form-card">
    <?= $mensagem ?>
    <form action="criar.php" method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>Código do Produto:</label>
                <input type="text" name="codigo" required placeholder="Ex: ALI001">
            </div>
            <div class="form-group">
                <label>Categoria:</label>
                <select name="id_categoria" required>
                    <option value="">Selecione...</option>
                    <?php while($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Nome do Produto:</label>
            <input type="text" name="nome" required placeholder="Ex: Banana Prata 1kg">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Qtd. Inicial em Estoque:</label>
                <input type="number" name="quantidade_estoque" required min="0" value="0">
            </div>
            <div class="form-group">
                <label>Preço de Venda (R$):</label>
                <input type="number" name="preco_venda" required step="0.01" min="0" placeholder="0.00">
            </div>
        </div>

        <button type="submit" class="btn-primary">Salvar Produto</button>
        <a href="index.php" class="btn-secundario">Cancelar</a>
    </form>
</div>

<?php require '../includes/footer.php'; ?>