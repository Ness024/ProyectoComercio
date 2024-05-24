<?php
session_start();
if ($_SESSION['correo']) {
    $usuario_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require 'db_connection.php';
    try {
        $consulta = "SELECT * FROM tarjetas WHERE usuario_id = :usuario_id";
        $stmtConsulta = $conexion->prepare($consulta);
        $stmtConsulta->bindParam(':usuario_id', $usuario_id);
        $stmtConsulta->execute();
        $target = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

        if ($target) {
            if (empty($target['primer_nombre']) || empty($target['apellido_titular']) || empty($target['numero_tarjeta']) || empty($target['fecha_expiracion']) || empty($target['cvv'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => true,
                    'mensaje' => 'Te falta un dato en la tarjeta',
                    'tarjeta' => $target
                ]);
            } else {
                // Incluir la información de redirección en el JSON de respuesta
                header('Content-Type: application/json');
                echo json_encode([
                    'error' => false,
                    'mensaje' => 'Redireccionar a revisarOrden.php',
                    'redireccionar' => 'revisarOrden.php' // Puedes ajustar la URL de redirección según tu estructura
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