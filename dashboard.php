<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$tareas = json_decode(file_get_contents('data/tareas.json'), true) ?? [];

// Procesar el formulario solo si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva = [
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion']
    ];
    $tareas[] = $nueva;
    file_put_contents('data/tareas.json', json_encode($tareas, JSON_PRETTY_PRINT));
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de tareas</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
    <a href="logout.php">Cerrar sesión</a>

    <h2>Agregar tarea</h2>
    <form id="formTarea" method="post" action="dashboard.php">
        <input type="text" name="titulo" placeholder="Título" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <button type="submit">Guardar</button>
    </form>

    <h2>Lista de tareas</h2>
    <ul>
        <?php foreach ($tareas as $tarea): ?>
            <li><strong><?= htmlspecialchars($tarea['titulo']) ?>:</strong> <?= htmlspecialchars($tarea['descripcion']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>