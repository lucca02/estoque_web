<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

require '../config/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM produtos WHERE id_produto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        header("Location: index.php");
        exit();

    } catch (mysqli_sql_exception $e) {
        echo "<script>
                alert('Não é possível excluir este produto, pois ele possui movimentações de estoque registradas!');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>