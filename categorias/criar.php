<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: ../login.php"); exit(); }
require '../config/conexao.php';
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $stmt = $conn->prepare("INSERT INTO categorias (nome) VALUES (?)");
    $stmt->bind_param("s", $nome);
    if ($stmt->execute()) { $mensagem = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Categoria cadastrada!</div>"; } 
    else { $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro: Categoria já existe.</div>"; }
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