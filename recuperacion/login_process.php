<?php
session_start();
// Aquí podrías validar contra una BD. Por ahora, validación simple:
if ($_POST['username'] == 'admin' && $_POST['password'] == '1234') {
    $_SESSION['usuario'] = $_POST['username'];
    header("Location: dashboard.php"); // Redirige a la nueva interfaz
    exit();
} else {
    echo "Credenciales incorrectas. <a href='index.php'>Volver</a>";
}
?>