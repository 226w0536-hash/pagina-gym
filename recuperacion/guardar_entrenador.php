<?php
session_start();
// 1. Proteger el archivo
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
    
    // 4. Manejo de la imagen
    $rutaDestino = ""; // Valor por defecto
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $directorio = "uploads/";
        
        // Crear carpeta si no existe
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = time() . "_" . basename($_FILES['imagen']['name']);
        $rutaDestino = $directorio . $nombreArchivo;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            throw new Exception("Error al mover el archivo de imagen.");
        }
    }

    // 5. Insertar en la base de datos
    $sql = "INSERT INTO entrenadores (nombre, descripcion, foto_url) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $rutaDestino]);

    // 6. Redireccionar
    header("Location: dashboard.php");
    exit();

} catch (Exception $e) {
    die("Error al guardar: " . $e->getMessage());
}
?>
