<?php
// $titulo y $subtitulo deben definirse antes de incluir este componente
$titulo    = $titulo    ?? 'Panel';
$subtitulo = $subtitulo ?? 'Jeser Etiquetas RRHH';
?>

<header class="topbar">
  <div class="topbar-left">
    <h2><?= htmlspecialchars($titulo) ?></h2>
    <p><?= htmlspecialchars($subtitulo) ?></p>
  </div>
  <div class="topbar-right">
    <!-- Notificaciones -->
    <div class="topbar-badge" title="Notificaciones">
      <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="dot"></span>
    </div>
    <!-- Fecha -->
    <span style="font-size:.8rem;color:var(--gris-400);">
      <?= date('d M Y') ?>
    </span>
  </div>
</header>
