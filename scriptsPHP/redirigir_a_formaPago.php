<?php
session_start();
if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require 'db_connection.php';
    try {
        $consulta = "SELECT u.nombre, u.apellidos, u.celular, d.direccion, d.colonia, d.ciudad, d.codigo_postal, d.nro_exterior, d.nro_interior, d.descripcion
            FROM usuarios u
            LEFT JOIN domicilios d 
            ON u.id = d.usuario_id
            WHERE u.id = :usuarioId";
        $stmtConsulta = $conexion->prepare($consulta);
        $stmtConsulta->bindParam(':usuarioId', $usuario_id);
        $stmtConsulta->execute();
        $domicilio = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

        if ($domicilio) {
            if (empty($domicilio['nombre']) || empty($domicilio['apellidos']) || empty($domicilio['celular']) || empty($domicilio['direccion']) || empty($domicilio['colonia']) || empty($domicilio['ciudad']) || empty($domicilio['codigo_postal']) || empty($domicilio['nro_exterior']) || empty($domicilio['nro_interior']) || empty($domicilio['descripcion'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => true,
                    'mensaje' => 'Te falta un dato en la información del usuario',
                    'usuario' => $domicilio
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => false,
                    'mensaje' => 'Redireccionar a formadepago.ph',
                    'redireccionar' => 'formaDePago.php' 
                ]);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => true, 'mensaje' => 'Registre una Forma de Pago para continuar']);
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