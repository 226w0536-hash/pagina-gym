<?php
// Habilitar errores para depurar
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // Consulta incluyendo 'foto_tipo' para soporte multiformato
    $stmt = $pdo->query("SELECT nombre, descripcion, foto_url, foto_tipo FROM entrenadores");
    $entrenadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión a la BD: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestro Staff</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="equipo-body">
    
    <header class="equipo-header">
        <h1>NUESTRO STAFF COMPLETO</h1>
        <a href="index.php" class="equipo-btn-volver">← VOLVER AL INICIO</a>
    </header>

    <div class="equipo-contenedor">
        <?php if (!empty($entrenadores)): ?>
            <?php foreach ($entrenadores as $persona): ?>
            <div class="equipo-card">
                <img src="data:<?php echo htmlspecialchars($persona['foto_tipo']); ?>;base64,<?php echo htmlspecialchars($persona['foto_url']); ?>" alt="Foto de <?php echo htmlspecialchars($persona['nombre']); ?>">
                
                <h3><?php echo htmlspecialchars($persona['nombre']); ?></h3>
                
                <p class="equipo-descripcion">
                    <?php echo htmlspecialchars($persona['descripcion']); ?>
                </p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron integrantes en la base de datos.</p>
        <?php endif; ?>
    </div>

</body>
</html>
