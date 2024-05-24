<?php
session_start();

if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') { 

    require 'db_connection.php';

    try {
        $consulta = "SELECT * FROM tarjetas WHERE usuario_id = :usuario_id";
        $stmtConsulta = $conexion->prepare($consulta);
        $stmtConsulta->bindParam(':usuario_id', $usuario_id);
        $stmtConsulta->execute();
        $tarjetaExistente = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

        if ($tarjetaExistente) {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => false,
                'mensaje' => 'Consulta exitosa',
                'tarjeta' => $tarjetaExistente
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => true, 'mensaje' => 'No se encontró una tarjeta asociada al usuario']);
        }
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