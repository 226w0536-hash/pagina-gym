<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
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
                <h2>REGISTRAR / EDITAR SOCIO</h2>
                <form action="guardar_socio.php" method="POST">
                    <input type="text" name="nombre" placeholder="Nombre completo" required>
                    <input type="email" name="correo" placeholder="Correo electrónico" required>
                    <select name="plan">
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
                        <tr>
                            <td>Carlos Mendoza</td>
                            <td>carlos@ejemplo.com</td>
                            <td>Pesas</td>
                            <td>
                                <button class="btn-editar">EDITAR</button>
                                <button class="btn-eliminar">ELIMINAR</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>