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

    // 3. Recibir datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // 4. Obtener datos actuales
    $stmt = $pdo->prepare("SELECT foto_url, foto_tipo FROM entrenadores WHERE id = ?");
    $stmt->execute([$id]);
    $entrenador_actual = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Valores actuales por defecto
    $imagen_a_guardar = $entrenador_actual['foto_url'];
    $tipo_a_guardar = $entrenador_actual['foto_tipo'];

    // 5. Si el usuario subió una imagen nueva, procesarla
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        
        // Detectar tipo MIME real (image/png, image/webp, etc.)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $tipo_a_guardar = $finfo->file($_FILES['imagen']['tmp_name']);

        // Convertir contenido a base64
        $datos_binarios = file_get_contents($_FILES['imagen']['tmp_name']);
        $imagen_a_guardar = base64_encode($datos_binarios);
    }

    // 6. Actualizar la base de datos (Incluyendo foto_tipo)
    $sql = "UPDATE entrenadores SET nombre = ?, descripcion = ?, foto_url = ?, foto_tipo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $imagen_a_guardar, $tipo_a_guardar, $id]);

    // 7. Redireccionar
    header("Location: dashboard.php");
    exit();

} catch (Exception $e) {
    die("Error al actualizar: " . $e->getMessage());
}
?>
