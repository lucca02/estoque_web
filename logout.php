<?php
session_start();
session_unset();
session_destroy();
setcookie('estoq_lembrar', '', time() - 3600, "/");
header("Location: login.php");
exit();
?>