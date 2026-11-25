<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require 'config/conexao.php';
$mensagem = "";
$tipo_mensagem = "";

$id_usuario = $_SESSION['usuario_id'];

if (isset($_POST['acao']) && $_POST['acao'] == 'atualizar_dados') {
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $nome_completo = $nome . " " . $sobrenome;
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=?, telefone=? WHERE id_usuario=?");
    $stmt->bind_param("sssi", $nome_completo, $email, $telefone, $id_usuario);
    
    if ($stmt->execute()) {
        $_SESSION['usuario_nome'] = $nome_completo;
        $mensagem = "Dados atualizados com sucesso!";
        $tipo_mensagem = "sucesso";
    } else {
        $mensagem = "Erro ao atualizar dados (o e-mail pode já estar em uso).";
        $tipo_mensagem = "erro";
    }
}

if (isset($_POST['acao']) && $_POST['acao'] == 'atualizar_senha') {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];

    $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE id_usuario=?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res['senha'] === $senha_atual) {
        $stmt = $conn->prepare("UPDATE usuarios SET senha=? WHERE id_usuario=?");
        $stmt->bind_param("si", $nova_senha, $id_usuario);
        if ($stmt->execute()) {
            $mensagem = "Senha alterada com sucesso!";
            $tipo_mensagem = "sucesso";
        }
    } else {
        $mensagem = "A senha atual informada está incorreta.";
        $tipo_mensagem = "erro";
    }
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

$partes_nome = explode(' ', $usuario['nome'], 2);
$primeiro_nome = $partes_nome[0];
$sobrenome = $partes_nome[1] ?? ''; 
$saldo_ficticio = 1450.75;

require 'includes/header.php';
?>

<div class="page-title-bar">Configurações de Perfil</div>

<?php if($mensagem): ?>
    <div style="padding: 15px; margin-bottom: 20px; border-radius: 5px; font-weight: bold; background: <?= $tipo_mensagem == 'sucesso' ? '#d4edda' : '#f8d7da' ?>; color: <?= $tipo_mensagem == 'sucesso' ? '#155724' : '#721c24' ?>;">
        <?= $mensagem ?>
    </div>
<?php endif; ?>

<div style="display: flex; justify-content: space-between; background: #159AE3; color: white; padding: 20px 30px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <div>
        <span style="font-size: 12px; opacity: 0.9;">Nome Completo</span><br>
        <strong style="font-size: 16px;"><?= htmlspecialchars($usuario['nome']) ?></strong>
    </div>
    <div>
        <span style="font-size: 12px; opacity: 0.9;">E-mail</span><br>
        <strong style="font-size: 16px;"><?= htmlspecialchars($usuario['email']) ?></strong>
    </div>
    <div>
        <span style="font-size: 12px; opacity: 0.9;">Telefone</span><br>
        <strong style="font-size: 16px;"><?= htmlspecialchars($usuario['telefone'] ?? 'Não informado') ?></strong>
    </div>
    <div>
        <span style="font-size: 12px; opacity: 0.9;">Cargo</span><br>
        <strong style="font-size: 16px;"><?= htmlspecialchars($usuario['cargo']) ?></strong>
    </div>
    <div>
        <span style="font-size: 12px; opacity: 0.9;">Saldo Estimado</span><br>
        <div style="display: flex; align-items: center; gap: 10px;">
            <strong id="valor-saldo" style="font-size: 16px;">R$ <?= number_format($saldo_ficticio, 2, ',', '.') ?></strong>
            <button type="button" style="background: none; border: none; cursor: pointer; font-size: 18px; color: white;" onclick="toggleSaldo()" id="btn-olho">
                <i class="fa-solid fa-eye"></i>
            </button>
        </div>
    </div>
</div>

<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <h3 style="color: #073076; margin-bottom: 20px;">Editar Informações Básicas</h3>
    <form action="perfil.php" method="POST">
        <input type="hidden" name="acao" value="atualizar_dados">
        
        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; color: #333;">Primeiro Nome:</label>
                <input type="text" name="nome" required value="<?= htmlspecialchars($primeiro_nome) ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; color: #333;">Sobrenome:</label>
                <input type="text" name="sobrenome" value="<?= htmlspecialchars($sobrenome) ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; color: #333;">E-mail:</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($usuario['email']) ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; color: #333;">Telefone:</label>
                <input type="text" name="telefone" value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <button type="submit" class="btn-primary" style="margin-bottom: 0;">Atualizar Perfil</button>
    </form>
</div>

<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <h3 style="color: #073076; margin-bottom: 20px;">Alterar Senha</h3>
    <form action="perfil.php" method="POST">
        <input type="hidden" name="acao" value="atualizar_senha">
        
        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <label style="font-weight: bold; color: #333;">Senha Atual:</label>
                <input type="password" name="senha_atual" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; color: #333;">Nova Senha:</label>
                <input type="password" name="nova_senha" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
            </div>
        </div>

        <button type="submit" style="background-color: #ffc107; color: #333; padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer; font-weight: bold;">Alterar Senha</button>
    </form>
</div>

<script>
    let saldoVisivel = true;
    function toggleSaldo() {
        const valor = document.getElementById('valor-saldo');
        const btn = document.getElementById('btn-olho');
        if (saldoVisivel) {
            valor.innerText = '••••••';
            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            saldoVisivel = false;
        } else {
            valor.innerText = 'R$ <?= number_format($saldo_ficticio, 2, ',', '.') ?>';
            btn.innerHTML = '<i class="fa-solid fa-eye"></i>';
            saldoVisivel = true;
        }
    }
</script>

<?php require 'includes/footer.php'; ?>