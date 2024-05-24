<?php

session_start();
if (isset($_SESSION['correo'])) {
    $usuarioId = $_SESSION['user_id'];
}

try {
    require 'db_connection.php';

    $consulta = " SELECT u.nombre, u.apellidos, u.celular, d.direccion, d.colonia, d.ciudad, d.codigo_postal, d.nro_exterior, d.nro_interior, d.descripcion
                  FROM usuarios u
                  LEFT JOIN domicilios d 
                  ON u.id = d.usuario_id
                  WHERE u.id = :usuarioId 
                ";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':usuarioId', $usuarioId);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario){
        header('Content-Type: application/json');
        echo json_encode(['error' => false, 'usuario' => $usuario]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => true, 'mensaje' => 'Error de datos ' . $e->getMessage()]);
    }

} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => true, 'mensaje' => 'Error al consultar la base de datos: ' . $e->getMessage()]);
} finally {
    if ($conexion) {
        $conexion = null;
    }
}
?>