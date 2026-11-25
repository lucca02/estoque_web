<?php
session_start();
require 'config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id_usuario, nome, cargo FROM usuarios WHERE email = ? AND senha = ? AND ativo = 1");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $dados_usuario = $resultado->fetch_assoc();
        
        $_SESSION['usuario_id'] = $dados_usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $dados_usuario['nome'];
        $_SESSION['usuario_cargo'] = $dados_usuario['cargo'];

        if (isset($_POST['lembrar']) && $_POST['lembrar'] == '1') {
            setcookie('estoq_lembrar', $email, time() + (86400 * 30), "/");
        } else {
            setcookie('estoq_lembrar', '', time() - 3600, "/");
        }

        header("Location: produtos/index.php");
        exit();
    } else {
        header("Location: login.php?erro=1");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>