<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$areas = [
    ['id' => 1, 'descripcion' => 'Producción',     'empleados' => 8]
    ['id' => 2, 'descripcion' => 'Administración', 'empleados' => 4] 
    ['id' => 3, 'descripcion' => 'Logística',      'empleados' => 5]  
    ['id' => 4, 'descripcion' => 'Ventas',          'empleados' => 4]
    ['id' => 5, 'descripcion' => 'Calidad',         'empleados' => 3] 
];

$titulo    = 'Áreas';
$subtitulo = 'Departamentos de la empresa';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Áreas — Jeser Etiquetas RRHH</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="layout">
  <?php include 'componentes/menu.php'; ?>

  <div class="main-wrap">
    <?php include 'componentes/header.php'; ?>

    <main class="page-content">

      <div class="page-title">
        <h1>Áreas</h1>
        <p>Departamentos y divisiones de Jeser Etiquetas</p>
      </div>

      <div class="section-card">
        <div class="table-toolbar">
          <div class="search-box">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="buscar" placeholder="Buscar área…">
          </div>
          <button class="btn btn-primary" onclick="document.getElementById('modal-area').style.display='flex'">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nueva área
          </button>
        </div>

        <div class="table-wrap">
          <table id="tabla-areas">
            <thead>
              <tr>
                <th>#</th>
                <th>Descripción</th>
                <th>Empleados asignados</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($areas as $a): ?>
              <tr>
                <td><?= $a['id'] ?></td>
                <td><?= htmlspecialchars($a['descripcion']) ?></td>
                <td><?= $a['empleados'] ?></td>
                <td>
                  <?php if ($a['activo']): ?>
                    <span class="badge badge-activo">Activa</span>
                  <?php else: ?>
                    <span class="badge badge-inactivo">Inactiva</span>
                  <?php endif; ?>
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

<!-- Modal nueva área -->
<div class="modal-overlay" id="modal-area" style="display:none">
  <div class="modal">
    <div class="modal-header">
      <h3>Nueva Área</h3>
      <button class="modal-close" onclick="document.getElementById('modal-area').style.display='none'">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="field-group">
          <label>Descripción del área</label>
          <input type="text" placeholder="Ej. Producción">
        </div>
        <div class="field-group">
          <label>Estado</label>
          <select>
            <option value="1">Activa</option>
            <option value="0">Inactiva</option>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="document.getElementById('modal-area').style.display='none'">Cancelar</button>
      <button class="btn btn-primary">Guardar área</button>
    </div>
  </div>
</div>

<script>
  document.getElementById('buscar').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tabla-areas tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
  document.getElementById('modal-area').addEventListener('click', function (e) {
    if (e.target === this) this.style.display = 'none';
  });
</script>

</body>
</html>
