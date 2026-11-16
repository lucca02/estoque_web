<?php
// Pega o e-mail salvo no cookie, se existir
$email_salvo = isset($_COOKIE['estoq_lembrar']) ? $_COOKIE['estoq_lembrar'] : '';

session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: produtos/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Estoq+</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { display: flex; height: 100vh; margin: 0; background-color: white; }
        
        .left-panel { width: 50%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 40px; }
        .form-container { width: 100%; max-width: 350px; }
        
        .logo-box { display: flex; align-items: center; gap: 15px; margin-bottom: 40px; justify-content: center; }
        .logo-box img { max-height: 60px; width: auto; border-radius: 8px; }
        .logo-text { font-size: 28px; font-weight: bold; color: #073076; }
        .logo-text span { color: #159AE3; }
        
        .form-container h2 { color: #333; font-size: 20px; font-weight: normal; margin-bottom: 30px; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; color: #333; margin-bottom: 8px; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #D9D9D9; border-radius: 20px; box-sizing: border-box; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: #159AE3; }
        
        .btn-entrar { width: 100%; background-color: #073076; color: white; padding: 12px; border: none; border-radius: 20px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; transition: 0.3s; }
        .btn-entrar:hover { background-color: #159AE3; }
        
        .checkbox-group { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; font-size: 14px; color: #666; }
        
        .footer-text { margin-top: 20px; font-size: 14px; color: #666; text-align: left; }
        .footer-text a { color: #073076; font-weight: bold; text-decoration: none; }
        
        .erro { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: center; }

        .right-panel { width: 50%; background-color: white; background-image: url('img/fundo_login.png'); background-size: cover; background-position: center; }

        @media (max-width: 768px) {
            .right-panel { display: none; }
            .left-panel { width: 100%; }
        }
    </style>
</head>
<body>

<div class="left-panel">
    <div class="form-container">
        <div class="logo-box">
            <img src="img/logo_azul.png" alt="Ícone Estoq+">
            <div class="logo-text">Estoq<span>+</span></div>
        </div>

        <h2>Bem-vindo ao nosso software!</h2>
        
        <?php if (isset($_GET['erro'])): ?>
            <div class="erro">E-mail ou senha incorretos!</div>
        <?php endif; ?>

        <form action="autenticar.php" method="POST">
            <!-- AQUI ESTÁ O CAMPO DE EMAIL ÚNICO -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email_salvo) ?>">
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
            
            <div class="checkbox-group">
                <input type="checkbox" name="lembrar" id="lembrar" value="1" <?= $email_salvo ? 'checked' : '' ?>>
                <label for="lembrar" style="margin: 0; font-weight: normal;">Manter-me conectado</label>
            </div>

            <button type="submit" class="btn-entrar">Entrar</button>
        </form>
        
        <div class="footer-text">
            Não possui uma conta? <a href="cadastro.php">Registrar</a>
        </div>
    </div>
</div>

<div class="right-panel"></div>

<script>
    function toggleSenha(idInput, btn) {
        const input = document.getElementById(idInput);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>'; // Olho cortado
        } else {
            input.type = 'password';
            btn.innerHTML = '<i class="fa-solid fa-eye"></i>'; // Olho aberto
        }
    }
</script>

</body>
</html>