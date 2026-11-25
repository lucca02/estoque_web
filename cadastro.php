<?php
require 'config/conexao.php';
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'] ?? '';
    $senha = $_POST['senha'];
    $cargo = $_POST['cargo'];

    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows > 0) {
        $mensagem = "<div class='erro'>Este e-mail já está cadastrado!</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, telefone, senha, cargo, ativo) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssss", $nome, $email, $telefone, $senha, $cargo);
        
        if ($stmt->execute()) {
            $mensagem = "<div style='background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: center;'>Conta criada! Redirecionando...</div>";
            header("refresh:2;url=login.php");
        } else {
            $mensagem = "<div class='erro'>Erro ao cadastrar.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Estoq+</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
        body { display: flex; min-height: 100vh; margin: 0; background-color: white; }
        
        .left-panel { 
            width: 50%; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            padding: 20px;
            overflow-y: auto;
        }
        
        .form-container { width: 100%; max-width: 350px; }
        
        .logo-box { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; /* Reduzi de 30 para 20 */ }
        .logo-icon { width: 45px; height: 45px; background-color: #073076; color: white; display: flex; justify-content: center; align-items: center; font-weight: bold; font-size: 24px; border-radius: 8px; }
        .logo-text { font-size: 28px; font-weight: bold; color: #073076; }
        .logo-text span { color: #159AE3; }
        
        .form-container h2 { color: #333; font-size: 20px; font-weight: normal; margin-bottom: 15px; /* Reduzi de 20 para 15 */ }
        
        .form-group { margin-bottom: 10px; }
        .form-group label { display: block; font-size: 14px; color: #333; margin-bottom: 4px; font-weight: 600; /* Reduzi de 5 para 4 */ }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #D9D9D9; border-radius: 20px; box-sizing: border-box; outline: none; }
        .form-group input:focus, .form-group select:focus { border-color: #159AE3; }
        
        .btn-entrar { width: 100%; background-color: #073076; color: white; padding: 10px; /* Reduzi de 12 para 10 */ border: none; border-radius: 20px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; transition: 0.3s; }
        .btn-entrar:hover { background-color: #159AE3; }
        
        .footer-text { margin-top: 15px; /* Reduzi de 20 para 15 */ font-size: 14px; color: #666; text-align: left; }
        .footer-text a { color: #073076; font-weight: bold; text-decoration: none; }
        .erro { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 10px; font-size: 14px; text-align: center; }

        .right-panel { width: 50%; background-color: white; background-image: url('img/fundo_login.png'); background-size: cover; background-position: center; }

        @media (max-width: 768px) {
            .right-panel { display: none; }
            .left-panel { width: 100%; padding: 20px; }
        }
    </style>
</head>
<body>

<div class="left-panel">
    <div class="form-container">
        <div class="logo-box" style="justify-content: center; gap: 15px; margin-bottom: 30px;">
            <img src="img/logo_azul.png" alt="Ícone Estoq+" style="max-height: 45px; width: auto; border-radius: 8px;">
            <div class="logo-text">Estoq<span>+</span></div>
        </div>

        <h2>Crie uma nova conta!</h2>
        <?= $mensagem ?>
        
        <form action="cadastro.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone">
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <div class="password-wrapper">
                    <input type="password" name="senha" id="senha" required>
                    <button type="button" class="toggle-password" onclick="toggleSenha('senha', this)">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <select name="cargo" id="cargo" required>
                    <option value="" disabled selected>Selecionar</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Estoquista">Estoquista</option>
                </select>
            </div>

            <button type="submit" class="btn-entrar">Registrar</button>
        </form>
        
        <div class="footer-text">
            Já tem uma conta? <a href="login.php">Entrar</a>
        </div>
    </div>
</div>

<div class="right-panel"></div>

<script>
    function toggleSenha(idInput, btn) {
        const input = document.getElementById(idInput);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
        }
    }
</script>

</body>
</html>