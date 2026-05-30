<?php
// 1. Intentamos obtener las variables de entorno de Railway
$host = $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST');
$db   = $_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE');
$user = $_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER');
$pass = $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD');
$port = $_ENV['MYSQLPORT'] ?? getenv('MYSQLPORT');

$equipo_seleccionado = [];

try {
    // 2. Conexión segura usando PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    
    // 3. Consulta de los entrenadores
    $stmt = $pdo->query("SELECT nombre, descripcion AS desc, foto_url AS img FROM entrenadores");
    $equipo_seleccionado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Si falla, mostramos un mensaje o dejamos el arreglo vacío
    // En producción, es mejor solo loguear el error
    $error_bd = "No se pudo conectar a la base de datos.";
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
