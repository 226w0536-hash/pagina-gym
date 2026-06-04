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
    
    // Consulta incluyendo foto_tipo para soporte multiformato
    $stmt = $pdo->query("SELECT nombre, descripcion AS descripcion_corta, foto_url AS img, foto_tipo FROM entrenadores");
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

        <section class="seccion-intro">
            <div class="imagen-intro">
                <img src="/img/Low-cost.jpg" alt="Bienvenidos a Ejercicio Mexicano">
            </div>
            <div class="texto-intro">
                <h2>BIENVENIDOS A EJERCICIO MEXICANO</h2>
                <p>Tu meta es nuestro objetivo. Entrena con los mejores.</p>
                <a href="equipo.php" style="text-decoration: none;">
                <button class="boton-blanco-fucsia">SABER MÁS</button>
                </a>    
            </div>
        </section>

        <section class="seccion-equipo">
            <h2 class="titulo-seccion">NUESTRO EQUIPO</h2>
            <div class="contenedor-entrenadores">
                <?php if (!empty($equipo_seleccionado)): ?>
                    <?php foreach ($equipo_seleccionado as $persona): ?>
                    <div class="card-entrenador">
                        <img src="data:<?php echo htmlspecialchars($persona['foto_tipo']); ?>;base64,<?php echo htmlspecialchars($persona['img']); ?>" alt="<?php echo htmlspecialchars($persona['nombre']); ?>">
                        
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
        // Lógica para cerrar el modal haciendo clic fuera de él o mediante el checkbox
        // Si necesitas agregar la funcionalidad del checkbox, asegúrate de que el ID sea correcto
    </script>
</body>
</html>
