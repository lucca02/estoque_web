<?php
// Descobre qual é a página atual para marcar no menu
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estoq+ | Gestão de Estoque</title>
    <!-- Caminho absoluto para o CSS -->
    <link rel="stylesheet" href="/estoque_web/css/style.css">
    <!-- Biblioteca de Ícones FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Menu Lateral (Sidebar) -->
    <nav class="sidebar">
        <div class="sidebar-logo" style="gap: 10px;">
            <img src="/estoque_web/img/logo.png" alt="Ícone Estoq+" style="max-height: 35px; width: auto;">
            <h2 style="color: white; margin: 0; font-size: 24px;">Estoq<span style="color: #159AE3;">+</span></h2>
        </div>
        
        <div class="sidebar-menu">
            <a href="/estoque_web/produtos/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'produtos') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-box" style="margin-right: 10px;"></i> Produtos
            </a>
            <a href="/estoque_web/categorias/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'categorias') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-tags" style="margin-right: 10px;"></i> Categorias
            </a>
            <a href="/estoque_web/movimentacoes/index.php" class="<?= strpos($_SERVER['PHP_SELF'], 'movimentacoes') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-arrow-right-arrow-left" style="margin-right: 10px;"></i> Movimentações
            </a>
            <a href="/estoque_web/perfil.php" class="<?= strpos($_SERVER['PHP_SELF'], 'perfil.php') !== false ? 'active' : '' ?>">
                <i class="fa-solid fa-user" style="margin-right: 10px;"></i> Meu Perfil
            </a>
        </div>

        <div class="sidebar-footer">
            <a href="/estoque_web/logout.php" style="color: #ff6b6b; text-decoration: none; transition: 0.2s;" onmouseover="this.style.fontWeight='bold'" onmouseout="this.style.fontWeight='normal'" onclick="return confirm('Tem certeza que deseja sair da sua conta?');">
                <i class="fa-solid fa-right-from-bracket" style="margin-right: 10px;"></i> Sair do Sistema
            </a>
        </div>
    </nav>

    <!-- Área Principal -->
    <main class="main-content">
        <!-- Topbar (Header) -->
        <header class="topbar">
            <div class="topbar-welcome">
                <h1>Olá, <?= explode(' ', $_SESSION['usuario_nome'])[0] ?>!</h1>
                <p>Sessão de Gerenciamento</p>
            </div>
            
            <div class="topbar-user">
                <div class="user-info">
                    <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>
                    <span><?= htmlspecialchars($_SESSION['usuario_cargo']) ?></span>
                </div>
                <div class="user-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>
        
        <!-- O conteúdo da página começa aqui -->
        <div class="page-content">