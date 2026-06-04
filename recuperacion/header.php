<?php
// Aseguramos que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<input type="checkbox" id="check-login" class="oculto">

<header class="barra-navegacion">
    <div class="logo">■ EJERCICIO MEXICANO</div>
    <nav class="enlaces-nav">
        <a href="index.php">INICIO</a>
        <a href="equipo.php">NOSOTROS</a>
       

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
            <a href="dashboard.php" class="btn-nav">PANEL</a>
            <a href="logout.php" class="btn-nav">CERRAR SESIÓN</a>
        <?php else: ?>
            <label for="check-login" class="btn-nav-login" style="cursor: pointer;">INICIAR SESIÓN</label>
        <?php endif; ?>
    </nav>
</header>

<?php if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin'): ?>
<div class="login-modal oculto" id="modal-login">
    <div class="login-card">
        <label for="check-login" class="close-btn" style="cursor: pointer;">&times;</label>
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" class="login-btn">ENTRAR</button>
        </form>
    </div>
</div>
<?php endif; ?>
