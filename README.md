# Sistema de Recursos Humanos

Este es un sistema básico de gestión de recursos humanos desarrollado en PHP con MySQL.

## Requisitos
- XAMPP instalado (o cualquier servidor con PHP y MySQL)
- Apache y MySQL ejecutándose

## Instalación
1. Coloca los archivos en `c:\xampp\htdocs\recursoshumanos\`
2. Inicia XAMPP Control Panel y enciende Apache y MySQL.
3. Importa el archivo `recursoshumanos.sql` en phpMyAdmin (o ejecuta el script setup.php).
4. Accede al sistema en http://localhost/recursoshumanos/

## Módulos
- **Áreas**: Gestión de áreas/departamentos
- **Empleados**: Gestión de empleados, asignados a áreas
- **Reportes**: Creación y visualización de reportes
- **Asistencias**: Registro de asistencias con campos: fecha, estatus, hora_entrada, hora_salida, id_asistencia

## Diseño
El sistema incluye un diseño sencillo pero elegante con CSS personalizado, incluyendo navegación, formularios estilizados y tablas responsivas.

## Notas
- Las contraseñas de base de datos están configuradas para XAMPP por defecto (usuario: root, contraseña: vacía).
- Ajusta `config.php` si es necesario.