<?php
// 1. Iniciar la sesión para poder destruirla
session_start();

// 2. Vaciar el arreglo de la sesión
$_SESSION = array();

// 3. Destruir la cookie de la sesión (si existe) para que el navegador la olvide
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Destruir la sesión físicamente en el servidor
session_destroy();

// 5. Redirigir al usuario al inicio de la página
header("Location: index.php");
exit();
?>
