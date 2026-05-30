<?php
session_start();
// 1. Proteger el archivo: solo admins pueden eliminar
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

    // 3. Verificar que recibimos el ID
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // 4. Eliminar el registro
        $stmt = $pdo->prepare("DELETE FROM entrenadores WHERE id = ?");
        $stmt->execute([$id]);
    }

    // 5. Regresar al dashboard
    header("Location: dashboard.php");
    exit();

} catch (PDOException $e) {
    die("Error al eliminar: " . $e->getMessage());
}
?>
