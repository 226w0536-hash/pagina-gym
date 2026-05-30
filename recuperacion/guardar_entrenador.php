<?php
session_start();
// 1. Proteger el archivo: solo admins pueden guardar
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// 2. Conexión a la base de datos
$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 3. Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $foto_url = $_POST['foto_url'];

    // 4. Insertar en la base de datos
    $sql = "INSERT INTO entrenadores (nombre, descripcion, foto_url) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $foto_url]);

    // 5. Redireccionar de vuelta al dashboard
    header("Location: dashboard.php");
    exit();

} catch (PDOException $e) {
    die("Error al guardar: " . $e->getMessage());
}
?>
