<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
// Si hay sesión activa, continúa al dashboard

$titulo    = 'Dashboard';
$subtitulo = 'Resumen general del sistema';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Jeser Etiquetas RRHH</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="layout">
  <?php include 'componentes/menu.php'; ?>

  <div class="main-wrap">
    <?php include 'componentes/header.php'; ?>

    <main class="page-content">

      <!-- Bienvenida -->
      <div class="welcome-card">
        <h2>¡Hola, <?= htmlspecialchars(ucfirst($_SESSION['usuario'])) ?>!</h2>
        <p>Aquí tienes un resumen de la actividad de hoy en Jeser Etiquetas.</p>
      </div>

      <!-- Estadísticas -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon azul">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div class="stat-info">
            <strong>24</strong>
            <p>Empleados activos</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon verde">
            <svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <div class="stat-info">
            <strong>19</strong>
            <p>Presentes hoy</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon naranja">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div class="stat-info">
            <strong>3</strong>
            <p>Tardanzas este mes</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon rojo">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
          </div>
          <div class="stat-info">
            <strong>5</strong>
            <p>Áreas registradas</p>
          </div>
        </div>
      </div>

      <!-- Tabla resumen reciente -->
      <div class="section-card">
        <div class="section-header">
          <div>
            <h3>Actividad reciente</h3>
            <p>Últimos registros de asistencia</p>
          </div>
          <a href="asistencias.php" class="btn btn-secondary btn-sm">Ver todos</a>
        </div>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Empleado</th>
                <th>Área</th>
                <th>Hora entrada</th>
                <th>Hora salida</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Carlos Méndez</td>
                <td>Producción</td>
                <td>08:02</td>
                <td>17:00</td>
                <td><span class="badge badge-presente">Presente</span></td>
              </tr>
              <tr>
                <td>Laura Vega</td>
                <td>Administración</td>
                <td>08:45</td>
                <td>17:00</td>
                <td><span class="badge badge-tardanza">Tardanza</span></td>
              </tr>
              <tr>
                <td>Jorge Ruiz</td>
                <td>Logística</td>
                <td>—</td>
                <td>—</td>
                <td><span class="badge badge-ausente">Ausente</span></td>
              </tr>
              <tr>
                <td>Ana Torres</td>
                <td>Ventas</td>
                <td>07:58</td>
                <td>17:00</td>
                <td><span class="badge badge-presente">Presente</span></td>
              </tr>
              <tr>
                <td>Miguel Sosa</td>
                <td>Producción</td>
                <td>08:05</td>
                <td>17:00</td>
                <td><span class="badge badge-presente">Presente</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </main>

    <?php include 'componentes/footer.php'; ?>
  </div>
</div>

</body>
</html>