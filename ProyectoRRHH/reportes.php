<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$reportes = [
    ['id' => 1, 'fecha_reporte' => '2025-04-01', 'empleado' => 'Carlos Méndez',  'descripcion' => 'Reporte mensual de asistencia — Marzo 2025'],
    ['id' => 2, 'fecha_reporte' => '2025-04-01', 'empleado' => 'Laura Vega',     'descripcion' => 'Reporte de tardanzas — Q1 2025'],
    ['id' => 3, 'fecha_reporte' => '2025-03-15', 'empleado' => 'Jorge Ruiz',     'descripcion' => 'Reporte de ausencias — Febrero 2025'],
    ['id' => 4, 'fecha_reporte' => '2025-04-05', 'empleado' => 'Ana Torres',     'descripcion' => 'Resumen general del personal activo'],
    ['id' => 5, 'fecha_reporte' => '2025-04-06', 'empleado' => 'Patricia León',  'descripcion' => 'Reporte de áreas — Producción y Calidad'],
];

$titulo    = 'Reportes';
$subtitulo = 'Documentos y resúmenes generados';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes — Jeser Etiquetas RRHH</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="layout">
  <?php include 'componentes/menu.php'; ?>

  <div class="main-wrap">
    <?php include 'componentes/header.php'; ?>

    <main class="page-content">

      <div class="page-title">
        <h1>Reportes</h1>
        <p>Historial de reportes generados por empleado</p>
      </div>

      <div class="section-card">
        <div class="table-toolbar">
          <div class="search-box">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="buscar" placeholder="Buscar reporte…">
          </div>
          <button class="btn btn-primary" onclick="document.getElementById('modal-rep').style.display='flex'">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Generar reporte
          </button>
        </div>

        <div class="table-wrap">
          <table id="tabla-rep">
            <thead>
              <tr>
                <th>#</th>
                <th>Empleado</th>
                <th>Descripción</th>
                <th>Fecha reporte</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reportes as $r): ?>
              <tr>
                <td><?= $r['id'] ?></td>
                <td><?= htmlspecialchars($r['empleado']) ?></td>
                <td><?= htmlspecialchars($r['descripcion']) ?></td>
                <td><?= $r['fecha_reporte'] ?></td>
                <td>
                  <div class="table-actions">
                    <button class="action-btn" title="Ver">
                      <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <button class="action-btn del" title="Eliminar">
                      <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                    </button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </main>
    <?php include 'componentes/footer.php'; ?>
  </div>
</div>

<!-- Modal generar reporte -->
<div class="modal-overlay" id="modal-rep" style="display:none">
  <div class="modal">
    <div class="modal-header">
      <h3>Generar Reporte</h3>
      <button class="modal-close" onclick="document.getElementById('modal-rep').style.display='none'">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-grid form-grid-2">
        <div class="field-group" style="grid-column:1/-1">
          <label>Empleado</label>
          <select>
            <option value="">Todos los empleados</option>
            <option>Carlos Méndez</option>
            <option>Laura Vega</option>
            <option>Jorge Ruiz</option>
            <option>Ana Torres</option>
            <option>Miguel Sosa</option>
            <option>Patricia León</option>
          </select>
        </div>
        <div class="field-group">
          <label>Fecha inicio</label>
          <input type="date">
        </div>
        <div class="field-group">
          <label>Fecha fin</label>
          <input type="date" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="field-group" style="grid-column:1/-1">
          <label>Descripción</label>
          <input type="text" placeholder="Ej. Reporte mensual de asistencia">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="document.getElementById('modal-rep').style.display='none'">Cancelar</button>
      <button class="btn btn-primary">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Generar
      </button>
    </div>
  </div>
</div>

<script>
  document.getElementById('buscar').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tabla-rep tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
  document.getElementById('modal-rep').addEventListener('click', function (e) {
    if (e.target === this) this.style.display = 'none';
  });
</script>

</body>
</html>
