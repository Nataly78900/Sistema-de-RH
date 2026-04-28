<?php
require 'db.php';
$message = '';
$message_class = 'success';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_area') {
    $area_nombre = trim($_POST['area_nombre']);
    if ($area_nombre !== '') {
        $sql = "INSERT INTO areas (nombre) VALUES ('$area_nombre')";
        if ($conn->query($sql) === TRUE) {
            $message = 'Área agregada exitosamente.';
        } else {
            $message_class = 'error';
            $message = 'Error: ' . $conn->error;
        }
    } else {
        $message_class = 'error';
        $message = 'Ingrese el nombre del área.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $area_id = $_POST['area_id'];
    if ($area_id === 'add') {
            $message_class = 'error';
        $message = 'Selecciona un área válida o agrega una nueva área primero.';
    } else {
        $sql = "INSERT INTO empleados (nombre, apellido, area_id) VALUES ('$nombre', '$apellido', '$area_id')";
        if ($conn->query($sql) === TRUE) {
            $message = 'Empleado agregado exitosamente.';
        } else {
                $message_class = 'error';
            $message = 'Error: ' . $conn->error;
        }
    }
}

$areas = $conn->query("SELECT * FROM areas");
$result = $conn->query("SELECT e.id, e.nombre, e.apellido, a.nombre as area FROM empleados e LEFT JOIN areas a ON e.area_id = a.id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empleados</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gestión de Empleados</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="areas.php">Áreas</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                    <li><a href="asistencias.php">Asistencias</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="form-container">
            <h2>Agregar Empleado</h2>
            <?php if (!empty($message)) { ?>
            <p class="<?php echo $message_class; ?>"><?php echo $message; ?></p>
            <?php } ?>
            <form method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
                <label for="area_id">Área:</label>
                <select id="area_id" name="area_id" required>
                    <option value="">Seleccionar Área</option>
                    <option value="add">Agregar nueva área</option>
                    <?php while($row = $areas->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php } ?>
                </select>
                <input type="submit" value="Agregar Empleado">
            </form>
            <form method="post" id="areaForm" style="display:none; margin-top:20px;">
                <input type="hidden" name="action" value="add_area">
                <label for="area_nombre">Nueva Área:</label>
                <input type="text" id="area_nombre" name="area_nombre" required>
                <input type="submit" value="Guardar Área">
            </form>
        </div>
        <div class="table-container">
            <h2>Lista de Empleados</h2>
            <table>
                <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Área</th></tr>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr><td><?php echo $row['id']; ?></td><td><?php echo $row['nombre']; ?></td><td><?php echo $row['apellido']; ?></td><td><?php echo $row['area']; ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('area_id').addEventListener('change', function() {
            var areaForm = document.getElementById('areaForm');
            if (this.value === 'add') {
                areaForm.style.display = 'block';
            } else {
                areaForm.style.display = 'none';
            }
        });
    </script>
</body>
</html>