<?php 
$titulo = "Ejercicio Mexicano - Inicio";

// Definición de los entrenadores (puedes añadir todos los que quieras)
$equipo_completo = [
    ["nombre" => "DAVID SOSA", "desc" => "Entrenador profesional con experiencia", "img" => "img/david.jpg"],
    ["nombre" => "MARIA JUANA", "desc" => "Entrenadora entusiasta y rigurosa", "img" => "img/maria.jpg"],
    ["nombre" => "LAURA GONZALES", "desc" => "Entrenadora estrella local", "img" => "img/laura.jpg"],
    ["nombre" => "JUAN PEREZ", "desc" => "Especialista en cardio y resistencia", "img" => "img/juan.jpg"],
    ["nombre" => "ANA RUIZ", "desc" => "Experta en nutrición deportiva", "img" => "img/ana.jpg"],
    ["nombre" => "PEDRO LÓPEZ", "desc" => "Coach de levantamiento de pesas", "img" => "img/pedro.jpg"]
];

// Lógica de aleatoriedad
shuffle($equipo_completo);
$equipo_seleccionado = array_slice($equipo_completo, 0, 6);
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

        <div id="modal-login" class="login-modal oculto">
            <div class="login-card">
                <button id="btn-cerrar" class="close-btn">×</button>
                <h2>Login Now 🔑</h2>
                <form action="login_process.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="login-btn">Log In</button>
                </form>
            </div>
        </div>

        <section class="seccion-intro">
            <div class="imagen-intro">
                <img src="img/Low-cost.jpg" alt="Ejercicio">
            </div>
            <div class="texto-intro">
                <h1>ENTRENA CON NOSOTROS</h1>
                <button class="boton-blanco-fucsia">EXPLORAR MÁS</button>
            </div>
        </section>

        <section class="seccion-equipo">
            <h2 class="titulo-seccion">NUESTRO EQUIPO</h2>
            <div class="contenedor-entrenadores">
                <?php foreach ($equipo_seleccionado as $persona): ?>
                <div class="card-entrenador">
                    <img src="<?php echo $persona['img']; ?>" alt="<?php echo $persona['nombre']; ?>">
                    <div class="nombre-box"><?php echo $persona['nombre']; ?></div>
                    <p>"<?php echo $persona['desc']; ?>"</p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script>
        const modal = document.getElementById('modal-login');
        const btnLogin = document.getElementById('btn-login');
        const btnCerrar = document.getElementById('btn-cerrar');

        if(btnLogin) {
            btnLogin.addEventListener('click', () => modal.classList.remove('oculto'));
        }
        btnCerrar.addEventListener('click', () => modal.classList.add('oculto'));
    </script>
</body>
</html>