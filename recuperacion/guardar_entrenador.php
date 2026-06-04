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
    
    // Inicializar variables para la base de datos
    $imagen_base64 = "";
    $tipo_archivo = "image/jpeg"; // Valor por defecto

    // 4. Manejo de la imagen a Base64
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        
        // Detectar el tipo MIME real (image/png, image/webp, image/avif, etc)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $tipo_archivo = $finfo->file($_FILES['imagen']['tmp_name']);

        // Convertir el contenido a base64
        $datos_binarios = file_get_contents($_FILES['imagen']['tmp_name']);
        $imagen_base64 = base64_encode($datos_binarios);
    }

    // 5. Insertar en la base de datos
    // Ahora guardamos foto_url (base64) y foto_tipo
    $sql = "INSERT INTO entrenadores (nombre, descripcion, foto_url, foto_tipo) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $imagen_base64, $tipo_archivo]);

    // 6. Redireccionar
    header("Location: dashboard.php");
    exit();

} catch (Exception $e) {
    die("Error al guardar: " . $e->getMessage());
}
?>
