<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: ../login.php"); exit(); }
require '../config/conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];

    try {
        // Tenta inserir a categoria
        $stmt = $conn->prepare("INSERT INTO categorias (nome) VALUES (?)");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        
        $mensagem = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Categoria cadastrada com sucesso!</div>";
    } catch (mysqli_sql_exception $e) {
        // Captura o erro de chave duplicada
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro: Já existe uma categoria cadastrada com este nome (" . htmlspecialchars($nome) . ").</div>";
        } else {
            $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro ao cadastrar: " . $e->getMessage() . "</div>";
        }
    }
}
require '../includes/header.php';
?>

<div class="page-title-bar">Cadastrar Categoria</div>

<div class="form-card">
    <?= $mensagem ?>
    <form action="criar.php" method="POST">
        <div class="form-group">
            <label>Nome da Categoria:</label>
            <input type="text" name="nome" required placeholder="Ex: Frutas">
        </div>
        <button type="submit" class="btn-primary">Salvar Categoria</button>
        <a href="index.php" class="btn-secundario">Cancelar</a>
    </form>
</div>

<?php require '../includes/footer.php'; ?>