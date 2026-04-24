<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$asistencias = [
    ['id' => 1, 'empleado' => 'Carlos Méndez',   'fecha' => '2025-04-07', 'hora_entrada' => '08:02', 'hora_salida' => '17:00', 'estatus' => 'Presente'],
    ['id' => 2, 'empleado' => 'Laura Vega',       'fecha' => '2025-04-07', 'hora_entrada' => '08:45', 'hora_salida' => '17:00', 'estatus' => 'Tardanza'],
    ['id' => 3, 'empleado' => 'Jorge Ruiz',       'fecha' => '2025-04-07', 'hora_entrada' => '—',     'hora_salida' => '—',     'estatus' => 'Ausente'],
    ['id' => 4, 'empleado' => 'Ana Torres',       'fecha' => '2025-04-07', 'hora_entrada' => '07:58', 'hora_salida' => '17:00', 'estatus' => 'Presente'],
    ['id' => 5, 'empleado' => 'Miguel Sosa',      'fecha' => '2025-04-07', 'hora_entrada' => '08:05', 'hora_salida' => '17:00', 'estatus' => 'Presente'],
    ['id' => 6, 'empleado' => 'Patricia León',    'fecha' => '2025-04-07', 'hora_entrada' => '08:00', 'hora_salida' => '17:00', 'estatus' => 'Presente'],
];

$badge_map = [
    'Presente' => 'badge-presente',
    'Tardanza' => 'badge-tardanza',
    'Ausente'  => 'badge-ausente',
];

$titulo    = 'Asistencias';
$subtitulo = 'Control de entradas y salidas';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asistencias — Jeser Etiquetas RRHH</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="layout">
  <?php include 'componentes/menu.php'; ?>

  <div class="main-wrap">
    <?php include 'componentes/header.php'; ?>

    <main class="page-content">

      <div class="page-title">
        <h1>Asistencias</h1>
        <p>Registro de entradas y salidas del personal</p>
      </div>

      <div class="section-card">
        <div class="table-toolbar">
          <div class="search-box">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="buscar" placeholder="Buscar empleado o fecha…">
          </div>
          <div style="display:flex;gap:10px;align-items:center">
            <input type="date" class="field-group input" style="padding:8px 12px;border:1.5px solid var(--gris-200);border-radius:8px;font-size:.875rem;outline:none;background:var(--gris-50);" value="<?= date('Y-m-d') ?>">
            <button class="btn btn-primary" onclick="document.getElementById('modal-asist').style.display='flex'">
              <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Registrar
            </button>
          </div>
        </div>

        <div class="table-wrap">
          <table id="tabla-asist">
            <thead>
              <tr>
                <th>#</th>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Hora entrada</th>
                <th>Hora salida</th>
                <th>Estatus</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($asistencias as $a): ?>
              <tr>
                <td><?= $a['id'] ?></td>
                <td><?= htmlspecialchars($a['empleado']) ?></td>
                <td><?= $a['fecha'] ?></td>
                <td><?= $a['hora_entrada'] ?></td>
                <td><?= $a['hora_salida'] ?></td>
                <td>
                  <span class="badge <?= $badge_map[$a['estatus']] ?? '' ?>">
                    <?= $a['estatus'] ?>
                  </span>
                </td>
                <td>
                  <div class="table-actions">
                    <button class="action-btn" title="Editar">
                      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
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

<!-- Modal registrar asistencia -->
<div class="modal-overlay" id="modal-asist" style="display:none">
  <div class="modal">
    <div class="modal-header">
      <h3>Registrar Asistencia</h3>
      <button class="modal-close" onclick="document.getElementById('modal-asist').style.display='none'">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-grid form-grid-2">
        <div class="field-group" style="grid-column:1/-1">
          <label>Empleado</label>
          <select>
            <option value="">Selecciona…</option>
            <option>Carlos Méndez</option>
            <option>Laura Vega</option>
            <option>Jorge Ruiz</option>
            <option>Ana Torres</option>
            <option>Miguel Sosa</option>
            <option>Patricia León</option>
          </select>
        </div>
        <div class="field-group">
          <label>Fecha</label>
          <input type="date" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="field-group">
          <label>Estatus</label>
          <select>
            <option>Presente</option>
            <option>Tardanza</option>
            <option>Ausente</option>
          </select>
        </div>
        <div class="field-group">
          <label>Hora entrada</label>
          <input type="time" value="08:00">
        </div>
        <div class="field-group">
          <label>Hora salida</label>
          <input type="time" value="17:00">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="document.getElementById('modal-asist').style.display='none'">Cancelar</button>
      <button class="btn btn-primary">Guardar registro</button>
    </div>
  </div>
</div>

<script>
  document.getElementById('buscar').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tabla-asist tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
  document.getElementById('modal-asist').addEventListener('click', function (e) {
    if (e.target === this) this.style.display = 'none';
  });
</script>

</body>
</html>
