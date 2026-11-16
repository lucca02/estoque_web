<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: ../login.php"); exit(); }
require '../config/conexao.php';

$produtos = $conn->query("SELECT id_produto, nome, quantidade_estoque FROM produtos ORDER BY nome");
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produto = $_POST['id_produto']; $id_usuario = $_SESSION['usuario_id'];
    $tipo = $_POST['tipo']; $quantidade = $_POST['quantidade']; $preco_unitario = $_POST['preco_unitario'];
    $data_movimentacao = $_POST['data_movimentacao'] . " " . date("H:i:s");
    $observacao = $_POST['observacao'];

    try {
        $stmt = $conn->prepare("INSERT INTO movimentacoes (id_produto, id_usuario, tipo, quantidade, preco_unitario, data_movimentacao, observacao) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisidss", $id_produto, $id_usuario, $tipo, $quantidade, $preco_unitario, $data_movimentacao, $observacao);
        $stmt->execute();
        $mensagem = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Movimentação registrada! Estoque atualizado.</div>";
    } catch (mysqli_sql_exception $e) {
        $erro_msg = $e->getMessage();
        if (strpos($erro_msg, 'Estoque insuficiente') !== false) { $erro_msg = "Não foi possível realizar a saída: estoque insuficiente!"; }
        elseif (strpos($erro_msg, 'maior que zero') !== false) { $erro_msg = "A quantidade deve ser maior que zero."; }
        $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro: " . $erro_msg . "</div>";
    }
}
require '../includes/header.php';
?>

<div class="page-title-bar">Registrar Movimentação</div>

<div class="form-card">
    <?= $mensagem ?>
    <form action="criar.php" method="POST">
        <div class="form-group">
            <label>Produto:</label>
            <select name="id_produto" required>
                <option value="">Selecione o produto...</option>
                <?php while($p = $produtos->fetch_assoc()): ?>
                    <option value="<?= $p['id_produto'] ?>"><?= htmlspecialchars($p['nome']) ?> (Estoque: <?= $p['quantidade_estoque'] ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tipo de Movimentação:</label>
                <select name="tipo" required>
                    <option value="entrada">Entrada (Compra/Recebimento)</option>
                    <option value="saida">Saída (Venda/Perda)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Quantidade:</label>
                <input type="number" name="quantidade" required min="1" value="1">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Preço Unitário Praticado (R$):</label>
                <input type="number" name="preco_unitario" required step="0.01" min="0" placeholder="0.00">
            </div>
            <div class="form-group">
                <label>Data da Movimentação:</label>
                <input type="date" name="data_movimentacao" required value="<?= date('Y-m-d') ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Observação (Opcional):</label>
            <input type="text" name="observacao" placeholder="Ex: Venda no balcão...">
        </div>

        <button type="submit" class="btn-primary">Registrar</button>
        <a href="index.php" class="btn-secundario">Cancelar</a>
    </form>
</div>

<?php require '../includes/footer.php'; ?>