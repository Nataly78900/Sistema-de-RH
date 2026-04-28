<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $sql = "INSERT INTO areas (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        echo "Área agregada exitosamente.<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM areas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Áreas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gestión de Áreas</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="empleados.php">Empleados</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                    <li><a href="asistencias.php">Asistencias</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <h2>Agregar Área</h2>
            <form method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <input type="submit" value="Agregar Área">
            </form>
        </div>
        <div class="table-container">
            <h2>Lista de Áreas</h2>
            <table>
                <tr><th>ID</th><th>Nombre</th></tr>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr><td><?php echo $row['id']; ?></td><td><?php echo $row['nombre']; ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>