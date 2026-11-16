<?php
session_start();
require 'config/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta
    $stmt = $conn->prepare("SELECT id_usuario, nome, cargo FROM usuarios WHERE email = ? AND senha = ? AND ativo = 1");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        // Login deu certo! Guarda os dados em uma variável
        $dados_usuario = $resultado->fetch_assoc();
        
        // Salva os dados do usuário na sessão
        $_SESSION['usuario_id'] = $dados_usuario['id_usuario'];
        $_SESSION['usuario_nome'] = $dados_usuario['nome'];
        $_SESSION['usuario_cargo'] = $dados_usuario['cargo'];

        // Lógica do "Manter-me conectado"
        if (isset($_POST['lembrar']) && $_POST['lembrar'] == '1') {
            // Cria um cookie de 30 dias com o e-mail
            setcookie('estoq_lembrar', $email, time() + (86400 * 30), "/");
        } else {
            // Se não marcou, apaga o cookie antigo se ele existir
            setcookie('estoq_lembrar', '', time() - 3600, "/");
        }

        // Redireciona para o sistema
        header("Location: produtos/index.php");
        exit();
    } else {
        // Login falhou
        header("Location: login.php?erro=1");
        exit();
    }
} else {
    // Se tentarem acessar esse arquivo sem ser pelo formulário
    header("Location: login.php");
    exit();
}
?>