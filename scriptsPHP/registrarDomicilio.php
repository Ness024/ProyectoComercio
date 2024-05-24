<?php
session_start();
if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id']; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $calle = $_POST['calle'];
    $colonia = $_POST['colonia'];
    $ciudad = $_POST['ciudad'];
    $cp = $_POST['cp'];
    $numE = $_POST['numE'];
    $numI = $_POST['numI'];

    try {
        require 'db_connection.php'; 

        $sql = "INSERT INTO domicilios (usuario_id, direccion, colonia, ciudad, codigo_postal, nro_exterior, nro_interior) 
        VALUES (:usuario_id, :direccion, :colonia, :ciudad, :codigo_postal, :nro_exterior, :nro_interior)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':direccion', $calle);
        $stmt->bindParam(':colonia', $colonia);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':codigo_postal', $cp);
        $stmt->bindParam(':nro_exterior', $numE);
        $stmt->bindParam(':nro_interior', $numI);

        $stmt->execute();

        header('Content-Type: application/json');
        echo json_encode(['error' => false, 'mensaje' => 'Dirección registrada exitosamente']);
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(['error' => true, 'mensaje' => 'Error en la base de datos: ' . $e->getMessage()]);
    } finally {
        if ($conexion) {
            $conexion = null;
        }
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => true, 'mensaje' => 'Método no permitido']);
}
?>