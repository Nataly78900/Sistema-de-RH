<?php
require 'config.php';

// Create database if not exists
$conn_temp = new mysqli(DB_HOST, DB_USER, DB_PASS);
if ($conn_temp->connect_error) {
    die("Connection failed: " . $conn_temp->connect_error);
}
$conn_temp->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
$conn_temp->close();

// Now connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS areas (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL
)";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS empleados (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
apellido VARCHAR(100) NOT NULL,
area_id INT,
FOREIGN KEY (area_id) REFERENCES areas(id)
)";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS reportes (
id INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(200) NOT NULL,
contenido TEXT,
fecha DATE
)";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS asistencias (
id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
fecha DATE NOT NULL,
estatus VARCHAR(50),
hora_entrada TIME,
hora_salida TIME,
empleado_id INT,
FOREIGN KEY (empleado_id) REFERENCES empleados(id)
)";
$conn->query($sql);

echo "Tablas creadas exitosamente.";
?>