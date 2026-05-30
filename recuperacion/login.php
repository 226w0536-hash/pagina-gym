<?php
session_start();

// Configuración de conexión (Asegúrate de que tus variables de entorno estén bien cargadas)
$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Recibir datos del formulario
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Consulta al usuario
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // --- BLOQUE DE DIAGNÓSTICO ---
    if (!$usuario) {
        die("DEBUG: No se encontró ningún usuario con el correo: " . htmlspecialchars($email));
    }

    // Verificar contraseña (usando el hash que ya tienes en la base de datos)
    if (password_verify($password, $usuario['password_hash'])) {
        
        // Asignación de variables de sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['usuario'] = $usuario['correo']; // Requisito para tu dashboard
        
        // Redirección por rol
        if ($usuario['rol'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
        
    } else {
        die("DEBUG: El correo existe, pero la contraseña no coincide. Intentaste con: " . htmlspecialchars($password));
    }

} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
