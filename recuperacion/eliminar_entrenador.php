<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // 1. Obtener la ruta de la imagen antes de eliminar el registro
        $stmt = $pdo->prepare("SELECT foto_url FROM entrenadores WHERE id = ?");
        $stmt->execute([$id]);
        $entrenador = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($entrenador && !empty($entrenador['foto_url'])) {
            // 2. Borrar el archivo físico si existe
            if (file_exists($entrenador['foto_url'])) {
                unlink($entrenador['foto_url']);
            }
        }

        // 3. Eliminar el registro de la base de datos
        $stmt = $pdo->prepare("DELETE FROM entrenadores WHERE id = ?");
        $stmt->execute([$id]);
    }

    header("Location: dashboard.php");
    exit();

} catch (PDOException $e) {
    die("Error al eliminar: " . $e->getMessage());
}
?>
