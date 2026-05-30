<?php
// Conexión a la base de datos usando variables de entorno de Railway
if (!getenv('MYSQLHOST')) {
    die("Error: Las variables de entorno de Railway no están llegando al código.");
}

// Verificar si PDO tiene drivers disponibles
$drivers = PDO::getAvailableDrivers();
if (!in_array('mysql', $drivers)) {
    die("Error: El driver 'mysql' no está en la lista de drivers disponibles: " . implode(", ", $drivers));
}

// Si llega aquí, es que el driver SÍ existe y el error está en otro lado
echo "El driver mysql está cargado correctamente. Intentando conectar...";

$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT');

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Traemos toda la información de la tabla
    $stmt = $pdo->query("SELECT nombre, descripcion, foto_url FROM entrenadores");
    $entrenadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión a la BD: " . $e->getMessage());
}
?>

<body class="equipo-body">
    <header class="equipo-header">
        <h1>NUESTRO STAFF COMPLETO</h1>
        <a href="index.php" class="equipo-btn-volver">← VOLVER AL INICIO</a>
    </header>

    <div class="equipo-contenedor">
        <?php if (!empty($entrenadores)): ?>
            <?php foreach ($entrenadores as $persona): ?>
            <div class="equipo-card">
                <img src="<?php echo htmlspecialchars($persona['foto_url']); ?>" alt="Foto de <?php echo htmlspecialchars($persona['nombre']); ?>">
                <h3><?php echo htmlspecialchars($persona['nombre']); ?></h3>
                <p>"<?php echo htmlspecialchars($persona['descripcion']); ?>"</p>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No se encontraron integrantes en la base de datos.</p>
        <?php endif; ?>
    </div>
</body>
