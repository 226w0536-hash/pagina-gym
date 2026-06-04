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

    // 4. Obtener la ruta de la imagen actual antes de hacer nada
    $stmt = $pdo->prepare("SELECT foto_url FROM entrenadores WHERE id = ?");
    $stmt->execute([$id]);
    $entrenador_actual = $stmt->fetch(PDO::FETCH_ASSOC);
    $ruta_foto = $entrenador_actual['foto_url'];

    // 5. Si el usuario subió una imagen nueva, procesarla
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        // Borrar la imagen vieja del servidor si existe
        if (!empty($ruta_foto) && file_exists($ruta_foto)) {
            unlink($ruta_foto);
        }

        // Subir la nueva imagen
        $directorio = "uploads/";
        $nombreArchivo = time() . "_" . basename($_FILES['imagen']['name']);
        $ruta_foto = $directorio . $nombreArchivo;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_foto);
    }

    // 6. Actualizar la base de datos
    $sql = "UPDATE entrenadores SET nombre = ?, descripcion = ?, foto_url = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $ruta_foto, $id]);

    // 7. Redireccionar
    header("Location: dashboard.php");
    exit();

} catch (PDOException $e) {
    die("Error al actualizar: " . $e->getMessage());
}
?>
