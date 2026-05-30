<?php
session_start();
// Validación de rol
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

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
    <title>Panel de Control - Entrenadores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="barra-navegacion">
        <div class="logo">■ PANEL DE CONTROL: ENTRENADORES</div>
        <nav class="enlaces-nav">
            <a href="logout.php">CERRAR SESIÓN</a>
        </nav>
    </header>

    <main class="contenedor-principal">
        <div class="header-panel">
            <h1>ADMINISTRACIÓN DE ENTRENADORES</h1>
        </div>

        <section class="dashboard-grid">
            
            <div class="panel-izquierdo">
                <h2>REGISTRAR ENTRENADOR</h2>
                <form action="guardar_entrenador.php" method="POST">
                    <input type="text" name="nombre" placeholder="Nombre completo" required>
                    <input type="text" name="descripcion" placeholder="Descripción breve" required>
                    <input type="url" name="foto_url" placeholder="URL de la imagen" required>
                    <button type="submit" class="btn-guardar">GUARDAR REGISTRO</button>
                </form>
            </div>

            <div class="panel-derecho">
                <h2>REGISTROS ACTUALES</h2>
                <table class="tabla-socios">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta ajustada a los campos de la tabla entrenadores
                        $stmt = $pdo->query("SELECT * FROM entrenadores ORDER BY id DESC");
                        while ($entrenador = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($entrenador['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($entrenador['descripcion']) . "</td>";
                            echo "<td>
                                    <button class='btn-editar'>EDITAR</button>
                                    <form action='eliminar_entrenador.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='" . $entrenador['id'] . "'>
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
