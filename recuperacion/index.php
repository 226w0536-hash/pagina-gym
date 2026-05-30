<?php
// Configuración de variables de entorno para la conexión
$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

$equipo_seleccionado = [];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    // 1. DIAGNÓSTICO: Verificar si la tabla existe
    $check_table = $pdo->query("SHOW TABLES LIKE 'entrenadores'");
    if ($check_table->rowCount() === 0) {
        die("ERROR: La tabla 'entrenadores' no existe en la base de datos '$db'.");
    }

    // 2. DIAGNÓSTICO: Verificar si hay registros
    $count = $pdo->query("SELECT COUNT(*) FROM entrenadores")->fetchColumn();
    if ($count == 0) {
        die("AVISO: La tabla 'entrenadores' existe pero está vacía (0 registros).");
    }

    // Si pasamos los tests, hacemos la consulta normal
    $stmt = $pdo->query("SELECT nombre, descripcion AS desc, foto_url AS img FROM entrenadores");
    $equipo_seleccionado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$titulo = "Ejercicio Mexicano - Inicio";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="contenedor-principal">
        <?php include 'header.php'; ?>

        <section class="seccion-equipo">
            <h2 class="titulo-seccion">NUESTRO EQUIPO</h2>
            <div class="contenedor-entrenadores">
                <?php if (!empty($equipo_seleccionado)): ?>
                    <?php foreach ($equipo_seleccionado as $persona): ?>
                    <div class="card-entrenador">
                        <img src="<?php echo htmlspecialchars($persona['img']); ?>" alt="<?php echo htmlspecialchars($persona['nombre']); ?>">
                        <div class="nombre-box"><?php echo htmlspecialchars($persona['nombre']); ?></div>
                        <p>"<?php echo htmlspecialchars($persona['desc']); ?>"</p>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Cargando equipo o base de datos no disponible.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        // ... (tu código JS de login sigue igual)
    </script>
</body>
</html>
