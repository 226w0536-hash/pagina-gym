<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') { header("Location: index.php"); exit(); }

$id = $_GET['id'];
$host = getenv('MYSQLHOST'); $db = getenv('MYSQLDATABASE'); $user = getenv('MYSQLUSER'); $pass = getenv('MYSQLPASSWORD'); $port = getenv('MYSQLPORT') ?: '3306';
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);

$stmt = $pdo->prepare("SELECT * FROM entrenadores WHERE id = ?");
$stmt->execute([$id]);
$entrenador = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<form action="actualizar_entrenador.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $entrenador['id']; ?>">
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($entrenador['nombre']); ?>" required>
    <textarea name="descripcion"><?php echo htmlspecialchars($entrenador['descripcion']); ?></textarea>
    <input type="file" name="imagen">
    <p>Imagen actual: <img src="<?php echo $entrenador['foto_url']; ?>" width="50"></p>
    <button type="submit">Actualizar</button>
</form>
