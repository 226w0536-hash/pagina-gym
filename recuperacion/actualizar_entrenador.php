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

    // 4. Obtener el valor actual de foto_url (que ahora será texto base64)
    $stmt = $pdo->prepare("SELECT foto_url FROM entrenadores WHERE id = ?");
    $stmt->execute([$id]);
    $entrenador_actual = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si no se sube imagen, mantenemos lo que ya hay en la BD
    $imagen_a_guardar = $entrenador_actual['foto_url'];

    // 5. Si el usuario subió una imagen nueva, procesarla a Base64
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        
        // Leemos el contenido binario y lo convertimos a base64
        $datos_binarios = file_get_contents($_FILES['imagen']['tmp_name']);
        $imagen_a_guardar = base64_encode($datos_binarios);
    }

    // 6. Actualizar la base de datos
    // Nota: foto_url ahora guarda una cadena de texto gigante (Base64)
    $sql = "UPDATE entrenadores SET nombre = ?, descripcion = ?, foto_url = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $imagen_a_guardar, $id]);

    // 7. Redireccionar
    header("Location: dashboard.php");
    exit();

} catch (PDOException $e) {
    die("Error al actualizar: " . $e->getMessage());
}
?>
