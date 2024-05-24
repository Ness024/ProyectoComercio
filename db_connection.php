<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "bdtienda";

try {
    $conexion = new PDO("mysql: host=$servername; dbname=$db_name; charset=utf8", $db_username, $db_password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Conexión fallida: " . $e->getMessage());
    die("Ocurrió un error. Contacta al administrador del sistema para obtener asistencia. xD");
}
?>
