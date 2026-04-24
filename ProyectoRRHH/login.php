<?php
session_start(); //Inicia la sesión;

if ($_POST) {
    $usuario  = $_POST['usuario'];
    $password = $_POST['password'];

    if ($usuario === 'admin' && $password === '1234') {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit();
    } else {
        $error = 'Usuario o contraseña incorrectos. Intenta de nuevo.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jeser Etiquetas — Acceso RRHH</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="login-page">

  <!-- Panel izquierdo -->
  <div class="login-panel-left">
    <div class="login-deco-grid"></div>
    <div class="login-brand">
      <div class="login-brand-icon">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <h1>Jeser Etiquetas</h1>
      <span>Sistema de Recursos Humanos</span>
    </div>
    <p class="login-tagline">
      Gestiona tu equipo, controla asistencias y genera reportes desde un solo lugar.
    </p>
  </div>

  <!-- Panel derecho / formulario -->
  <div class="login-panel-right">
    <div class="login-form-wrap">
      <h2>Bienvenido</h2>
      <p>Ingresa tus datos para continuar</p>

      <?php if (isset($error)): ?>
        <div class="login-error">
          
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" autocomplete="off">
        <div class="form-group">
          <label for="usuario">Usuario</label>
          <div class="input-wrap">
            <input type="text" id="usuario" name="usuario" placeholder="Escribe tu usuario" required>
                   
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <div class="input-wrap">
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </div>
        </div>

        <button type="submit" class="btn-login">Iniciar Sesión</button>
      </form>

      <p class="login-footer-note">© <?= date('Y') ?> Jeser Etiquetas · Todos los derechos reservados</p>
    </div>
  </div>

</div>

</body>
</html>
