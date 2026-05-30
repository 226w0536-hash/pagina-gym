<input type="checkbox" id="check-login" class="oculto">

<header class="barra-navegacion">
    <div class="logo">■ EJERCICIO MEXICANO</div>
    <nav class="enlaces-nav">
        <a href="index.php">INICIO</a>
        <a href="equipo.php">NOSOTROS</a>
        <a href="#">PRODUCTOS</a>
        <label for="check-login" class="btn-nav-login" style="cursor: pointer;">INICIAR SESIÓN</label>
    </nav>
</header>

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
