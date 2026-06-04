<?php
session_start();
// Configuración de variables de entorno
$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

$equipo_seleccionado = [];

try {
    // Conexión a la base de datos
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    // Consulta corregida: cambiamos 'AS desc' por 'AS descripcion_corta'
    $stmt = $pdo->query("SELECT nombre, descripcion AS descripcion_corta, foto_url AS img FROM entrenadores");
    $equipo_seleccionado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
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
                        <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($persona['img']); ?>" alt="<?php echo htmlspecialchars($persona['nombre']); ?>">
                        <div class="nombre-box"><?php echo htmlspecialchars($persona['nombre']); ?></div>
                        <p>"<?php echo htmlspecialchars($persona['descripcion_corta']); ?>"</p>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Cargando equipo o base de datos no disponible.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        // ... (tu código JS de login)
    </script>
</body>
</html>
