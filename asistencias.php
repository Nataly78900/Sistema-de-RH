<?php
require 'db.php';

$message = '';
$last_empleado = '--';
$last_fecha = '--';
$last_entrada = '--';
$last_salida = '--';
$last_estatus = 'A tiempo';

function parseTimeAmPm($time) {
    if ($time === '' || $time === null) {
        return null;
    }
    $time = trim($time);
    if (!preg_match('/^(0[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9] (AM|PM)$/i', $time, $matches)) {
        return false;
    }
    $parts = explode(' ', $time);
    list($hour, $minute, $second) = explode(':', $parts[0]);
    $ampm = strtoupper($parts[1]);
    $hour = (int) $hour;
    if ($ampm === 'PM' && $hour !== 12) {
        $hour += 12;
    }
    if ($ampm === 'AM' && $hour === 12) {
        $hour = 0;
    }
    return sprintf('%02d:%02d:%02d', $hour, $minute, $second);
}

function formatTimeAmPm($time) {
    if ($time === null || $time === '') {
        return '--';
    }
    $date = DateTime::createFromFormat('H:i:s', $time);
    if (!$date) {
        return $time;
    }
    return $date->format('h:i:s A');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_employee') {
    $nombre = trim($_POST['emp_nombre']);
    $apellido = trim($_POST['emp_apellido']);
    $area_id = (int) $_POST['emp_area_id'];
    if ($nombre !== '' && $apellido !== '') {
        $sql = "INSERT INTO empleados (nombre, apellido, area_id) VALUES ('$nombre', '$apellido', '$area_id')";
        $conn->query($sql);
        header('Location: asistencias.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['action']) || $_POST['action'] !== 'add_employee')) {
    $attendance_id = isset($_POST['attendance_id']) && trim($_POST['attendance_id']) !== '' ? (int) $_POST['attendance_id'] : null;
    $fecha = $_POST['fecha'];
    $estatus = $_POST['estatus'];
    $hora_entrada = isset($_POST['hora_entrada']) ? parseTimeAmPm($_POST['hora_entrada']) : null;
    $hora_salida = isset($_POST['hora_salida']) ? parseTimeAmPm($_POST['hora_salida']) : null;
    $empleado_id = (int) $_POST['empleado_id'];

    if ($hora_entrada === false || ($hora_salida === false && trim($_POST['hora_salida']) !== '')) {
        $message = 'El formato de hora debe ser HH:MM:SS AM/PM.';
    } else {
        if ($hora_entrada !== null && ($hora_entrada < '09:00:00' || $hora_entrada > '17:00:00')) {
            $message = 'La hora de entrada debe estar entre 09:00:00 AM y 05:00:00 PM.';
        } elseif ($hora_salida !== null && ($hora_salida < '09:00:00' || $hora_salida > '17:00:00')) {
            $message = 'La hora de salida debe estar entre 09:00:00 AM y 05:00:00 PM.';
        } else {
            if ($attendance_id === null) {
                $whereEntrada = $hora_entrada === null ? 'AND hora_entrada IS NULL' : "AND hora_entrada = '$hora_entrada'";
                $whereSalida = $hora_salida === null ? 'AND hora_salida IS NULL' : "AND hora_salida = '$hora_salida'";
                $check = $conn->query("SELECT id_asistencia FROM asistencias WHERE empleado_id = $empleado_id AND fecha = '$fecha' $whereEntrada $whereSalida");
                if ($check->num_rows > 0) {
                    $message = 'Este registro ya existe y no puede guardarse duplicado.';
                } else {
                    $sql = "INSERT INTO asistencias (fecha, estatus, hora_entrada, hora_salida, empleado_id) VALUES ('$fecha', '$estatus', " . ($hora_entrada === null ? 'NULL' : "'$hora_entrada'") . ", " . ($hora_salida === null ? 'NULL' : "'$hora_salida'") . ", $empleado_id)";
                    if ($conn->query($sql) === TRUE) {
                        $message = 'Asistencia guardada correctamente.';
                    } else {
                        $message = 'Error al guardar asistencia: ' . $conn->error;
                    }
                }
            } else {
                $sql = "UPDATE asistencias SET fecha = '$fecha', estatus = '$estatus', hora_entrada = " . ($hora_entrada === null ? 'NULL' : "'$hora_entrada'") . ", hora_salida = " . ($hora_salida === null ? 'NULL' : "'$hora_salida'") . ", empleado_id = $empleado_id WHERE id_asistencia = $attendance_id";
                if ($conn->query($sql) === TRUE) {
                    $message = 'Registro actualizado correctamente.';
                } else {
                    $message = 'Error al actualizar asistencia: ' . $conn->error;
                }
            }
            if (strpos($message, 'Error') === false) {
                $emp_query = $conn->query("SELECT nombre, apellido FROM empleados WHERE id = $empleado_id");
                $emp = $emp_query->fetch_assoc();
                $last_empleado = $emp['nombre'] . ' ' . $emp['apellido'];
                $last_fecha = $fecha;
                $last_entrada = trim($_POST['hora_entrada']) !== '' ? $_POST['hora_entrada'] : '--';
                $last_salida = trim($_POST['hora_salida']) !== '' ? $_POST['hora_salida'] : '--';
                $last_estatus = $estatus;
            }
        }
    }
}

$areas = $conn->query("SELECT * FROM areas");
$empleados = $conn->query("SELECT id, nombre, apellido FROM empleados");
$result = $conn->query("SELECT a.id_asistencia, a.fecha, a.estatus, a.hora_entrada, a.hora_salida, a.empleado_id, e.nombre, e.apellido FROM asistencias a JOIN empleados e ON a.empleado_id = e.id ORDER BY a.fecha DESC, a.hora_entrada DESC");
$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Asistencias</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #1e2a38, #dfe3ea);
}

.header {
    background: linear-gradient(135deg, #2c4a7a, #8fa9d6);
    color: white;
    padding: 25px;
    font-size: 28px;
    font-weight: bold;
}

.container {
    padding: 25px;
}

.cards {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    background: #f8f9fb;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.card-title {
    font-size: 13px;
    color: #6c757d;
}

.card-value {
    font-weight: bold;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.icon {
    color: #3b5998;
}

.form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.form input, .form select {
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
    min-width: 180px;
}

.cards .card input,
.cards .card select,
.cards .card button {
    width: 100%;
}

.cards .card .card-value {
    flex-direction: column;
    align-items: stretch;
}

.cards .card small {
    margin-top: 6px;
    color: #6c757d;
    font-size: 12px;
}

.form button {
    background: #2c4a7a;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
}

.form button:hover {
    background: #1f3a5b;
}

.table-container {
    background: #f8f9fb;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: linear-gradient(135deg, #2c4a7a, #5c7bc2);
    color: white;
    padding: 10px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.badge {
    padding: 5px 12px;
    border-radius: 20px;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.verde { background: #28a745; }
.naranja { background: #f39c12; }
.rojo { background: #e74c3c; }
.azul { background: #17a2b8; }

.top-bar {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-bottom: 10px;
}

.clickable-row {
    cursor: pointer;
}

.clickable-row:hover {
    background: rgba(44, 74, 122, 0.08);
}

.message {
    margin-bottom: 15px;
    padding: 10px 15px;
    border-radius: 8px;
}

.message.success { background: #d4edda; color: #155724; }
.message.error { background: #f8d7da; color: #721c24; }
</style>
</head>
<body>

<div class="header">Asistencias</div>

<div class="container">

<?php if ($message !== '') { ?>
    <div class="message <?php echo strpos($message, 'Error') === 0 ? 'error' : 'success'; ?>"><?php echo $message; ?></div>
<?php } ?>

<form method="post" id="attendanceForm" class="form">
    <input type="hidden" name="attendance_id" id="attendance_id" value="">
    <div class="cards">
        <div class="card">
            <div class="card-title">Empleado</div>
            <div class="card-value">
                <i class="fas fa-user icon"></i>
                <select id="empleado_id" name="empleado_id" required>
                    <option value="">Seleccione empleado</option>
                    <?php while ($row = $empleados->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="card">
            <div class="card-title">Fecha</div>
            <div class="card-value">
                <i class="fas fa-calendar icon"></i>
                <input id="fecha" type="date" name="fecha" required onchange="updateFechaDia()">
                <small id="fechaDia"></small>
            </div>
        </div>
        <div class="card">
            <div class="card-title">Hora de Entrada</div>
            <div class="card-value">
                <i class="fas fa-clock icon"></i>
                <input id="hora_entrada" type="text" name="hora_entrada" placeholder="08:00:00 AM (opcional)" pattern="^(|(?:0[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9] (AM|PM))$">
                <small>Puedes dejarla vacía y completar la entrada más tarde.</small>
            </div>
        </div>
        <div class="card">
            <div class="card-title">Hora de Salida</div>
            <div class="card-value">
                <i class="fas fa-clock icon"></i>
                <input id="hora_salida" type="text" name="hora_salida" placeholder="05:30:00 PM">
                <small>Puedes dejarla vacía y completarla después.</small>
            </div>
        </div>
        <div class="card">
            <div class="card-title">Estatus</div>
            <div class="card-value">
                <i class="fas fa-check-circle icon"></i>
                <select id="estatus" name="estatus" required>
                    <option value="A tiempo">A tiempo</option>
                    <option value="Retardo">Retardo</option>
                    <option value="Ausente">Ausente</option>
                    <option value="Salida Temprana">Salida Temprana</option>
                </select>
            </div>
        </div>
        <div class="card card-submit">
            <div class="card-title">Guardar</div>
            <div class="card-value">
                <button id="saveButton" type="submit">Agregar</button>
            </div>
        </div>
    </div>
</form>

<div class="top-bar">
    <input type="text" id="buscar" placeholder="Buscar..." onkeyup="filtrar()">
</div>

<div class="table-container">
    <h3>Registro de Asistencias</h3>
    <table id="tabla">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $row) {
                $color = 'verde';
                if ($row['estatus'] === 'Retardo') $color = 'naranja';
                if ($row['estatus'] === 'Ausente') $color = 'rojo';
                if ($row['estatus'] === 'Salida Temprana') $color = 'azul';
            ?>
            <tr class="clickable-row" onclick="loadAttendanceRecord(this)"
                data-recordid="<?php echo $row['id_asistencia']; ?>"
                data-empid="<?php echo $row['empleado_id']; ?>"
                data-fecha="<?php echo $row['fecha']; ?>"
                data-entrada="<?php echo $row['hora_entrada'] ? formatTimeAmPm($row['hora_entrada']) : ''; ?>"
                data-salida="<?php echo $row['hora_salida'] ? formatTimeAmPm($row['hora_salida']) : ''; ?>"
                data-estatus="<?php echo $row['estatus']; ?>">
                <td><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['hora_entrada'] ? formatTimeAmPm($row['hora_entrada']) : '--'; ?></td>
                <td><?php echo $row['hora_salida'] ? formatTimeAmPm($row['hora_salida']) : '--'; ?></td>
                <td><span class="badge <?php echo $color; ?>"><?php echo $row['estatus']; ?></span></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</div>

<script>
function filtrar() {
    let input = document.getElementById('buscar').value.toLowerCase();
    let filas = document.querySelectorAll('#tabla tbody tr');
    filas.forEach(fila => {
        let texto = fila.innerText.toLowerCase();
        fila.style.display = texto.includes(input) ? '' : 'none';
    });
}

function loadAttendanceRecord(row) {
    const recordId = row.getAttribute('data-recordid');
    const empleadoId = row.getAttribute('data-empid');
    const fecha = row.getAttribute('data-fecha');
    const horaEntrada = row.getAttribute('data-entrada');
    const horaSalida = row.getAttribute('data-salida');
    const estatus = row.getAttribute('data-estatus');

    document.getElementById('attendance_id').value = recordId || '';
    document.getElementById('empleado_id').value = empleadoId || '';
    document.getElementById('fecha').value = fecha || '';
    document.getElementById('hora_entrada').value = horaEntrada || '';
    document.getElementById('hora_salida').value = horaSalida || '';
    document.getElementById('estatus').value = estatus || 'A tiempo';
    document.getElementById('saveButton').textContent = recordId ? 'Actualizar' : 'Agregar';
    updateFechaDia();
}

function updateFechaDia() {
    const input = document.getElementById('fecha');
    const label = document.getElementById('fechaDia');
    if (!input.value) {
        label.textContent = '';
        return;
    }
    const dias = ['D', 'L', 'M', 'X', 'J', 'V', 'S'];
    const date = new Date(input.value + 'T00:00:00');
    label.textContent = 'Día: ' + dias[date.getDay()];
}

window.addEventListener('DOMContentLoaded', updateFechaDia);
</script>

</body>
</html>
