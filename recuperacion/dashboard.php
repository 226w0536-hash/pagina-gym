<?php
session_start();
// Asegúrate de usar la variable de sesión que definiste en login.php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Configuración de conexión
$host = getenv('MYSQLHOST');
$db   = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Ejercicio Mexicano</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="barra-navegacion">
        <div class="logo">■ PANEL DE CONTROL DE SOCIOS</div>
        <nav class="enlaces-nav">
            <a href="logout.php">CERRAR SESIÓN</a>
        </nav>
    </header>

    <main class="contenedor-principal">
        <div class="header-panel">
            <h1>PANEL DE CONTROL DE SOCIOS</h1>
        </div>

        <section class="dashboard-grid">
            
            <div class="panel-izquierdo">
                <h2>REGISTRAR SOCIO</h2>
                <form action="guardar_socio.php" method="POST">
                    <input type="text" name="nombre" placeholder="Nombre completo" required>
                    <input type="email" name="correo" placeholder="Correo electrónico" required>
                    <select name="plan" required>
                        <option value="">Selecciona un plan...</option>
                        <option value="pesas">Pesas</option>
                        <option value="yoga">Yoga</option>
                    </select>
                    <button type="submit" class="btn-guardar">GUARDAR REGISTRO</button>
                </form>
            </div>

            <div class="panel-derecho">
                <h2>REGISTROS ACTUALES</h2>
                <table class="tabla-socios">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>CORREO</th>
                            <th>PLAN</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM socios ORDER BY id DESC");
                        while ($socio = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($socio['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($socio['correo']) . "</td>";
                            echo "<td>" . htmlspecialchars($socio['plan']) . "</td>";
                            echo "<td>
                                    <button class='btn-editar'>EDITAR</button>
                                    <form action='eliminar_socio.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='" . $socio['id'] . "'>
                                        <button type='submit' class='btn-eliminar'>ELIMINAR</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
