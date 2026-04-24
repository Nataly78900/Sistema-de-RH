<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Datos estáticos de ejemplo
$empleados = [
    ['id' => 1, 'nombre' => 'Carlos Méndez',   'puesto' => 'Operador',       'area' => 'Producción',     'telefono' => '555-1001', 'email' => 'c.mendez@jeseretiquetas.com',  'activo' => true],
    ['id' => 2, 'nombre' => 'Laura Vega',       'puesto' => 'Contadora',      'area' => 'Administración', 'telefono' => '555-1002', 'email' => 'l.vega@jeseretiquetas.com',    'activo' => true],
    ['id' => 3, 'nombre' => 'Jorge Ruiz',       'puesto' => 'Almacenista',    'area' => 'Logística',      'telefono' => '555-1003', 'email' => 'j.ruiz@jeseretiquetas.com',    'activo' => false],
    ['id' => 4, 'nombre' => 'Ana Torres',       'puesto' => 'Ejecutiva',      'area' => 'Ventas',         'telefono' => '555-1004', 'email' => 'a.torres@jeseretiquetas.com',  'activo' => true],
    ['id' => 5, 'nombre' => 'Miguel Sosa',      'puesto' => 'Operador',       'area' => 'Producción',     'telefono' => '555-1005', 'email' => 'm.sosa@jeseretiquetas.com',    'activo' => true],
    ['id' => 6, 'nombre' => 'Patricia León',    'puesto' => 'Supervisora',    'area' => 'Calidad',        'telefono' => '555-1006', 'email' => 'p.leon@jeseretiquetas.com',    'activo' => true],
];

$titulo    = 'Empleados';
$subtitulo = 'Gestión del personal';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Empleados — Jeser Etiquetas RRHH</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="layout">
  <?php include 'componentes/menu.php'; ?>

  <div class="main-wrap">
    <?php include 'componentes/header.php'; ?>

    <main class="page-content">

      <div class="page-title">
        <h1>Empleados</h1>
        <p>Administra los datos del personal de Jeser Etiquetas</p>
      </div>

      <div class="section-card">
        <div class="table-toolbar">
          <div class="search-box">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="buscar" placeholder="Buscar empleado…">
          </div>
          <button class="btn btn-primary" onclick="document.getElementById('modal-emp').style.display='flex'">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nuevo empleado
          </button>
        </div>

        <div class="table-wrap">
          <table id="tabla-emp">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Área</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($empleados as $e): ?>
              <tr>
                <td><?= $e['id'] ?></td>
                <td><?= htmlspecialchars($e['nombre']) ?></td>
                <td><?= htmlspecialchars($e['puesto']) ?></td>
                <td><?= htmlspecialchars($e['area']) ?></td>
                <td><?= htmlspecialchars($e['telefono']) ?></td>
                <td><?= htmlspecialchars($e['email']) ?></td>
                <td>
                  <?php if ($e['activo']): ?>
                    <span class="badge badge-activo">Activo</span>
                  <?php else: ?>
                    <span class="badge badge-inactivo">Inactivo</span>
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

<!-- Modal nuevo empleado -->
<div class="modal-overlay" id="modal-emp" style="display:none">
  <div class="modal">
    <div class="modal-header">
      <h3>Nuevo Empleado</h3>
      <button class="modal-close" onclick="document.getElementById('modal-emp').style.display='none'">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-grid form-grid-2">
        <div class="field-group">
          <label>Nombre completo</label>
          <input type="text" placeholder="Ej. Juan García">
        </div>
        <div class="field-group">
          <label>Puesto</label>
          <input type="text" placeholder="Ej. Operador">
        </div>
        <div class="field-group">
          <label>Área</label>
          <select>
            <option value="">Selecciona…</option>
            <option>Producción</option>
            <option>Administración</option>
            <option>Logística</option>
            <option>Ventas</option>
            <option>Calidad</option>
          </select>
        </div>
        <div class="field-group">
          <label>Teléfono</label>
          <input type="text" placeholder="555-0000">
        </div>
        <div class="field-group" style="grid-column:1/-1">
          <label>Email</label>
          <input type="email" placeholder="correo@jeseretiquetas.com">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="document.getElementById('modal-emp').style.display='none'">Cancelar</button>
      <button class="btn btn-primary">Guardar empleado</button>
    </div>
  </div>
</div>

<script>
  // Filtro de búsqueda en tiempo real
  document.getElementById('buscar').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tabla-emp tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
  // Cerrar modal al hacer clic fuera
  document.getElementById('modal-emp').addEventListener('click', function (e) {
    if (e.target === this) this.style.display = 'none';
  });
</script>

</body>
</html>
