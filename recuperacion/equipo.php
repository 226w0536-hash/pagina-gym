<?php
// Mismo arreglo que usas en index.php
$equipo_completo = [
    ["nombre" => "DAVID SOSA", "desc" => "Entrenador profesional", "img" => "img/david.jpg"],
    ["nombre" => "MARIA JUANA", "desc" => "Entrenadora entusiasta", "img" => "img/maria.jpg"],
    // ... agrega el resto de tus 8+ integrantes aquí
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuestro Equipo - Ejercicio Mexicano</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos específicos para la nueva página */
        body { 
            background: linear-gradient(135deg, #1a0b2e 0%, #001f3f 100%); 
            color: white; 
            min-height: 100vh;
        }
        .header-equipo { padding: 50px; text-align: center; }
        .contenedor-full-equipo { 
            display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; padding: 40px; 
        }
        .card-profesional { 
            background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);
            padding: 20px; border-radius: 20px; text-align: center; width: 250px;
            border: 1px solid rgba(255,255,255,0.2);
        }
    </style>
</head>
<body>
    <div class="header-equipo">
        <h1>NUESTRO STAFF COMPLETO</h1>
        <a href="index.php" class="equipo-btn-volver">← VOLVER AL INICIO</a>
    </div>
    <div class="contenedor-full-equipo">
        <?php foreach ($equipo_completo as $persona): ?>
        <div class="card-profesional">
            <img src="<?php echo $persona['img']; ?>" style="width:100px; height:100px; border-radius:50%; border: 2px solid #ec008c;">
            <h3><?php echo $persona['nombre']; ?></h3>
            <p style="font-size: 0.8rem; opacity: 0.8;"><?php echo $persona['desc']; ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>