<?php
session_start();
if (!isset($_SESSION['usuario_id'])) { header("Location: ../login.php"); exit(); }
require '../config/conexao.php';

if (!isset($_GET['id'])) { header("Location: index.php"); exit(); }
$id = $_GET['id']; $mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $stmt = $conn->prepare("UPDATE categorias SET nome=? WHERE id_categoria=?");
    $stmt->bind_param("si", $nome, $id);
    if ($stmt->execute()) { $mensagem = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Atualizada!</div>"; } 
    else { $mensagem = "<div style='color: red; margin-bottom: 15px; font-weight: bold;'>Erro: " . $stmt->error . "</div>"; }
}

$stmt = $conn->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id); $stmt->execute();
$categoria = $stmt->get_result()->fetch_assoc();
if (!$categoria) { die("Categoria não encontrada."); }

require '../includes/header.php';
?>

<div class="page-title-bar">Editar Categoria</div>

<div class="form-card">
    <?= $mensagem ?>
    <form action="editar.php?id=<?= $id ?>" method="POST">
        <div class="form-group">
            <label>Nome da Categoria:</label>
            <input type="text" name="nome" required value="<?= htmlspecialchars($categoria['nome']) ?>">
        </div>
        <button type="submit" class="btn-primary">Atualizar Categoria</button>
        <a href="index.php" class="btn-secundario">Cancelar</a>
    </form>
</div>

<?php require '../includes/footer.php'; ?>