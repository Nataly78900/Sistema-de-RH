<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $fecha = $_POST['fecha'];
    $sql = "INSERT INTO reportes (titulo, contenido, fecha) VALUES ('$titulo', '$contenido', '$fecha')";
    if ($conn->query($sql) === TRUE) {
        echo "Reporte agregado exitosamente.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM reportes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gestión de Reportes</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="areas.php">Áreas</a></li>
                    <li><a href="empleados.php">Empleados</a></li>
                    <li><a href="asistencias.php">Asistencias</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <h2>Agregar Reporte</h2>
            <form method="post">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" required></textarea>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
                <input type="submit" value="Agregar Reporte">
            </form>
        </div>
        <div class="table-container">
            <h2>Lista de Reportes</h2>
            <table>
                <tr><th>ID</th><th>Título</th><th>Contenido</th><th>Fecha</th></tr>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr><td><?php echo $row['id']; ?></td><td><?php echo $row['titulo']; ?></td><td><?php echo $row['contenido']; ?></td><td><?php echo $row['fecha']; ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>